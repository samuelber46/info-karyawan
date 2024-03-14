<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$stmt = $dbh->query(
    "TRANSFORM Count(sel_kar_jab_gol1.nama) AS CountOfnama
    SELECT sel_kar_jab_gol1.gol AS golongan, Count(sel_kar_jab_gol1.nama) AS jumlah
    FROM sel_kar_jab_gol1
    GROUP BY sel_kar_jab_gol1.gol
    PIVOT sel_kar_jab_gol1.nm_jabatan;"
);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Laporan Gologan Vs Jabatan Karyawan</title>
</head>

<body>
    <div class="container-fluid p-4">
        <div class="row align-items-center mb-3">
            <h1 class="text-center">Laporan Gologan Vs Jabatan Karyawan</h1>
        </div>
        <div class="row mb-3 table-responsive">
            <table class="table table-striped">
                <tr>
                    <?php if (count($result) > 0) {
                        foreach (array_keys($result[0]) as $key) {
                            echo '<th scope="col">' . $key . '</th>';
                        }
                    }
                    ?>
                </tr>
                <?php if (count($result) > 0) {
                    foreach ($result as $key => $value) {
                        echo '<tr>';
                        foreach ($value as $key2 => $value2) {
                            echo '<td>' . $value2 . '</td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="' . count($result) . '">Tidak ada data</td></tr>';
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