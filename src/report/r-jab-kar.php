<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$jabatan = $_GET['jabatan'] ?? null;

if (!isset($jabatan)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT KARYAWAN.nik, KARYAWAN.nama, KARYAWAN.alamat, KARYAWAN.kota, KARYAWAN.kd_jabatan, KARYAWAN.gol, KARYAWAN.status, KARYAWAN.jm_anak, KARYAWAN.pendidikan, KARYAWAN.departement, KARYAWAN.section, KARYAWAN.group
    FROM KARYAWAN
    WHERE (((KARYAWAN.kd_jabatan)='" . $jabatan . "'));"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Data Karyawan Tiap Jabatan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center mb-3">Laporan Data Karyawan Tiap Jabatan</h1>
        </div>
        <div class="row mb-3">
            <p class="text-uppercase">kode jabatan : <strong><?= $jabatan ?></strong></p>
        </div>
        <div class="row mb-3 overflow-x-scroll">
            <table class="table table-striped">
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>Golongan</th>
                    <th>Status</th>
                    <th>Jumlah Anak</th>
                    <th>Pendidikan</th>
                    <th>Departement</th>
                    <th>Section</th>
                    <th>Group</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= $result[$i]['nik']; ?></td>
                            <td><?= $result[$i]['nama']; ?></td>
                            <td><?= $result[$i]['alamat']; ?></td>
                            <td><?= $result[$i]['kota']; ?></td>
                            <td><?= $result[$i]['gol']; ?></td>
                            <td><?= $result[$i]['status']; ?></td>
                            <td><?= $result[$i]['jm_anak']; ?></td>
                            <td><?= $result[$i]['pendidikan']; ?></td>
                            <td><?= $result[$i]['departement']; ?></td>
                            <td><?= $result[$i]['section']; ?></td>
                            <td><?= $result[$i]['group']; ?></td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td class='text-center' colspan='9'>Data tidak ditemukan</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="row">
            <div class="d-flex justify-content-end gap-3 p-0">
                <button type="button" class="btn btn-success btn-lg printPageButton" onclick="window.print()">🖨️ Cetak</button>
                <a href="javascript:history.back()" class="btn btn-danger btn-lg printPageButton">Kembali</a>
            </div>
        </div>
    </div>
</body>