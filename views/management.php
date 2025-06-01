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


$getAccount = json_decode(api('account'), true);
$heaAccount = $getAccount['response'];
$getAccountfill = array_filter($getAccount['data'], function ($item) {
    return $item['user_token'] !== $_SESSION['user_token'];
});


$sumAllHealth = number_format($heaAcc + $heaAccount / 2, 2);

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
    <title>Management User</title>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<style>
    td {
        align-items: center;
        justify-content: center;
    }
</style>

<body class="bg">
    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top-left-radius: 0; border-top-right-radius: 0;">
        <div class="container">
            <a class="navbar-brand header-2">Management User</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="profile?validated=<?= $_SESSION['user_token']?>">Hi, <?= $name_account ?></a>
                    <img src="<?= $photoProfile?>" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>


    <div class="container">

        <table class="table table-hover" style="border-radius: 10px;">
            <thead>
                <tr>
                    <th scope="col" class="text-center">No.</th>
                    <th scope="col" class="text-center">Pengguna</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (($getAccount['count'] - 1) >= 1) {
                    foreach ($getAccountfill as $data) {
                        if ($data['gender'] == 'Laki-laki') {
                            $img = 'male_icon.png';
                        } else {
                            $img = 'female_icon.png';
                        }
                ?>
                        <tr>
                            <th scope="row" class="text-center"><i style="background: var(--abubayangan); padding: 2px 7px;color: var(--white);border-radius: 50%;">1</i></th>
                            <td><img src="asset/images/<?= $img?>" alt="female" width="50" height="50" class="me-1">
                                <span class="text-truncate"><?= $data['fullname'] ?></span>
                            </td>
                            <td class="text-center"><span class="badge-status-verifikasi text-bg-primary rounded-pill text-center"><?= $data['status_account'] ?></span></td>
                            <td class="text-center"><a href="profiles?validated=<?= $data['user_token']?>" class="text-decoration-none link-set">Details</a></td>
                        </tr>

                <?php
                    }
                }
                ?>
            </tbody>
        </table>

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
                            <a class="foot-link" href="laporan">
                                <i class="fa-solid fa-chart-simple" class="navicon"></i>
                                Laporan
                            </a>
                        </li>
                        <li class="nav-items">
                            <a class="foot-link actived" href="management">
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