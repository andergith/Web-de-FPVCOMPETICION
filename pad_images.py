import os
import glob
from PIL import Image, ImageFilter, ImageDraw

img_dir = r"c:\Users\Ander\Desktop\Programación\Web de FPVCOMPETICION\imagenes"
images = glob.glob(os.path.join(img_dir, "drone_cover_*.png"))

for path in images:
    if "_scaled" in path:
        continue
        
    img = Image.open(path).convert("RGBA")
    w, h = img.size
    
    target_w = int(h * 16 / 9)
    target_h = h
    
    new_w = int(w * 0.6)
    new_h = int(h * 0.6)
    small_img = img.resize((new_w, new_h), Image.LANCZOS)
    
    canvas = Image.new("RGBA", (target_w, target_h), (15, 23, 42, 255))
    bg_img = img.resize((target_w, target_h), Image.LANCZOS).filter(ImageFilter.GaussianBlur(radius=80))
    canvas.paste(bg_img, (0, 0))
    
    mask = Image.new("L", (new_w, new_h), 0)
    draw = ImageDraw.Draw(mask)
    pad = int(new_w * 0.1)
    draw.ellipse((pad, pad, new_w-pad, new_h-pad), fill=255)
    mask = mask.filter(ImageFilter.GaussianBlur(radius=50))
    
    small_img.putalpha(mask)
    
    offset_x = (target_w - new_w) // 2
    offset_y = (target_h - new_h) // 2
    canvas.paste(small_img, (offset_x, offset_y), small_img)
    
    final = canvas.convert("RGB")
    final.save(path)
    print(f"Processed: {os.path.basename(path)}")
