import open_clip
import torch
from PIL import Image

# Chargement du modèle
model, _, preprocess = open_clip.create_model_and_transforms(
    "ViT-B-32",
    pretrained="laion2b_s34b_b79k"
)

# Mode évaluation
model.eval()

# Charger une image
image = preprocess(Image.open("public/image_1.jpg")).unsqueeze(0)

# Générer l'embedding
with torch.no_grad():
    embedding = model.encode_image(image)

print(embedding.shape)