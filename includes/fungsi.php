<?php if(isset($_SESSION['userid'])){
$userid = $_SESSION['userid'];
$rights = $_SESSION['rights'];
}

$time = time();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$id = intval($_GET['id']);
$j = ($page-1)*10;


function go($url){
header('Location: '.$url);
exit;
}
function rrmdir($dir) {
foreach(glob($dir . '/*') as $file) {
if(is_dir($file))
rrmdir($file);
else
unlink($file);
}
rmdir($dir);
}


function insert($name){
$qr = mysql_query("select max(id) from $name");
$max = mysql_fetch_array($qr);
return $max['max(id)']+1;
mysql_free_result($qr);
}
function update($name,$value){
mysql_query("UPDATE `settings` SET  `value` =  '$value' WHERE  `name` = '$name';");
return TRUE;
}

function username($user){
$qr = mysql_query("select username from users where id = '$user'");
$max = mysql_fetch_array($qr);
return $max['username'];
mysql_free_result($qr);
}

function filename($idfile){
$fn = mysql_query("select name from files where id = '$idfile'");
$file = mysql_fetch_array($fn);
return $file['name'];
mysql_free_result($fn);
}

function catname($idcat){
$cn = mysql_query("select name from file_cat where id = '$idcat'");
$cat = mysql_fetch_array($cn);
return $cat['name'];
mysql_free_result($cn);
}

function input($text){
return trim(addslashes($text));
}

function output($text,$html=false){
if($html){
return trim(stripslashes($text));
} else {
return trim(htmlspecialchars(stripslashes($text)));
}
}


function hdm_converturl($text){
$text=str_replace(" ","-",$text);
$text=str_replace(".","-",$text);
$text=str_replace("@","-",$text);
$text=str_replace("/","-",$text);
$text=str_replace("\\","-",$text);
$text=str_replace("&","-and-",$text);
$text=preg_replace("/[^a-zA-Z0-9\-]/", "", $text);
return $text;
}


function hdm_fileurl($text){
$text = html_entity_decode(trim($text), ENT_QUOTES, 'UTF-8');
$text=str_replace(" ","-", $text);
$text=str_replace("--","-", $text);
$text=str_replace("@","-",$text);
$text=str_replace("/","-",$text);
$text=str_replace("\\","-",$text);
$text=str_replace(":","",$text);
$text=str_replace("\"","",$text);
$text=str_replace("'","",$text);
$text=str_replace("<","",$text);
$text=str_replace(">","",$text);
$text=str_replace(",","",$text);
$text=str_replace("?","",$text);
$text=str_replace(";","",$text);
$text=str_replace(".",".",$text);
$text=str_replace("[","",$text);
$text=str_replace("]","",$text);
$text=str_replace("(","",$text);
$text=str_replace(")","",$text);
$text=str_replace("*","",$text);
$text=str_replace("!","",$text);
$text=str_replace("$","-",$text);
$text=str_replace("&","-and-",$text);
$text=str_replace("%","",$text);
$text=str_replace("#","",$text);
$text=str_replace("^","",$text);
$text=str_replace("=","",$text);
$text=str_replace("+","",$text);
$text=str_replace("~","",$text);
$text=str_replace("`","",$text);
$text=str_replace("--","-",$text);
$text = preg_replace("/(–ì†|–ì°|–±∫°|–±∫£|–ì£|–ì¢|–±∫ß|–±∫•|–±∫≠|–±∫©|–±∫´|–îÉ|–±∫±|–±∫Ø|–±∫∑|–±∫≥|–±∫µ)/", 'a', $text);
$text = preg_replace("/(–ì†|–ì°|–±∫°|–±∫£|–ì£|–ì¢|–±∫ß|–±∫•|–±∫≠|–±∫©|–±∫´|–îÉ|–±∫±|–±∫Ø|–±∫∑|–±∫≥|–±∫µ)/", 'a', $text);
$text = preg_replace("/(–ì–Å|–ì©|–±∫π|–±∫ª|–±∫Ω|–ì™|–±ªÅ|–±∫ø|–±ªá|–±ªÉ|–±ªÖ)/", 'e', $text);
$text = preg_replace("/(–ì–Å|–ì©|–±∫π|–±∫ª|–±∫Ω|–ì™|–±ªÅ|–±∫ø|–±ªá|–±ªÉ|–±ªÖ)/", 'e', $text);
$text = preg_replace("/(–ì¨|–ì≠|–±ªã|–±ªâ|–î©)/", 'i', $text);
$text = preg_replace("/(–ì¨|–ì≠|–±ªã|–±ªâ|–î©)/", 'i', $text);
$text = preg_replace("/(–ì≤|–ì≥|–±ªç|–±ªè|–ìµ|–ì¥|–±ªì|–±ªë|–±ªô|–±ªï|–±ªó|–ñ°|–±ªù|–±ªõ|–±ª£|–±ªü|–±ª°)/", 'o', $text);
$text = preg_replace("/(–ì≤|–ì≥|–±ªç|–±ªè|–ìµ|–ì¥|–±ªì|–±ªë|–±ªô|–±ªï|–±ªó|–ñ°|–±ªù|–±ªõ|–±ª£|–±ªü|–±ª°)/", 'o', $text);
$text = preg_replace("/(–ìπ|–ì∫|–±ª•|–±ªß|–ï©|–ñ∞|–±ª´|–±ª©|–±ª±|–±ª≠|–±ªØ)/", 'u', $text);
$text = preg_replace("/(–ìπ|–ì∫|–±ª•|–±ªß|–ï©|–ñ∞|–±ª´|–±ª©|–±ª±|–±ª≠|–±ªØ)/", 'u', $text);
$text = preg_replace("/(–±ª≥|–ìΩ|–±ªµ|–±ª∑|–±ªπ)/", 'y', $text);
$text = preg_replace("/(–îë)/", 'd', $text);
$text = preg_replace("/(–±ª≥|–ìΩ|–±ªµ|–±ª∑|–±ªπ)/", 'y', $text);
$text = preg_replace("/(–îë)/", 'd', $text);
$text = preg_replace("/(–ìÄ|–ìÅ|–±∫†|–±∫¢|–ìÉ|–ìÇ|–±∫¶|–±∫§|–±∫¨|–±∫–Å|–±∫™|–îÇ|–±∫∞|–±∫Æ|–±∫∂|–±∫≤|–±∫¥)/", 'A', $text);
$text = preg_replace("/(–ìÄ|–ìÅ|–±∫†|–±∫¢|–ìÉ|–ìÇ|–±∫¶|–±∫§|–±∫¨|–±∫–Å|–±∫™|–îÇ|–±∫∞|–±∫Æ|–±∫∂|–±∫≤|–±∫¥)/", 'A', $text);
$text = preg_replace("/(–ìà|–ìâ|–±∫—ë|–±∫∫|–±∫º|–ìä|–±ªÄ|–±∫æ|–±ªÜ|–±ªÇ|–±ªÑ)/", 'E', $text);
$text = preg_replace("/(–ìà|–ìâ|–±∫—ë|–±∫∫|–±∫º|–ìä|–±ªÄ|–±∫æ|–±ªÜ|–±ªÇ|–±ªÑ)/", 'E', $text);
$text = preg_replace("/(–ìå|–ìç|–±ªä|–±ªà|–î–Å)/", 'I', $text);
$text = preg_replace("/(–ìå|–ìç|–±ªä|–±ªà|–î–Å)/", 'I', $text);
$text = preg_replace("/(–ìí|–ìì|–±ªå|–±ªé|–ìï|–ìî|–±ªí|–±ªê|–±ªò|–±ªî|–±ªñ|–ñ†|–±ªú|–±ªö|–±ª¢|–±ªû|–±ª†)/", 'O', $text);
$text = preg_replace("/(–ìí|–ìì|–±ªå|–±ªé|–ìï|–ìî|–±ªí|–±ªê|–±ªò|–±ªî|–±ªñ|–ñ†|–±ªú|–±ªö|–±ª¢|–±ªû|–±ª†)/", 'O', $text);
$text = preg_replace("/(–ìô|–ìö|–±ª§|–±ª¶|–ï–Å|–ñØ|–±ª™|–±ª–Å|–±ª∞|–±ª¨|–±ªÆ)/", 'U', $text);
$text = preg_replace("/(–ìô|–ìö|–±ª§|–±ª¶|–ï–Å|–ñØ|–±ª™|–±ª–Å|–±ª∞|–±ª¨|–±ªÆ)/", 'U', $text);
$text = preg_replace("/(–±ª≤|–ìù|–±ª¥|–±ª∂|–±ª—ë)/", 'Y', $text);
$text = preg_replace("/(–îê)/", 'D', $text);
$text = preg_replace("/(–±ª≤|–ìù|–±ª¥|–±ª∂|–±ª—ë)/", 'Y', $text);
$text = preg_replace("/(–îê)/", 'D', $text);
$text=strtolower($text);
return $text;
}


function user_rights($id){
if($id == 1){
return '<b><font color="blue">pengguna</font></b>';
}
elseif($id == 2){
return '<b><font color="red">Administrator</font></b>';
}
}

function fileExt($fname) {
$f1 = strrpos($fname, ".");
$f2 = substr($fname, $f1 + 1, 999);
$name = strtolower($f2);
return $name;
}

function bytetomb($byte){
return round($byte/1048576, 2);
}

function size($a_bytes){
if ($a_bytes<1024) {
return $a_bytes.' bytes';
} elseif ($a_bytes<
1048576) {
return round($a_bytes/1024, 2) .' KB';
} elseif ($a_bytes<1073741824) {
return round($a_bytes/1048576, 2) . ' MB';
} elseif ($a_bytes<
1099511627776) {
return round($a_bytes/1073741824, 2) . ' GB';
} elseif ($a_bytes<
1125899906842624) {
return round($a_bytes/1099511627776, 2) .' TB';
} elseif ($a_bytes<
1152921504606846976) {
return round($a_bytes/1125899906842624, 2) .' PB';
} elseif ($a_bytes<
1180591620717411303424){
return round($a_bytes/1152921504606846976, 2) .' EB';
} elseif ($a_bytes<1208925819614629174706176) {
returnround($a_bytes/1180591620717411303424,2) .' ZB';
} else {
return round($a_bytes/1208925819614629174706176, 2) .' YB';
}}

function getWithoutPath($filename) {
return end(explode("/",$filename));}

function getExt($name) {
return end(explode('.', $name));
}

function imgExt($name) {
$found = false;
foreach($exts as $key=>$value) {
if(getExt($name) == $value) {
$found = true;
break;
}
}

if($found) return true;
else return false;
}

function rm20($fn) {
return str_replace('%20', ' ', $fn);
}

function paging($all,$page,$num,$url) { $total = ceil($all/$num);
if ($page != 1) $pervpage = ' <a href= "'.$url.'page='. ($page - 1) .'">&lt;&lt;</a> ';
if ($page != $total) $nextpage = ' <a href="'.$url.'page='. ($page + 1) .'">&gt;&gt;</a>';
if ($page - 4 > 0) $first = '<a href="'.$url.'page=1">1</a>...';
if ($page + 4 <= $total) $last = '...<a href="'.$url.'page='.$total.'">'.$total.'</a>';
if($page - 2 > 0) $page2left = ' <a href= "'.$url.'page='. ($page - 2) .'">'. ($page - 2) .'</a> ';
if($page - 1 > 0) $page1left = '<a href= "'.$url.'page='. ($page - 1) .'">'. ($page - 1) .'</a> ';
if($page + 2 <= $total) $page2right = ' <a href= "'.$url.'page='. ($page + 2) .'">'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' <a href="'.$url.'page='. ($page + 1) .'">'. ($page + 1) .'</a>';
echo '<div class="paging">'.$pervpage.$first.$page2left.$page1left.'['.$page.']'.$page1right.$page2right.$last.$nextpage.'</div>';
}

function check_email($email) {
if (strlen($email) == 0) return false;
if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) return true;
return false;
}
?>
