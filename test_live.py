import cv2
from ultralytics import YOLO
import os

# 1. Load Model (Pastikan path model benar)
# Kita pakai model yang sudah Anda latih
model_path = "model/yolov8_tree.pt" 

if not os.path.exists(model_path):
    print(f"ERROR: Model tidak ditemukan di {model_path}")
    exit()

print("Memuat Model... Tunggu sebentar...")
model = YOLO(model_path)

# 2. Buka Kamera (0 biasanya kamera webcam laptop)
cap = cv2.VideoCapture(0)

# Cek apakah kamera terbuka
if not cap.isOpened():
    print("ERROR: Tidak bisa membuka kamera.")
    exit()

print("Kamera Terbuka! Tekan tombol 'q' di keyboard untuk STOP.")

while True:
    # 3. Baca Frame dari Kamera
    success, frame = cap.read()
    if not success:
        break

    # 4. Deteksi dengan YOLO
    # conf=0.15 agar sensitif
    # show=False karena kita akan gambar manual/plot
    results = model.predict(frame, conf=0.15, verbose=False)
    
    # 5. Gambar Kotak di Frame
    # method plot() otomatis menggambar kotak & label
    annotated_frame = results[0].plot()

    # 6. Tampilkan di Jendela Desktop
    cv2.imshow("TES STREAMING YOLO (Tekan 'q' untuk keluar)", annotated_frame)

    # 7. Tombol Keluar (Tekan 'q')
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Bersih-bersih setelah selesai
cap.release()
cv2.destroyAllWindows()