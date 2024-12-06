<?php
session_start();
include('config/koneksi.php'); // Menyertakan koneksi ke database (seperti yang sudah Anda buat)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input username dan password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari username di tabel Mahasiswa dan Dosen
    $sql = "
    SELECT IdAdmin AS username, Password, 'admin' AS Role FROM Admin WHERE IdAdmin = ? 
    UNION 
    SELECT Nim AS username, Password, 'mahasiswa' AS Role FROM Mahasiswa WHERE Nim = ? 
    UNION 
    SELECT Nip AS username, Password, 'dosen' AS Role FROM Dosen WHERE Nip = ?
";

    $stmt = sqlsrv_prepare($conn, $sql, array(&$username, &$username, &$username));

    // Eksekusi query
    if (sqlsrv_execute($stmt)) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($result) {
            // Verifikasi password
            if ($password === $result['Password']) {
                // Set session untuk username dan role
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $result['Role'];

                // Arahkan ke halaman sesuai role
                switch ($_SESSION['role']) {
                    case 'admin':
                        header('Location: public/indexadmin.php');
                        break;
                    case 'mahasiswa':
                        $_SESSION['nim'] = $result['username'];
                        header('Location: public/indexmhs.php');
                        break;
                    case 'dosen':
                        $_SESSION['nip'] = $result['username'];
                        header('Location: public/indexdosen.php');
                        break;
                    default:
                        echo "Role tidak dikenali.";
                }
                exit();
            } else {
                echo "Password salah!";
            }
        } else {
            echo "Username tidak ditemukan!";
        }
    } else {
        echo "Terjadi kesalahan saat memproses query: ";
        print_r(sqlsrv_errors());
    }
}
