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

$getPP = json_decode(api('photo', 'GET', ['user_token' => $_SESSION['user_token']], $_SESSION['user_token']), true);
if ($getPP['success'] == true) {
    $photoProfile = "asset/sources/" . $getPP['data']['photo'];
} else {
    $photoProfile = "asset/images/Akun.png";
}

$sumAllHealth = number_format($heaAcc, 2);
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>

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

</head>


<style>
    .health {
        bottom: 15px;
        right: 15px;
    }
</style>

<body class="bg">
    <div class="container text-center pt-1 pb-2"
        style="background: var(--biruBG1); font-weight: var(--fwbold);  font-size: 24px; border-radius: 0 0 10px 10px;">
        <div class="row align-items-center mt-3 ">
            <div class="col">
                <a href="/" style=" color: white;">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </a>
            </div>
            <div class="col">
                Profile
            </div>
            <div class="col">
            </div>
        </div>
    </div>


    <div class="container mb-2 pb-2 mt-4">
        <div class="header-3">Informasi Akun</div>
        <div class="card" style="background: white; color: #26374D">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center flex-column flex-md-row gap-3">
                    <div class="d-flex flex-column">
                        <img id="mainPreview" src="<?= $photoProfile ?>" alt="Foto Profil"
                            class="rounded-circle" width="110" height="110" style="object-fit: cover; color: var(--biruBG1) !important;">

                        <!-- trigger modal -->
                        <button class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#photoModal">
                            Ubah Foto
                        </button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="photoModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data" class="container pb-2">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <h5 class="modal-title text-center mb-3 mt-3"
                                            style="color: var(--biruBG1); font-weight: var(--fwbold); font-size: 29px; font-family: Poppins, sans-serif;">
                                            Ubah foto profil</h5>
                                        <img id="modalPreview" src="/asset/images/Akun.png" alt="Foto Profil"
                                            class="rounded-circle mb-3" width="110" height="110"
                                            style="object-fit: cover;">
                                        <input type="file" id="uploadFoto" style="display: none;" name="pp"
                                            onchange="loadPreview(this)">
                                        <label for="uploadFoto" class="btn btn-link text-primary fw-bold mb-1">Unggah
                                            foto</label>
                                        <button type="submit" name="deletepp" id="hapusFoto" class="btn btn-link text-danger fw-bold d-block">Hapus
                                            foto saat ini</button>
                                    </div>

                                    <div class="d-grid gap-2 mt-4 mx-3 mb-3 text-center">
                                        <button type="submit" name="confirm" class="btn btn-yes">Simpan</button>
                                        <button type="button" class="btn btn-no">Batal</button>
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['confirm'])) {
                                    $tmpName = $_FILES['pp']['tmp_name'];
                                    $name = $_FILES['pp']['name'];
                                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                                    $newName = $getAcc['data']['nik'] . date('Ymdhis') . '.' . $extension;
                                    if (move_uploaded_file($tmpName, "asset/sources/" . $newName)) {
                                        $query = json_decode(api('photo/create', 'POST', ['user_token' => $_SESSION['user_token'], 'photo' => $newName], $_SESSION['user_token']), true);
                                        if ($query['success'] == true) {
                                            echo "<script>alert('Foto berhasil disimpan ke server'); location.href = 'account';</script>";
                                        } else {
                                            echo "<script>alert('Foto gagal disimpan ke server'); location.href = 'account';</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Foto gagal disimpan'); location.href = 'account';</script>";
                                    }
                                }
                                if (isset($_POST['deletepp'])) {
                                    $query = json_decode(api('photo/delete', 'POST', ['user_token' => $_SESSION['user_token']], $_SESSION['user_token']), true);
                                    if ($query['success'] == true) {
                                        unlink("asset/sources/" . $query['data']['photo']);
                                        echo "<script>alert('Foto berhasil dihapus'); location.href = 'account';</script>";
                                    } else {
                                        echo "<script>alert('Foto gagal dihapus: " . $query['message'] . "'); location.href = 'account';</script>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php 
                if(isset($_POST['validEdit'])){
                    $readonly = "style='background:rgb(234, 234, 234);'";
                    $tombol = '<button type="submit" name="confirmEdit">Simpan Perubahan</button>';
                }
                else{
                    $readonly = "readonly";
                    $tombol = '<button type="submit" name="validEdit">Ubah Akun</button>';
                }
                ?>
                <br>
                <form method="post">
                    <style>
                        .form-control-plaintext {
                            border-radius: 10px;
                            padding: 3px 10px;
                        }
                    </style>
                    <div class="mb-2 row">
                        <label for="nama akun" class="col-sm-2 col-form-label">Nama Akun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="nama akun" <?= $readonly?> name="fullname" value="<?= $getAcc['data']['fullname']?>"
                                style="font-weight: var(--fwbold);">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="NIK" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="NIK" <?= $readonly?> name="nik" value="<?= $getAcc['data']['nik']?>"
                                style="font-weight: var(--fwbold);">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="kk" class="col-sm-2 col-form-label">NIK Kepala Keluarga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="kk" <?= $readonly?> name="kepala_keluarga" value="<?= $getAcc['data']['kepala_keluarga']?>"
                                style="font-weight: var(--fwbold);">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Alamat Rumah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="staticEmail"
                                <?= $readonly?> value="<?= $getAcc['data']['address']?>" name="address" style="font-weight: var(--fwbold);">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="nomor hp" class="col-sm-2 col-form-label">No. Handphone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="nomor hp" name="whatsapp" <?= $readonly?> value="<?= $getAcc['data']['whatsapp']?>"
                                style="font-weight: var(--fwbold);">
                        </div>
                    </div>
                </div>
                <div class="tbl-ubh">
                    <?= $tombol ?>
                </div>
            </form>
            <?php 
            if(isset($_POST['confirmEdit'])){
                $_POST['user_token'] = $_SESSION['user_token'];
                $_POST['gender'] = $getAcc['data']['gender'];
                $_POST['role'] = $getAcc['data']['role'];
                $_POST['status_account'] = $getAcc['data']['status_account'];

                $updateAcc = json_decode(api('account/update', 'POST', $_POST, $_SESSION['user_token']), true);
                if($updateAcc['success'] == true){
                    echo "<script>alert('Akun berhasil diubah'); location.href = 'profile?validated=".$_SESSION['user_token']."';</script>";
                }
                else{
                    echo "<script>alert('Akun gagal diubah: " . $updateAcc['message'] . "'); location.href = 'profile?validated=".$_SESSION['user_token']."';</script>";
                }
            }
            ?>
            <?php 
            
            ?>
        </div>
    </div>
    <div class="container mb-2 pb-2 mt-4">
        <div class="header-3">Informasi Lainnya</div>
        <div class="card" style="background: white; color: #26374D">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <img src="asset/images/data-base-alt.png" width="40" height="40" class="me-2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1" style="font-weight: var(--fwmedium);">Informasi Pribadi</h6>
                        <p class="mb-1" style="font-size: 14px; color: #D0DA12; font-weight: var(--fwbold);">Belum
                            dilengkapi</p>
                    </div>
                    <a href="profilePribadi.html" class="text-end" style="font-size: 14px; color: var(--biruBG1);"><i
                            class="bi bi-arrow-right-circle-fill fs-3"></i></a>
                </div>

                <div class="d-flex justify-content-between align-items-start">
                    <img src="asset/images/data-base-alt.png" width="40" height="40" class="me-2">
                    <div class="flex-grow-1">
                        <h6 class="mb-1" style="font-weight: var(--fwmedium);">Informasi Keluarga</h6>
                        <p class="mb-1" style="font-size: 14px; color: #D0DA12; font-weight: var(--fwbold);">Belum
                            dilengkapi</p>
                    </div>
                    <a href="profileKeluarga.html" class="text-end" style="font-size: 14px; color: var(--biruBG1);"><i
                            class="bi bi-arrow-right-circle-fill fs-3"></i></a>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

    <script>
        // Fungsi preview di modal
        function loadPreview(input) {
            const modalPreview = document.getElementById('modalPreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    modalPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Hapus foto: reset ke default
        document.getElementById('hapusFoto').addEventListener('click', function() {
            const modalPreview = document.getElementById('modalPreview');
            const mainPreview = document.getElementById('mainPreview');
            const uploadInput = document.getElementById('uploadFoto');

            const defaultImg = '/asset/images/Akun.png';
            modalPreview.src = defaultImg;
            mainPreview.src = defaultImg;
            uploadInput.value = '';
        });

        // Simpan foto → salin dari modal ke main → tutup modal
        document.querySelector('.btn-yes').addEventListener('click', function() {
            const modalPreview = document.getElementById('modalPreview');
            const mainPreview = document.getElementById('mainPreview');
            mainPreview.src = modalPreview.src;

            const modalEl = document.getElementById('photoModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });

        // Batal → hanya tutup modal
        document.querySelector('.btn-no').addEventListener('click', function() {
            const modalEl = document.getElementById('photoModal');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });
    </script>


</body>

</html>