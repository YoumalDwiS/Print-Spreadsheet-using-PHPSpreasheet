<?php
    require 'vendor/autoload.php';

    // koneksi php dan mysql
    $koneksi = mysqli_connect("localhost", "root", "", "perpustakaan_2022");

    $c = $_POST["spreadsheet"];

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // sheet pertama
    $sheet->setTitle('Sheet 1');
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'ID');
    $sheet->setCellValue('C1', 'Nama');
    $sheet->setCellValue('D1', 'Jenis');
    $sheet->setCellValue('E1', 'Vendor');
    $sheet->setCellValue('F1', 'Stok');

    $employee = mysqli_query($koneksi,"select * from buku where nama_buku LIKE '%$c%'order by id_buku");
    $row = 2;
    $no =1;
    while($record = mysqli_fetch_array($employee))
    {
        $sheet->setCellValue('A'.$row, $no);
        $sheet->setCellValue('B'.$row, $record['id_buku']);
        $sheet->setCellValue('C'.$row, $record['nama_buku']);
        $sheet->setCellValue('D'.$row, $record['id_jenis_buku']);
        $sheet->setCellValue('E'.$row, $record['id_vendor']);
        $sheet->setCellValue('F'.$row, $record['jml_stok']);
        $row++;
        $no++;
    }

    $writer = new Xlsx($spreadsheet);
    ob_clean();
    $fileName = "Data_Buku.xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    $writer->save("php://output");

    ?>
