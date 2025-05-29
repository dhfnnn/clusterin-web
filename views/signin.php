<?php
if (isset($_POST['signin'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $account = api('account/signin', 'POST', ['nik' => $_POST['nik'], 'password' => "$password"]);
    $acc = json_decode($account, true);
    if ($acc['success'] == true) {
        session_start();
        $_SESSION['user_token'] = $acc['data']['user_token'];
        echo "<script>location.href = '/';</script>";
    } else {
        echo "<script>alert('" . $acc['message'] . "'); location.href = 'signin';</script>";
    }
}
$nonedddd = 'none';
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clusterin Login</title>

    <!---link google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!---rute ke style.css-->
    <link rel="stylesheet" href="asset/style.css">
</head>


<body style="height: 100vh;">
    <nav class="navbarss">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand">
                <img src="asset/images/logoRemove.png" alt="Logo" width="200">
            </a>
        </div>
    </nav>

    <div class="form-login d-flex flex-column justify-content-center align-items-center" style="height: 70vh;">
        <form style="width: 100%; max-width: 350px;" method="post">
            <h1 class="header mb-4 text-start">Login</h1>
            <div class="form-floating mb-3">
                <input type="text" name="nik" class="form-control" style="border-radius: 16px;" id="floatingNIK" maxlength="16" placeholder="NIK">
                <label for="floatingNIK">NIK</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" name="password" class="form-control" style="border-radius: 16px" ; id="floatingPassword"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="text-start mb-5">
                <a href="" class="paragraf-mini">Lupa Password?</a>
            </div>

            <div class="text-end mb-5">
                <button type="submit" name="signin" class="tbl-login">Login</button>
            </div>

        </form>
    </div>
    <div class="container paragraf-semiMini d-flex justify-content-center align-items-center gap-1">
        Belum punya akun? <a href="signup" style="font-weight: var(--fwbold); color:rgb(111, 173, 249);">Daftar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

    <script>
        document.getElementById('floatingNIK').addEventListener('input', function(e) {
            // Hanya izinkan angka
            this.value = this.value.replace(/[^0-9]/g, '');

            // Batasi maksimal 16 digit
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    </script>
</body>

</html>