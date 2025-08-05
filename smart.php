<?php
require_once('includes/init.php');

// Ambil semua alternatif dari DB
$query = mysqli_query($koneksi, "SELECT * FROM alternatif");
$alternatif = [];
while ($row = mysqli_fetch_assoc($query)) {
    $alternatif[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Perbandingan Produk - SMART</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background: #fff;
            padding: 40px;
            margin-top: 40px;
            margin-bottom: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        h3, h4 {
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .badge {
            font-size: 1rem;
            padding: 0.6em 1em;
            border-radius: 6px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center">Bandingkan Produk Parfum (Metode SMART)</h3>
    <form method="post">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width:10%;">Pilih</th>
                        <th>Nama Parfum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alternatif as $alt): ?>
                        <tr onclick="toggleCheckbox(this)">
                            <td>
                                <input class="form-check-input" type="checkbox" name="alternatif[]" value="<?= $alt['id_alternatif']; ?>" onclick="event.stopPropagation()">
                            </td>
                            <td class="text-start"><?= $alt['nama']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="home.php" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary">Bandingkan Sekarang</button>
        </div>
    </form>

    <?php if (isset($_POST['alternatif'])): ?>
        <h4 class="mt-5 text-center">Hasil Perbandingan Berdasarkan Metode SMART</h4>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Produk</th>
                        <th>Nilai SMART</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $kriteria = [];
                    $qk = mysqli_query($koneksi, "SELECT * FROM kriteria");
                    $total_bobot = 0;
                    while ($k = mysqli_fetch_assoc($qk)) {
                        $total_bobot += $k['bobot'];
                        $kriteria[$k['id_kriteria']] = $k;
                    }

                    foreach ($kriteria as $id_k => &$k) {
                        $k['bobot'] = $k['bobot'] / $total_bobot;
                        $qmm = mysqli_query($koneksi, "SELECT MIN(nilai) as min, MAX(nilai) as max FROM penilaian WHERE id_kriteria = '$id_k'");
                        $mm = mysqli_fetch_assoc($qmm);
                        $k['min'] = $mm['min'];
                        $k['max'] = $mm['max'];
                    }

                    $ids = $_POST['alternatif'];
                    $hasil = [];
                    foreach ($ids as $id) {
                        $alt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nama FROM alternatif WHERE id_alternatif = '$id'"));
                        $qp = mysqli_query($koneksi, "SELECT * FROM penilaian WHERE id_alternatif = '$id'");
                        $total = 0;
                        while ($p = mysqli_fetch_assoc($qp)) {
                            $krit = $kriteria[$p['id_kriteria']];
                            $nilai = $p['nilai'];
                            if ($krit['max'] == $krit['min']) {
                                $normal = 1;
                            } else {
                                if (strtolower($krit['type']) == 'benefit') {
                                    $normal = ($nilai - $krit['min']) / ($krit['max'] - $krit['min']);
                                } else {
                                    $normal = ($krit['max'] - $nilai) / ($krit['max'] - $krit['min']);
                                }
                            }
                            $total += $normal * $krit['bobot'];
                        }
                        $hasil[] = ['nama' => $alt['nama'], 'skor' => $total];
                    }

                    usort($hasil, function($a, $b) {
                        return $b['skor'] <=> $a['skor'];
                    });

                    $no = 1;
                    foreach ($hasil as $row): ?>
                        <tr>
                            <td><span class="badge bg-dark">#<?= $no++; ?></span></td>
                            <td class="text-start"><?= $row['nama']; ?></td>
                            <td><span class="badge bg-success fs-6"><?= number_format($row['skor'], 4); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<script>
function toggleCheckbox(row) {
    const checkbox = row.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
}
</script>
</body>
</html>
