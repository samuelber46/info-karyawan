<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$stmt = $dbh->query("SELECT nik FROM Karyawan ORDER BY nik");
$nik_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Form Total Potongan Tiap Karyawan</title>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card" style="width: 80vw">
            <div class="card-header">
                <h1>
                    Form Total Potongan Tiap Karyawan
                </h1>
            </div>
            <div class="card-body">
                <form action="r-nik-tot-potongan.php" method="GET">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <select class="form-select" aria-label="nik" name="nik" required>
                            <option selected disabled value="">Pilih NIK</option>
                            <?php
                            foreach ($nik_list as $nik) {
                                echo '<option value="' . $nik['nik'] . '">' . $nik['nik'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input type="date" name="bulan" class="form-control" id="bulan" required>
                    </div>
                    <div class="row">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="/" class="btn btn-danger">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</body>