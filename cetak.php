<?php
require_once('includes/init.php');
?>	

<html>
	<head>
		<title>Sistem Pendukung Keputusan Metode SMART & VIKOR</title>
	</head>
<body onload="window.print();">

<div style="width:100%;margin:0 auto;text-align:center;">
	<h4>Hasil Akhir Perankingan SMART</h4>
	<br/>
	<table width="100%" cellspacing="0" cellpadding="5" border="1">
		<thead>
			<tr align="center">
				<th>Nama Alternatif</th>
				<th>Nilai</th>
				<th width="15%">Rank</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no=0;
				$query = mysqli_query($koneksi,"SELECT * FROM hasil_smart JOIN alternatif ON hasil_smart.id_alternatif=alternatif.id_alternatif ORDER BY hasil_smart.nilai DESC");
				while($data = mysqli_fetch_array($query)){
				$no++;
			?>
			<tr align="center">
				<td align="left"><?= $data['nama'] ?></td>
				<td><?= $data['nilai'] ?></td>
				<td><?= $no; ?></td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	
</div>

</body>
</html>
