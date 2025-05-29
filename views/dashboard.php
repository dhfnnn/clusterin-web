<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['user_token'])) {
    echo "<script>alert('Sesi Anda Telah Habis, Silahkan Login Terlebih Dahulu'); location.href = 'signin';</script>";
}
// GET DATA ACCOUNT IN LOGED
$getAcc = json_decode(api('account', 'GET', ['user_token' => $_SESSION['user_token']]), true);
if (!$getAcc['success'] == true) {
    echo "<script>alert('Akun Tidak Ditemukan, Kami Akan Mengarahkan Ke Halaman Daftar'); location.href = 'signup';</script>";
    exit(1);
}
$name_account = $getAcc['data']['fullname'];
$heaAcc = $getAcc['response'];

// GET ALL ACCOUNT
$getAccount = json_decode(api('account'), true);
$heaAccount = $getAccount['response'];
$getAccountfill = array_filter($getAccount['data'], function ($item) {
    return $item['user_token'] !== $_SESSION['user_token'];
});

// GET ONE PENGAJUAN: Pengaduan
$getPengaduan = json_decode(api('pengajuan', 'GET', ['kategori' => 'Pengaduan']), true);
$onePengaduan = json_decode(api('pengajuan', 'GET', ['gets' => '1', 'kategori' => 'Pengaduan']), true);
$heaPengaduan = $getPengaduan['response'];

// GET ACCOUNT WHERE: user_token, Pengaduan
$getAccPengaduan = json_decode(api('account', 'GET', ['user_token' => $onePengaduan['data']['user_token']]), true);
$heaAccPengaduan = $getAccPengaduan['response'];

// GET ONE PENGAJUAN: Permohonan
$getPermohonan = json_decode(api('pengajuan', 'GET', ['kategori' => 'Permohonan']), true);
$onePermohonan = json_decode(api('pengajuan', 'GET', ['gets' => '1', 'kategori' => 'Permohonan']), true);
$heaPermohonan = $getPermohonan['response'];

// GET ACCOUNT WHERE: user_token, Permohonan
$getAccPermohonan = json_decode(api('account', 'GET', ['user_token' => $onePermohonan['data']['user_token']]), true);
$heaAccPermohonan = $getAccPermohonan['response'];


// GET ONE GUEST: Masuk
$getGuestMasuk = json_decode(api('guest', 'GET', ['status' => 'Masuk']), true);
$oneGuestMasuk = json_decode(api('guest', 'GET', ['gets' => '1', 'status' => 'Masuk']), true);
$heaGuestMasuk = $getGuestMasuk['response'];

// GET ONE GUEST: Keluar
$getGuestKeluar = json_decode(api('guest', 'GET', ['status' => 'Keluar']), true);
$oneGuestKeluar = json_decode(api('guest', 'GET', ['gets' => '1', 'status' => 'Keluar']), true);
$heaGuestKeluar = $getGuestKeluar['response'];

$sumAllHealth = number_format($heaAcc + $heaAccount + $heaPengaduan + $heaAccPengaduan + $heaPermohonan + $heaAccPermohonan + $heaGuestMasuk + $heaGuestKeluar / 7, 2);
// $log = dated() . " - Response time: {$sumAllHealth}ms" . PHP_EOL;
// file_put_contents('health.txt', $log, FILE_APPEND);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!---link google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/cc8eb8fa05.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!---rute ke style.css-->
    <link rel="stylesheet" href="asset/style.css">
</head>

<body class="bg">
    
    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top-left-radius: 0; border-top-right-radius: 0;">
        <div class="container">
            <a class="header-2">Dashboard</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <a href="profile?validated=<?= $_SESSION['user_token']?>" class="profile-header">
                    <span><?= $name_account ?></span>
                    <img src="asset/images/Akun.png" alt="akun" width="30" height="30">
                </a>
            </ul>
        </div>
    </nav>

    <section class="kotak_warga mb-4">
        <div class="container">
            <div class="row">
                <h1 class="header-3 text-start mb-1">Kotak Warga</h1>
                <div class="col-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header">
                            Surat Permohonan
                            <?php
                            if ($getPermohonan['count'] >= 1) {
                                echo " : " . $getPermohonan['count'];
                            } else {
                                echo "";
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($getPermohonan['count'] >= 1) {
                            ?>
                                <div class="name-sts">
                                    <h5 class="card-title"><?= $getAccPermohonan['data']['fullname'] ?></h5>
                                    <span class="badge-status"><?= $onePermohonan['data']['status'] ?></span>
                                </div>
                                <p class="card-text" style="font-size: 12px"><?= $onePermohonan['data']['judul'] ?></p>
                                <p class="card-text" style="font-size: 10px"><?= dated($onePermohonan['data']['created_at']) ?></p>
                                <a style="font-size: 11px" href="">Lihat Lainnya</a>
                            <?php
                            } else {
                                echo "<p>Tidak Ada Data</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Surat Pengaduan
                            <?php
                            if ($getPengaduan['count'] >= 1) {
                                echo " : " . $getPengaduan['count'];
                            } else {
                                echo "";
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($getPengaduan['count'] >= 1) {
                            ?>
                                <div class="name-sts">
                                    <h5 class="card-title"><?= $getAccPengaduan['data']['fullname'] ?></h5>
                                    <span class="badge-status"><?= $onePengaduan['data']['status'] ?></span>
                                </div>
                                <p class="card-text" style="font-size: 12px"><?= $onePengaduan['data']['judul'] ?></p>
                                <p class="card-text" style="font-size: 10px"><?= dated($onePengaduan['data']['created_at']) ?></p>
                                <a style="font-size: 11px" href="">Lihat Lainnya</a>
                            <?php
                            } else {
                                echo "<p>Tidak Ada Data</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="data_tamu">
        <div class="container">
            <div class="row">
                <h1 class="header-3 text-start mb-1">Data Tamu</h1>
                <div class="col-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-header">
                            Check-In
                            <?php
                            if ($getGuestMasuk['count'] >= 1) {
                                echo " : " . count($getGuestMasuk['data']);
                            } else {
                                echo "";
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($getGuestMasuk['count'] >= 1) {
                            ?>
                                <h5 class="card-title"><?= $oneGuestMasuk['data']['fullname'] ?></h5>
                                <p class="card-text" style="font-size: 12px"><?= $oneGuestMasuk['data']['destination_address'] ?></p>
                                <p class="card-text" style="font-size: 10px"><?= $oneGuestMasuk['data']['checkin_date'] ?></p>
                                <p class="card-text" style="font-size: 12px"><?= $oneGuestMasuk['data']['reason'] ?></p>
                                <a style="font-size: 11px" href="">Lihat Lainnya</a>
                            <?php
                            } else {
                                echo "<p>Tidak Ada Data</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Check-Out
                            <?php
                            if ($getGuestKeluar['count'] >= 1) {
                                echo " : " . $getGuestKeluar['count'];
                            } else {
                                echo "";
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <?php
                            if ($getGuestKeluar['count'] >= 1) {
                            ?>
                                <h5 class="card-title"><?= $oneGuestKeluar['data']['fullname'] ?></h5>
                                <p class="card-text" style="font-size: 12px"><?= $oneGuestKeluar['data']['destination_address'] ?></p>
                                <p class="card-text" style="font-size: 10px"><?= $oneGuestKeluar['data']['checkout_date'] ?></p>
                                <p class="card-text" style="font-size: 12px"><?= $oneGuestKeluar['data']['reason'] ?></p>
                                <a style="font-size: 11px" href="">Lihat Lainnya</a>
                            <?php
                            } else {
                                echo "<p>Tidak Ada Data</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="management_User">
        <div class="container">
            <h1 class="header-3 text-start mt-3 mb-1">Management User</h1>
            <div class="card">
                <div class="card-body">
                    <?php
                    $sumAccount = count($getAccountfill);
                    if ($sumAccount >= 1) {
                        if ($sumAccount >= 5) {
                            echo '
                                    <li class="list-group-item d-flex justify-content-left align-items-center mt-1">
                                        <a href="">Lihat lainnya</a>
                                    </li>
                                ';
                        }
                    ?>

                        <ol class="list-group list-group-numbered">
                            <?php
                            foreach ($getAccountfill as $data) {
                                if ($data['gender'] == 'Laki-laki') {
                                    $img = 'male_icon.png';
                                } else {
                                    $img = 'female_icon.png';
                                }
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center" style="min-width: 0; flex-grow: 1;">
                                        <img src="asset/images/<?= $img ?>" alt="female" width="27" height="27"
                                            class="me-1">
                                        <span class="text-truncate"><?= $data['fullname'] ?></span>
                                    </div>
                                    <span class="badge text-bg-primary rounded-pill">
                                        <?= $data['status_account'] ?>
                                    </span>
                                    <a href="" class="ms-2 text-decoration-none">
                                        Details
                                    </a>
                                </li>
                            <?php
                            }
                        } else {
                            ?>
                            <p>Tidak Ada Data</p>
                        <?php
                        }
                        ?>
                        </ol>
                </div>
            </div>
        </div>
    </section>

    <nav class="navbars cc-fot fixed-bottom navbar-expand-lg">
        <div class="container c-fot">
            <div class="navbar-collapse" id="navbarNav">
                <ul class="fot">
                    <li class="nav-items">
                        <a class="foot-link" href="datatamu">
                            <i class="fa-solid fa-folder-open" class="navicon"></i>
                            Data Tamu
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="kotakwarga">
                            <i class="fa-solid fa-table-list" class="navicon"></i>
                            Kotak Warga
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link actived" href="/">
                            <i class="fa-solid fa-house" class="navicon"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="laporan">
                            <i class="fa-solid fa-chart-simple" class="navicon"></i>
                            Laporan
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="management">
                            <i class="fa-solid fa-users" class="navicon"></i>
                            Management
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>


</body>

</html>