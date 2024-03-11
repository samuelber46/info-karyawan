<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$bulan = $_GET['bulan'] ?? null;
$nik = $_GET['nik'] ?? null;

if (!isset($bulan) || !isset($nik)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT Pot_Kop.bulan, Karyawan.nik, Karyawan.nama, Pot_Kop.jh_pot, Golongan.askes, ([Pot_Kop].[jh_pot]+[Golongan].[askes]) AS Total_Potongan
    FROM (Golongan INNER JOIN Karyawan ON Golongan.gol = Karyawan.gol) INNER JOIN Pot_Kop ON Karyawan.nik = Pot_Kop.nik
    WHERE (((Pot_Kop.bulan)=#" . $bulan . "#) AND ((Karyawan.nik)='" . $nik . "'))"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Total Potongan Tiap Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center">Laporan Total Potongan Tiap Karyawan</h1>
        </div>
        <div class="row mb-3 overflow-x-scroll">
            <table class="table table-striped">
                <tr>
                    <th>Bulan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Potongan Koperasi</th>
                    <th>Askes</th>
                    <th>Total Potongan</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= date("d-m-Y", strtotime($result[$i]["bulan"])) ?></td>
                            <td><?= $result[$i]["nik"] ?></td>
                            <td><?= $result[$i]["nama"] ?></td>
                            <td><?= $result[$i]["jh_pot"] ?></td>
                            <td><?= $result[$i]["askes"] ?></td>
                            <td><?= $result[$i]["Total_Potongan"] ?></td>
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