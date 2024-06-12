<?php
$serverName = "localhost";
$connectionOptions = array(
    "Database" => "Proyecto_SI",
    "Uid" => "zurita",
    "PWD" => "160423"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

