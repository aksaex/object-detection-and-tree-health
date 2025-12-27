import sys
import json
import os
import base64
from io import BytesIO
from PIL import Image 
from ultralytics import YOLO
import logging

logging.getLogger("ultralytics").setLevel(logging.ERROR)

if len(sys.argv) < 2:
    print(json.dumps({"status": "gagal", "label": "No Input"}))
    sys.exit()

image_path = sys.argv[1]

try:
    if not os.path.exists(image_path):
        raise Exception("File input tidak ditemukan.")

    # Load Model
    model_path = os.path.join(os.path.dirname(__file__), "model", "yolov8_tree.pt")
    if not os.path.exists(model_path):
        raise Exception("Model tidak ditemukan.")

    model = YOLO(model_path)

    # Deteksi (Confidence rendah biar gampang kedetect)
    results = model.predict(image_path, conf=0.15, iou=0.5, save=False)
    result = results[0]

    # --- GAMBAR GARIS KOTAK ---
    # Plot gambar dengan garis tebal
    im_array_bgr = result.plot(line_width=3, font_size=2.0)
    
    # Konversi ke Base64 (Agar bisa dikirim ke PHP tanpa simpan file)
    im_pil = Image.fromarray(im_array_bgr[..., ::-1]) # BGR ke RGB
    buffered = BytesIO()
    im_pil.save(buffered, format="JPEG", quality=70) # Quality 70 biar cepat
    img_str = base64.b64encode(buffered.getvalue()).decode("utf-8")
    base64_output = f"data:image/jpeg;base64,{img_str}"

    # Hitung Jumlah
    jumlah = len(result.boxes)
    label = f"Ditemukan {jumlah} Pohon" if jumlah > 0 else "Tidak Ada Pohon"

    # KIRIM JSON (PENTING: image_path berisi base64)
    print(json.dumps({
        "status": "sukses",
        "label": label,
        "jumlah": jumlah,
        "mode": "deteksi",
        "image_path": base64_output 
    }))

except Exception as e:
    print(json.dumps({"status": "gagal", "label": f"Error: {str(e)}"}))