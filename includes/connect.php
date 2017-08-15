<?php ob_start();

//SILAHKAN SESUAIKAN DATA DENGAN DATABASE ANDA.
//BAGIMEDIA.INFO WAPUNDUH.COM KONTERKU.COM
//Desain By Fandy fb.com/fandy.q.ii

session_start();
$dbhost = 'localhost';
$dbuser = 'nama user';
$dbname = 'nama database';
$dbpass = 'password database';
$url = 'http://localhost';

if(!($db=@mysql_connect($dbhost, $dbuser, $dbpass)))
{ die('Silahkan Import dulu databasenya ya kawan,, Silahkan baca file baca.txt untuk cara installasinya'); }
if (!@mysql_select_db($dbname, $db))
{ die('Silahkan Import dulu databasenya ya kawan,, Silahkan baca file baca.txt untuk cara installasinya'); }
mysql_query('set charset utf8',$db);
mysql_query('SET names utf8',$db);
$querySetup = mysql_query('SELECT name,value FROM settings');
$set = array();
while($setup=mysql_fetch_assoc($querySetup)) $set[$setup['name']] = $setup['value'];
mysql_free_result($querySetup);
include "fungsi.php";
?>