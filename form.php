<?php

class Form
{
    private $nama;
    private $buku;
    private $tema;
    private $email;

    public function __construct($nama = "", $buku = "", $tema = "", $email = "")
    {
        $this->nama = $nama;
        $this->buku = $buku;
        $this->tema = $tema;
        $this->email = $email;
    }

    public function renderForm()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Form</title>
            <!-- bootstrap css -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container pt-4">
                <h1>Form Data Buku</h1>
                <form method="POST" action="crud.php">
                    <div class="mb-3 row">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $this->nama ?>" required>
                    </div>
                    <div class="mb-3 row">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= $this->buku ?>" required>
                    </div>
                    <div class="mb-3 row">
                        <label for="tema" class="form-label">Tema</label>
                        <select class="form-control" id="tema" name="tema" required>
                            <option value="sains" <?= ($this->tema === 'sains') ? 'selected' : '' ?>>Sains</option>
                            <option value="spiritual" <?= ($this->tema === 'spiritual') ? 'selected' : '' ?>>Spritiual</option>
                            <option value="fantasy" <?= ($this->tema === 'fantasy') ? 'selected' : '' ?>>Fantasy</option>
                            <option value="sejarah" <?= ($this->tema === 'sejarah') ? 'selected' : '' ?>>Sejarah</option>
                            <option value="umum" <?= ($this->tema === 'umum') ? 'selected' : '' ?>>Umum</option>
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $this->email ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <!-- bootstrap bundle with popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}

$form = new Form();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Retrieve data based on the ID
    $id = $_GET['id'];
    // Fetch data from the database using the $id
    // Set the form fields with the fetched data
    $form = new Form($nama, $buku, $tema, $email);
}

$form->renderForm();

?>
