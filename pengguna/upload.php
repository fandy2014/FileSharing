<?php ini_set("display_errors",0);
include('../includes/connect.php');
if(!$userid) go($url);
$queryUser = mysql_query("SELECT password,username FROM users WHERE id = '$userid'") or die ( mysql_error());
$info = mysql_fetch_assoc($queryUser);
mysql_free_result($queryUser);

if($rights>0) {
if(isset($_GET['upload'])){
$title = 'Unggah Berkas';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Unggah Berkas</div>';
If(isset($_POST['up'])){
$cat = $_POST['cat'];
$dir = '../data/user'.$userid.'/';
$name = preg_replace('/[^a-zA-Z0-9-_\.]/i','',$_FILES['file']['name']);
$size = $_FILES['file']['size'];
$queryCat = mysql_query('SELECT * FROM file_cat WHERE id = '.$cat.'');
while($inf_cat = mysql_fetch_array($queryCat))
{ $cat_ext = $inf_cat["ext"];
if(!empty($cat_ext)) {
$cat_ext = explode(', ', $inf_cat['ext']);
$cat_ext2 = $inf_cat['ext'];
} else
{ $cat_ext = explode(', ', $set['file_ext']);
$cat_ext2 = $set['file_ext'];
}
}
$ext = explode(".", $name);
if(!$name) {
echo '<div class="news">Silahkan pilih berkas! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif(!$cat || $cat == 0){
echo '<div class="news">Silahkan pilih kategori berkas! <br/><a href="javascript:history.go(-1)">Kembali</a></div>'; }
elseif(!in_array($ext[1], $cat_ext)) {
echo '<div class="news">Ekstensi tidak benar! Diizinkan : '.$cat_ext2.' <br><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif(file_exists("$dir$name")){
echo '<div class="news">Berkas sudah ada silahkan gunakan nama lain! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
} else {
copy($_FILES['file']['tmp_name'],$dir.$name);
$idff = insert('files');
mysql_query("insert into files set id = '".$idff."', name = '$name', catid = '$cat', size = '$size', time = '$time', userid = '$userid' ");
mysql_query("UPDATE users SET files = files+1 WHERE id = '$userid'");
echo '<div class="news">Berkas telah berhasil di unggah! <br/><a href="/file.php?id='.$idff.'">Lihat Berkas</a></div>';
}
} else {
echo '<div class="menu"><form method="post" enctype="multipart/form-data" >Pilih Berkas :<br><input type="file" name="file"><br/>Kategori Berkas:<br>
<select name="cat"><option value="0">Pilih Kategori</option>';
$queryCat = mysql_query("SELECT * FROM file_cat order by `name` asc");
while($cat_info = mysql_fetch_array($queryCat))
{ $id = $cat_info["id"];
$name = $cat_info["name"];
echo"<option value=\"$id\">$name</option>"; }
echo '</select>';
echo '<br><input type="submit" name="up" value="Unggah"></form></div>';
}
include ('../includes/footer.php');
die();
}
$title = 'Unggah';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Unggah berkas</div>
<div class="menu"><a href="?upload">Unggah berkas</a></div>
<div class="menu"><a href="'.$url.'/pengguna/?files">Berkas saya</a> ('.mysql_result(mysql_query('SELECT COUNT(id) FROM files WHERE userid = '.$userid.''),0).')</div>';
}
else
{
$title = 'Akun Diblokir';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Akun diblokir!</div>
<div class="news">Akun anda diblokir!<br> Silahkan hubungi admin yang cantik dan tamvan Sri,ingan,fandy,novel </div>';
}
include('../includes/footer.php');
?>
