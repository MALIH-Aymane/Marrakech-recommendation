import os
import json
import pymysql
import torch
import open_clip
import numpy as np

from PIL import Image
from tqdm import tqdm
from collections import defaultdict

print("Loading OpenCLIP...")

device = "cuda" if torch.cuda.is_available() else "cpu"

model, _, preprocess = open_clip.create_model_and_transforms(
    "ViT-B-32",
    pretrained="laion2b_s34b_b79k"
)

model.to(device)
model.eval()

print("Model loaded!")

# -------------------------
# Connexion MySQL
# -------------------------

db = pymysql.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="marrakechtour_new",
    charset="utf8mb4",
    autocommit=True
)

cursor = db.cursor()

# -------------------------
# Images des attractions
# -------------------------

cursor.execute("""
SELECT
    attractions.id,
    attractions.attraction,
    attraction_images.image
FROM attractions
JOIN attraction_images
ON attraction_images.attraction_id = attractions.id
ORDER BY attractions.id
""")

rows = cursor.fetchall()

print(f"{len(rows)} images trouvées.")

# -------------------------
# Grouper les images
# -------------------------

attractions = defaultdict(list)

for attraction_id, attraction_name, image in rows:

    path = os.path.join(
        "storage",
        "app",
        "public",
        image
    )

    if os.path.exists(path):
        attractions[attraction_id].append(path)

print(f"{len(attractions)} attractions à traiter.")

# -------------------------
# Reprise automatique
# -------------------------

cursor.execute("""
SELECT attraction_id
FROM attraction_embeddings
""")

already_done = {row[0] for row in cursor.fetchall()}

print(f"{len(already_done)} attractions déjà traitées.")

# -------------------------
# Fonction embedding
# -------------------------

def embed_image(path):

    image = preprocess(
        Image.open(path).convert("RGB")
    ).unsqueeze(0).to(device)

    with torch.no_grad():

        features = model.encode_image(image)

        features /= features.norm(dim=-1, keepdim=True)

    return features.squeeze().cpu().numpy()

# -------------------------
# Génération
# -------------------------

for attraction_id in tqdm(attractions):

    if attraction_id in already_done:
        continue

    vectors = []

    for image_path in attractions[attraction_id]:

        try:

            vector = embed_image(image_path)

            vectors.append(vector)

        except Exception as e:

            print()
            print("Erreur :", image_path)
            print(e)

    if len(vectors) == 0:
        continue

    average = np.mean(vectors, axis=0).tolist()

    cursor.execute("""

        INSERT INTO attraction_embeddings
        (attraction_id, embedding, created_at, updated_at)

        VALUES (%s,%s,NOW(),NOW())

        ON DUPLICATE KEY UPDATE

        embedding=VALUES(embedding),
        updated_at=NOW()

    """, (

        attraction_id,
        json.dumps(average)

    ))

print()
print("===================================")
print("Embeddings générés avec succès !")
print("===================================")

cursor.close()
db.close()