<?php
$dbname = dirname(__FILE__) . "/../db/info-karyawan.accdb";
$dbpwd = "vikomark123";
$connStr = "odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)};DBQ=$dbname;PWD=$dbpwd";
$dbh = new PDO($connStr);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
