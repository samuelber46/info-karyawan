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
        <div class="row mb-3 overflow-x-scroll">
            <table class="table table-striped">
                <tr>
                    <th>Gologan</th>
                    <th>Jumlah</th>
                    <th>All</th>
                    <th>Lead</th>
                    <th>QCI</th>
                    <th>SOP</th>
                    <th>Anal</th>
                    <th>ADM</th>
                    <th>SPV</th>
                    <th>YOP</th>
                </tr>
                <?php if (sizeof($result) > 0) { ?>
                    <?php for ($i = 0; $i < sizeof($result); $i++) { ?>
                        <tr>
                            <td>
                                <?php echo $result[$i]['golongan']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['jumlah']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Assistant Line Leader']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Line Leader']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Quality Control Inspector']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Senior Operator Produksi']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Sistem Analis']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Staff Administrasi']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Supervisor']; ?>
                            </td>
                            <td>
                                <?php echo $result[$i]['Yunior Operator Produksi']; ?>
                            </td>
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