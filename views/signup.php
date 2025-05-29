<!--template awal dari bootstrap-->
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!---link google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!---rute ke style.css-->
    <link rel="stylesheet" href="../asset/style.css">
</head>


<body>
    <nav class="navbar">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand">
                <img src="../asset/images/logoRemove.png" alt="Logo" width="88" height="85">
            </a>
        </div>
    </nav>

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div style="width: 100%; max-width: 400px;" class="text-start">

        </div>
        <form style="width: 90%; max-width: 400px;" method="post">
            <h1 class="header mb-3">Register</h1>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" style="border-radius: 16px;" id="floatingNama"
                    placeholder="Nama Lengkap" name="fullname">
                <label for="floatingNama">Nama Lengkap </label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" style="border-radius: 16px;" id="floatingNIK"
                    placeholder="NIK" name="nik">
                <label for="floatingNIK">NIK</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" style="border-radius: 16px;" id="floatingAlamatRumah"
                    placeholder="AlamatRumah" name="address">
                <label for="floatingAlamatRumah">Alamat Rumah</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" style="border-radius: 16px;" id="floatingNoTelp"
                    placeholder="NomorTelp" name="whatsapp">
                <label for="floatingNoTelp">No. Telp</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" style="border-radius: 16px;" id="floatingPassword"
                    placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating mb-2">
                <select name="gender" class="form-control" style="border-radius: 16px;">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <label for="floatingPassword">Jenis Kelamin</label>
            </div>

            <div class="text-end mb-3">
                <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            </div>

        </form>
    </div>
    <div class="container paragraf-semiMini d-flex justify-content-center align-items-center gap-1">
        Sudah punya akun? <a href="#" style="font-weight: var(--fwbold); color:white;">Register</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

    <?php 
        if(isset($_POST['signup'])){
            $_POST['role'] = 'Warga';
            $_POST['status_account'] = 'Pending';
            // $account = api('account/create', 'POST', [
            //     'fullname' => $_POST['fullname'],
            //     'address' => $_POST['address'],
            //     'whatsapp' => $_POST['whatsapp'],
            //     'nik' => $_POST['nik'],
            //     'password' => $_POST['password'],
            //     'role' => $role,
            //     'gender' => $_POST['gender'],
            //     'status_account' => $status
            // ]);

            $account = api('account/create', 'POST', $_POST);

            $acc = json_decode($account, true);
            if($acc['success'] == true){
                echo "<script>alert('Akun Berhasil Dibuat, Silahkan Login Terlebih Dahulu'); location.href = 'signin';</script>";
            }
            else{
                echo "<script>alert('".$acc['message']."'); location.href = 'signup';</script>";
            }
            
        }
        $nonedddd = 'none';
    ?>
</body>

</html>