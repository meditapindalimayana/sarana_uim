<?php
session_start();


// ===== CEK BLOKIR =====
$BLOCK_TIME = 300; // 5 menit
$remaining = 0;

if(isset($_SESSION['blocked_time'])){
    $elapsed = time() - $_SESSION['blocked_time'];
    $remaining = $BLOCK_TIME - $elapsed;

    if($remaining <= 0){
        unset($_SESSION['blocked_time']);
        unset($_SESSION['attempt']);
        $remaining = 0;
    }
}

// Jika sudah login
if(isset($_SESSION['login']) && $_SESSION['login'] === true){
    header("Location: index.php");
    exit;
}

$blocked = ($remaining > 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sarana Prasarana Kampus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .login-card{
            border-radius:15px;
            overflow:hidden;
        }
        .login-left{
            background:#0d6efd;
            color:white;
            padding:40px;
        }
        .login-right{
            padding:40px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow login-card">
                <div class="row g-0">
                    
                    <!-- KIRI -->
                    <div class="col-md-5 login-left d-none d-md-flex flex-column justify-content-center">
                        <h3 class="fw-bold">Sarana Prasarana</h3>
                        <p class="mb-0">Sistem Pengelolaan Aset Kampus</p>
                        <hr>
                        <small>Universitas Islam Mulia</small>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-7 login-right">
                        <h4 class="fw-bold mb-3">Login Sistem</h4>

                        <?php if($blocked): ?>
                    <div class="alert alert-warning text-center">
                         Terlalu banyak percobaan login.<br>
                         Silakan tunggu <strong><span id="timer"></span></strong>
                    </div>
                    <?php elseif(isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center">
                          Username atau password salah!
                    </div>
                    <?php endif; ?>

                        <form method="post" action="login_proses.php">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control" required autofocus <?= $blocked ? 'disabled' : '' ?>>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" required <?= $blocked ? 'disabled' : '' ?>>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100" <?= $blocked ? 'disabled' : '' ?>>
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>

                            <div class="text-center mt-3">
                            <a href="reset_password.php">Lupa Password?</a>
                            </div>

                        </form>
                        <hr>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    <?php if($blocked): ?>
    <script>
    let remaining = <?= $remaining ?>;

    function formatTime(seconds){
        let m = Math.floor(seconds / 60);
        let s = seconds % 60;
        return m.toString().padStart(2,'0') + ':' + s.toString().padStart(2,'0');
    }

    const timerEl = document.getElementById('timer');

    const interval = setInterval(() => {
        timerEl.textContent = formatTime(remaining);
        remaining--;

        if(remaining < 0){
            clearInterval(interval);
            location.reload();
        }
    }, 1000);
    </script>
    <?php endif; ?>

</body>
</html>

</body>
</html>
