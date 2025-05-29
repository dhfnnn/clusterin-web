<?php
$start = microtime(true);
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
$sumAllHealth = number_format($heaAcc, 2);
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kotak Warga</title>

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
    <link rel="stylesheet" href="../asset/style.css">
</head>


<body class="bg">
    
    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top-left-radius: 0; border-top-right-radius: 0;">
        <div class="container">
            <a class="navbar-brand header-2">Kotak Warga</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="">Hi, <?= $name_account ?></a>
                    <img src="asset/images/Akun.png" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>

    <section class="kotak_warga mb-4">
        <div class="container">
            <div class="row mb-3 g-5 d-flex">
                <div class="col-12 col-sm-6 col-lg-6 mb-3 mb-sm-0 d-flex justify-content-center">
                    <a href="permohonan" class="text-decoration-none text-dark">
                        <div class="card card-hover d-flex justify-content-center align-items-center"
                            style="height: 230px; width: 283px;">
                            <img src="asset/images/data_permohonan.png"
                                style="height: 190px; width: 200px; object-fit: cover;" class="card-img-top"
                                alt="laporan permohonan">
                            <span class="badge-status text-center py-2 px-3" style=" width: 283px;">Data
                                Permohonan</span>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-lg-6 d-flex justify-content-center">
                    <a href="pengaduan" class="text-decoration-none text-dark">
                        <div class="card card-hover justify-content-center align-items-center "
                            style="height: 230px; width: 283px;">
                            <img src="asset/images/data_pengaduan.png"
                                style="height: 180px; width: 200px; object-fit: cover;" class="card-img-top mt-1 mb-1"
                                alt="laporan pengaduan">
                            <span class="badge-status text-center py-2 px-3" style=" width: 283px;">Data
                                Pengaduan</span>
                        </div>

                    </a>
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
                        <a class="foot-link actived" href="kotakwarga">
                            <i class="fa-solid fa-table-list" class="navicon"></i>
                            Kotak Warga
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="/">
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
<?php 
    $stop = microtime(true);

    $sumAllHealth = number_format(($stop - $start) + $heaAcc / 2, 2);
?>