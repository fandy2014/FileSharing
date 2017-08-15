<?php ini_set("display_errors",0);
$title = "Masuk";
include('includes/connect.php');
include('includes/header.php');
echo '<div class="br"/><div class="title">Masuk</div>
';
if(isset($_POST['LogIn'])){
$username = input($_POST['username']);
$pass = md5(input($_POST['pass']));
if(!$username || !$pass){
echo '<div class="news">Kesalahan! Isi semua kolom! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
} else {
$queryUser = mysql_query("SELECT * FROM users WHERE username = '$username'") or die ( mysql_error());
if(mysql_num_rows($queryUser)>0){
$info = mysql_fetch_assoc($queryUser);
if($pass != $info['password']){
echo '<div class="news">Kata Sandi Salah! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
} else {
$_SESSION['userid'] = $info['id'];
$_SESSION['rights'] = $info['rights'];
echo '<div class="news">Anda sudah masuk! <br/><a href="'.$url.'">Lanjutkan</a></div>'; header("location: index.php"); }
} else { echo '<div class="news">Nama Pengguna dan Kata Sandi Salah! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
}
} else {
echo '<div class="left"><div class="menu"><form method="POST">Nama Pengguna:<br/><input type="text" name="username" value="" size="15" class="name"><br/>
Kata Sandi:<br/><input type="password" name="pass" value="" size="15" class="pass"><br/>
<input type="submit" value="Masuk" name="LogIn"/></div>';
echo '</div>';
}
include "includes/footer.php";
?>
