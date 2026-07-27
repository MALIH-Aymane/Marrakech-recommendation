import sys
import json
import torch
import open_clip
from PIL import Image

# Charger le modèle
model, _, preprocess = open_clip.create_model_and_transforms(
    "ViT-B-32",
    pretrained="laion2b_s34b_b79k"
)

model.eval()

# Chemin de l'image
image_path = sys.argv[1]

# Prétraitement
image = preprocess(Image.open(image_path)).unsqueeze(0)

# Embedding
with torch.no_grad():
    embedding = model.encode_image(image)

# Normalisation (très importante)
embedding = embedding / embedding.norm(dim=-1, keepdim=True)

# Transformer en liste Python
vector = embedding.squeeze().tolist()

# Retour JSON
print(json.dumps(vector))