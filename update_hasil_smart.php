<?php
require_once('includes/init.php'); // Sesuaikan path jika perlu

// Fungsi untuk menghitung nilai SMART untuk semua alternatif dan mengupdate tabel hasil_smart
function updateHasilSmart($koneksi) {
    // 1. Hapus data lama di tabel hasil_smart
    // Ini penting agar tidak ada data usang atau duplikat
    mysqli_query($koneksi, "TRUNCATE TABLE hasil_smart");

    // 2. Ambil bobot kriteria
    $kriteria = [];
    $qk = mysqli_query($koneksi, "SELECT * FROM kriteria");
    while ($k = mysqli_fetch_assoc($qk)) {
        $kriteria[$k['id_kriteria']] = [
            'kode' => $k['kode_kriteria'],
            'bobot' => $k['bobot'],
            'tipe' => $k['type'] // benefit/cost
        ];
    }

    // 3. Ambil nilai MIN dan MAX untuk SETIAP kriteria SEKALI SAJA
    $min_max_values = [];
    foreach ($kriteria as $id_kriteria => $data_kriteria) {
        $q_min_max = mysqli_query($koneksi, "SELECT MIN(nilai) as min_nilai, MAX(nilai) as max_nilai FROM penilaian WHERE id_kriteria = '$id_kriteria'");
        $row_min_max = mysqli_fetch_assoc($q_min_max);
        $min_max_values[$id_kriteria] = [
            'min' => $row_min_max['min_nilai'],
            'max' => $row_min_max['max_nilai']
        ];
    }

    // 4. Ambil semua alternatif yang ada untuk perhitungan
    $alternatif_all = [];
    $q_alt = mysqli_query($koneksi, "SELECT * FROM alternatif");
    while ($a = mysqli_fetch_assoc($q_alt)) {
        $alternatif_all[] = $a['id_alternatif'];
    }

    // 5. Proses perhitungan SMART untuk SEMUA alternatif
    foreach ($alternatif_all as $id_alternatif) {
        $nilai_total = 0;

        $qp = mysqli_query($koneksi, "SELECT * FROM penilaian WHERE id_alternatif = '$id_alternatif'");
        while ($p = mysqli_fetch_assoc($qp)) {
            $id_kriteria = $p['id_kriteria'];
            $nilai = $p['nilai'];

            // Pastikan kriteria ini ada di array $kriteria
            if (!isset($kriteria[$id_kriteria])) {
                continue; // Lewati jika kriteria tidak ditemukan (data tidak konsisten)
            }

            $min_nilai_kriteria = $min_max_values[$id_kriteria]['min'];
            $max_nilai_kriteria = $min_max_values[$id_kriteria]['max'];
            
            $bobot = $kriteria[$id_kriteria]['bobot'];
            $jenis = $kriteria[$id_kriteria]['tipe'];

            $normal = 0; // Inisialisasi

            if (($max_nilai_kriteria - $min_nilai_kriteria) != 0) {
                if ($jenis == 'benefit') {
                    $normal = ($nilai - $min_nilai_kriteria) / ($max_nilai_kriteria - $min_nilai_kriteria);
                } else { // cost
                    $normal = ($max_nilai_kriteria - $nilai) / ($max_nilai_kriteria - $min_nilai_kriteria);
                }
            } else {
                // Jika min dan max sama, maka utilitas adalah 1 jika nilai kriteria sama dengan min/max
                $normal = ($nilai == $min_nilai_kriteria && $nilai == $max_nilai_kriteria) ? 1 : 0; 
            }
            
            $nilai_total += $normal * $bobot;
        }

        // 6. Simpan/Update hasil ke tabel hasil_smart
        // Gunakan prepared statement untuk keamanan (opsional tapi disarankan)
        $insert_query = "INSERT INTO hasil_smart (id_alternatif, nilai) VALUES ('$id_alternatif', '$nilai_total')";
        if (!mysqli_query($koneksi, $insert_query)) {
            error_log("Gagal menyimpan hasil SMART untuk alternatif $id_alternatif: " . mysqli_error($koneksi));
            // Anda bisa tambahkan handling error yang lebih baik di sini
        }
    }
    return true;
}

// Panggil fungsi update di sini, misalnya saat halaman diakses
// Atau bisa dipanggil dari tombol di admin
// updateHasilSmart($koneksi); // Contoh pemanggilan
?>