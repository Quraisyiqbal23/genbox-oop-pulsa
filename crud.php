<?php

class CRUD
{
    private $conn;

    public function __construct()
    {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "latihan_crud";
        $this->conn = new mysqli($host, $user, $pass, $db);

        if ($this->conn->connect_error) {
            die("Koneksi database gagal: " . $this->conn->connect_error);
        }
    }

    public function insertData($nama, $buku, $tema, $email)
    {
        $query = "INSERT INTO data_buku (nama, buku, tema, email) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $nama, $buku, $tema, $email);

        if ($stmt->execute()) {
            $stmt->close();
            $this->redirectToCrud();
        } else {
            echo "Data gagal ditambahkan: " . $this->conn->error;
        }
    }

    private function redirectToCrud()
    {
        header("Location: crud.php");
        exit();
    }

    public function deleteData($id)
    {
        $query = "DELETE FROM data_buku WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();
            $this->redirectToCrud();
        } else {
            echo "Data gagal dihapus: " . $this->conn->error;
        }
    }

    public function getData()
    {
        $query = "SELECT * FROM data_buku";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row'>$index</th>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['buku'] . "</td>";
                echo "<td>" . $row['tema'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>";
                echo "<a href='form.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>";
                echo "<a href='crud.php?action=delete&id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</a>";
                echo "</td>";
                echo "</tr>";
                $index++;
            }
        }
    }
}

$crud = new CRUD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $buku = $_POST['judul'];
    $tema = $_POST['tema'];
    $email = $_POST['email'];

    $crud->insertData($nama, $buku, $tema, $email);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $crud->deleteData($id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font-awesome css -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0-alpha1/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container pt-4">
        <h1>Data Buku</h1>
        <a href="form.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Data</a>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Tema</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $crud->getData(); ?>
            </tbody>
        </table>
    </div>
    <!-- bootstrap bundle with popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- font-awesome js -->
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0-alpha1/js/all.min.js"></script>
</body>
</html>
