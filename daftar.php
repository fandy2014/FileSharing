<?php ini_set("display_errors",0);
$title = "Pendaftaran";
include('includes/connect.php');
include('includes/header.php');
echo '<div class="br"/><div class="title"><b>Pendaftaran</b></div>';
{
if ( $_GET['act'] == "do" )
{
$password = md5( addslashes( $_POST['password'] ) );
$verify_password = md5( addslashes( $_POST['verify_password'] ) );
$username = addslashes( $_POST['username'] );
$nim = addslashes( $_POST['nim'] );
$email = addslashes( $_POST['email'] );
if (strlen($_POST['username'])<1 || strlen($_POST['username'])>40 ) {
echo '<div class="news">Kesalahan! Nama Pengguna harus 4-15 karakter<br/><a href="javascript:history.go(-1)">Kembali</a></div>'; }
elseif ( mysql_num_rows(mysql_query("SELECT id FROM users WHERE username='$username'"))>0)
{ echo '<div class="news">Nama ini sudah ada! <br/><a href="javascript:history.go(-1)">Kembali</a></div>'; }
elseif(!preg_match("^[A-Za-z0-9]+$^", "$username"))
{ echo '<div class="news">Nama Pengguna berisi karakter yang tidak benar! <br/><a href="javascript:history.go(-1)">Kembali</a></div>'; }
elseif ( ! $_POST['password'] || ! $_POST['verify_password'] || ! $email || ! $nim)
{
echo '<div class="news">Kesalahan! Kamu belum mengisi semua kolom! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif (!check_email($email))
{
echo '<div class="news">Email tidak benar! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif ( mysql_num_rows(mysql_query("SELECT id FROM users WHERE mail='$email'"))>0)
{
echo '<div class="news">Email ini sudah digunakan, silahkan gunakan email lain! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif ( $password != $verify_password )
{
echo '<div class="news">Kata Sandi tidak cocok! <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
elseif (strlen($_POST['password'])<5 || strlen($_POST['password'])>15 )
{
echo '<div class="news">Kata Sandi harus 6-15 karakter <br/><a href="javascript:history.go(-1)">Kembali</a></div>';
}
else{
$pw = $_POST['password'];
$idu = insert('users');
mkdir('data/user'.$idu);
@$a=mysql_query("INSERT INTO users (id,username,nim,mail,password,rights) VALUES ('$idu', '$username', '$nim', '{$email}', '{$password}', '1')");
if ($a) print "<div class=\"news\">Akun kamu telah berhasil dibuat.<br/><a href='/masuk.php'>Klik disini untuk masuk</a></div>";
else
print '<div class="news">Ada kesalahan dalam proses pendaftaran, silahkan hubungi admini</div>';
}} else {

echo <<<EOF
<div class="menu"><form action="?act=do" method="post">Nama Pengguna:<br><input size="20" type="text" name="username" value=""><br/>NIM:<br><input size="20" type="number" name="nim" value="1515015201"><br/>E-mail:<br/><input size="20" type="text" placeholder="@domain.tld"name="email" value=""><br/>Kata Sandi: (6 - 20 karakter)<br><input size="20" type="password" name="password" value=""><br>Ulangi Kata Sandi:<br><input type="password" size="20" name="verify_password" value=""><br/><br><input type="submit" name="submit" value="Daftar"></form>
EOF;
echo '</div>';
}
}
include "includes/footer.php";
?>
