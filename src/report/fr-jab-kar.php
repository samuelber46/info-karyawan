<?php
include_once '../../includes/db_connect.php';
include_once '../templates/root.php';

$stmt = $dbh->query(
    "SELECT JABATAN.kd_jabatan
     FROM JABATAN
     ORDER BY JABATAN.[kd_jabatan];"
);
$jabatan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <title>Form Data Karyawan Tiap Jabatan</title>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card" style="width: 80vw">
            <div class="card-header">
                <h1>
                    Form Data Karyawan Tiap Jabatan
                </h1>
            </div>
            <div class="card-body">
                <form action="r-jab-kar.php" method="GET">
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select class="form-select" name="jabatan">
                            <option selected disabled value="">Pilih Jabatan</option>
                            <?php
                            foreach ($jabatan_list as $jabatan) {
                                echo '<option value="' . $jabatan['kd_jabatan'] . '">' . $jabatan['kd_jabatan'] . '</option>';
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
    </div>
</body>