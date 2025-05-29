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

$getGuest = api('guest');

if (isset($_POST['Masuk'])) {
    $getGuest = api('guest', 'GET', ['status' => 'Masuk']);
}
if (isset($_POST['Keluar'])) {
    $getGuest = api('guest', 'GET', ['status' => 'Keluar']);
}
$getAllGuest = json_decode($getGuest, true);
$heaAllGuest = $getAllGuest['response'];

$sumAllHealth = number_format($heaAcc + $heaAllGuest / 2, 2);
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Tamu</title>

    <!---link google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/cc8eb8fa05.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="asset/style.css">


</head>


<body class="bg">
    <nav class="navbar navbar-expand-lg mb-4"
        style="background: var(--biruBG1); border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; border-top-left-radius: 0; border-top-right-radius: 0;">
        <div class="container">
            <a class="navbar-brand header-2">Data Tamu</a>
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item">
                    <a class="paragraf-semiMini me-2" href="">Hi, <?= $name_account ?></a>
                    <img src="asset/images/Akun.png" alt="akun" width="30" height="30">
                </li>
            </ul>
        </div>
    </nav>

    <nav class="navbar">
        <div class="container d-flex justify-content-center">
            <form method="post" class="search-form-data-akun">
                <input type="text" placeholder="Search" name="fullname">
                <button type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </nav>

    <form method="post" class="nav d-flex justify-content-center">
        <li class="nav-item-basic mx-2">
            <button type="submit" class="nav-link nav-badge" name="Masuk">Masuk</i></button>
        </li>
        <li class="nav-item mb-3">
            <button type="submit" class="nav-link nav-badge" name="Keluar">Keluar</button>
        </li>
    </form>

    <?php
    if (isset($_POST['search'])) {
        $search = $_POST['fullname'];
        $threshold = 10;

        $getSrcGuest = [];

        foreach ($getAllGuest['data'] as $data) {
            similar_text(strtolower($search), strtolower($data['fullname']), $percent);
            if ($percent >= $threshold) {
    ?>
                <div class="card w-75 mb-3 mx-auto p-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div href="formPermohonan.html">
                                    <h6 class="mb-1 fw-bold"><?= $data['fullname'] ?></h6>
                                    <p class="mb-1" style="font-size: 14px;">Tujuan : <?= $data['destination'] ?></p>
                                    <small class=" me-1" style="font-size: 14px; color: var(--ijobubble);"><?= dated($data['created_at']) ?></small>
                                </div>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetailTamu<?= $data['id'] ?>">
                                <span class="badge-status menunggu" style="background: #5D6EC7;">Details</span>
                            </a>
                            <form method="post" class="modal fade" id="modalDetailTamu<?= $data['id'] ?>" tabindex="-1" aria-labelledby="modalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content custom-modal">
                                        <div class="modal-header" style="border-bottom-color: black;">
                                            <h5 class="modal-title" id="modalLabel">Detail
                                                Tamu
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" value="<?= $data['fullname'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control" value="<?= $data['address'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Tujuan Kunjungan</label>
                                                <input type="text" class="form-control" value="<?= $data['reason'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Rumah tujuan</label>
                                                <input type="text" class="form-control" value="<?= $data['destination'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Waktu Masuk</label>
                                                <input type="text" class="form-control" value="<?= $data['checkin'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Waktu Keluar</label>
                                                <?php
                                                if ($data['checkout'] == null) {
                                                    echo '<input type="text" class="form-control" value="-" readonly>';
                                                } else {
                                                    echo '<input type="text" class="form-control" value="' . $data['checkout'] . '" readonly>';
                                                }
                                                ?>
                                            </div>
                                            <div class="mb-2">
                                                <label>No. Hp</label>
                                                <input type="text" class="form-control" value="<?= $data['whatsapp'] ?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label>Status</label>
                                                <?php
                                                if ($data['status'] == "Masuk") {
                                                ?>
                                                    <select class="form-control" name="status">
                                                        <option hidden>Klik Untuk Update Status Tamu</option>
                                                        <option value='Keluar'>Keluar</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type='text' class='form-control' value='<?= $data["status"] ?>' readonly>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <?php
                                            if ($data['status'] == "Masuk") {
                                            ?>
                                                <button type="submit" name="update" class="btn btn-secondary" style="background: var(--ijobubble);">Update</button>
                                            <?php
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                            <button type="button" class="btn btn-secondary" style="background: var(--biruBG1);"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    } else {
        foreach ($getAllGuest['data'] as $data) {
            ?>
            <div class="card w-75 mb-3 mx-auto p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div href="formPermohonan.html">
                                <h6 class="mb-1 fw-bold"><?= $data['fullname'] ?></h6>
                                <p class="mb-1" style="font-size: 14px;">Tujuan : <?= $data['destination'] ?></p>
                                <small class=" me-1" style="font-size: 14px; color: var(--ijobubble);"><?= dated($data['created_at']) ?></small>
                            </div>
                        </div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetailTamu<?= $data['id'] ?>">
                            <span class="badge-status menunggu" style="background: #5D6EC7;">Details</span>
                        </a>
                        <form method="post" class="modal fade" id="modalDetailTamu<?= $data['id'] ?>" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content custom-modal">
                                    <div class="modal-header" style="border-bottom-color: black;">
                                        <h5 class="modal-title" id="modalLabel">Detail
                                            Tamu
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" value="<?= $data['fullname'] ?>" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" value="<?= $data['address'] ?>" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Tujuan Kunjungan</label>
                                            <input type="text" class="form-control" value="<?= $data['reason'] ?>" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Rumah tujuan</label>
                                            <input type="text" class="form-control" value="<?= $data['destination'] ?>" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Waktu Masuk</label>
                                            <input type="text" class="form-control" value="<?= $data['checkin'] ?>" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Waktu Keluar</label>
                                            <?php
                                            if ($data['checkout'] == null) {
                                                echo '<input type="text" class="form-control" value="-" readonly>';
                                            } else {
                                                echo '<input type="text" class="form-control" value="' . $data['checkout'] . '" readonly>';
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-2">
                                            <label>No. Hp</label>
                                            <input type="text" class="form-control" value="<?= $data['whatsapp'] ?>" readonly>
                                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label>Status</label>
                                            <?php
                                            if ($data['status'] == "Masuk") {
                                            ?>
                                                <select class="form-control" name="status">
                                                    <option hidden>Klik Untuk Update Status Tamu</option>
                                                    <option value='Keluar'>Keluar</option>
                                                </select>
                                            <?php
                                            } else {
                                            ?>
                                                <input type='text' class='form-control' value='<?= $data["status"] ?>' readonly>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <?php
                                        if ($data['status'] == "Masuk") {
                                        ?>
                                            <button type="submit" name="update" class="btn btn-secondary" style="background: var(--ijobubble);">Update</button>
                                        <?php
                                        } else {
                                            echo "";
                                        }
                                        ?>
                                        <button type="button" class="btn btn-secondary" style="background: var(--biruBG1);"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>


    <?php
    if (isset($_POST['update'])) {
        $_POST['checkout'] = dated();
        $postQuery = json_decode(api("guest/update", "POST", $_POST, $_SESSION['user_token']), true);
        if ($postQuery['success'] == true) {
            echo "<script>alert('Status Tamu Berhasil Diubah'); location.href = 'datatamu';</script>";
        } else {
            echo "<script>alert('" . $postQuery['message'] . "'); location.href = 'datatamu';</script>";
        }
    }
    ?>


    <nav class="navbars cc-fot fixed-bottom navbar-expand-lg">
        <div class="container c-fot">
            <div class="navbar-collapse" id="navbarNav">
                <ul class="fot">
                    <li class="nav-items">
                        <a class="foot-link actived" href="datatamu">
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