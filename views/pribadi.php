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
$name_account = $getAcc['data']['fullname'];
$heaAcc = $getAcc['response'];

$sumAllHealth = number_format($heaAcc, 2);
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile: Informasi Pribadi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/cc8eb8fa05.js" crossorigin="anonymous"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link rel="stylesheet" href="asset/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


</head>
<style>
    .health {
        bottom: 15px;
        right: 15px;
    }
</style>

<body>
    <?php 
    if(isset($_POST['edit'])){
        $readonly = "style='background:rgb(232, 232, 232);font-weight: bold;padding:3px 5px;border-radius:7px;'";
        $tombol = '<button type="submit" name="confirm" class="btn btn-edit mb-3 mt-5">Simpan Perubahan</button>';
    }
    else{
        $readonly = "readonly style='font-weight: bold;'";
        $tombol = '<button type="submit" name="edit" class="btn btn-edit mb-3 mt-5">Edit Akun</button>';
    }

    if(isset($_POST['confirm'])){
        $_POST['status_account'] = $getAcc['data']['status_account'];
        $_POST['user_token'] = $getAcc['data']['user_token'];
        $query = json_decode(api('account/update', 'POST', $_POST, $_SESSION['user_token']), true);
        if($query['success'] == true){
            echo "<script>alert('Akun berhasil diubah'); location.href = 'pribadi';</script>";
        }
        else{
            echo "<script>alert('Akun gagal diubah: " . $query['message'] . "'); location.href = 'pribadi';</script>";
        }
    }
    ?>
    <form method="post" id="view-mode">
        <div class="container text-center pt-1 pb-2"
            style="background: var(--biruBG1); font-weight: var(--fwbold);  font-size: 24px; border-radius: 0 0 10px 10px;">
            <div class="row align-items-center justify-content-center mt-3 ">
                Informasi Pribadi
            </div>
        </div>

        <div class="container mb-2 pb-2 mt-4" width="50 ">
            <div class="card" style="background: white; color: #26374D">
                <div class="card-body">
                    <div class="header-3 mb-3">Informasi Umum</div>
                    <div class="mb-2 row">
                        <label for="NIK" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="NIK" name="nik" value="<?= $getAcc['data']['nik']?>"
                                <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="NIK" class="col-sm-2 col-form-label">NIK Kepala Keluarga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="NIK" name="kepala_keluarga" value="<?= $getAcc['data']['kepala_keluarga']?>"
                                <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="nama_lengkap" name="fullname"
                                value="<?= $getAcc['data']['fullname']?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="alamat" name="address" value="<?= $getAcc['data']['address']?>"
                                <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="nomor_hp" class="col-sm-2 col-form-label">No. Handphone</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control-plaintext" id="nomor_hp" name="whatsapp"
                                value="<?= $getAcc['data']['whatsapp']?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="nomor_hp" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control-plaintext" id="nomor_hp" name="role"
                                value="<?= $getAcc['data']['role']?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="jenis_kelamin" value="<?= $getAcc['data']['gender']?>" name="gender" <?= $readonly ?>>
                        </div>
                    </div>
                </div>
            </div>
            <?= $tombol ?>
            <a href="profile" style="text-decoration: none; color: inherit;">
            <button type="submit" class="btn btn-edit mb-3" style="background-color: transparent !important;">Kembali</button></a>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

</body>

</html>