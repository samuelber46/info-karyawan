<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM jabatan");
$jabatan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$jabatan_GET = $_GET['kd_jabatan'] ?? null;
$input_value = [];
if (isset($jabatan_GET)) {
    $input_value =  $dbh->query("SELECT * FROM jabatan WHERE kd_jabatan='" . $jabatan_GET . "'")->fetchAll(PDO::FETCH_ASSOC);
    $input_value = $input_value[0];
}
$jabatan_POST = $_POST['kd_jabatan'] ?? null;
if (isset($jabatan_POST)) {
    $stmt = $dbh->query("DELETE FROM jabatan WHERE kd_jabatan='" . $jabatan_POST . "'");
    echo '<script>alert("Jabatan berhasil dihapus"); window.location.href = "fe-jabatan.php";</script>';
}

?>

<head>
    <title>Form Entri Jabatan</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Jabatan
                </h1>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <form action="fe-jabatan.php" method="POST">
                                <?php if ($input_value != null) {
                                    foreach ($input_value as $key => $value) {
                                        echo '<div class="mb-3">' .
                                            '<label for="' . $key . '" class="form-label">' . $key . '</label>' .
                                            '<input type="text" name="' . $key . '" class="form-control" id="' . $key . '" value="' . $value . '" required>' .
                                            '</div>';
                                    }
                                } else {
                                    echo
                                    '<div class="mb-3">
                                    <label for="kd_jabatan" class="form-label">kd_jabatan</label>
                                    <input type="text" name="kd_jabatan" class="form-control" id="kd_jabatan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nm_jabatan" class="form-label">nm_jabatan</label>
                                        <input type="text" name="nm_jabatan" class="form-control" id="nm_jabatan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tj_jabatan" class="form-label">tj_jabatan</label>
                                        <input type="text" name="tj_jabatan" class="form-control" id="tj_jabatan" required>
                                    </div>';
                                }
                                ?>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="/" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                        <form class="col-md-8" action="fe-jabatan.php" method="POST">
                            <div class="table-responsive table-entri">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Kode Jabatan</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Tunjangan Jabatan</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($jabatan_list as $jabatan) { ?>
                                            <tr>
                                                <td><?= $jabatan['kd_jabatan'] ?></td>
                                                <td><?= $jabatan['nm_jabatan'] ?></td>
                                                <td><?= $jabatan['tj_jabatan'] ?></td>
                                                <td>
                                                    <a href="fe-jabatan.php?kd_jabatan=<?= $jabatan['kd_jabatan'] ?>" class="btn btn-secondary">✍️</a>
                                                    <button type="submit" name="kd_jabatan" value="<?= $jabatan['kd_jabatan'] ?>" class="btn btn-danger">🗑️</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>