<?php

// delete all uploaded image before push to git
$dir = "public/up/";
$files = scandir($dir);
foreach($files as $file) {
    if ($file != '.' && $file != '..' && $file != 'empty') {
        $filepath = __DIR__. "/". $dir. $file;
        echo "Delete $filepath\n";
        unlink($filepath);
    }
}

?>
