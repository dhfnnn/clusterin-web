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

if(isset($_POST['Semua'])){
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan']);
    $row = json_decode($query, true);
}
if(isset($_POST['Menunggu'])){
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan', 'status' => 'Menunggu']);
    $row = json_decode($query, true);
}
elseif(isset($_POST['Dilihat'])){
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan', 'status' => 'Diproses']);
    $row = json_decode($query, true);
}
elseif(isset($_POST['Disetujui'])){
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan', 'status' => 'Disetujui']);
    $row = json_decode($query, true);
}
elseif(isset($_POST['Ditolak'])){
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan', 'status' => 'Ditolak']);
    $row = json_decode($query, true);
}
else{
    $query = api('pengajuan', 'GET', ['kategori' => 'Pengaduan']);
    $row = json_decode($query, true);
}


$sumAllHealth = number_format($heaAcc, 2);
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
    <title>Daftar Permohonan</title>

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
        style="background: var(--biruBG1); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px">
        <div class="container">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="profile?validated=<?= $_SESSION['user_token']?>">Hi, <?= $name_account ?></a>
                    <img src="<?= $photoProfile?>" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 10px; border-bottom-right-radius: 10px">
        <div class="container">
            <a href="permohonan">
                <i class="fa-regular fa-circle-left" style="font-size: 30px;color:#fff;margin-right: -30px;"></i>
            </a>
            <ul class="navbar-nav mx-auto mb-2 mb-lg-2">
                <li class="nav-item">
                    <h1 class=header-2>Daftar Pengaduan Warga</h1>
                </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar">
        <div class="container d-flex justify-content-center">
            <form class="search-form" role="search">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control search-input" placeholder="Search" aria-label="Search" />
                </div>
            </form>
        </div>
    </nav>

    <form method="post" class="nav nav-underline d-flex justify-content-center nav-status">
        <li class="nav-item-basic">
            <button type="submit" name="Semua" value="Semua" class="nav-link <?= $active?>" href="">Semua</button>
        </li>
        <li class="nav-item-basic ">
            <button type="submit" name="Menunggu" value="Menunggu" class="nav-link <?= $active?>" href="">Menunggu</button>
        </li>
        <li class="nav-item mb-3">
            <button type="submit" name="Dilihat" value="Dilihat" class="nav-link <?= $active?>" href="">Dilihat</button>
        </li>
        <li class="nav-item mb-3">
            <button type="submit" name="Disetujui" value="Disetujui" class="nav-link <?= $active?>" href="">Disetujui</button>
        </li>
        <li class="nav-item mb-3">
            <button type="submit" name="Ditolak" value="Ditolak" class="nav-link <?= $active?>" href="">Ditolak</button>
        </li>
    </form>

<?php 
if($row['count'] >= 1){
foreach($row['data'] as $data){
    $account = json_decode(api('account', 'GET', ['user_token' => $data['user_token']]), true);
?>
    <div class="card w-75 mb-3 mx-auto p-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <img src="asset/images/data-base-alt.png" width="40" height="40" class="me-2">
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold"><?= $account['data']['fullname'] ?></h6>
                    <p class="mb-1" style="font-size: 14px;">Judul : <?= $data['judul'] ?></p>
                    <span class="status-<?= $data['status']?>"><?= $data['status']?></span>
                </div>
                <small class="text-end" style="font-size: 14px;"><?= dated($data['created_at']) ?></small>
            </div>
        </div>
    </div>
<?php
}
}
else{
?>
    <div class="card w-75 mb-3 mx-auto p-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <!-- <img src="asset/images/data-base-alt.png" width="40" height="40" class="me-2"> -->
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold">Tidak Ada Data</h6>
                    <p class="mb-1" style="font-size: 14px;"></p>
                    <span class="status-<?= $data['status']?>"></span>
                </div>
                <small class="text-end" style="font-size: 14px;"></small>
            </div>
        </div>
    </div>
<?php
}
?>
    


    <nav class="navbars fixed-bottom navbar-expand-lg">
        <div class="container c-fot">
            <div class="navbar-collapse" id="navbarNav">
                <ul class="fot">
                    <li class="nav-items">
                        <a class="foot-link" href="datatamu">
                            <i class="fa-solid fa-folder-open" class="navicon"></i>
                            <span>Data Tamu</span>
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link actived" href="kotakwarga">
                            <i class="fa-solid fa-table-list" class="navicon"></i>
                            <span>Kotak Warga</span>
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="/">
                            <i class="fa-solid fa-house" class="navicon"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="laporan">
                            <i class="fa-solid fa-chart-simple" class="navicon"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    <li class="nav-items">
                        <a class="foot-link" href="management">
                            <i class="fa-solid fa-users" class="navicon"></i>
                            <span>Management</span>
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