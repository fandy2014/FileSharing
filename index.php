<?php ini_set("display_errors",0);
$title = "Beranda";
include('includes/connect.php');
include('includes/header.php');
echo '<div class="br"/><div class="title">Berita</div><div class="news">'.output($set['news'],true).'</div><div class="br"/>';
echo '<div class="br"/><div class="title">Kategori File</div>';
$queryCats = mysql_query('select name,id from file_cat order by `name` asc limit 20');
$queryNum = mysql_query('select id from file_cat');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($ct=mysql_fetch_assoc($queryCats)){
$cat_id = $ct['id'];
$reqCats = mysql_query("SELECT COUNT(*) FROM `files` WHERE `catid` = '$cat_id'");
$catfiles = mysql_result($reqCats, 0);
echo '<div class="menu"><img src="/images/dir.gif"> <a href="'.$url.'/loads/'.$ct['id'].'/'.hdm_converturl($ct['name']).'.html">'.$ct['name'].'</a> ('.$catfiles.')</div>';
}
} else {
echo '<div class="menu">Belum ada kategori cuy! ';
if($rights>=2) echo '<br><a href="'.$url.'/admin/?cat&new=add">Buat Baru</a></div>';
else
echo '<br><a href="'.$url.'#">Kembali</a></div>';
}
include('includes/footer.php');
?>
