<?php

return array(
    'default'       => 'mysql',
    'connections'   => array(
        'mysql'     => array(
            'driver'    => 'mysql',
            'host'      => getenv('DB_URL'),
            'port'      => 3306,
            'database'  => getenv('DB_NAME'),
            'username'  => getenv('DB_USER'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'unix_socket' => '/tmp/mysql.sock'
        )
    )
);

?>
