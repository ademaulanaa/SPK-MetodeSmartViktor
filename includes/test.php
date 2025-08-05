<?php
require_once('includes/init.php');

$page = "Perhitungan SMART";
require_once('template/header.php');
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-calculator"></i> Perhitungan Metode SMART</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Hitung Menggunakan SMART</h6>
    </div>

    <div class="card-body">
        <form action="" method="POST">
            <div class="row">
                <div class="col-10">
                    <button name="hitung" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Hitung</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['hitung'])) {
    if (!mysqli_query($koneksi,"TRUNCATE TABLE hasil_smart;")) die("Query error (TRUNCATE): " . mysqli_error($koneksi));
    $kriterias = array();
    $q0 = mysqli_query($koneksi,"SELECT SUM(bobot) as total FROM kriteria"); if (!$q0) die("Query error (SUM bobot): " . mysqli_error($koneksi));            
    $total_b = mysqli_fetch_array($q0);
    $q1 = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY kode_kriteria ASC"); if (!$q1) die("Query error (kriteria): " . mysqli_error($koneksi));            
    while($krit = mysqli_fetch_array($q1)){
        $kriterias[$krit['id_kriteria']]['id_kriteria'] = $krit['id_kriteria'];
        $kriterias[$krit['id_kriteria']]['kode_kriteria'] = $krit['kode_kriteria'];
        $kriterias[$krit['id_kriteria']]['bobot'] = $krit['bobot'] / $total_b['total'];
        $kriterias[$krit['id_kriteria']]['jenis'] = strtolower($krit['type']);
    }

    $data_alternatif = array();
    $q2 = mysqli_query($koneksi,"SELECT * FROM alternatif ORDER BY nama ASC"); if (!$q2) die("Query error (alternatif): " . mysqli_error($koneksi));
    while($alt = mysqli_fetch_array($q2)){
        $data_alternatif[$alt['id_alternatif']]['id_alternatif'] = $alt['id_alternatif'];
        $data_alternatif[$alt['id_alternatif']]['nama'] = $alt['nama'];
    }

    $q3 = mysqli_query($koneksi,"SELECT * FROM penilaian ORDER BY id_alternatif, id_kriteria ASC"); if (!$q3) die("Query error (penilaian): " . mysqli_error($koneksi));
    while($nilmat = mysqli_fetch_array($q3)){
        $id_alt = $nilmat['id_alternatif'];
        $id_krit = $nilmat['id_kriteria'];
        $nilai = $nilmat['nilai'];
        $data_alternatif[$id_alt]['nilai'][$id_krit] = $nilai;
    }

    foreach($kriterias as $id_krit => $k){
        $max = $min = null;
        foreach($data_alternatif as $id_alt => $alt){
            $nilai = isset($alt['nilai'][$id_krit]) ? $alt['nilai'][$id_krit] : 0;
            if($max === null || $nilai > $max) $max = $nilai;
            if($min === null || $nilai < $min) $min = $nilai;
        }
        $kriterias[$id_krit]['max'] = $max;
        $kriterias[$id_krit]['min'] = $min;
    }

    foreach($data_alternatif as $id_alt => $alt){
        $total = 0;
        foreach($kriterias as $id_krit => $k){
            $nilai = isset($alt['nilai'][$id_krit]) ? $alt['nilai'][$id_krit] : 0;
            if($k['jenis'] == 'benefit'){
                $normal = ($k['max'] != 0) ? $nilai / $k['max'] : 0;
            } else {
                $normal = ($nilai != 0) ? $k['min'] / $nilai : 0;
            }
            $data_alternatif[$id_alt]['normal'][$id_krit] = $normal;
            $total += $normal * $k['bobot'];
        }
        $data_alternatif[$id_alt]['total'] = $total;

        mysqli_query($koneksi,"INSERT INTO hasil_smart (id_alternatif, nilai) VALUES ('$id_alt', '$total')");
    }

    uasort($data_alternatif, function($a, $b) {
        return $b['total'] <=> $a['total'];
    });
?>


<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3"><strong>Matriks Keputusan (X)</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>No</th><th>Nama Alternatif</th><?php foreach($kriterias as $k): ?><th><?= $k['kode_kriteria'] ?></th><?php endforeach; ?></tr></thead><tbody><?php $no=1; foreach($data_alternatif as $alt): ?><tr><td><?= $no++ ?></td><td><?= $alt['nama'] ?></td><?php foreach($kriterias as $id_krit => $k): ?><td><?= $alt['nilai'][$id_krit] ?? 0 ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Bobot Kriteria</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered"><thead><tr><?php foreach($kriterias as $k): ?><th><?= $k['kode_kriteria'] ?> (<?= ucfirst($k['jenis']) ?>)</th><?php endforeach; ?></tr></thead><tbody><tr><?php foreach($kriterias as $k): ?><td><?= round($k['bobot']*100, 2) ?></td><?php endforeach; ?></tr></tbody></table></div></div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Normalisasi Bobot Kriteria</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered"><thead><tr><?php foreach($kriterias as $k): ?><th><?= $k['kode_kriteria'] ?> (<?= ucfirst($k['jenis']) ?>)</th><?php endforeach; ?></tr></thead><tbody><tr><?php foreach($kriterias as $k): ?><td><?= round($k['bobot'], 4) ?></td><?php endforeach; ?></tr></tbody></table></div></div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Matriks Ternormalisasi (R)</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>No</th><th>Nama Alternatif</th><?php foreach($kriterias as $k): ?><th><?= $k['kode_kriteria'] ?></th><?php endforeach; ?></tr></thead><tbody><?php $no=1; foreach($data_alternatif as $alt): ?><tr><td><?= $no++ ?></td><td><?= $alt['nama'] ?></td><?php foreach($kriterias as $id_krit => $k): ?><td><?= isset($alt['normal'][$id_krit]) ? round($alt['normal'][$id_krit], 4) : 0 ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></div></div>
<div class="card shadow mb-4">
    <div class="card-header py-3"><strong>Perhitungan Nilai</strong></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead><tr><th>No</th><th>Nama Alternatif</th><th>Total Nilai</th></tr></thead><tbody>
            <?php $no=1; foreach($data_alternatif as $alt): ?>
            <tr><td><?= $no++ ?></td><td><?= $alt['nama'] ?></td><td><?= round($alt['total'], 4) ?></td></tr>
            <?php endforeach; ?>
        </tbody></table>
    </div>
</div>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Perhitungan SMART</h6>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Alternatif</th>
                    <th>Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ranking = 1;
                foreach($data_alternatif as $alt){
                    echo "<tr>";
                    echo "<td>{$ranking}</td>";
                    echo "<td>{$alt['nama']}</td>";
                    echo "<td>".round($alt['total'], 4)."</td>";
                    echo "</tr>";
                    $ranking++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php } ?>

<?php
require_once('template/footer.php');
?>
