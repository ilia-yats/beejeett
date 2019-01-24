<?php

$host = $username = $password = $dbname = '';
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
if (isset($url["host"]) && isset($url["user"]) && isset($url["pass"]) && isset($url["path"])) {
    $host = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $dbname = substr($url["path"], 1);
}


return [
    'defaultRoute' => 'task/index',
    'dsn' => "mysql:host={$host};dbname={$dbname}",
    'dbUser' => $username,
    'dbPass' => $password,
    //'dsn' => 'sqlite:'.APP_ROOT.'/data/db.sq3',
];