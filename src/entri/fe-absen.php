<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM absen ORDER BY nik");
$absen_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$edit_value = [];
if (isset($_GET['nik']) && isset($_GET['bulan'])) {
    $edit_value =  $dbh->query("SELECT * FROM absen WHERE nik='" . $_GET['nik'] . "'" . " AND bulan=#" . $_GET['bulan'] . "#")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}

if (isset($_POST['aksi']) && $_POST['aksi'] == 'hapus') {
    $dbh->query("DELETE FROM absen WHERE nik='" . $_POST['nik'] . "' AND bulan=#" . $_POST['bulan'] . "#");
    echo '<script>alert("Absensi berhasil dihapus"); window.location.href = "fe-absen.php";</script>';
}
if (isset($_POST['aksi']) && $_POST['aksi'] == 'simpan') {
    if ($_POST['nik'] != $_POST['nik_before'] || $_POST['bulan'] != date('Y-m-d', strtotime($_POST['bulan_before']))) {
        $stmt = $dbh->prepare("INSERT INTO absen (nik, bulan, jh_masuk, jh_sakit, jh_izin, jh_mangkir) VALUES (:nik, :bulan, :jh_masuk, :jh_sakit, :jh_izin, :jh_mangkir)");
        $stmt->execute([
            'nik' => $_POST['nik'],
            'bulan' => date('Y-m-d', strtotime($_POST['bulan'])),
            'jh_masuk' => $_POST['jh_masuk'],
            'jh_sakit' => $_POST['jh_sakit'],
            'jh_izin' => $_POST['jh_izin'],
            'jh_mangkir' => $_POST['jh_mangkir']
        ]);
        echo '<script>alert("Absensi berhasil ditambahkan"); window.location.href = "fe-absen.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE absen SET jh_masuk=:jh_masuk, jh_sakit=:jh_sakit, jh_izin=:jh_izin, jh_mangkir=:jh_mangkir WHERE nik=:nik AND bulan=:bulan");
        $stmt->execute([
            'nik' => $_POST['nik'],
            'bulan' => date('Y-m-d', strtotime($_POST['bulan'])),
            'jh_masuk' => $_POST['jh_masuk'],
            'jh_sakit' => $_POST['jh_sakit'],
            'jh_izin' => $_POST['jh_izin'],
            'jh_mangkir' => $_POST['jh_mangkir']
        ]);
        echo '<script>alert("Absensi berhasil diubah"); window.location.href = "fe-absen.php";</script>';
    }
}
?>

<head>
    <title>Form Entri Absen</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Absen
                </h1>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row align-items-start">
                        <div class="col-md-8 order-md-last mb-3">
                            <div class="table-responsive table-entri" style="max-height: 80vh">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>bulan</th>
                                            <th>nik</th>
                                            <th>jh_masuk</th>
                                            <th>jh_sakit</th>
                                            <th>jh_izin</th>
                                            <th>jh_mangkir</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($absen_list as $absen) { ?>
                                            <tr>
                                                <td><?= $absen['bulan'] ?></td>
                                                <td><?= $absen['nik'] ?></td>
                                                <td><?= $absen['jh_masuk'] ?></td>
                                                <td><?= $absen['jh_sakit'] ?></td>
                                                <td><?= $absen['jh_izin'] ?></td>
                                                <td><?= $absen['jh_mangkir'] ?></td>
                                                <td>
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-absen.php?nik=<?= $absen['nik'] ?>&bulan=<?= $absen['bulan'] ?>" class="btn btn-secondary">✍️</a>
                                                            <form action="fe-absen.php" method="POST">
                                                                <input type="hidden" name="bulan" value="<?= $absen['bulan'] ?>" readonly>
                                                                <input type="hidden" name="nik" value="<?= $absen['nik'] ?>" readonly>
                                                                <button type="submit" name="aksi" value="hapus" class="btn btn-danger">🗑️</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-4 order-md-first">
                            <form action="fe-absen.php" method="POST">
                                <input id="nik_before" type="hidden" name="nik_before" value="<?= $edit_value['nik'] ?? '' ?>" readonly>
                                <input id="bulan_before" type="hidden" name="bulan_before" value="<?= $edit_value['bulan'] ?? '' ?>" readonly>
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">bulan</label>
                                    <input type="date" class="form-control" id="bulan" name="bulan" value="<?php if (isset($edit_value['bulan'])) echo date('Y-m-d', strtotime($edit_value['bulan']));
                                                                                                            else echo ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label">nik</label>
                                    <select class="form-select" id="nik" name="nik">
                                        <option <?php if ($edit_value == null) echo 'selected'; ?> disabled value="">Pilih nik</option>
                                        <?php
                                        $nik_list = $dbh->query("SELECT * FROM karyawan ORDER BY nik")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($nik_list as $nik) {
                                            if ($nik['nik'] == $edit_value['nik']) {
                                                echo '<option selected value="' . $nik['nik'] . '">' . $nik['nik'] . ' - ' . $nik['nama'] . '</option>';
                                            } else {
                                                echo '<option value="' . $nik['nik'] . '">' . $nik['nik'] . ' - ' . $nik['nama'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jh_masuk" class="form-label">jh_masuk</label>
                                    <input type="number" class="form-control" id="jh_masuk" name="jh_masuk" value="<?= $edit_value['jh_masuk'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jh_sakit" class="form-label">jh_sakit</label>
                                    <input type="number" class="form-control" id="jh_sakit" name="jh_sakit" value="<?= $edit_value['jh_sakit'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jh_izin" class="form-label">jh_izin</label>
                                    <input type="number" class="form-control" id="jh_izin" name="jh_izin" value="<?= $edit_value['jh_izin'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jh_mangkir" class="form-label">jh_mangkir</label>
                                    <input type="number" class="form-control" id="jh_mangkir" name="jh_mangkir" value="<?= $edit_value['jh_mangkir'] ?? '' ?>" required>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" name="aksi" value="simpan">Simpan</button>
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