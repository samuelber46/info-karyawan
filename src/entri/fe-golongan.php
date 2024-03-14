<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM golongan ORDER BY gol ASC");
$golongan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$gol_edit = $_GET['gol'] ?? null;
$edit_value = [];
if (isset($gol_edit)) {
    $edit_value =  $dbh->query("SELECT * FROM golongan WHERE gol='" . $gol_edit . "'")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}
$del_gol = $_POST['del_gol'] ?? null;
if (isset($del_gol)) {
    $dbh->query("DELETE FROM golongan WHERE gol='" . $del_gol . "'");
    echo '<script>alert("Golongan berhasil dihapus"); window.location.href = "fe-golongan.php";</script>';
}
if (isset($_POST['gol'])) {
    if (!in_array($_POST['gol'], array_column($golongan_list, 'gol'))) {
        $stmt = $dbh->prepare("INSERT INTO golongan(gol, tj_istri_suami, tj_anak, u_makan, ix_lembur, askes) VALUES (:gol, :tj_istri_suami, :tj_anak, :u_makan, :ix_lembur, :askes)");
        $stmt->execute($_POST);
        echo '<script>alert("Golongan berhasil ditambahkan"); window.location.href = "fe-golongan.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE golongan SET tj_istri_suami=:tj_istri_suami, tj_anak=:tj_anak, u_makan=:u_makan, ix_lembur=:ix_lembur, askes=:askes WHERE gol=:gol");
        $stmt->execute($_POST);
        echo '<script>alert("Golongan berhasil diubah"); window.location.href = "fe-golongan.php";</script>';
    }
}
?>

<head>
    <title>Form Entri Golongan</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Golongan
                </h1>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row align-items-start">
                        <form class="col-md-8 order-md-last mb-3" action="fe-golongan.php" method="POST">
                            <div class="table-responsive table-entri" style="max-height: 80vh">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">gol</th>
                                            <th scope="col">tj_istri_suami</th>
                                            <th scope="col">tj_anak</th>
                                            <th scope="col">u_makan</th>
                                            <th scope="col">ix_lembur</th>
                                            <th scope="col">askes</th>
                                            <th scope="col">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($golongan_list as $golongan) { ?>
                                            <tr>
                                                <td><?= $golongan['gol'] ?></td>
                                                <td><?= $golongan['tj_istri_suami'] ?></td>
                                                <td><?= $golongan['tj_anak'] ?></td>
                                                <td><?= $golongan['u_makan'] ?></td>
                                                <td><?= $golongan['ix_lembur'] ?></td>
                                                <td><?= $golongan['askes'] ?></td>
                                                <td>
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-golongan.php?gol=<?= $golongan['gol'] ?>" class="btn btn-secondary">✍️</a>
                                                            <button type="submit" name="del_gol" value="<?= $golongan['gol'] ?>" class="btn btn-danger">🗑️</button>
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
                            <form action="fe-golongan.php" method="POST">
                                <div class="mb-3">
                                    <label for="gol" class="form-label">gol</label>
                                    <input type="text" name="gol" class="form-control" id="gol" required value="<?= $edit_value['gol'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tj_istri_suami" class="form-label">tj_istri_suami</label>
                                    <input type="text" name="tj_istri_suami" class="form-control" id="tj_istri_suami" required value="<?= $edit_value['tj_istri_suami'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tj_anak" class="form-label">tj_anak</label>
                                    <input type="text" name="tj_anak" class="form-control" id="tj_anak" required value="<?= $edit_value['tj_anak'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="u_makan" class="form-label">u_makan</label>
                                    <input type="text" name="u_makan" class="form-control" id="u_makan" required value="<?= $edit_value['u_makan'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ix_lembur" class="form-label">ix_lembur</label>
                                    <input type="text" name="ix_lembur" class="form-control" id="ix_lembur" required value="<?= $edit_value['ix_lembur'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="askes" class="form-label">askes</label>
                                    <input type="text" name="askes" class="form-control" id="askes" required value="<?= $edit_value['askes'] ?? '' ?>">
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