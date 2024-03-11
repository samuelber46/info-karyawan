<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$bulan = $_GET['bulan'] ?? null;
$nik = $_GET['nik'] ?? null;

if (!isset($bulan) || !isset($nik)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT ABSEN.Bulan, Karyawan.nik, Karyawan.nama, JABATAN.tj_jabatan AS tunj_jabatan, IIf(Karyawan.status='tidak menikah',0,GOLONGAN.tj_istri_suami) AS tunj_istri_suami, (Karyawan.jm_anak*GOLONGAN.tj_anak) AS tunj_anak, (ABSEN.jh_masuk*GOLONGAN.u_makan) AS uang_makan, (LEMBUR.jam_lembur*GOLONGAN.ix_lembur) AS uang_lembur, (JABATAN.tj_jabatan+IIf(Karyawan.status='tidak menikah',0,GOLONGAN.tj_istri_suami)+(Karyawan.jm_anak*GOLONGAN.tj_anak)+(ABSEN.jh_masuk*GOLONGAN.u_makan)+(LEMBUR.jam_lembur*GOLONGAN.ix_lembur)) AS Tot_Tunjangan
    FROM ((JABATAN INNER JOIN (GOLONGAN INNER JOIN Karyawan ON GOLONGAN.gol = Karyawan.gol) ON JABATAN.kd_jabatan = Karyawan.kd_jabatan) INNER JOIN ABSEN ON Karyawan.nik = ABSEN.nik) INNER JOIN LEMBUR ON Karyawan.nik = LEMBUR.nik
    WHERE ABSEN.Bulan=#" . $bulan . "# And Karyawan.nik='" . $nik . "' ORDER BY Karyawan.nik;"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Total Tunjangan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center">Laporan Total Tunjangan</h1>
        </div>
        <div class="row mb-3 overflow-x-scroll">
            <table class="table table-striped">
                <tr>
                    <th>Bulan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tunjangan Jabatan</th>
                    <th>Tunjangan Istri Suami</th>
                    <th>Tunjangan Anak</th>
                    <th>Uang Makan</th>
                    <th>Uang Lembur</th>
                    <th>Total Tunjangan</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= date("d-m-Y", strtotime($result[$i]["Bulan"])) ?></td>
                            <td><?= $result[$i]["nik"] ?></td>
                            <td><?= $result[$i]["nama"] ?></td>
                            <td><?= $result[$i]["tunj_jabatan"] ?></td>
                            <td><?= $result[$i]["tunj_istri_suami"] ?></td>
                            <td><?= $result[$i]["tunj_anak"] ?></td>
                            <td><?= $result[$i]["uang_makan"] ?></td>
                            <td><?= $result[$i]["uang_lembur"] ?></td>
                            <td><?= $result[$i]["Tot_Tunjangan"] ?></td>

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