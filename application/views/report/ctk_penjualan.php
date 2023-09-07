<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
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
	<h1 style="text-align:center;">Laporan Penjualan</h1>
  <p>Period : <?= $from ?> sampai <?= $to ?></p>
    <table border="1" style="width:100%;font-size:10px;border: 1px solid #ddd;border-collapse: collapse;">
      <thead>
        <tr>
          <th>ID Penjualan</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Tipe Penjualan</th>
          <th>Potongan (dari Point)</th>
          <th>Barang</th>
          <th>jumlah</th>
          <th>Harga</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no=1;
        $tot_potongan = 0;
        $tot_barang = 0;
        $id_penjualanx="";
        $point_penguranganx=0;
        foreach($data as $row): 
          $id_penjualan = $row['id_penjualan'];
          $point_pengurangan = $row['point_pengurangan'];
          if($id_penjualanx <> $id_penjualan){
            $id_penjualanx = $id_penjualan;
            $point_penguranganx = $point_pengurangan;
          }else{
            $id_penjualanx = "";
            $point_penguranganx = 0;
          }
      ?>
        <tr>
          <td><?= $id_penjualanx; ?></td>
          <td ><?= $row['tgl_penjualan']; ?></td>
          <td ><?= $row['id_pelanggan']."</br>".$row['nm_pelanggan']; ?></td>
          <td ><?= $row['tipe_penjualan']; ?></td>
          <td  style="text-align:right;"><?= number_format($point_penguranganx,0,',','.'); ?></td>
          <td ><?= $row['id_barang']."</br>".$row['nm_barang']; ?></td>
          <td  style="text-align:right;"><?= number_format($row['jumlah'],0,',','.'); ?></td>
          <td style="text-align:right;"><?= number_format($row['harga'],0,',','.'); ?></td>
          <td style="text-align:right;"><?= number_format($row['subtotal'],0,',','.'); ?></td>
        </tr>
        <?php 
          $id_penjualanx = $id_penjualan;

          $tot_potongan += $point_penguranganx;
          $tot_barang += $row['subtotal'];
          endforeach; 
        ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"></td>
          <td style="text-align:right;"><?= number_format($tot_potongan,0,',','.'); ?></td>
          <td colspan="3"></td>
          <td style="text-align:right;"><?= number_format($tot_barang,0,',','.'); ?></td>
        </tr>
        <tr>
          <td colspan="8" style="text-align:center;font-weight:bold;font-size:14px;">Grand Total (Total Item - Total Potongan)</td>
          <td style="text-align:right;font-weight:bold;font-size:14px;">Rp. <?= number_format( ( $tot_barang - $tot_potongan ),0,',','.'); ?></td>
        </tr>
      </tfoot>
    </table>

</div>
 
</body>
</html>
