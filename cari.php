<?php ini_set("display_errors",0);
$title = 'Cari unggahan';
include ('includes/connect.php');
include ('includes/header.php');
if(isset($_GET['q'])){
$tags = input($_GET['q']);
$type = $_GET["q"];
$queryFiles = mysql_query('select id,name,userid,size from files where name Like \'%'.$tags.'%\' order by `time` desc limit '.$j.',11');
$queryNum = mysql_query('select id from files where name Like \'%'.$tags.'%\'');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
echo '<div class="br"/><div class="title">'.$all.' '.$type.' berkas</div><div class="left">';
while($file=mysql_fetch_assoc($queryFiles)){
$img = fileExt($file['name']);
$Filetag = fileExt($file['name']);
$name = $file['name'];
$name = str_replace(".$Filetag","",$name);
echo '<a href="'.$url.'/load/file/'.$file['id'].'/'.hdm_converturl($name).'.html"><div class="menu"><table><tbody><tr><td> <span class="img"><img src="/images/file.png" height="40" width="40"/></span></td><td>'.$file['name'].'<br><font color="green">Ukuran : '.size($file['size']).'</font></td></tr></tbody></table></div></a>';
}
mysql_free_result($queryFiles);
mysql_free_result($queryNum);
paging($all,$page,11,$url.'/cari.php?q='.$tags.'&');
} else  {
echo '<div class="news">Tidak ditemukan hasil pencarian untuk '.$tags.'</div>';
}
} else {
echo '
<div class="br"/><div class="title">Cari Berkas</div>
<div class="menu">
<form method="GET">
Massukkan Kata Kunci:<br/><input type="text" name="q" value="" size="15" class="search" /><br/><input type="submit" name="search" value="Cari"/>
</div>'; }
echo '</div>';
include ('includes/footer.php');
?>
