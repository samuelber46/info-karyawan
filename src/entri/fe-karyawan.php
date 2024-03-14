<?php
include_once '../templates/root.php';
include_once '../../includes/db_connect.php';
$stmt = $dbh->query("SELECT * FROM karyawan ORDER BY nik ASC");
$karyawan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nik_edit = $_GET['nik'] ?? null;
$edit_value = [];
if (isset($nik_edit)) {
    $edit_value =  $dbh->query("SELECT * FROM karyawan WHERE nik='" . $nik_edit . "'")->fetchAll(PDO::FETCH_ASSOC);
    $edit_value = $edit_value[0] ?? null;
}
$del_karyawan_nik = $_POST['del_karyawan_nik'] ?? null;
if (isset($del_karyawan_nik)) {
    $dbh->query("DELETE FROM karyawan WHERE nik='" . $del_karyawan_nik . "'");
    echo '<script>alert("Karyawan berhasil dihapus"); window.location.href = "fe-karyawan.php";</script>';
}
if (isset($_POST['nik'])) {
    if (!in_array($_POST['nik'], array_column($karyawan_list, 'nik'))) {
        $stmt = $dbh->prepare("INSERT INTO karyawan(nama, alamat, kota, tempat_lhr, tanggal_lhr, jenis_kelamin, agama, kd_jabatan, gol, [status], jm_anak, pendidikan, departement, section, [group], nik)
        VALUES (:nama, :alamat, :kota, :tempat_lhr, :tanggal_lhr, :jenis_kelamin, :agama, :kd_jabatan, :gol, :status, :jm_anak, :pendidikan, :departement, :section, :group, :nik);");
        $stmt->execute($_POST);
        echo '<script>alert("Karyawan baru berhasil ditambahkan"); window.location.href = "fe-karyawan.php";</script>';
    } else {
        $stmt = $dbh->prepare("UPDATE karyawan SET 
        nama = :nama,
        alamat = :alamat,
        kota = :kota,
        tempat_lhr = :tempat_lhr,
        tanggal_lhr = :tanggal_lhr,
        jenis_kelamin = :jenis_kelamin,
        agama = :agama,
        kd_jabatan = :kd_jabatan,
        gol = :gol,
        [status] = :status,
        jm_anak = :jm_anak,
        pendidikan = :pendidikan,
        departement = :departement,
        section = :section,
        [group] = :group
        WHERE nik = :nik");
        $stmt->execute($_POST);
        echo '<script>alert("Karyawan berhasil diubah"); window.location.href = "fe-karyawan.php";</script>';
    }
}
?>

<head>
    <title>Form Entri Karyawan</title>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="card" style="min-width: 80vw">
            <div class="card-header">
                <h1>
                    Form Entri Karyawan
                </h1>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row align-items-start">
                        <form class="col-md-8 order-md-last mb-3" action="fe-karyawan.php" method="POST">
                            <div class="table-responsive table-entri" style="max-height: 80vh">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>nik</th>
                                            <th>nama</th>
                                            <th>alamat</th>
                                            <th>kota</th>
                                            <th>tempat_lhr</th>
                                            <th>tanggal_lhr</th>
                                            <th>jenis_kelamin</th>
                                            <th>agama</th>
                                            <th>kd_jabatan</th>
                                            <th>gol</th>
                                            <th>status</th>
                                            <th>jm_anak</th>
                                            <th>pendidikan</th>
                                            <th>departement</th>
                                            <th>section</th>
                                            <th>group</th>
                                            <th>aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($karyawan_list as $karyawan) { ?>
                                            <tr>
                                                <td><?= $karyawan['nik'] ?></td>
                                                <td><?= $karyawan['nama'] ?></td>
                                                <td><?= $karyawan['alamat'] ?></td>
                                                <td><?= $karyawan['kota'] ?></td>
                                                <td><?= $karyawan['tempat_lhr'] ?></td>
                                                <td><?= $karyawan['tanggal_lhr'] ?></td>
                                                <td><?= $karyawan['jenis_kelamin'] ?></td>
                                                <td><?= $karyawan['agama'] ?></td>
                                                <td><?= $karyawan['kd_jabatan'] ?></td>
                                                <td><?= $karyawan['gol'] ?></td>
                                                <td><?= $karyawan['status'] ?></td>
                                                <td><?= $karyawan['jm_anak'] ?></td>
                                                <td><?= $karyawan['pendidikan'] ?></td>
                                                <td><?= $karyawan['departement'] ?></td>
                                                <td><?= $karyawan['section'] ?></td>
                                                <td><?= $karyawan['group'] ?></td>
                                                <td>
                                                    <div class="container overflow-hidden">
                                                        <div class="d-flex flex-md-row flex-column gap-2">
                                                            <a href="fe-karyawan.php?nik=<?= $karyawan['nik'] ?>" class="btn btn-secondary">✍️</a>
                                                            <button type="submit" name="del_karyawan_nik" value="<?= $karyawan['nik'] ?>" class="btn btn-danger">🗑️</button>
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
                            <form action="fe-karyawan.php" method="POST">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">nik</label>
                                    <input type="text" class="form-control" id="nik" name="nik" value="<?= $edit_value['nik'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $edit_value['nama'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $edit_value['alamat'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kota" class="form-label">kota</label>
                                    <input type="text" class="form-control" id="kota" name="kota" value="<?= $edit_value['kota'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lhr" class="form-label">tempat_lhr</label>
                                    <input type="text" class="form-control" id="tempat_lhr" name="tempat_lhr" value="<?= $edit_value['tempat_lhr'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lhr" class="form-label">tanggal_lhr</label>
                                    <input type="date" class="form-control" id="tanggal_lhr" name="tanggal_lhr" value="<?php if (isset($edit_value['tanggal_lhr'])) echo date('Y-m-d', strtotime($edit_value['tanggal_lhr']));
                                                                                                                        else echo ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">jenis_kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" <?= !isset($edit_value['jenis_kelamin']) ? 'selected' : '' ?>> Pilih Jenis Kelamin </option>
                                        <option value="pria" <?= isset($edit_value['jenis_kelamin']) && $edit_value['jenis_kelamin'] == 'pria' ? 'selected' : '' ?>>pria</option>
                                        <option value="wanita" <?= isset($edit_value['jenis_kelamin']) && $edit_value['jenis_kelamin'] == 'wanita' ? 'selected' : '' ?>>wanita</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="agama" class="form-label">agama</label>
                                    <select class="form-select" id="agama" name="agama" required>
                                        <option value="" <?= !isset($edit_value['agama']) ? 'selected' : '' ?>> Pilih Agama </option>
                                        <option value="Islam" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Budha" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Budha' ? 'selected' : '' ?>>Budha</option>
                                        <option value="Konghucu" <?= isset($edit_value['agama']) && $edit_value['agama'] == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                </div>
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
                                    <label for="gol" class="form-label">gol</label>
                                    <select class="form-select" name="gol" id="gol" required>
                                        <option <?php if ($edit_value == null) echo 'selected'; ?> disabled value="">Pilih golongan</option>
                                        <?php
                                        $golongan_list = $dbh->query("SELECT gol AS golongan FROM golongan ORDER BY gol ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($golongan_list as $golongan) {
                                            if ($edit_value != null && $edit_value['gol'] == $golongan['golongan']) {
                                                echo '<option selected value="' . $golongan['golongan'] . '">' . $golongan['golongan'] . '</option>';
                                            } else {
                                                echo '<option value="' . $golongan['golongan'] . '">' . $golongan['golongan'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="" <?= !isset($edit_value['status']) ? 'selected' : '' ?>> Pilih Status </option>
                                        <option value="menikah" <?= isset($edit_value['status']) && $edit_value['status'] == 'menikah' ? 'selected' : '' ?>>menikah</option>
                                        <option value="tidak menikah" <?= isset($edit_value['status']) && $edit_value['status'] == 'tidak menikah' ? 'selected' : '' ?>>tidak menikah</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jm_anak" class="form-label">jm_anak</label>
                                    <input type="number" class="form-control" id="jm_anak" name="jm_anak" value="<?= $edit_value['jm_anak'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pendidikan" class="form-label">pendidikan</label>
                                    <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="<?= $edit_value['pendidikan'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="departement" class="form-label">departement</label>
                                    <input type="text" class="form-control" id="departement" name="departement" value="<?= $edit_value['departement'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="section" class="form-label">section</label>
                                    <input type="text" class="form-control" id="section" name="section" value="<?= $edit_value['section'] ?? '' ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="group" class="form-label">group</label>
                                    <input type="text" class="form-control" id="group" name="group" value="<?= $edit_value['group'] ?? '' ?>" required>
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