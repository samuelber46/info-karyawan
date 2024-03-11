<?php
include_once '../templates/root.php';
?>

<head>
    <title>Form Data Absensi Karyawan</title>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card" style="width: 80vw">
            <div class="card-header">
                <h1>
                    Form Data Absensi Karyawan
                </h1>
            </div>
            <div class="card-body">
                <form action="r-absensi-karyawan.php" method="GET">
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