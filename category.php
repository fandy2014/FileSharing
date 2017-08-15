<?php ini_set("display_errors",0);
require_once('includes/connect.php');

if(isset($_GET['id'])) {
$cid = intval($_GET['id']);
$queryCats = mysql_query('select id,name from file_cat where id = '.$cid.'');
$queryNum = mysql_query('select id from file_cat where id = '.$cid.'');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($catinfo = mysql_fetch_assoc($queryCats)){
$catname = $catinfo['name'];
$title = "$catname";
require_once('includes/header.php');
echo '<div class="br"/><div class="title">'.$catname.'</div><div class="left">';
$queryFiles = mysql_query('select * from files where catid = '.$cid.' order by `id` desc limit '.$j.',11');
$queryNm = mysql_query('select id from files where catid = '.$cid.'');
if(mysql_num_rows($queryNm)>0){
$all = mysql_num_rows($queryNm);
while($file=mysql_fetch_assoc($queryFiles)){
$img = fileExt($file['name']);
$Filetag = fileExt($file['name']);
$name = $file['name'];
$name = str_replace(".$Filetag","",$name);
echo '<a href="'.$url.'/load/file/'.$file['id'].'/'.hdm_converturl($name).'.html"><div class="menu"><table><tbody><tr><td> <span class="img"><img src="/images/file.png" height="40" width="40"/></span></td><td>'.$file['name'].'<br><font color="#008800">Ukuran : '.size($file['size']).'</font></td></tr></tbody></table></div></a>';
}
mysql_free_result($queryFiles);
mysql_free_result($queryNm);
paging($all,$page,11,$url.'/category.php?id='.$cid.'&');
echo '</div>'; } else {
echo '<div class="news">Tidak ada berkas dalam Kategori!</div>';
}
}
} else { header('location: '.$url.'/category.php'); }
} else
{ $title = "Kategori File";
require_once('includes/header.php');
echo '<div class="br"/><div class="title">Kategori Berkas</div>';
$queryCats = mysql_query('select * from file_cat order by `name` asc limit 20');
$queryNum = mysql_query('select id from file_cat');
if(mysql_num_rows($queryNum)>0){
$all = mysql_num_rows($queryNum);
while($ct=mysql_fetch_assoc($queryCats)){
$cat_id = $ct['id'];
$img = $ct['img'];
if(!empty($img)) { $img= '<img src="'.$img.'" height="16" width="16"/>'; }
else { $img= '<img src="'.$url.'/images/dir.gif" height="16" width="16"/>'; }
$reqCats = mysql_query("SELECT COUNT(*) FROM `files` WHERE `catid` = '$cat_id'");
$catfiles = mysql_result($reqCats, 0);
echo '<div class="menu">'.$img.' <a href="'.$url.'/loads/'.$ct['id'].'/'.hdm_converturl($ct['name']).'.html">'.$ct['name'].'</a> ('.$catfiles.')</div>';
}
} else {
echo '<div class="news">Tidak ada berkas, Kategori belum ada!</div>';
}
}
include ('includes/footer.php');
?>
