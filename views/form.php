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
    <title>Form Permohonan</title>

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
        color: rgb(119, 145, 190);
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: 0.2s;
    }

    .actived {
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
            <a class="navbar-brand header-2">Pengajuan</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="">Hi,
                        <?= $name_account ?>
                    </a>
                    <img src="asset/images/Akun.png" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mb-5" width="50 ">
        <p style="font-size: 18px;font-weight: 500;">Buat Pengajuan Baru</p>
        <div class="card" style="background: var(--biruBG2); color: var(--biruBG1)">
            <form method="post" enctype="multipart/form-data" class="card-body">
                <div class="row mb-3">
                    <label for="kategori" class="col-sm-2 col-form-label mb-2">Kategori</label>
                    <div class="col-sm-10">
                        <select name="kategori" class="form-control" id="kategori">
                            <option hidden>Pilih kategori</option>
                            <option value="Permohonan">Permohonan</option>
                            <option value="Pengaduan">Pengaduan</option>
                        </select>
                    </div>
                    <br><br>
                    <label for="judul" class="col-sm-2 col-form-label mb-2">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" name="judul" class="form-control" id="judul">
                    </div>
                    <br><br>
                    <label for="file" class="col-sm-2 col-form-label">File</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="file" type="file" id="file">
                    </div>
                    <br><br>
                    <label for="catatan" class="col-sm-2 col-form-label mb-2">Catatan</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="deskripsi" class="form-control" id="catatan"></textarea>
                    </div>
                </div>
                <!-- <div class="row mb-3">
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Tempat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tanggal lahir">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">NIK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="NIK">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jenis kelamin">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Alamat">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">Email</label>
                    <div class="col-sm-10">
                        <input type="Email" class="form-control" id="Email">
                    </div>
                    <label for="colFormLabel" class="col-sm-2 col-form-label mb-2">No. HP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="Nomor hp">
                    </div>
                </div> -->
                <br>

                <div class="mb-3 tombol">
                    <button type="reset" class="cancel">Cancel</button>
                    <button type="submit" name="confirm" class="selesai">Confirm</button>
                </div>
            </form>
        </div>

        <?php
        if (isset($_POST['confirm'])) {
            $file = $_FILES['file']['name'];
            $filetmp = $_FILES['file']['tmp_name'];
            if (move_uploaded_file($filetmp, "asset/sources/".$file)) {
                $_POST['user_token'] = $_SESSION['user_token'];
                $_POST['status'] = 'Menunggu';
                $_POST['file'] = $file;
                $post = api('pengajuan/create', 'POST', $_POST, $_SESSION['user_token']);
                $resp = json_decode($post, true);
                if ($resp['success'] == true) {
                    echo "<script>alert('Pengajuan Berhasil Dibuat'); location.href = 'form';</script>";
                } else {
                    echo "<script>alert('" . $res['message'] . "'); location.href = 'form';</script>";
                }
            } else {
                echo "<script>alert('Gagal Mengunggah File'); location.href = 'form';</script>";
            }
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