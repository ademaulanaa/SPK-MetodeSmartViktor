<?php
require_once('includes/init.php');

$page = "Perhitungan SMART";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Perhitungan Metode SMART</h1>
</div>

<?php
// Logika perhitungan dipindahkan keluar dari kondisi POST
// Ini akan dijalankan setiap kali halaman dimuat

// Hapus data lama sebelum perhitungan baru
if (!mysqli_query($koneksi, "TRUNCATE TABLE hasil_smart;")) {
    die("Query error (TRUNCATE): " . mysqli_error($koneksi));
}

$kriterias = array();
$data_alternatif = array();

// Ambil data kriteria
$q0 = mysqli_query($koneksi, "SELECT SUM(bobot) as total FROM kriteria");
if (!$q0) die("Query error (SUM bobot): " . mysqli_error($koneksi));
$total_b = mysqli_fetch_array($q0);
$total_bobot_kriteria = $total_b['total'] > 0 ? $total_b['total'] : 1; // Hindari pembagian nol

$q1 = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY kode_kriteria ASC");
if (!$q1) die("Query error (kriteria): " . mysqli_error($koneksi));
while ($krit = mysqli_fetch_array($q1)) {
    $kriterias[$krit['id_kriteria']]['id_kriteria'] = $krit['id_kriteria'];
    $kriterias[$krit['id_kriteria']]['kode_kriteria'] = htmlspecialchars($krit['kode_kriteria']);
    $kriterias[$krit['id_kriteria']]['bobot'] = $krit['bobot'] / $total_bobot_kriteria;
    $kriterias[$krit['id_kriteria']]['jenis'] = strtolower($krit['type']);
}

// Tambahkan nilai max dan min dari sub_kriteria untuk masing-masing kriteria
foreach ($kriterias as $id_kriteria => $kriteria) {
    $sql = "SELECT MAX(nilai) as max_nilai, MIN(nilai) as min_nilai FROM sub_kriteria WHERE id_kriteria = '$id_kriteria'";
    $q_maxmin = mysqli_query($koneksi, $sql);
    if (!$q_maxmin) {
        die("Query error (MAX/MIN sub_kriteria): " . mysqli_error($koneksi));
    }
    $row = mysqli_fetch_assoc($q_maxmin);
    $kriterias[$id_kriteria]['max'] = $row['max_nilai'];
    $kriterias[$id_kriteria]['min'] = $row['min_nilai'];
}


// Ambil data alternatif
$q2 = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY nama ASC");
if (!$q2) die("Query error (alternatif): " . mysqli_error($koneksi));
while ($alt = mysqli_fetch_array($q2)) {
    $data_alternatif[$alt['id_alternatif']]['id_alternatif'] = $alt['id_alternatif'];
    $data_alternatif[$alt['id_alternatif']]['nama'] = htmlspecialchars($alt['nama']);
}

// Ambil data penilaian
$q3 = mysqli_query($koneksi, "SELECT * FROM penilaian ORDER BY id_alternatif, id_kriteria ASC");
if (!$q3) die("Query error (penilaian): " . mysqli_error($koneksi));
while ($nilmat = mysqli_fetch_array($q3)) {
    $id_alt = $nilmat['id_alternatif'];
    $id_krit = $nilmat['id_kriteria'];
    $nilai = $nilmat['nilai'];
    // Pastikan alternatif dan kriteria ada sebelum menambahkan nilai
    if (isset($data_alternatif[$id_alt]) && isset($kriterias[$id_krit])) {
        $data_alternatif[$id_alt]['nilai'][$id_krit] = $nilai;
    }
}

// Cek apakah ada data yang cukup untuk dihitung
if (empty($kriterias) || empty($data_alternatif)) {
    echo '<div class="alert alert-warning shadow mb-4" role="alert">';
    echo '<i class="fas fa-exclamation-triangle"></i> Belum ada data Kriteria, Alternatif, atau Penilaian yang cukup untuk melakukan perhitungan.';
    echo '</div>';
} else {
    // Cari nilai Max dan Min untuk setiap kriteria (Value Utility Function)
    foreach ($kriterias as $id_krit => $k) {
        $nilai_kriteria = array();
        
        // Kumpulkan semua nilai untuk kriteria ini
        foreach ($data_alternatif as $id_alt => $alt) {
            if (isset($alt['nilai'][$id_krit])) {
                $nilai_kriteria[] = $alt['nilai'][$id_krit];
            }
        }
        
        // Cari max dan min
        if (!empty($nilai_kriteria)) {
            $kriterias[$id_krit]['max'] = max($nilai_kriteria);
            $kriterias[$id_krit]['min'] = min($nilai_kriteria);
        } else {
            $kriterias[$id_krit]['max'] = 0;
            $kriterias[$id_krit]['min'] = 0;
        }
    }

    // Hitung normalisasi dan total nilai SMART
    foreach ($data_alternatif as $id_alt => $alt) {
        $total = 0;
        foreach ($kriterias as $id_krit => $k) {
            $nilai = isset($alt['nilai'][$id_krit]) ? $alt['nilai'][$id_krit] : 0;
            $normal = 0; // Default normalisasi
            
            // Periksa agar tidak terjadi pembagian dengan nol dan perbaiki rumus normalisasi
            if ($k['jenis'] == 'benefit') {
                // Untuk benefit: (Xi - Xmin) / (Xmax - Xmin)
                // Jika Xmax = Xmin, maka semua nilai sama, normalisasi = 1
                if ($k['max'] != $k['min']) {
                    $normal = ($nilai - $k['min']) / ($k['max'] - $k['min']);
                } else {
                    $normal = 1; // Semua nilai sama, berikan nilai maksimal
                }
            } else { // cost
                // Untuk cost: (Xmax - Xi) / (Xmax - Xmin)
                // Jika Xmax = Xmin, maka semua nilai sama, normalisasi = 1
                if ($k['max'] != $k['min']) {
                    $normal = ($k['max'] - $nilai) / ($k['max'] - $k['min']);
                } else {
                    $normal = 1; // Semua nilai sama, berikan nilai maksimal
                }
            }
            
            // Pastikan normalisasi tidak negatif dan tidak lebih dari 1
            $normal = max(0, min(1, $normal));
            
            $data_alternatif[$id_alt]['normal'][$id_krit] = $normal;
            $total += $normal * $k['bobot'];
        }
        $data_alternatif[$id_alt]['total'] = $total;

        // Simpan hasil ke database
        $total_escaped = mysqli_real_escape_string($koneksi, $total);
        mysqli_query($koneksi, "INSERT INTO hasil_smart (id_alternatif, nilai) VALUES ('$id_alt', '$total_escaped')");
    }

    // Urutkan alternatif berdasarkan total nilai (descending)
    uasort($data_alternatif, function($a, $b) {
        return $b['total'] <=> $a['total'];
    });
?>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3"><strong>Matriks Keputusan (X)</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Alternatif</th>
                    <?php foreach($kriterias as $k): ?>
                        <th><?= $k['kode_kriteria'] ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; 
                // Reset array untuk menampilkan dalam urutan asli
                $data_alternatif_original = array();
                $q2_display = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY nama ASC");
                while ($alt = mysqli_fetch_array($q2_display)) {
                    $id_alt = $alt['id_alternatif'];
                    if (isset($data_alternatif[$id_alt])) {
                        $data_alternatif_original[$id_alt] = $data_alternatif[$id_alt];
                    }
                }
                
                foreach($data_alternatif_original as $alt): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $alt['nama'] ?></td>
                    <?php foreach($kriterias as $id_krit => $k): ?>
                        <td><?= isset($alt['nilai'][$id_krit]) ? htmlspecialchars($alt['nilai'][$id_krit]) : 0 ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Bobot Kriteria</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <?php foreach($kriterias as $k): ?>
                        <th><?= $k['kode_kriteria'] ?> (<?= ucfirst($k['jenis']) ?>)</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($kriterias as $k): ?>
                        <td><?= number_format($k['bobot']*100, 2) ?>%</td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Normalisasi Bobot Kriteria</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <?php foreach($kriterias as $k): ?>
                        <th><?= $k['kode_kriteria'] ?> (<?= ucfirst($k['jenis']) ?>)</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($kriterias as $k): ?>
                        <td><?= number_format($k['bobot'], 4) ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Tambahkan tabel untuk menampilkan nilai Max dan Min setiap kriteria -->
<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Nilai Max dan Min Setiap Kriteria</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Kriteria</th>
                    <th>Jenis</th>
                    <th>Nilai Max</th>
                    <th>Nilai Min</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($kriterias as $k): ?>
                <tr>
                    <td><?= $k['kode_kriteria'] ?></td>
                    <td><?= ucfirst($k['jenis']) ?></td>
                    <td><?= $k['max'] ?></td>
                    <td><?= $k['min'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Matriks Ternormalisasi (R)</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Alternatif</th>
                    <?php foreach($kriterias as $k): ?>
                        <th><?= $k['kode_kriteria'] ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($data_alternatif_original as $alt): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $alt['nama'] ?></td>
                    <?php foreach($kriterias as $id_krit => $k): ?>
                        <td><?= isset($alt['normal'][$id_krit]) ? number_format($alt['normal'][$id_krit], 4) : 0 ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Perhitungan Nilai Akhir (Si)</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Alternatif</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($data_alternatif_original as $alt): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $alt['nama'] ?></td>
                    <td><?= number_format($alt['total'], 4) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Perankingan SMART</h6>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th width="10%">Ranking</th>
                    <th>Alternatif</th>
                    <th width="20%">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ranking = 1;
                foreach($data_alternatif as $alt){
                    echo "<tr>";
                    echo "<td>";
                    if ($ranking == 1):
                        echo '<span class="badge badge-success px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#'. $ranking .' </span>';
                    elseif ($ranking == 2):
                        echo '<span class="badge badge-warning px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#'. $ranking .'</span>';
                    elseif ($ranking == 3):
                        echo '<span class="badge badge-info px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#'. $ranking .'</span>';
                    else:
                        echo '<span class="badge badge-secondary px-3 py-2 text-white" style="font-size: 1rem; min-width: 70px;">'. $ranking .'</span>';
                    endif;
                    echo "</td>";
                    echo "<td>". htmlspecialchars($alt['nama']) ."</td>";
                    echo "<td>". number_format($alt['total'], 4) ."</td>";
                    echo "</tr>";
                    $ranking++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php } // Penutup else dari kondisi if (empty($kriterias) || empty($data_alternatif)) ?>

<?php
require_once('template/footer.php');
?>