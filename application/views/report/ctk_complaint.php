<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Customer Complaint</title>
    <style>
      @page { margin: 5px; }
      body { margin: 5px; }
      p{
        font-size:14px;
        font-weight: bold;
        margin: 0px;
      }

      table tr td{
        padding-left: 5px;
        padding-right: 5px;
      }
    </style>
</head>
<body>

<div id="container">
	<h1 style="text-align:center;">Laporan Customer Complaint</h1>
  <p>Period : <?= $from ?> sampai <?= $to ?></p>
    <table border="1" style="width:100%;font-size:10px;border: 1px solid #ddd;border-collapse: collapse;">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Complaint</th>
          <th>ID Penjualan</th>
          <th>Tanggal</th>
          <th>Judul Complaint</th>
          <th>Deskripsi</th>
          <th>Pelanggan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no=1;
        foreach($data as $row): 
      ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['id_complaint']; ?></td>
          <td ><?= $row['id_penjualan']; ?></td>
          <td ><?= $row['tgl_complaint']; ?></td>
          <td ><?= $row['judul_complaint']; ?></td>
          <td ><?= $row['deskripsi']; ?></td>
          <td ><?= $row['id_pelanggan']."</br>".$row['nm_pelanggan']; ?></td>
          <td ><?= $row['status']; ?></td>
        </tr>
        <?php 
          endforeach; 
        ?>
      </tbody>
    </table>

</div>
 
</body>
</html>
