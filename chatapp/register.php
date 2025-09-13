<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $nomor = trim($_POST["nomor"]);
    $password = trim($_POST["password"]);

    if (empty($nama) || empty($email) || empty($password) || $nomor == 0) {
        echo "<script>alert('Semua field wajib diisi!'); window.location.href='register.php';</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $cek = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $cek->bind_param("s", $email);
    if (!$cek->execute()) {
        echo "Gagal memeriksa email: " . $cek->error;
        exit;
    }
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>alert('email sudah di gunakan'); window.location.href='register.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (username, email, tlp, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $email, $nomor, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil'); window.location.href='login.php';</script>";
        } else {
            echo "Gagal registrasi: " . $stmt->error;
        }
        $stmt->close();
    }

    $cek->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
    <div class="container-fluid min-vh-100 d-flex align-items-center">
        <div class="row w-100">
            <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center">
                <img src="lmao.jpeg" alt="Logo" style="width:120px; height:auto; margin-bottom:24px;">
                <h2 class="text-white mb-3">Welcome to Chatin</h2>
                <p class="text-white text-center" style="max-width:350px;">
                    Silakan daftar untuk membuat akun baru dan mulai menggunakan aplikasi.
                </p>
            </div>
            <div class="col-lg-6 d-flex align-items-center justify-content-start">
                <div class="card shadow-lg border-0 rounded-lg w-100" style="max-width: 400px;">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="register.php">
                            <div class="form-floating mb-3">
                                <input class="form-control" name="username" id="username" type="text" placeholder="Enter your username" />
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="email" id="email" type="email" placeholder="Enter your email" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" name="nomor" id="nomor" type="number" placeholder="Enter your phone number" />
                                        <label for="inputPassword">Telp</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Enter your password" />
                                        <label for="inputPasswordConfirm">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-block" type="submit">Buat akun</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
