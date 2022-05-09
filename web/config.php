<?php
$config = [
    'project_name'   => env('PROJECT_NAME'),
    'host'           => $_SERVER['HTTP_HOST'],
    'mysql_database' => env('MYSQL_DATABASE'),
    'mysql_user'     => env('MYSQL_USER'),
    'mysql_pass'     => env('MYSQL_ROOT_PASSWORD'),
    'db_dsn'         => env('DB_DSN'),
];