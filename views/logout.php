<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clusterin</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<?php
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        session_unset();
        $form = "none";
        $logo = "none";
        $load = "flex";
        echo '<script>window.history.pushState({}, "", "?logout=true");</script>';
    } else {
        $form = "block";
        $logo = "block";
        $load = "none";
    }
    $nonedddd = 'none';
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

    body {
        height: 100vh;
        width: 100%;
        background: rgb(15, 15, 15);
        overflow: hidden;
    }


    .snowflake {
        position: absolute;
        top: -100px;
        color: white;
        font-size: 15px;
        user-select: none;
        pointer-events: none;
        animation: fall linear infinite;
        font-weight: 600;
    }

    #imgs {
        width: 40px;
        border-radius: 50%;
    }

    .logo {
        position: fixed;
        top: 43%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        min-width: 200px;
        max-width: 240px;
        z-index: 1;
        display: <?= $logo ?>;
    }

    form {
        display: <?= $form ?>;
        position: fixed;
        top: 65%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .load {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        display: <?= $load ?>;
        flex-direction: column;
        gap: 5px;
        align-items: center;
        width: 80%;
        text-align: center;
    }

    form p {
        margin-bottom: 5px;
    }

    form .tbl {
        display: flex;
        gap: 10px;
    }

    form .tbl button {
        width: 100px;
        border: none;
        padding: 6px;
        border-radius: 7px;
        color: #fff;
        font-weight: 500;
        transition: .2s;
        cursor: pointer;
    }

    form .tbl-kembali {
        background: #5f5cff7c;
    }

    form .tbl-kembali:hover {
        background: #5f5cff;
    }

    form .tbl-keluar {
        background: #f5319a6b;
    }

    form .tbl-keluar:hover {
        background: #f53199;
    }


    .load .loading {
        color: white;
        width: 50px;
    }

    .load p {
        color: white;
    }

    .message {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
    }

    .message.active {
        opacity: 1;
        /* Muncul dengan fade in */
    }

    @keyframes fall {
        0% {
            transform: translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateY(100vh);
            opacity: 0;
        }
    }
</style>

<body>
    <img src="../asset/images/logoRemove.png" class="logo">
    <form method="post">
        <p>Yakin Mau Keluar?</p>
        <div class="tbl">
            <button type="button" onclick="window.history.back()" class="tbl-kembali">Kembali</button>
            <button type="submit" name="logout" class="tbl-keluar">Keluar</button>
        </div>
    </form>
    <div class="load">
        <span class="loading loading-spinner loading-xl"></span>
        <p class="message" id="pesan1">Menghapus Story...</p>
        <p class="message" id="pesan2">Memberhentikan Sesi...</p>
        <p class="message" id="pesan3">Terima Kasih nama <br> Sudah mengunjungi Clusterin</p>
    </div>
    <script>
        const snowflakeCount = 50;

        for (let i = 0; i < snowflakeCount; i++) {
            const snowflake = document.createElement('div');
            //snowflake.id = 'imgs';
            //snowflake.src = 'image.png';
            snowflake.classList.add('snowflake');
            snowflake.textContent = 'I';

            const size = Math.random() * 5 + 5; // Ukuran bola salju kecil (5-10px)
            snowflake.style.fontSize = `${size}px`;

            snowflake.style.left = `${Math.random() * 100}%`;
            snowflake.style.animationDuration = `${Math.random() * 7 + 1}s`; // 5-10 detik durasi jatuh
            snowflake.style.animationDelay = `${Math.random() * 10}s`;

            document.body.appendChild(snowflake);
        }
    </script>
    <script>
        if (window.location.search.includes('logout=true')) {
            const messages = [{
                    id: "pesan1",
                    duration: 2300
                },
                {
                    id: "pesan2",
                    duration: 2400
                },
                {
                    id: "pesan3",
                    duration: 2500
                } // Pesan terakhir tetap muncul
            ];

            let currentIndex = 0;

            function showNextMessage() {
                if (currentIndex >= messages.length) return;

                // Sembunyikan pesan sebelumnya (kecuali pesan pertama)
                if (currentIndex > 0) {
                    const prevMessage = document.getElementById(messages[currentIndex - 1].id);
                    prevMessage.classList.remove("active");
                }

                // Tampilkan pesan saat ini
                const currentMessage = document.getElementById(messages[currentIndex].id);
                currentMessage.classList.add("active");

                // Jika pesan terakhir, set timeout untuk redirect
                if (currentIndex === messages.length - 1) {
                    setTimeout(() => {
                        window.location.href = "signin"; // Ganti dengan URL tujuan
                    }, messages[currentIndex].duration);
                    return;
                }

                // Lanjut ke pesan berikutnya
                setTimeout(showNextMessage, messages[currentIndex].duration);
                currentIndex++;
            }

            // Mulai animasi
            showNextMessage();
        }
    </script>
</body>

</html>