<?php
include_once 'templates/root.php';
?>

<head>
    <title>Menu Utama</title>
</head>

<body>
    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="card" style="width: 80vw">
            <div class="card-header">
                <h1>
                    🏠 Menu Utama
                </h1>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushMenuUtama">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                🖊️ Form Entri
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushMenuUtama">
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Jabatan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Golongan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Gaji Pokok
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Gaji Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Absen
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Lembur
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="#">
                                    Form Entri Potongan Koperasi
                                </a>
                            </div>
                        </div>
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                📃 Laporan Data Karyawan
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushMenuUtama">
                            <div class="accordion-body">
                                <a href="/report/fr-jab-kar.php">
                                    Laporan Data Karyawan tiap Jabatan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-gol-kar.php">
                                    Laporan Data Karyawan Tiap Golongan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-absensi-karyawan.php">
                                    Laporan Data Absensi Karyawan
                                </a>
                            </div>
                        </div>
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                💵 Laporan Gaji Karyawan
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushMenuUtama">
                            <div class="accordion-body">
                                <a href="/report/fr-nik-g-pokok.php">
                                    Laporan Gaji Pokok Tiap Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-nik-tot-tunjangan.php">
                                    Laporan Total Tunjangan Tiap Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-nik-tot-potongan.php">
                                    Laporan Total Potongan Tiap Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-nik-gaji-bersih.php">
                                    Laporan Gaji Bersih Tiap Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/fr-rekap-gaji-bersih.php">
                                    Laporan Rekap Gaji Bersih Karyawan
                                </a>
                            </div>
                        </div>
                        <h2 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                🧑‍💼Laporan Golongan dan Jabatan Karyawan
                            </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushMenuUtama">
                            <div class="accordion-body">
                                <a href="/report/r-jab-gol.php">
                                    Laporan Jabatan vs Golongan Karyawan
                                </a>
                            </div>
                            <div class="accordion-body">
                                <a href="/report/r-gol-jab.php">
                                    Laporan Golongan vs Jabatan Karyawan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>