<?php
include "../koneksi.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST ['username'];
    $password = $_POST ['username'];

    // query untuk mencari user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt ->bind_param("s", $username);
    $stmt ->execute();
    $result = $stmt ->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        //Bandingkan password dengan username tanpa enkripsi
        if($password == $user['password']){
            $_SESSION['useranme'] = $username;
            echo "Berhasil Login";
            exit;
        }else {
            echo "Password Salah";
        }
    }else{
        echo "Usernama Tidak Terdaftar";
    }
    $stmt->close();
}
$conn->close();
?>