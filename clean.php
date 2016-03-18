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

// make directory tests/codeception
mkdir(
    $path = 'tests/codeception',
    $mode = 0777,
    $recursive = true
);

fopen("tests/codeception/empty", "w");


?>
