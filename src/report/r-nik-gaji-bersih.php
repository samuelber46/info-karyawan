<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$bulan = $_GET['bulan'] ?? null;
$nik = $_GET['nik'] ?? null;

if (!isset($bulan) || !isset($nik)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT GB.bulan, GB.nik, GB.nama, GB.Gaji_Pokok, GB.Total_Tunjangan, GB.Total_Potongan, GB.Gaji_Bersih
    FROM QFR_nikGajiBersih AS GB
    WHERE (((GB.bulan)=#" . $bulan . "#) AND ((GB.nik)='" . $nik . "'))"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Gaji Bersih Tiap Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center">Laporan Gaji Bersih Tiap Karyawan</h1>
        </div>
        <div class="row mb-3 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Bulan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gaji Pokok</th>
                    <th>Total Tunjangan</th>
                    <th>Total Potongan</th>
                    <th>Gaji Bersih</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= date("d-m-Y", strtotime($result[$i]["bulan"])) ?></td>
                            <td><?= $result[$i]["nik"] ?></td>
                            <td><?= $result[$i]["nama"] ?></td>
                            <td><?= $result[$i]["Gaji_Pokok"] ?></td>
                            <td><?= $result[$i]["Total_Tunjangan"] ?></td>
                            <td><?= $result[$i]["Total_Potongan"] ?></td>
                            <td><?= $result[$i]["Gaji_Bersih"] ?></td>
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