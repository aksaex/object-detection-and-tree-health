import os
import sys
import json
import numpy as np

# Matikan log TensorFlow yang berisik
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' 
import tensorflow as tf
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image

if len(sys.argv) < 2:
    print(json.dumps({"status": "gagal", "label": "Error: Tidak ada input file"}))
    sys.exit()

# Ambil alamat gambar dari PHP
image_path = sys.argv[1]

try:
    # 1. CEK FILE GAMBAR
    if not os.path.exists(image_path):
        # Coba perbaiki path jika ada masalah backslash Windows
        image_path = image_path.replace("\\", "/")
        if not os.path.exists(image_path):
            raise Exception(f"Gambar tidak ditemukan di: {image_path}")

    # 2. CARI MODEL (Otomatis Mengikuti Folder Baru)
    base_dir = os.path.dirname(os.path.abspath(__file__))
    model_path = os.path.join(base_dir, "model", "model_pohon_v1.h5")

    if not os.path.exists(model_path):
        raise Exception(f"Model hilang! Pastikan ada file: {model_path}")

    # 3. LOAD MODEL & PREDIKSI
    model = load_model(model_path)

    img = image.load_img(image_path, target_size=(224, 224))
    x = image.img_to_array(img)
    x = np.expand_dims(x, axis=0)
    x = x / 255.0 

    predictions = model.predict(x, verbose=0)
    
    # --- PERBAIKAN DI SINI (Konversi ke tipe data standar Python) ---
    class_index = int(np.argmax(predictions[0])) # Paksa jadi int biasa
    confidence = float(np.max(predictions[0]))   # Paksa jadi float biasa
    
    # Sesuaikan Label dengan urutan folder training Anda
    class_labels = ['Perlu Tindakan', 'Sakit', 'Sehat'] 
    
    if class_index < len(class_labels):
        label_result = class_labels[class_index]
    else:
        label_result = "Tidak Diketahui"

    # Hitung akurasi
    akurasi_fix = round(confidence * 100, 1)

    print(json.dumps({
        "status": "sukses",
        "label": label_result,
        "akurasi": akurasi_fix,
        "mode": "klasifikasi"
    }))

except Exception as e:
    print(json.dumps({
        "status": "gagal", 
        "label": f"Error: {str(e)}",
        "akurasi": 0
    }))