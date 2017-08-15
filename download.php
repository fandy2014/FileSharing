<?php include ('includes/connect.php');
$file_id = intval($_GET['id']);
$Filetag = fileExt(filename($file_id));
$name = filename($file_id);
$name = str_replace(".$Filetag","",$name);
$ref = intval($_GET['ref']);
if(!isset($_SESSION['download'.$file_id])) header('location:'.$url.'/load/file/'.$file_id.'/'.hdm_converturl($name).'.html');

$queryFile = mysql_query("select name,size from files where id = '$file_id'");
if($_GET['sid'] != $_SESSION['download'.$file_id]) header('location:'.$url.'/load/file/'.$file_id.'/'.hdm_converturl($name).'.html');
elseif(mysql_num_rows($queryFile)>0){
$info = mysql_fetch_assoc($queryFile);
mysql_free_result($queryFile);
$filed = 'data/user'.$ref.'/'.$info['name'];
if(!is_file($filed) || !is_readable($filed)) {
header('location:'.$url.'/load/file/0/file-not-found.html');
} else {
mysql_query("UPDATE files SET downloaded = downloaded+1 WHERE id = '$file_id'");
$fp=fopen($filed, "rb");
header('Content-type:application/octet-stream');
header('Content-disposition: attachment;filename="'.$info['name'].'"');
header('Content-length: '.$info['size']);
fpassthru($fp);
fclose($fp);
}
} else header('location:'.$url.'/load/file/0/file-not-found.html');
?>
