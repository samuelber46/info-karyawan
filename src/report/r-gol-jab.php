<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$stmt = $dbh->query(
    "TRANSFORM Count(sel_kar_jab_gol1.nama) AS CountOfnama
     SELECT sel_kar_jab_gol1.nm_jabatan AS jabatan, Count(sel_kar_jab_gol1.nama) AS jumlah
     FROM sel_kar_jab_gol1
     GROUP BY sel_kar_jab_gol1.nm_jabatan
     PIVOT sel_kar_jab_gol1.gol;"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Jabatan Vs Gologan Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center mb-3">Laporan Jabatan Vs Gologan Karyawan</h1>
        </div>
        <div class="row mb-3 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Jabatan</th>
                    <th>Jumlah</th>
                    <th>Gol 1</th>
                    <th>Gol 2</th>
                    <th>Gol 3</th>
                    <th>Gol 4</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td><?= $result[$i]['jabatan']; ?></td>
                            <td><?= $result[$i]['jumlah']; ?></td>
                            <td><?= $result[$i]['1']; ?></td>
                            <td><?= $result[$i]['2']; ?></td>
                            <td><?= $result[$i]['3']; ?></td>
                            <td><?= $result[$i]['4']; ?></td>
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