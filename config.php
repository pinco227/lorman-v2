<?php
session_start();
set_time_limit(0);
error_reporting(E_ALL);

if (file_exists('env.php')) include('env.php');

// Informatii baza de date

$AdresaBazaDate = $_ENV['DB_URL'];
$UtilizatorBazaDate = $_ENV['DB_USER'];
$ParolaBazaDate = $_ENV['DB_PASS'];
$NumeBazaDate = $_ENV['DB_NAME'];

$conexiune = mysqli_connect($AdresaBazaDate, $UtilizatorBazaDate, $ParolaBazaDate, $NumeBazaDate) or die("Can not connect to MySQL Server");

function addentities($data)
{
    if (trim($data) != '') {
        $data = htmlentities($data, ENT_QUOTES);
        return str_replace('\\', '&#92;', $data);
    } else return $data;
} // End addentities() --------------

function getUserIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
