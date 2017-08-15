<?php ini_set("display_errors",0);
include('../includes/connect.php');
if(!$userid || $rights<2) go($url);

if(isset($_GET['users'])){
$title = 'Kontrol Panel Admin';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Pengguna</div>';
$queryUsers = mysql_query('select id,rights,nim,username from users order by `id` asc limit '.$j.', 10');
$queryNum = mysql_query('select id from users');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($user=mysql_fetch_assoc($queryUsers)){
echo '<div class="menu">Pengguna: <b><font color="blue">'.$user['username'].'</font></b> <br>ID Pengguna: <b>'.$user['id'].'</b> <br>NIM: <font color="red"<b>'.$user['nim'].'</b></font> <br>Jabatan: <b>('.user_rights($user['rights']).')</b> <br>
<a href="?user&del='.$user['id'].'">[hapus]</a> <a href="?user&edit='.$user['id'].'">[ubah]</a></div>';
}
mysql_free_result($queryUsers);
mysql_free_result($queryNum);
paging($all,$page,10,$url.'/admin/?users&');
}
include '../includes/footer.php';
die();
}

if(isset($_GET['user'])){
$title = 'Kelola Pengguna';
include('../includes/header.php');

if(isset($_GET['del'])){
$del = intval($_GET['del']);
echo '<div class="br"/><div class="title">Hapus</div>';
$idu = mysql_query("select id from users where id = '$del'");
if(mysql_num_rows($idu)>0){
if (isset($_POST['submit'])) {
rrmdir('../data/user'.$inf['id']);
mysql_query("delete from users where id = '$del'");
mysql_query("delete from files where userid = '$del'");
mysql_free_result($idu);
echo '<div class="news">Pengguna berhasil dihapus! <br><a href="?users">Kembali</a></div>';
} else {
echo '<div class="news">Kamu yakin ingin menghapus pengguna <font color="red">(<b>'.username($del).'</b>)</font> ? ' . '<form method="post">' . '<input type="submit" name="submit" value="Hapus" />' . ' <a href="?users">Batal</a></form></div>';
}
} else {
echo '<div class="news">Pengguna tidak ada! <br><a href="?users">Kembali</a></div>';
}
}
elseif(isset($_GET['edit'])){
$fandy = intval($_GET['edit']);
echo '<div class="br"/><div class="title">Ubah '.username($fandy).'</div>';
$idu = mysql_query("select mail,rights,username from users where id = '$fandy'");
if(mysql_num_rows($idu)>0){
$inf  = mysql_fetch_assoc($idu);
if(isset($_POST['change'])){
$mail = (strlen($_POST['mail'])>50) ? input(substr($_POST['mail'],0,50)) : input($_POST['mail']) ;
$rights = intval($_POST['rights']);
mysql_query("UPDATE users Set mail = '$mail', rights = '$rights' where id = '$fandy'");
echo '<div class="menu">Data pengguna berhasil di perbaharui! <br/><a href="?users">Kembali ke Pengguna</a></div>';
} else {
echo '<div class="menu"><form method="post">Pengguna: '.$inf['username'].'<br>E-mail:<br/><input type="text" name="mail" value="'.$inf['mail'].'" size="15"/><br>Jabatan: '.user_rights($inf['rights']).'<br/>Jabatan Pengguna: <br><select name="rights"><option value="1">Pengguna</option><br><option value="2">Admin</option><br></select><br/><input type="submit" name="change" value="Simpan"></form></div>'; } } else {
echo '<div class="news">Pengguna tidak ada! <br><a href="?users">Kembali</a></div>';
}
}  else {
header("location: ?users");
}
include '../includes/footer.php';
die();
}
if(isset($_GET['files'])){
$title = 'Kelola Berkas';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Kelola Berkas</div>';
$queryFiles = mysql_query('select * from files order by `time` desc limit '.$j.', 10');
$queryNum = mysql_query('select id from files');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($file=mysql_fetch_assoc($queryFiles)){
$Filetag = fileExt($file['name']);
$name = $file['name'];
$name = str_replace(".$Filetag","",$name);
echo '
<div class="menu">File: <a href="'.$url.'/load/file/'.$file['id'].'/'.hdm_converturl($name).'.html">'.$file['name'].'</a>
<br>Ukuran File: '.size($file['size']).'
<br>Kategori: '.catname($file['catid']).'
<br>Pengunggah: '.username($file['userid']).'<br>
<a href="?file&del='.$file['id'].'"><font color="red">hapus</font></a></div>';
}
mysql_free_result($queryFiles);
mysql_free_result($queryNum);
paging($all,$page,10,$url.'/admin/?files&');
} else {
echo '<div class="news">Tidak ada berkas, Belum di unggah! <br><a href="'.$url.'/pengguna/upload.php">Unggah disini</a></div>';
}
include '../includes/footer.php';
die();
}

if(isset($_GET['file'])){
$title = 'Kelola Berkas';
include('../includes/header.php');

if(isset($_GET['del'])){
echo '<div class="br"/><div class="title">Hapus Berkas</div>';
$del = intval($_GET['del']);
$idf = mysql_query("select * from files where id = '$del'");
if(mysql_num_rows($idf)>0){
if (isset($_POST['submit'])) {
$inf  = mysql_fetch_assoc($idf);
unlink('../data/user'.$inf['userid'].'/'.$inf['name']);
mysql_query("delete from files where id = '$del'");
mysql_free_result($idf);
echo '<div class="news">Berkas telah dihapus <br><a href="?files">Kembali ke berkas</a></div>';
} else {
echo '<div class="news">Kamu yakin ingin menghapus berkas <b>'.filename($del).'</b> ?' . '<form method="post">' . '<input type="submit" name="submit" value="Hapus" />' . ' <a href="?files">Batal</a></form></div>';
}
} else {
echo '<div class="news">Berkas tidak ada! <br><a href="?files">Kembali</a></div>';
}
}
elseif(isset($_GET['move'])){
echo '<div class="br"/><div class="title">Pindah Berkas</div>';
$move = intval($_GET['move']);
$idf = mysql_query("select * from files where id = '$move'");
if(mysql_num_rows($idf)>0){
$inf  = mysql_fetch_assoc($idf);
if(isset($_POST['m0ve'])){
$newcat = $_POST['newcat'];
if(!$newcat || $newcat == 0){
echo '<div class="news">Silahkan pilih kategori! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
else
{ mysql_query("UPDATE files Set catid = '$newcat' where id = '$move'");
echo '<div class="news">Berkas telah dipindahkan ke <b>'.catname($newcat).'</b> <br><a href="?files">Kembali ke berkas</a></div>';
}
} else {
echo '<div class="menu"><b>'.filename($move).'</b>
<form method="post">Pindah ke:<br> <select name="newcat"><option value="0">Pilih Kategori</option>';
$queryCat = mysql_query("SELECT * FROM file_cat order by `name` asc");
while($cat_info = mysql_fetch_array($queryCat))
{ $id = $cat_info["id"];
$name = $cat_info["name"];
echo "<option value=\"$id\">$name</option>"; }
echo '</select><br><input type="submit" name="m0ve" value="Pindah Berkas">  <a href="?files">Batal</a></form></div>';
}
} else {
echo '<div class="news">Berkas tidak ada! <br><a href="?files">Kembali</a></div>';
}
}   else {
header("location: ?files");
}
include '../includes/footer.php';
die();
}
if(isset($_GET['cats'])){
$title = 'Kategori';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Kelola Kategori</div><div class="news" align="center"><a href="?cat&new=add"><b>Buat kategori Baru</b></a></div>';
$queryCats = mysql_query('select name,id from file_cat order by `name` asc limit '.$j.', 10');
$queryNum = mysql_query('select id from file_cat');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($ct=mysql_fetch_assoc($queryCats)){
$cat_id = $ct['id'];
$reqCats = mysql_query("SELECT COUNT(*) FROM `files` WHERE `catid` = '$cat_id'");
$catfiles = mysql_result($reqCats, 0);
echo '<div class="menu"><img src="/images/dir.gif"> <a href="'.$url.'/loads/'.$ct['id'].'/'.hdm_converturl($ct['name']).'.html">'.$ct['name'].'</a> ('.$catfiles.')<br><a href="?cat&del='.$ct['id'].'"><font color="red">[hapus]</font></a> <a href="?cat&edit='.$ct['id'].'">[ubah]</a></div>';
}
mysql_free_result($queryCats);
mysql_free_result($queryNum);
paging($all,$page,10,$url.'/admin/?cats&');
} else {
echo '<div class="news">Tidak ada berkas, Belum ada Kategori! <br><a href="?cat&new=add">Buat Baru</a></div>';
}
include '../includes/footer.php';
die();
}

if(isset($_GET['cat'])){
$title = 'Kelola Kategori';
include('../includes/header.php');

if(isset($_GET['del'])){
echo '<div class="br"/><div class="title">Hapus Kategori</div>';
$del = intval($_GET['del']);
$cid = mysql_query("select name,id from file_cat where id = '$del'");
if(mysql_num_rows($cid)>0){
if (isset($_POST['submit'])) {
$cin  = mysql_fetch_assoc($cid);
mysql_query("delete from file_cat where id = '$del'"); mysql_query("delete from files where catid = '$del'");
mysql_free_result($cid);
echo '<div class="news">Kategori telah dihapus! <br><a href="?cats">Daftar Kategori</a></div>';
} else {
echo '<div class="news">Kamu yakin ingin menghapus Kategori <b>'.catname($del).'</b> ? ' . '<form method="post">' . '<input type="submit" name="submit" value="Hapus" />' . ' <a href="?files">Batal</a></form></div>';
}
} else {
echo '<div class="news">Kategori tidak ada! <br><a href="?cats">Kembali</a></div>';
}
}

elseif(isset($_GET['edit'])){
echo '<div class="br"/><div class="title">Ubah Kategori</div>';
$fandy = intval($_GET['edit']);
$cid = mysql_query("select name,ext from file_cat where id = '$fandy'");
if(mysql_num_rows($cid)>0){
$cin  = mysql_fetch_assoc($cid);
if(isset($_POST['change'])){
$ext = $_POST['ext'];
$name = $_POST['name'];
$checkcat = mysql_num_rows(mysql_query("select * from file_cat where name='$name'"));
if(empty($name) || strlen($name)<2)
{ echo '<div class="news">Nama kategori tidak boleh kosong atau kurang dari 3 karakter <br><a href="?cats">Kembali</a></div>'; }
elseif($checkcat>1) {
echo '<div class="news">Kategori sudah ada! Gunakan nama lain <br><a href="?cats">Kembali</a></div>'; }
else
{ mysql_query("UPDATE file_cat Set name = '$name', ext = '$ext' where id = '$fandy'");
echo '<div class="news">Kategori telah berhasil di ubah! <br><a href="?cats">Kembali</a></div>';
}
} else {
echo '<div class="menu"><b>'.catname($fandy).'</b>
<form method="post">Nama Kategori<br/><input type="text" name="name" value="'.$cin['name'].'" size="15"/><br>Ekstensi diizinkan : pdf, doc, ppt, xls, txt atau biarkan kosong untuk ekstensi bawaan! <br><input type="text" name="ext" value="'.$cin['ext'].'" size="15"/><br/><input type="submit" name="change" value="Simpan"></form></div>';
}
} else {
echo '<div class="news">Kategori tidak ada! <br><a href="?cats">Kembali</a></div>';
}
}
elseif(isset($_GET['new'])){
echo '<div class="br"/><div class="title">Kategori Baru</div>';
if(isset($_POST['submit'])){
$name = $_POST["name"];
$ext = $_POST["ext"];
$checkcat = mysql_num_rows(mysql_query("select * from file_cat where name='$name'"));
if(empty($name) || strlen($name)<2)
{ echo '<div class="news">Nama kategori tidak boleh kosong atau kurang dari 3 karakter! <br><a href="?cats">Kembali</a></div>'; }
elseif($checkcat>0) {
echo '<div class="news">Kategori sudah ada! Gunakan nama lain <br><a href="?cats">Kembali</a></div>'; }
else
{ $idc = insert('file_cat');
mysql_query("INSERT INTO file_cat (id,name,ext) VALUES ('$idc','{$name}','{$ext}')");
echo '<div class="news">Kategori baru berhasil dibuat! <br><a href="?cats">Kembali</a></div>';
}
}
else { echo '<div class="menu"><form method="post">Nama Kategori<br/><input type="text" name="name" value="" size="15"/><br>Ekstensi diizinkan : pdf, doc, ppt, xls, txt atau biarkan kosong untuk ekstensi bawaan! <br><input type="text" name="ext" value="" size="15"/><br/><input type="submit" name="submit" value="Buat"></form></div>';
}
}
else {
header("location: ?cats");
}
include '../includes/footer.php';
die();
}

if(isset($_GET['set'])){
$title = 'Pengaturan Website';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Pengaturan Website</div>';
if(isset($_POST['change'])){
$title = input($_POST['title']);
$news = input($_POST['news']);
update('title',$title);
update('news',$news);
echo '<div class="news">Pengaturan website diperbaharui! <br><a href="?set">Kembali</a></div>';
} else {
echo '
<div class="menu"><form method="post">Judul Website:<br/><input type="text" name="title" value="'.$set['title'].'" size="15"/><br>Berita website (HTML): <br><textarea name="news">'.stripslashes($set['news']).'</textarea><br> <input type="submit" name="change" value="Simpan"></form></div>';
}
include '../includes/footer.php';
die();
}

$title = 'Admin Panel';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Admin Panel</div> <div class="menu"><a href="?users">Kelola Pengguna</a> ('.mysql_result(mysql_query('SELECT COUNT(id) FROM users'),0).')</div>
<div class="menu"><a href="?cats">Kategori Berkas</a> ('.mysql_result(mysql_query('SELECT COUNT(id) FROM file_cat'),0).')</div>
<div class="menu"><a href="?files">Kelola Berkas</a> ('.mysql_result(mysql_query('SELECT COUNT(id) FROM files'),0).')</div>
<div class="menu"><a href="?set">Pengaturan Website</a></div>
<div class="news"><a href="../keluar">Keluar</a></div>';
include ("../includes/footer.php");
?>