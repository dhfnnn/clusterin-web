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

$kk = json_decode(api('account', 'GET', ['nik' => $getAcc['data']['kepala_keluarga']]), true);
$getkk = json_decode(api('account', 'GET', ['kepala_keluarga' => $kk['data']['kepala_keluarga']]), true);
$sumGetKK = $getkk['count'];
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile: Informasi Keluarga</title>

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
    .tbll{
        height: 30px;
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .tbll-edit{
        margin-top: -10px;
        width: 80%;
        background:rgb(46, 95, 218);
        border-radius: 10px;
        border: none;
        color: #fff;
        padding: 7px;
        max-width: 300px;
    }
</style>

<body>
    <div id="view-mode">
        <div class="container text-center pt-1 pb-2"
            style="background: var(--biruBG1); font-weight: var(--fwbold);  font-size: 24px; border-radius: 0 0 10px 10px;">
            <div class="row align-items-center justify-content-center mt-3 ">
                Informasi Keluarga
            </div>
        </div>

        <div class="container mb-2 pb-2 mt-4" width="50">
            <div class="card" style="background: white; color: #26374D">
                <div class="card-body">
                    <div class="header-3 mb-3" >Informasi Identitas & Kependudukan
                    </div>
                    <div class="mb-2 row">
                        <label for="kepala_keluarga" class="col-sm-2 col-form-label">Kepala Keluarga</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" style="font-weight: bold;" id="kepala_keluarga"
                                value="<?= $kk['data']['fullname'] ?>" >
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="jumlahAnggotaKel" class="col-sm-2 col-form-label">Jumlah Anggota Keluarga</label>
                        <div class="col-sm-10">
                            <input type="number" readonly class="form-control-plaintext" style="font-weight: bold;" id="jumlahAnggotaKel" value="<?= $sumGetKK?>"
                                >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-2 pb-2 mt-4" width="50 ">
        <?php
        $sumk = 0;
        foreach($getkk['data'] as $data){
        $sumk++;
        if(isset($_POST['validEdit'])){
            $readonly = "style='background:rgb(232, 232, 232);font-weight: bold;padding:3px 5px;border-radius:7px;'";
            $tombol = '<button class="tbll-edit" type="submit" name="confirmEdit">Simpan Perubahan</button>';
            $opt = "<option value='Active'>Active</option><option value='Inactive'>Inactive</option>";
        }
        else{
            $readonly = "readonly style='background:rgb(255, 255, 255);font-weight: bold;padding:3px 5px;border-radius:7px;'";
            $tombol = '<button class="tbll-edit" type="submit" name="validEdit">Edit Akun</button>';
            $opt = "<option value={$data['status_account']}'>{$data['status_account']}</option>";
        }
        if(isset($_POST["confirmEdit"])){
            $_POST['whatsapp'] = $data['whatsapp'];
            $_POST['user_token'] = $data['user_token'];
            $_POST['gender'] = $data['gender'];
            $_POST['address'] = $data['address'];
            $postQ = json_decode(api('account/update', 'POST', $_POST, $_SESSION['user_token']), true);
            if($postQ['success'] == true){
                echo "<script>alert('Akun berhasil diubah'); location.href = 'keluarga';</script>";
            }
            else{
                echo "<script>alert('Akun gagal diubah: " . $postQ['message'] . "'); location.href = 'keluarga';</script>";
            }
        }
        ?> 
            <form method="post" class="card" style="color: var(--biruBG1)">
                <div class="card-body">
                    <p class="header-3 mb-3" style="color: var(--biruBG1);  font-weight: var(--fwbold);">
                        Anggota
                        Keluarga <?= $sumk ?></p>
                    <div class="row mb-1">
                        <label for="colFormLabel" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-7 mb-2">
                            <input type="text" class="form-control-plaintext" 
                                id="NIK" <?= $readonly?> value="<?= $data['nik']?>" name="nik">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="colFormLabel" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-7 mb-2">
                            <input type="text" class="form-control-plaintext" 
                                id="nama" <?= $readonly?> value="<?= $data['fullname']?>" name="fullname">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="colFormLabel" class="col-sm-2 col-form-label">Status Akun</label>
                        <div class="col-sm-7 mb-2">
                            <select class="form-control-plaintext" <?= $readonly?> name="status_account"><?= $opt ?></select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="colFormLabel" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-7 mb-2">
                            <input type="text" value="<?= $data['role']?>" class="form-control-plaintext" 
                                id="tanggal lahir" <?= $readonly?> name="role">
                        </div>
                    </div>
        
                <div class="tbll">
                    <?= $tombol ?>
                </div>
                </div>
            </form>
            <br>
        <?php
        }
        ?>
        </div>
    </div>

    <!--tampilan edit-->
    <!-- <div id="edit-mode" style="display: none">
        <div class="container text-center pt-1 pb-2"
            style="background: var(--biruBG1); font-weight: var(--fwbold);  font-size: 24px; border-radius: 0 0 10px 10px;">
            <div class="row align-items-center justify-content-center mt-3 ">
                Edit Informasi Keluarga
            </div>
        </div>
        <div class="container mb-2 pb-2 mt-4" width="50">
            <div class="card" style="background: white; color: #26374D">
                <div class="card-body">
                    <div class="header-3 mb-3" >Informasi Identitas & Kependudukan
                    </div>
                    <div class="mb-2 row">
                        <label for="kepala_keluarga" class="col-sm-2 col-form-label">Kepala Keluarga</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" id="kepala_keluarga"
                                value="Kim Jong In" style="font-weight: var(--fwbold);background: #D9D9D9;" placeholder="Masukkan kepala keluarga">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="jumlahAnggotaKel" class="col-sm-2 col-form-label">Jumlah Anggota Keluarga</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="jumlahAnggotaKel" 
                                style="font-weight: var(--fwbold); background: #D9D9D9;" placeholder="Masukkan jumlah keluarga">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-2 pb-2 mt-4" width="50 ">
            <div class="card" style="color: var(--biruBG1)">
                <div class="card-body">
                    <p class="header-3 mb-3" style="color: var(--biruBG1);  font-weight: var(--fwbold); ">
                        Anggota
                        Keluarga 3</p>
                    <div class="row mb-1">
                        <label for="nama2" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10 mb-2">
                            <input type="text" class="form-control" style="font-weight: var(--fwbold); background: #D9D9D9;"
                                id="nama2" value="Aburizal Pratama" placeholder="Masukkan nama lengkap">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="hubungan2" class="col-sm-2 col-form-label">Hubungan Keluarga</label>
                        <div class="col-sm-10 mb-2">
                            <input type="text" class="form-control" style="font-weight: var(--fwbold); background: #D9D9D9;"
                                id="hubungan2" value="Istri" placeholder="Ibu/Ayah/Anak/dll" >
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="tanggal_lahir2" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10 mb-2">
                            <input type="date" class="form-control" style="font-weight: var(--fwbold); background: #D9D9D9;"
                                id="tanggal_lahir2"  placeholder="Masukkan tanggal lahir" >
                        </div>
                    </div>
                    <div class="row mb-1">
                        <label for="NIK2" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10 mb-2">
                            <input type="text" class="form-control" style="font-weight: var(--fwbold); background: #D9D9D9;"
                                id="NIK2" value="1849204661" placeholder="Masukkan NIK">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-edit mb-3 mt-5" data-bs-toggle="modal"
                data-bs-target="#modalEditSuccess">Simpan</button>
            <button onclick="cancelEdit2()" type="submit" class="btn btn-edit mb-3"
                style="background-color: transparent !important;">Batal</button>
            <div class="modal fade" id="modalEditSuccess" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container pb-2">
                            <div class="d-flex align-items-center justify-content-center"
                                style="font-size: 6rem; color: var(--biruBG1);">
                                <i class="bi bi-check-circle-fill text-center"></i>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h5 class="modal-title text-center mb-3"
                                    style="color: var(--biruBG1); font-weight: var(--fwbold); font-size: 29px; font-family: Poppins, sans-serif;">
                                    Berhasil</h5>
                                <p>Perubahan informasi keluarga anda berhasil dilakukan.</p>
                            </div>

                            <div class="d-grid gap-2 mt-4 mx-3 mb-3 text-center">
                                <a href="profile.html">
                                    <button type="button" class="btn btn-yes">Kembali ke profil</button>
                                </a>
                                <a href="dashboard.html">
                                    <button type="button" class="btn btn-no">Kembali ke beranda</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
            
        </div>
    </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>