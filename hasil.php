<?php
require_once('includes/init.php');

$page = "Hasil";
require_once('template/header.php');

// Ambil data hasil untuk tabel dan mencari alternatif terbaik
$query_hasil = mysqli_query($koneksi, "SELECT * FROM hasil_smart JOIN alternatif ON hasil_smart.id_alternatif=alternatif.id_alternatif ORDER BY hasil_smart.nilai DESC");
$data_hasil = []; // Array untuk menyimpan semua data hasil

while ($data = mysqli_fetch_array($query_hasil)) {
    $data_hasil[] = $data;
}

// Ambil alternatif terbaik (jika ada data)
$top_alternatif = null;
if (!empty($data_hasil)) {
    $top_alternatif = $data_hasil[0]; // Alternatif pertama setelah diurutkan adalah yang terbaik
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Hasil Akhir</h1>
    
    <a href="cetak.php" target="_blank" class="btn btn-primary btn-icon-split"> 
        <span class="icon text-white-50"><i class="fas fa-print"></i></span>
        <span class="text">Cetak Data</span>
    </a>
</div>

<div class="row">
    
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-table"></i> Hasil Akhir Perankingan SMART</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr align="center">
                                <th width="10%">Rank</th>
                                <th>Nama Alternatif</th>
                                <th width="20%">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 0;
                                if (!empty($data_hasil)) {
                                    foreach ($data_hasil as $row) {
                                        $no++;
                            ?>
                            <tr align="center">
                                <td>
                                    <?php if ($no == 1): ?>
                                        <span class="badge badge-success px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#<?= $no; ?> </span>
                                    <?php elseif ($no == 2): ?>
                                        <span class="badge badge-warning px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#<?= $no; ?></span>
                                    <?php elseif ($no == 3): ?>
                                        <span class="badge badge-info px-3 py-2 text-white font-weight-bold" style="font-size: 1rem; min-width: 70px;">#<?= $no; ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary px-3 py-2 text-white" style="font-size: 1rem; min-width: 70px;"><?= $no; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td align="left"><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= number_format($row['nilai'], 4) ?></td>
                            </tr>
                            <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="3" class="text-center">Belum ada data hasil perankingan.</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once('template/footer.php');
?>