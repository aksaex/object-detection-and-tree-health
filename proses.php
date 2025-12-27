<?php
// proses.php - VERSI ANTI-WARNING
header('Content-Type: application/json');
error_reporting(0); // Matikan error PHP biar output bersih

$response = ['status' => 'gagal', 'label' => 'Server Error', 'jumlah' => 0];
$mode = isset($_POST['mode']) ? $_POST['mode'] : 'klasifikasi';

function jalankanPython($scriptName, $filePath) {
    if (!file_exists($filePath)) {
        return ["status" => "gagal", "label" => "File gambar hilang"];
    }

    $command = "python " . $scriptName . " " . escapeshellarg($filePath) . " 2>&1";
    $output = shell_exec($command);
    
    // --- FILTER PEMBERSIH (JURUS RAHASIA) ---
    // Cari kurung kurawal pembuka '{' pertama
    $first_brace = strpos($output, '{');
    // Cari kurung kurawal penutup '}' terakhir
    $last_brace = strrpos($output, '}');

    // Jika ditemukan kurung kurawal yang valid
    if ($first_brace !== false && $last_brace !== false) {
        // Potong hanya bagian JSON-nya saja (Buang warning di depan/belakang)
        $clean_json = substr($output, $first_brace, $last_brace - $first_brace + 1);
        
        $json = json_decode($clean_json, true);
        if ($json) {
            return $json; // Sukses!
        }
    }

    // Jika gagal decode, kirim error asli untuk dibaca
    return [
        "status" => "gagal", 
        "label" => "Output Kotor: " . substr($output, 0, 100)
    ];
}

// Setup Folder
$base_dir = __DIR__; 
$target_dir = $base_dir . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

// Nama file
if (isset($_FILES['gambar'])) {
    $filename = "upload_" . time() . ".jpg"; 
} else {
    $filename = "live_" . time() . ".jpg"; 
}
$target_file = $target_dir . $filename;
$fileReady = false;

// Simpan File
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) $fileReady = true;
} else if (isset($_POST['image_base64'])) {
    $data = $_POST['image_base64'];
    if (strpos($data, ',') !== false) $data = explode(',', $data)[1];
    $data = base64_decode($data);
    file_put_contents($target_file, $data);
    $fileReady = true;
}

if ($fileReady) {
    if ($mode == 'deteksi') {
        $hasil = jalankanPython("detect.py", $target_file);
    } else {
        $hasil = jalankanPython("otak.py", $target_file);
    }

    if ($hasil) {
        $response = $hasil;
        
        // Handle Gambar
        if (isset($hasil['image_path']) && strpos($hasil['image_path'], 'data:image') === 0) {
            $response['image_path'] = $hasil['image_path']; 
        } else {
            $webPath = "uploads/" . $filename;
            $response['image_path'] = $webPath . "?t=" . time();
        }
    }

    // Hapus file setelah selesai (Zero Waste)
    if (file_exists($target_file)) { unlink($target_file); } 

} else {
    $response['label'] = "Gagal simpan gambar.";
}

echo json_encode($response);
?>