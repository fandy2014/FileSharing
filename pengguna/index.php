<?php ini_set("display_errors",0);
include('../includes/connect.php');
if(!$userid) go($url);
$queryUser = mysql_query("SELECT password,username FROM users WHERE id = '$userid'") or die ( mysql_error());
$info = mysql_fetch_assoc($queryUser);
mysql_free_result($queryUser);
if($rights>0) {
if(isset($_GET['password'])){
$title = 'Ubah kata Sandi';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Ubah Kata Sandi</div>';
if(isset($_POST['change'])){
$old = md5(input($_POST['old']));
$new = md5(input($_POST['new']));
$verify_new = md5(input($_POST['verify_new']));
$new2 = $_POST['new'];
if($old != $info['password']){
echo '<div class="news">Kata Sandi Lama Salah! <a href="javascript:history.go(-1)">Kembali</a></div>';
} elseif ( $new != $verify_new )
{ echo '<div class="news">Sandi Tidak Cocok! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
else {
mysql_query("UPDATE users SET password = '$new' WHERE id = '$userid'");
echo "<div class='news'>Sandi telah berhasil di ubah! <br/>Kata Sandi Baru: $new2</div>";
}
}
echo '<div class="menu"><form method="POST">
Kata Sandi Lama:<br>
<input type="password" name="old" size="15" /><br/>
Kata Sandi baru:<br/>
<input type="text" name="new" value="" size="15"/><br/>
Ulangi Kata Sandi Baru:<br/>
<input type="text" name="verify_new" value="" size="15"/><br/>
<input type="submit" name="change" value="Ganti"/><br/><form></div>';
include '../includes/footer.php';
die();
}

if(isset($_GET['files'])){
if(isset($_GET['user'])){
$userfile = intval($_GET['user']); } else
{ $userfile = $userid; }

$title = 'Berkas '.username($userfile).'';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Berkas '.username($userfile).'</div><div class="left">';
$queryFiles = mysql_query('select id,name,userid,size from files where userid = '.$userfile.' order by `time` desc limit '.$j.', 11');
$queryNum = mysql_query('select id from files where userid = '.$userfile.'');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($ufile=mysql_fetch_assoc($queryFiles)){
$img = fileExt($ufile['name']);
if($img == jar) { $fimg = ''.$url.'/icon.php?id='.$ufile['id'].''; }
elseif(file_exists("images/$img.png")) { $fimg = ''.$url.'/images/'.$img.'.png'; }
$Filetag = fileExt($ufile['name']);
$name = $ufile['name'];
$name = str_replace(".$Filetag","",$name);
echo '<a href="'.$url.'/load/file/'.$ufile['id'].'/'.hdm_converturl($name).'.html"><div class="menu"><table><tbody><tr><td> <span class="img"><img src="/images/file.png" height="40" width="40"/></span></td><td>'.$ufile['name'].'<br><font color="#008800">Ukuran : '.size($ufile['size']).'</font></td></tr></tbody></table></div></a>';
}
mysql_free_result($queryFiles);
mysql_free_result($queryNum);
paging($all,$page,11,$url.'/pengguna/?files&user='.$userfile.'&');
} else {
echo '<div class="news">Anda belum mengunggah berkas! <br><a href="upload.php">Unggah disini</a></div>';
}
echo '</div>';
include '../includes/footer.php';
die();
}
else{
$pw = $_POST['password'];
$user = insert('users');
mkdir('data/pengguna'.$user);
@$a=mysql_query("INSERT INTO users (id,username,mail, password,rights,files,regtime) VALUES ('$user', '$username', '{$email}', '{$password}', '0', '0', '0', '$time')");}
$title = 'Kontrol Pengguna';
include('../includes/header.php');
echo '<div class="br"/>
<div class="title">Menu Pengguna</div>
<div class="menu"><a href="upload.php?upload">Unggah Berkas</a></div>
<div class="menu"><a href="?files">Berkas Saya</a> ('.mysql_result(mysql_query('SELECT COUNT(id) FROM files WHERE userid = '.$userid.''),0).')</div>
<div class="menu"><a href="?password">Ganti Kata Sandi</a></div>
<div class="news"><a href="../keluar">Keluar</a></div><div>';
}
else
{
$title = 'Akun Diblokir';
include('../includes/header.php');
echo '<div class="br"/><div class="title">Akun Diblokir!</div>
<div class="news">Akun anda diblokir!<br> Silahkan hubungi admin yang Cantik dan Tamvan(Ingan,Novel,Fandy,Sri Uswatun).. </div>';
}
include('../includes/footer.php');
?>
