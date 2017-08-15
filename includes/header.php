<?php ini_set("display_errors",0);
global $userid;
echo "<head><title>{$title} - {$set['title']}</title><link rel=\"stylesheet\" href=\"/kelompok8_d2015.css\" type=\"text/css\" media=\"all,handheld\"/>
<meta name=\"description\" content=\"Tugas Project Akhir kelas D2015 Universitas Mulawarman\" />
</head>";
echo '<body><div class="header"><img src="/images/logo.png" width="700px" height="60px"/></div>
';

echo '<body background="/images/backg.png"><div class="top"><a href="'.$url.'" title="home">Beranda</a> | <a href="'.$url.'/cari.php">Cari</a> | '; if($userid) { echo '<a href="'.$url.'/pengguna">Kelola</a>'; if($rights>1) { echo ' | <a href="'.$url.'/admin">Admin</a>'; } echo '  <a href="'.$url.'/keluar"></a>'; } else { echo '<a href="'.$url.'/masuk">Masuk</a> | <a href="'.$url.'/daftar">Daftar</a>'; } echo '</div>';
?>
