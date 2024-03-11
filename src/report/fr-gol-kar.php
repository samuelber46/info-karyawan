<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$stmt = $dbh->query(
    "SELECT GOLONGAN.gol
    FROM GOLONGAN
    ORDER BY GOLONGAN.[gol];"
);
$golongan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Form Data Karyawan Tiap Golongan</title>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card" style="width: 80vw">
            <div class="card-header">
                <h1>
                    Form Data Karyawan Tiap Golongan
                </h1>
            </div>
            <div class="card-body">
                <form action="r-gol-kar.php" method="GET">
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Golongan</label>
                        <select class="form-select" name="golongan">
                            <option selected disabled value="">Pilih golongan</option>
                            <?php
                            foreach ($golongan_list as $golongan) {
                                echo '<option value="' . $golongan['gol'] . '">' . $golongan['gol'] . '</option>';
                            }
                            ?>
                        </select>
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