<?php ini_set("display_errors",0);
require_once("includes/connect.php");
$timezone = "1";

$queryFile = mysql_query("select * from files where id = '$id'");
if(mysql_num_rows($queryFile)>0){
$info = mysql_fetch_assoc($queryFile);
$catid = $info['catid'];
$queryCat = mysql_query("select * from file_cat where id = '$catid'");
if(mysql_num_rows($queryCat)>0){
$catinfo = mysql_fetch_assoc($queryCat);
$catname = $catinfo['name'];
}

$title = ''.$info['name'].'';
include "includes/header.php";
echo '<div class="br"/><div class="title">'.$info['name'].'</div><div class="menu" align="center">';
if(!isset($_SESSION['download'.$info['id']])){ $_SESSION['download'.$info['id']] = md5($time); }
if(imgExt(getExt($info['name']))) { echo '<span class="img"><img src="'.$url.'/thumb.php?src='.$url.'/data/pengguna'.$info['userid'].'/'.$info['name'].'&amp;w=150&amp;h=150&amp;q=50" class="img" /></span>'; } else { $img = fileExt($info['name']);
if($img == jar) { $fimg = ''.$url.'/icon.php?id='.$info['id'].''; }
elseif(file_exists("images/$img.png")) { $fimg = ''.$url.'/images/file.png'; }
else { $fimg = ''.$url.'/images/file.png'; }
echo '<img src="'.$fimg.'"/>'; }
echo '</div><div class="menu"><b>Nama Berkas</b> : <a href="'.$url.'/download/'.$info['id'].'/'.$info['userid'].'/'.$_SESSION['download'.$info['id']].'/'.hdm_fileurl($info['name']).'">'.$info['name'].'</a></div><div class="menu"><b>Ukuran Berkas</b> : '.size($info['size']).'</div><div class="menu"><b>Kategori</b> : <a href="'.$url.'/loads/'.$info['catid'].'/'.hdm_converturl($catname).'.html">'.$catname.'</a></div>';
echo '<div class="menu"><b>Tanggal Unggah</b> : '.gmdate('d-m-Y, g:ia',$info['time']+3600*($timezone)).'</div><div class="menu"><b>Pengguna</b> : <font color="red">'.username($info['userid']).'</font></div><a href="'.$url.'/download/'.$info['id'].'/'.$info['userid'].'/'.$_SESSION['download'.$info['id']].'/'.hdm_fileurl($info['name']).'"><div class="download"><b>Unduh '.$info['name'].' ('.size($info['size']).')</b></div></a>';
if($rights==2){
echo '<div class="br"/><div class="title"><b>Hapus Berkas</b></div><div class="menu"><a href="'.$url.'/admin/?file&del='.$info['id'].'" style="color:red">Hapus</a></div>';
} } else {
$title = 'Berkas Tidak Ditemukan !';
include "includes/header.php";
echo '<div class="br"/><div class="title">Berkas Tidak Ditemukan</div><div class="news">Berkas tidak ada! <br><a href="'.$url.'/category.php">Kembali</a></div>'; } mysql_free_result($queryFile);
include "includes/footer.php";
?>
