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

$permohonanDisetujui = json_decode(api('pengajuan', 'GET', ['kategori' => 'Permohonan','status' => 'Disetujui']), true);
$permohonanDitolak = json_decode(api('pengajuan', 'GET', ['kategori' => 'Permohonan','status' => 'Ditolak']), true);
$permohonanMenunggu = json_decode(api('pengajuan', 'GET', ['kategori' => 'Permohonan','status' => 'Menunggu']), true);

$pengaduanDisetujui = json_decode(api('pengajuan', 'GET', ['kategori' => 'Pengaduan','status' => 'Disetujui']), true);
$pengaduanDitolak = json_decode(api('pengajuan', 'GET', ['kategori' => 'Pengaduan','status' => 'Ditolak']), true);
$pengaduanMenunggu = json_decode(api('pengajuan', 'GET', ['kategori' => 'Pengaduan','status' => 'Menunggu']), true);

$guestTotal = json_decode(api('guest'), true);
$guestIn = json_decode(api('guest', 'GET', ['status' => 'Masuk']), true);
$guestOut = json_decode(api('guest', 'GET', ['status' => 'Keluar']), true);

$getPP = json_decode(api('photo', 'GET', ['user_token' => $_SESSION['user_token']], $_SESSION['user_token']), true);
if ($getPP['success'] == true) {
    $photoProfile = "asset/sources/" . $getPP['data']['photo'];
} else {
    $photoProfile = "asset/images/Akun.png";
}
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

<script src="https://kit.fontawesome.com/cc8eb8fa05.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="stylesheet" href="asset/style.css">
</head>

<style>
.navbars {
  height: 70px;
  display: flex;
  align-items: center;
  background: var(--white);
  color: var(--white);
  border-radius: 15px 15px 0 0;
}
.foot-link {
  font-size: 15px;
  color:rgb(119, 145, 190);
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: 0.2s;
}
.actived{
    color: rgb(28, 97, 217);
    font-size: 17px;
}
.foot-link:hover {
  color: rgb(28, 97, 217);
}
</style>
<body>
    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top-left-radius: 0; border-top-right-radius: 0;">
        <div class="container">
            <a class="navbar-brand header-2">Laporan Wilayah</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="profile?validated=<?= $_SESSION['user_token']?>">Hi, <?= $name_account ?></a>
                    <img src="<?= $photoProfile?>" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mb-1">
        <form method="post" action="pdf" class="d-flex align-items-center mb-3">
            <div class="paragraf-mini me-auto p-2" style="font-weight: var(--fwreguler) !important;">
                Minggu, 25 Mei 2025
            </div>
            <button class="btn badge-status"><i class="bi bi-filetype-pdf" style="margin-right: 6px; color: white !important;"></i>Buat PDF</button>
        </form>
    </div>

    <section class="Permohonan warga">
        <div class="header-2 d-flex justify-content-center mb-3" style="font-size: 18px;">
            Permohonan Warga</div>
        <div class="container d-flex justify-content-center align-items-center mb-3">
            <div class="card d-flex flex-row justify-content-center align-items-center"
                style="height: 95px; width: 232px;">
                <img src="asset/images/ikon_masuk.png" style="height: 54px; width: 54px; margin-right: 10px;"
                    class="card-img-top" alt="laporan permohonan">
                <div class="d-flex flex-column justify-content-center ">
                    <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Permohonan Masuk</p>
                    <div class="d-flex align-items-baseline">
                        <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($permohonanMenunggu['data']) ?></p>
                        <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Permohonan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0 mx-auto mb-3">
            <div class="col-6  d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center"
                        style="height: 94px; width: 180px;">

                        <img src="asset/images/disetujui.png" style="height: 53px; width: 51px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Disetujui</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($permohonanDisetujui['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Permohonan
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center me-2"
                        style="height: 94px; width: 180px;">

                        <img src="asset/images/ditolak.png" style="height: 54px; width: 54px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Ditolak</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($permohonanDitolak['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Permohonan
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="garis-bawah"></div>

    <section class="Pengaduan warga">
        <div class="header-2 d-flex justify-content-center mb-3 mt-4" style="font-size: 18px;">
            Pengaduan Warga</div>

        <div class="container d-flex justify-content-center align-items-center mb-3">
            <div class="card d-flex flex-row justify-content-center align-items-center"
                style="height: 95px; width: 232px;">
                <img src="asset/images/complaint.png" style="height: 54px; width: 54px; margin-right: 10px;"
                    class="card-img-top" alt="laporan permohonan">
                <div class="d-flex flex-column justify-content-center ">
                    <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Pengaduan Masuk</p>
                    <div class="d-flex align-items-baseline">
                        <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($pengaduanMenunggu['data']) ?></p>
                        <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Pengaduan</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row g-0 mx-auto mb-3">
            <div class="col-6  d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center"
                        style="height: 94px; width: 180px;">
                        <img src="asset/images/setuju.png" style="height: 53px; width: 51px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Disetujui</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($pengaduanDisetujui['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Pengaduan
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center me-2"
                        style="height: 94px; width: 180px;">
                        <img src="asset/images/tolak.png" style="height: 54px; width: 54px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Ditolak</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($pengaduanDitolak['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Pengaduan
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="garis-bawah"></div>

    <section class="Kunjungan tamu mb-3 pb-3">
        <div class="header-2 d-flex justify-content-center mb-3 mt-4" style="font-size: 18px;">
            Kunjungan Tamu</div>

        <div class="container d-flex justify-content-center align-items-center mb-3">
            <div class="card d-flex flex-row justify-content-center align-items-center"
                style="height: 95px; width: 232px;">
                <img src="asset/images/tamu.png" style="height: 54px; width: 54px; margin-right: 10px;"
                    class="card-img-top" alt="laporan permohonan">
                <div class="d-flex flex-column justify-content-center ">
                    <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Total Kunjungan</p>
                    <div class="d-flex align-items-baseline">
                        <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= $guestTotal['count'] ?></p>
                        <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Kunjungan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0 mx-auto mb-3">
            <div class="col-6  d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center"
                        style="height: 94px; width: 180px;">
                        <img src="asset/images/masuk.png" style="height: 53px; width: 51px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Check-In</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($guestIn['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Orang
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="card d-flex flex-row justify-content-center align-items-center me-2"
                        style="height: 94px; width: 180px;">
                        <img src="asset/images/keluar.png" style="height: 54px; width: 54px; margin-right: 2px;"
                            class="card-img-top" alt="laporan permohonan">
                        <div class="d-flex flex-column justify-content-center ">
                            <p class="paragraf-semiMini mb-1" style="color: black; font-size: 15px;">Check-Out</p>
                            <div class="d-flex align-items-baseline">
                                <p class="paragraf-medium mb-0" style="font-size: 20px; color: black;"><?= count($guestOut['data']) ?></p>
                                <p class="paragraf-semiMini mb-0 ms-1" style="font-size: 12px; color: black;">Orang
                                </p>
                            </div>
                        </div>

                    </div>
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
                        <a class="foot-link" href="/">
                            <i class="fa-solid fa-house" class="navicon"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link actived" href="laporan">
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