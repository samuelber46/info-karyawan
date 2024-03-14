<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM g_pokok");
$g_pokok_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$g_pokok_edit = $_GET['kd_jabatan'] ?? null;
$edit_value = [];
if (isset($g_pokok_edit)) {
    $edit_value =  $dbh->query("SELECT * FROM g_pokok WHERE kd_jabatan='" . $g_pokok_edit . "'")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}
$del_g_pokok = $_POST['del_kd_jabatan_g_pokok'] ?? null;
if (isset($del_g_pokok)) {
    $dbh->query("DELETE FROM g_pokok WHERE kd_jabatan='" . $del_g_pokok . "'");
    echo '<script>alert("Gaji pokok berhasil dihapus"); window.location.href = "fe-g-pokok.php";</script>';
}
if (isset($_POST['kd_jabatan'])) {
    if (!in_array($_POST['kd_jabatan'], array_column($g_pokok_list, 'kd_jabatan'))) {
        $stmt = $dbh->prepare("INSERT INTO g_pokok (kd_jabatan, golongan, gpo) VALUES (:kd_jabatan, :golongan, :gpo)");
        $stmt->execute($_POST);
        echo '<script>alert("Gaji pokok berhasil ditambahkan"); window.location.href = "fe-g-pokok.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE g_pokok SET golongan=:golongan, gpo=:gpo WHERE kd_jabatan=:kd_jabatan");
        $stmt->execute($_POST);
        echo '<script>alert("Gaji pokok berhasil diubah"); window.location.href = "fe-g-pokok.php";</script>';
    }
}
?>

<head>
    <title>Form Entri Gaji Pokok</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Gaji Pokok
                </h1>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row align-items-start">
                        <form class="col-md-8 order-md-last mb-3" action="fe-g-pokok.php" method="POST">
                            <div class="table-responsive table-entri" style="max-height: 80vh">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">kd_jabatan</th>
                                            <th scope="col">golongan</th>
                                            <th scope="col">gpo</th>
                                            <th scope="col">aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($g_pokok_list as $g_pokok) { ?>
                                            <tr>
                                                <td><?= $g_pokok['kd_jabatan'] ?></td>
                                                <td><?= $g_pokok['golongan'] ?></td>
                                                <td><?= $g_pokok['gpo'] ?></td>
                                                <td>
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-g-pokok.php?kd_jabatan=<?= $g_pokok['kd_jabatan'] ?>" class="btn btn-secondary">✍️</a>
                                                            <button type="submit" name="del_kd_jabatan_g_pokok" value="<?= $g_pokok['kd_jabatan'] ?>" class="btn btn-danger">🗑️</button>
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
                            <form action="fe-g-pokok.php" method="POST">
                                <div class="mb-3">
                                    <label for="kd_jabatan" class="form-label">kd_jabatan</label>
                                    <select class="form-select" name="kd_jabatan" id="kd_jabatan" required>
                                        <option <?php if ($edit_value == null) echo 'selected'; ?> disabled value="">Pilih kd_jabatan</option>
                                        <?php
                                        $kd_jabatan_list = $dbh->query("SELECT kd_jabatan FROM jabatan ORDER BY kd_jabatan ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($kd_jabatan_list as $kd_jabatan) {
                                            if ($edit_value != null && $edit_value['kd_jabatan'] == $kd_jabatan['kd_jabatan']) {
                                                echo '<option selected value="' . $kd_jabatan['kd_jabatan'] . '">' . $kd_jabatan['kd_jabatan'] . '</option>';
                                            } else {
                                                echo '<option value="' . $kd_jabatan['kd_jabatan'] . '">' . $kd_jabatan['kd_jabatan'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="golongan" class="form-label">golongan</label>
                                    <select class="form-select" name="golongan" id="golongan" required>
                                        <option <?php if ($edit_value == null) echo 'selected'; ?> disabled value="">Pilih golongan</option>
                                        <?php
                                        $golongan_list = $dbh->query("SELECT gol AS golongan FROM golongan ORDER BY gol ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($golongan_list as $golongan) {
                                            if ($edit_value != null && $edit_value['golongan'] == $golongan['golongan']) {
                                                echo '<option selected value="' . $golongan['golongan'] . '">' . $golongan['golongan'] . '</option>';
                                            } else {
                                                echo '<option value="' . $golongan['golongan'] . '">' . $golongan['golongan'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="gpo" class="form-label">gpo</label>
                                    <input type="text" name="gpo" class="form-control" id="gpo" required value="<?= $edit_value['gpo'] ?? '' ?>">
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