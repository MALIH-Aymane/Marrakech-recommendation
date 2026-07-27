import sys
import json
import torch
import open_clip

from PIL import Image

device = "cuda" if torch.cuda.is_available() else "cpu"

model, _, preprocess = open_clip.create_model_and_transforms(
    "ViT-B-32",
    pretrained="laion2b_s34b_b79k"
)

model.to(device)
model.eval()

image_path = sys.argv[1]

image = preprocess(
    Image.open(image_path).convert("RGB")
).unsqueeze(0).to(device)

with torch.no_grad():

    features = model.encode_image(image)

    features /= features.norm(dim=-1, keepdim=True)

print(json.dumps(features.squeeze().cpu().numpy().tolist()))