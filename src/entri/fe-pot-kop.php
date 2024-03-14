<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM pot_kop ORDER BY nik");
$pot_kop_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$edit_value = [];
if (isset($_GET['nik']) && isset($_GET['bulan'])) {
    $edit_value =  $dbh->query("SELECT * FROM pot_kop WHERE nik='" . $_GET['nik'] . "'" . " AND bulan=#" . $_GET['bulan'] . "#")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}

if (isset($_POST['aksi']) && $_POST['aksi'] == 'hapus') {
    $dbh->query("DELETE FROM pot_kop WHERE nik='" . $_POST['nik'] . "' AND bulan=#" . $_POST['bulan'] . "#");
    echo '<script>alert("Potongan koperasi berhasil dihapus"); window.location.href = "fe-pot-kop.php";</script>';
}
if (isset($_POST['aksi']) && $_POST['aksi'] == 'simpan') {
    if ($_POST['nik'] != $_POST['nik_before'] || $_POST['bulan'] != date('Y-m-d', strtotime($_POST['bulan_before']))) {
        $stmt = $dbh->prepare("INSERT INTO pot_kop (nik, bulan, jh_pot) VALUES (:nik, :bulan, :jh_pot)");
        $stmt->bindParam(':nik', $_POST['nik']);
        $stmt->bindParam(':bulan', $_POST['bulan']);
        $stmt->bindParam(':jh_pot', $_POST['jh_pot']);
        $stmt->execute();
        echo '<script>alert("Potongan koperasi berhasil ditambahkan"); window.location.href = "fe-pot-kop.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE pot_kop SET nik=:nik, bulan=:bulan, jh_pot=:jh_pot WHERE nik=:nik_before AND bulan=:bulan_before");
        $stmt->bindParam(':nik', $_POST['nik']);
        $stmt->bindParam(':bulan', $_POST['bulan']);
        $stmt->bindParam(':jh_pot', $_POST['jh_pot']);
        $stmt->bindParam(':nik_before', $_POST['nik_before']);
        $stmt->bindParam(':bulan_before', $_POST['bulan_before']);
        $stmt->execute();
        echo '<script>alert("Potongan koperasi berhasil diubah"); window.location.href = "fe-pot-kop.php";</script>';
    }
}
?>

<head>
    <title>Form Entri Potongan Koperasi </title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Potongan Koperasi
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
                                            <th>jh_pot</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pot_kop_list as $pot_kop) { ?>
                                            <tr>
                                                <td><?= $pot_kop['bulan'] ?></td>
                                                <td><?= $pot_kop['nik'] ?></td>
                                                <td><?= $pot_kop['jh_pot'] ?></td>
                                                <td>
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-pot-kop.php?nik=<?= $pot_kop['nik'] ?>&bulan=<?= $pot_kop['bulan'] ?>" class="btn btn-secondary">✍️</a>
                                                            <form action="fe-pot-kop.php" method="POST">
                                                                <input type="hidden" name="nik" value="<?= $pot_kop['nik'] ?>" readonly>
                                                                <input type="hidden" name="bulan" value="<?= $pot_kop['bulan'] ?>" readonly>
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
                            <form action="fe-pot-kop.php" method="POST">
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
                                    <label for="jh_pot" class="form-label">jh_pot</label>
                                    <input type="number" class="form-control" id="jh_pot" name="jh_pot" value="<?= $edit_value['jh_pot'] ?? '' ?>" required>
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