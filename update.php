<?php
$conn = new mysqli("localhost", "root", "", "crud_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = '';
$nama = '';
$email = '';
$nomor_telepon = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$status = '';

// Mendapatkan data pengguna berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pendaftar WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $email = $row['email'];
        $nomor_telepon = $row['nomor_telepon'];
        $tanggal_lahir = $row['tanggal_lahir'];
        $jenis_kelamin = $row['jenis_kelamin'];
        $status = $row['status'];
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

// Memperbarui data pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status = $_POST['status'];

    $sql = "UPDATE pendaftar 
            SET nama='$nama', email='$email', nomor_telepon='$nomor_telepon', 
                tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', status='$status' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e1e2f, #34345c);
            color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .form-input {
            width: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #d0d0e0;
        }

        input, select, button {
            width: 100%;
            padding: 10px 0px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #f0f0f5;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.8);
        }

        button {
            background: #6c63ff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background: #574bce;
        }
    </style>
</head>
<body>
    <div class="form-page">
        <div class="form-input">
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($nama); ?>" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

                <label for="nomor_telepon">Nomor Telepon:</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" value="<?php echo htmlspecialchars($nomor_telepon); ?>" required>

                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>" required>

                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if ($jenis_kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if ($jenis_kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Pelajar" <?php if ($status == 'Pelajar') echo 'selected'; ?>>Pelajar</option>
                    <option value="Pekerja" <?php if ($status == 'Pekerja') echo 'selected'; ?>>Pekerja</option>
                    <option value="Mahasiswa" <?php if ($status == 'Mahasiswa') echo 'selected'; ?>>Mahasiswa</option>
                </select>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
