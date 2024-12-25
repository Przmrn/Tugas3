<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link rel="stylesheet" href="assets/index.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e1e2f, #34345c);
            color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #e4e4f0;
            margin-bottom: 20px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .search-form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-input {
            width: 90%;
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #f0f0f5;
            margin-right: 10px;
        }

        .btn-search {
            padding: 10px 15px;
            background: #6c63ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 10%;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #6c63ff;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn:hover {
            background: #574bce;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        table th {
            background: #6c63ff;
            color: #fff;
        }

        .btn-edit {
            padding: 5px 10px;
            background: #ffa500;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete {
            padding: 5px 10px;
            background: #ff6347;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #e69500;
        }

        .btn-delete:hover {
            background: #e34234;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dashboard Pendaftar</h2>
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="Cari pengguna..." class="search-input" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn-search">Cari</button>
        </form>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Filter pencarian
                    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                    $sql = "SELECT * FROM pendaftar";
                    if (!empty($search)) {
                        $sql .= " WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR nomor_telepon LIKE '%$search%'";
                    }
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["nama"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["nomor_telepon"] . "</td>
                                    <td>" . $row["status"] . "</td>
                                    <td>
                                        <a href='update.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                        <a href='delete.php?id=" . $row["id"] . "' class='btn-delete'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
