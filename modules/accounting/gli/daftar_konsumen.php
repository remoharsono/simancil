<html>
 <head>
  <title>Daftar Buku</title>
  <style>
   body,table,input{
   	font-size:12px
   }
  </style>
  <script language="javascript">
   function selectSupp(no,nama){
	   window.parent.selectSupp(no,nama);
	   window.parent.tb_remove();
   }
  </script>
 </head>
<body>
<?
 include '../include/globalx.php';
 
 $SQL = "SELECT * FROM $database.supplier WHERE status = 1";
 if(isset($_POST['search'])){
	 $SQL = "SELECT * FROM $database.supplier WHERE  status = 1 AND nama LIKE '%$_POST[search_name]%'";
 }
 $query = mysql_query($SQL, $dbh_jogjaide);
 //echo $SQL;
?>
<form action="" method="post">
 Cari Nama Rekening: <input type="text" name="search_name" size="15" value="<?php echo @$_POST['search_name']; ?>" />
 <input type="submit" name="search" value="Cari" />
</form>
<table width="100%" bgcolor="#000000" cellspacing="1" cellpadding="3">	
	<tr bgcolor="#DDDDDD">
		<th>Kode Supplier</th>
		<th>Nama Supplier</th>
	</tr>
	<? while($row = mysql_fetch_object($query)): ?>
	<tr bgcolor="#FFFFFF">
		<!-- fungsi selectBuku di deklarasikan di index.html dan file ini bisa memanggilnya selama file ini
			 dipanggil oleh thickbox dari index.html, fungsi dari selectPegawai adalah untuk memasukan nilai
			 NIP dan nama pegawai dari masing-masing baris di daftar pegawai ini -->
		<td align="center"><a href="javascript:selectSupp('<?=$row->kode?>','<?=$row->nama?>')"><?=$row->kode?></a></td>
		<td><?=$row->nama?></td>
	</tr>
	<? endwhile; ?>
</table>
</body>
</html>
