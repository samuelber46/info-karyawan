<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM jabatan");
$jabatan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$kd_jabatan_edit = $_GET['kd_jabatan'] ?? null;
$edit_value = [];
if (isset($kd_jabatan_edit)) {
    $edit_value =  $dbh->query("SELECT * FROM jabatan WHERE kd_jabatan='" . $kd_jabatan_edit . "'")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}
$del_jabatan = $_POST['del_jabatan'] ?? null;
if (isset($del_jabatan)) {
    $dbh->query("DELETE FROM jabatan WHERE kd_jabatan='" . $del_jabatan . "'");
    echo '<script>alert("Jabatan berhasil dihapus"); window.location.href = "fe-jabatan.php";</script>';
}
if (isset($_POST['kd_jabatan'])) {
    if (!in_array($_POST['kd_jabatan'], array_column($jabatan_list, 'kd_jabatan'))) {
        $stmt = $dbh->prepare("INSERT INTO jabatan(kd_jabatan, nm_jabatan, tj_jabatan) VALUES (:kd_jabatan, :nm_jabatan, :tj_jabatan)");
        $stmt->execute($_POST);
        echo '<script>alert("Jabatan berhasil ditambahkan"); window.location.href = "fe-jabatan.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE jabatan SET nm_jabatan=:nm_jabatan, tj_jabatan=:tj_jabatan WHERE kd_jabatan=:kd_jabatan");
        $stmt->execute($_POST);
        echo '<script>alert("Jabatan berhasil diubah"); window.location.href = "fe-jabatan.php";</script>';
    }
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
                    <div class="row align-items-start">
                        <form class="col-md-8 order-md-last mb-3" action="fe-jabatan.php" method="POST">
                            <div class="table-responsive table-entri" style="max-height: 80vh">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">kd_jabatan</th>
                                            <th scope="col">nm_jabatan</th>
                                            <th scope="col">tj_jabatan</th>
                                            <th scope="col">aksi</th>
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
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-jabatan.php?kd_jabatan=<?= $jabatan['kd_jabatan'] ?>" class="btn btn-secondary">✍️</a>
                                                            <button type="submit" name="del_jabatan" value="<?= $jabatan['kd_jabatan'] ?>" class="btn btn-danger">🗑️</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <hr>
                        <div class="col-md-4 order-md-first">
                            <form action="fe-jabatan.php" method="POST">
                                <div class="mb-3">
                                    <label for="kd_jabatan" class="form-label">kd_jabatan</label>
                                    <input type="text" class="form-control" id="kd_jabatan" name="kd_jabatan" value="<?= $edit_value['kd_jabatan'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nm_jabatan" class="form-label">nm_jabatan</label>
                                    <input type="text" class="form-control" id="nm_jabatan" name="nm_jabatan" value="<?= $edit_value['nm_jabatan'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tj_jabatan" class="form-label">tj_jabatan</label>
                                    <input type="text" class="form-control" id="tj_jabatan" name="tj_jabatan" value="<?= $edit_value['tj_jabatan'] ?? '' ?>" required>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="/" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>