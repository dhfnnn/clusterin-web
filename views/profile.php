<?php
$start = microtime(true);
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
if (!empty($_GET['validated'])) {
    $validated = $_GET['validated'];
} else {
    echo "<script>alert('Tidak Ada Data Ditemukan'); location.href = 'management';</script>";
}
$name_account = $getAcc['data']['fullname'];
$heaAcc = $getAcc['response'];

$getAccount = json_decode(api('account', 'GET', ['user_token' => $validated]), true);
$heaAccount = $getAccount['response'];

$sumAllHealth = number_format($heaAcc + $heaAccount / 2, 2);
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


<body class="bg">
    <nav class="navbar navbar-expand-lg mb-4" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px">
        <div class="container d-flex justify-content-center align-items-center">
            <h1 class="navbar-brand header-2 mt-3" style="color: var(--biruBG1);">Detail Pengguna</h1>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex flex-row-reverse">
            <button class="btn" style="background: var(--biruBG1); border: none; color: white;" data-bs-toggle="modal"
                data-bs-target="#modalHapus">Hapus</button>
            <div class="modal fade" id="modalHapus" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container pb-2">
                            <div class="d-flex align-items-center justify-content-center"
                                style="font-size: 6rem; color: var(--biruBG1);">
                                <i class="bi bi-exclamation-circle text-center"></i>
                            </div>

                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h5 class="modal-title mb-3" style="color: var(--biruBG1);">Konfirmasi Penghapusan</h5>
                                <p>Apakah anda yakin ingin menghapus pengguna?</p>
                            </div>

                            <form method="post" class="d-grid gap-2 mt-4 mx-3">
                                <button type="submit" name="delete" value="<?= $getAccount['data']['user_token'] ?>" class="btn btn-yes" id="btnYaHapus">Ya, hapus!</button>
                                <button type="button" class="btn btn-no" data-bs-dismiss="modal">Tidak, batal!</button>
                            </form>
                            <?php
                            if (isset($_POST['delete'])) {
                                $delete = json_decode(api('account/delete', 'POST', ['user_token' => $_POST['delete']], $_SESSION['user_token']), true);
                                if ($delete['success'] == true) {
                                    echo "<script>alert('Akun Pengguna Berhasil Dihapus'); location.href = 'management';</script>";
                                } else {
                                    echo "<script>alert('Akun Pengguna Gagal Dihapus, " . $delete['message'] . "'); location.href = '';</script>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalSukses" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h5 class="text-success" style="color: var(--biruBG1) !important;">Pengguna berhasil dihapus!</h5>
                            <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <a href="managementU.html">
                <button class="btn">Kembali</button>
            </a>
        </div>
    </div>

    <form method="post" class="container" style="color: var(--biruBG1); font-weight: var(--fwbold);">

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="fullname" class="form-control-plaintext input-line" value="<?= $getAccount['data']['fullname'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Induk Keluarga</label>
            <input type="text" name="nik" class="form-control-plaintext input-line" value="">
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="address" class="form-control-plaintext input-line" value="<?= $getAccount['data']['address'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" name="whatsapp" class="form-control-plaintext input-line" value="">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <input type="text" name="gender" class="form-control-plaintext input-line" value="<?= $getAccount['data']['gender'] ?>">
        </div>
        <input type="hidden" name="user_token" value="<?= $getAccount['data']['user_token'] ?>">
        <input type="hidden" name="status_account" value="<?= $getAccount['data']['status_account'] ?>">

        <div class="row" method="post">
            <div class="col-lg-auto">
                <label for="exampleFormControlInput1" class="form-label">Role Pengguna</label>
            </div>
            <div class="col-4">
                <select class="form-select" name="role" aria-label="Default select example">
                    <option value="<?= $getAccount['data']['role'] ?>"><?= $getAccount['data']['role'] ?></option>
                </select>
            </div>
            <div class="col-1 tombol">
                <button type="submit" name="updateStatus" class="btn btn-u rounded-pill mb-3">Update</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-auto">
                <label for="exampleFormControlInput1" class="form-label">Status</label>
            </div>
            <div class="col-1 tombol">
                <button type="submit" name="statusAccount" value="Active" class="btn btn-yes mb-3 mx-3">Accept</button>
                <button type="submit" name="statusAccount" value="Inactive" class="btn btn-no mb-3">Decline</button>
            </div>
        </div>
    </form>

    <?php

    if (isset($_POST['updateStatus'])) {
        if ($_POST['role'] == 'default') {
            $_POST['role'] = $getAccount['data']['role'];
        }
        $query = json_decode(api('account/update', 'POST', $_POST, $_SESSION['user_token']), true);
        if ($query['success'] == true) {
            echo "<script>alert('Role Pengguna Berhasil Diubah'); location.href = 'management';</script>";
        } else {
            echo "<script>alert('Role Pengguna Gagal Diubah, " . $query['message'] . "'); location.href = '';</script>";
        }
    }
    if (isset($_POST['statusAccount'])) {
        if ($_POST['role'] == 'default') {
            $_POST['role'] = $getAccount['data']['role'];
        }
        $_POST['status_account'] = $_POST['statusAccount'];
        $query = json_decode(api('account/update', 'POST', $_POST, $_SESSION['user_token']), true);
        if ($query['success'] == true) {
            echo "<script>alert('Status Pengguna Berhasil Diubah'); location.href = 'management';</script>";
        } else {
            echo "<script>alert('Status Pengguna Gagal Diubah, " . $query['message'] . "'); location.href = '';</script>";
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
                        <a class="foot-link" href="kotakwarga">
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
                        <a class="foot-link actived" href="management">
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

    <script>
        const btnYaHapus = document.getElementById('btnYaHapus');
        const modalHapusEl = document.getElementById('modalHapus');
        const modalSuksesEl = document.getElementById('modalSukses');


        const modalHapus = bootstrap.Modal.getInstance(modalHapusEl) || new bootstrap.Modal(modalHapusEl);
        const modalSukses = bootstrap.Modal.getInstance(modalSuksesEl) || new bootstrap.Modal(modalSuksesEl);

        btnYaHapus.addEventListener('click', () => {

            modalHapus.hide();

            modalSukses.show();
        });
    </script>

</body>

</html>