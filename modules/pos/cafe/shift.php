<? session_start(); ?>
<? // include "otentik_admin.php"; include ("../include/functions.php");?><head>
<script type="text/javascript" src="../assets/kalendar_files/jsCalendar.js"></script>
<link href="../assets/kalendar_files/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../assets/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="../assets/jquery.validate.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$("#frmijin").validate({
		rules: {
			password: "required",
			password_again: {
		equalTo: "#password"
			}
		},
		messages: {
			email: {
				required: "E-mail harus diisi",
				email: "Masukkan E-mail yang valid"
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo(element.parent("td"));
		}
	});
})
</script>
<script type="text/javascript">
function confirmDelete(delUrl) {
	if (confirm("Shift ini akan dibuka!\nApakah Anda yakin ?")) {
			document.location = delUrl;
		}
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
<!--
body {
	background-image: url(../images/bg.png);
}
.style1 {
	font-family: "Segoe UI";
	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
-->
</style></head>



<style type="text/css">
* { font: 11px/20px Verdana, sans-serif; }
h4 { font-size: 18px; }
input.error, select.error { border: 1px solid red; }
label.error { color:red; margin-left: 10px; }
td { padding: 5px; }
</style>
<?  
	include "../include/globalx.php"; ?>
<?
	$SQL = "SELECT * FROM $database.shift WHERE id <> ''";
	if ($_GET['id']<>"") {
		$SQL = $SQL." and id=".$_GET['id'];
	}
	$SQL = $SQL." ORDER BY id DESC LIMIT 20";
	//echo $SQL;
	$hasil=mysql_query($SQL, $dbh_jogjaide);
?>
<table width="1140" border="0">
  <tr>
    <td width="32"><img src="../images/calendar.png" width="32" height="32" /></td>
    <td width="1090"><span class="style1">SETUP DIVISI 
      </span>
      <hr /></td>
  </tr>
  <tr>
    <td width="32">&nbsp;</td>
    <td><table border="1" align="left" cellpadding="3" cellspacing="0" bordercolorlight="silver" bordercolordark="#FFFFFF">
      <? if ($_GET['id']<>"") {?>
      <tr>
        <td background="../images/impactg.png" colspan="9" align="center"><font color="white"><b>Edit Meja </b></font></td>
      </tr>
      <? } else { ?>
      <tr>
        <td background="../images/impactg.png" colspan="9" align="center"><strong><font color="white">MASTER Shift </font></strong></td>
      </tr>
      <? } ?>
      <tr bgcolor="#FFCC00">
        <td width="150" align="center"><strong>Kode shift </strong></td>
        <td width="150" align="center"><strong>Nama shift </strong></td>
        <td width="150" align="center"><strong>Tanggal </strong></td>
        <? if ($_GET['id']<>"") { ?>
        <td width="58" align="center"><b>Update</b></td>
        <td width="58" align="center"><b>Batal</b></td>
        <? } else { ?>
        <td width="58" align="center"><strong>Edit</strong></td>
        <td width="58" align="center"><b>Open</b></td>
        <td width="58" align="center"><b>status</b></td>
        <? } ?>
      </tr>
      <? if ($_GET['id']=="") { ?>
      <tr bgcolor="yellow">
        <form name="frmijin" id="frmijin" method="post" action="submission_cafe.php">
          <input type="hidden" name="cmd" value="add_sft" />
          <td>&nbsp;</td><td align="center"><select  name="nama"  class="required" title="*">
		  <option value="">Pilih Nama</option>
		  <?php
		  	$sqls = "select * from ml_user where id <> 1 and status = 1";
			$hasils = mysql_query($sqls);
			while($bariss = mysql_fetch_array($hasils)){
		  ?>
		  	<option value="<?=$bariss["id"]?>"><?=$bariss["nama"]?></option>
		  <? } ?>
		  </select></td>
          <td align="center"><input type="text" name="tanggal" id="tanggal" size="10" class="required" title="*" value="<?=$_GET['tanggal']?>" <? if($_GET['nomor']<>""){ ?>  readonly="true"  <? }?> />
          <a href="javascript:showCalendar('tanggal')"><img src="../assets/kalendar_files/calendar_icon.gif" border="0"></a></td>
          <td align="center" colspan="4"><input name="image" type="image" src="../images/add.gif" border="0" /></td>
        </form>
      </tr>
      <? } ?>
      <?	 
		$nRecord = 1;
		if (mysql_num_rows($hasil) > 0) { 
		while ($row=mysql_fetch_array($hasil)) { 
	?>
      <tr <?	 if (($nRecord % 2)==0) {?>bgcolor="#FFFFFF"<? } else {?> else="else" bgcolor="#CCCCCC"<? }?>>
        <form action="submission_cafe.php" method="post" name="frmijin" id="frmijin">
          <input type="hidden" name="id" value="<?=$_GET['id']?>" />
          <input type="hidden" name="cmd" value="upd_sft" />
		  <td align="center"><?php echo $row["id"]; ?></td>
          <td align="left"><? if ($_GET['id']<>"") { ?>
            <select  name="nama"  class="required" title="*">
              <?php
		  	$sqls = "select * from ml_user where id <> 1 and status = 1";
			$hasils = mysql_query($sqls);
			while($bariss = mysql_fetch_array($hasils)){
		  ?>
              <option value="<?=$bariss["id"]?>" <? if($_GET["user_id"]== $bariss["id"]) { ?> selected="selected" <? }?>><?=$bariss["nama"]?></option>
              <? } ?>
            </select>
            <? } else { ?>
              <?
			  $hasild = mysql_query("select nama from ml_user WHERE id = '$row[user_id]'");
			  $rowd = mysql_fetch_array($hasild);
			  echo $rowd["nama"]; ?>
              <? } ?></td>
          <td align="left"><? if ($_GET['id']<>"") { ?>
            <input type="text" name="tanggal" id="tanggal" size="10" class="required" title="*" value="<?=$_GET['tanggal']?>" <? if($_GET['nomor']<>""){ ?>  readonly="true"  <? }?> />
          <a href="javascript:showCalendar('tanggal')"><img src="../assets/kalendar_files/calendar_icon.gif" border="0"></a>
            <? } else { ?>
              <?=baliktglindo($row["tanggal"])?>
              <? } ?></td>
          <? if ($_GET['id']<>"") { ?>
          <td align="center"><input name="image" type="image" src="../images/approve.gif" border="0" /></td>
          <td align="center"><a href="javascript:history.back()"><img src="../images/kal_prev.gif" alt="Sebelumnya" border="0" /></a></td>
          <? } else { ?>
          <td align="center"><a href="?mn=<?=$_GET['mn']?>&amp;id=<?=$row["id"]?>&amp;tanggal=<?=baliktglindo($row["tanggal"])?>&amp;user_id=<?=($row["user_id"])?>"><img src="../images/edit.gif" alt="Edit" border="0" /></a></td>
          <td align="center"><a href="javascript:confirmDelete('submission_cafe.php?id=<?=$row["id"]?>&amp;cmd=open_sft')">Open</a></td>
          <td align="center"><?php echo $row["status"]; ?></td>
          <? } ?>
        </form>
      </tr>
      <?  
		 $nRecord = $nRecord + 1;
		} 
	} else { ?>
      <tr>
        <td align="center" colspan="9"><font color="red">Mohon maaf, tidak ada Data dimaksud.</font></td>
      </tr>
      <?  } ?>
    </table></td>
  </tr>
</table>
