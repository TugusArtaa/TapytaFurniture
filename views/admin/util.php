<?php

// Fungsi untuk mengekspor database ke file SQL
function exportDB($host, $name, $user, $password)
{
    // Membuat koneksi ke database
    $db = new mysqli($host, $user, $password, $name);

    // Mendapatkan daftar tabel dalam database
    $tables = array();
    $result = $db->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }

    $return = '';

    // Looping melalui setiap tabel untuk mengekspor struktur dan data
    foreach ($tables as $table) {
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;

        $result2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $result2->fetch_row();

        $return .= "\n\n" . $row2[1] . ";\n\n";

        for ($i = 0; $i < $numColumns; $i++) {
            while ($row = $result->fetch_row()) {
                $return .= "INSERT INTO $table VALUES(";
                for ($j = 0; $j < $numColumns; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = $row[$j];
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($numColumns - 1)) {
                        $return .= ',';
                    }
                }
                $return .= ");\n";
            }
        }

        $return .= "\n\n\n";
    }

    // Menyimpan file SQL
    $filename = time() . '.sql';
    $handle = fopen($filename, 'w');
    fwrite($handle, $return);
    fclose($handle);

    // Menetapkan header untuk transfer file
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . basename($filename));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    header('Content-Type: application/sql');
    ob_clean();
    flush();
    readfile($filename);
}

// Fungsi untuk mengimpor database dari file SQL menggunakan PDO
function importDB($pdo)
{
    $sql = file_get_contents($_FILES['file']['tmp_name']);
    $pdo->query($sql);
}

// Fungsi untuk mengunggah gambar
function uploadImages()
{
    // Konfigurasi upload file
    $targetDir = "uploads/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $paths = array();

    $fileNames = array_filter($_FILES['files']['name']);
    if (!empty($fileNames)) {
        foreach ($_FILES['files']['name'] as $key => $val) {
            // Path untuk upload file
            $file = explode(".", $_FILES["files"]["name"][$key]);
            $fileName = md5(microtime(true)) . '.' . end($file);
            $targetFilePath = $targetDir . $fileName;

            // Periksa apakah tipe file valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            // Periksa apakah tipe file valid 
            if (in_array($fileType, $allowTypes, true) && verifyMagicByte($_FILES["files"]["tmp_name"][$key])) {
                $imageTemp = $_FILES["files"]["tmp_name"][$key];
                $imageUploadPath = $targetDir . $fileName;
                $paths[] = compressImage($imageTemp, $imageUploadPath, 50);
            }
        }
    }
    return $paths;
}

// Fungsi untuk memeriksa byte ajaib pada file gambar
function verifyMagicByte($file)
{
    // Byte ajaib untuk PNG, GIF, JFIF JPEG, EXIF JPEF secara berurutan
    $allowed = array('89504E47', '47494638', 'FFD8FFE0', 'FFD8FFE1');
    $handle = fopen($file, 'r');
    $bytes = strtoupper(bin2hex(fread($handle, 4)));
    fclose($handle);
    return in_array($bytes, $allowed);
}

// Fungsi untuk menghapus informasi EXIF dari gambar
function removeExif($image)
{
    $img = new Imagick($image);
    $profiles = $img->getImageProfiles("icc", true);

    $img->stripImage();

    if (!empty($profiles))
        $img->profileImage("icc", $profiles['icc']);
}

// Fungsi untuk mengompres gambar
function compressImage($source, $destination, $quality)
{
    // Dapatkan informasi gambar
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Buat gambar baru dari file
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Simpan gambar dengan kualitas tertentu
    imagejpeg($image, $destination, $quality);

    // Kembalikan path gambar yang terkompresi
    return $destination;
}
?>