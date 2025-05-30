<?php
require "apps/core.php";
require "vendor/autoload.php";
//$ccn = readCcn();
$sumAllHealth = 0;
$responseStart = microtime(true);
date_default_timezone_set('Asia/Jakarta');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($uri, '/');
$segments = explode('/', $path);
$lastSeg = end($segments);

switch ($path) {
    case '':
        include 'views/dashboard.php';
        break;
    case 'signin':
        include 'views/signin.php';
        break;
    case 'signup':
        include 'views/signup.php';
        break;
    case 'logout':
        include 'views/logout.php';
        break;


    case 'kotakwarga':
        include 'views/kotakwarga.php';
        break;

    case 'pengaduan':
        include 'views/pengaduan.php';
        break;
    case 'permohonan':
        include 'views/permohonan.php';
        break;

    case 'form':
        include 'views/form.php';
        break;


    case 'datatamu':
        include 'views/datatamu.php';
        break;


    case 'laporan':
        include 'views/laporan.php';
        break;
    case 'pdf':
        include 'views/pdf.php';
        break;


    case 'management':
        include 'views/management.php';
        break;
    case 'profiles':
        include 'views/profiles.php';
        break;
    case 'account':
        include 'views/account.php';
        break;
    case 'keluarga':
        include 'views/keluarga.php';
        break;
    case 'pribadi':
        include 'views/pribadi.php';
        break;


    default:
        include 'views/404.php';
        break;
}

$responseEnd = microtime(true);
$responseLocal = number_format($responseEnd - $responseStart, 2);
$responseApi = 0.00; 
$sumAllResponse = number_format(($responseApi + $responseLocal) / 2, 2);
$log = dated() . " - Local: {$responseLocal} ms - API: {$responseApi} ms - Average: {$sumAllResponse} ms" . PHP_EOL;
file_put_contents('health.txt', $log, FILE_APPEND);
?>
<div class="health" style="display: <?= $nonedddd?>;">
    <i class="fa-solid fa-heart-pulse"></i><?= $sumAllHealth ?> ms
</div>