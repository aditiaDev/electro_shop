<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cetak Struk</title>
    <style>
      @page { margin: 5px; }
      body { margin: 5px; }
      p{
        font-size:12px;
        margin: 0px;
      }
    </style>
</head>
<body>

<div id="container">
	<h5 style="text-align:center;">NOTA</h5>
    <table border="0" style="width:100%;font-size:12px;border: 0px solid #ddd;border-collapse: collapse;">
	  	<tbody>
        <tr>
          <td style="vertical-align: top">No Nota :</td>
          <td style="vertical-align: top"><?= $data[0]['id_penjualan']; ?></td>
          <td style="vertical-align: top">Pelanggan :</td>
          <td><?= $data[0]['id_pelanggan']."</br>".$data[0]['nm_pelanggan']; ?></td>
        </tr>
	  		<tr>
          <td>Tanggal :</td>
          <td colspan="3"><?= $data[0]['tgl_penjualan']; ?></td>
        </tr>
	  	</tbody>
	  </table>

    <table border="1" style="width:100%;font-size:10px;border: 1px solid #ddd;border-collapse: collapse;">
      <thead>
        <tr>
          <th>No</th>
          <th>Item</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $no=1;
        foreach($data as $row): 
      ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['id_barang']."</br>".$row['nm_barang']; ?></td>
          <td style="text-align:right;"><?= $row['jumlah']; ?></td>
          <td style="text-align:right;"><?= $row['harga']; ?></td>
          <td style="text-align:right;"><?= $row['subtotal']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" style="text-align:center;">Total</td>
          <td style="text-align:right;"><?= number_format($data[0]['tot_biaya_barang'],0,',','.'); ?></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align:center;">Penggunaan Point</td>
          <td style="text-align:right;"><?= number_format($data[0]['point_pengurangan'],0,',','.'); ?></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align:center;font-weight:bold;">Total Pembayaran</td>
          <td style="text-align:right;;font-weight:bold;">Rp. <?= number_format($data[0]['tot_akhir'],0,',','.'); ?></td>
        </tr>
      </tfoot>
    </table>

    <p style="text-align:center;font-size:10px;">Terima kasih telah Berbelanja di Toko Mahir Comp</p>
</div>
 
</body>
</html>
