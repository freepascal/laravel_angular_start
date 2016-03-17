<?php

return array(
    'default'       => 'mysql',
    'connections'   => array(
        'mysql'     => array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'port'      => 3306,
            'database'  => 'circle_test',
            'username'  => 'ubuntu',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            //'unix_socket' => '/tmp/mysql.sock'
        )
    )
);

?>
