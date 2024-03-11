<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$bulan = $_GET['bulan'] ?? null;

if (!isset($bulan)) {
    echo '<script>alert("Lengkapi data terlebih dahulu"); history.back();</script>';
}

$stmt = $dbh->query(
    "SELECT A.bulan, A.nik, K.nama, A.jh_masuk, A.jh_sakit, A.jh_izin, A.jh_mangkir, L.jam_lembur
    FROM (KARYAWAN AS K INNER JOIN ABSEN AS A ON K.nik = A.nik) INNER JOIN LEMBUR AS L ON K.nik = L.nik
    WHERE (((A.bulan)=#$bulan#));"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Data Absensi Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center mb-3">Laporan Data Absensi Karyawan</h1>
        </div>
        <div class="row mb-3">
            <p class="text-uppercase">bulan : <strong><?= $bulan ?></strong></p>
        </div>
        <div class="row mb-3 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jmlh Masuk</th>
                    <th>Jmlh Sakit</th>
                    <th>Jmlh Izin</th>
                    <th>Jmlh Mangkir</th>
                    <th>Total Jam Lembur</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= $result[$i]['nik']; ?></td>
                            <td><?= $result[$i]['nama']; ?></td>
                            <td><?= $result[$i]['jh_masuk']; ?></td>
                            <td><?= $result[$i]['jh_sakit']; ?></td>
                            <td><?= $result[$i]['jh_izin']; ?></td>
                            <td><?= $result[$i]['jh_mangkir']; ?></td>
                            <td><?= $result[$i]['jam_lembur']; ?></td>
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