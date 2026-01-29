<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-3">Reset Password</h4>

                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger">Username tidak ditemukan</div>
                    <?php endif; ?>

                    <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success">Password berhasil direset</div>
                    <?php endif; ?>

                    <form action="reset_proses.php" method="post">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Reset Password</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="login.php">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
