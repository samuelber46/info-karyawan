<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$bulan = $_GET['bulan'] ?? null;
$nik = $_GET['nik'] ?? null;

if (!isset($bulan) || !isset($nik)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT ABSEN.bulan, KARYAWAN.nik, KARYAWAN.nama, KARYAWAN.kd_jabatan, KARYAWAN.gol, G_POKOK.gpo
    FROM (JABATAN INNER JOIN ((GOLONGAN INNER JOIN G_POKOK ON GOLONGAN.gol = G_POKOK.golongan) INNER JOIN KARYAWAN ON GOLONGAN.gol = KARYAWAN.gol) ON (JABATAN.kd_jabatan = G_POKOK.kd_jabatan) AND (JABATAN.kd_jabatan = KARYAWAN.kd_jabatan)) INNER JOIN ABSEN ON KARYAWAN.nik = ABSEN.nik
    WHERE (((ABSEN.bulan)=#" . $bulan . "#) AND ((KARYAWAN.nik)='" . $nik . "'))"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>LaporanGaji Pokok Tiap Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center">LaporanGaji Pokok Tiap Karyawan</h1>
        </div>
        <div class="row mb-3 overflow-x-scroll">
            <table class="table table-striped">
                <tr>
                    <th>Bulan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Kode Jabatan</th>
                    <th>Golongan</th>
                    <th>Gaji Pokok</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= date("d-m-Y", strtotime($result[$i]["bulan"])) ?></td>
                            <td><?= $result[$i]["nik"] ?></td>
                            <td><?= $result[$i]["nama"] ?></td>
                            <td><?= $result[$i]["kd_jabatan"] ?></td>
                            <td><?= $result[$i]["gol"] ?></td>
                            <td><?= $result[$i]["gpo"] ?></td>
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
        </div>>
    </div>
</body>