<?php
include './lib/db.php';

//載入PHPExcel類
require './lib/PHPExcel.php';

//建立一個excel物件例項
$objPHPExcel = new PHPExcel();
//設定文件基本屬性
$objProps = $objPHPExcel->getProperties();
$objProps->setCreator("GVM");
$objProps->setLastModifiedBy("GVM");

$objPHPExcel->setActiveSheetIndex(0);

$objActSheet = $objPHPExcel->getActiveSheet();
$objActSheet->setTitle('報名名單');

//這裡的資料可以從資料庫中讀取，然後再做迴圈處理
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '活動名稱');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', '活動場次');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', '姓名');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', '電話');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', '信箱');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', '報名時間');

$objPHPExcel->getActiveSheet()->SetCellValue('A2', '下午茶');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', '牛肚包');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', '黃俊翔');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', '0988123456');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'jx@domain.tw');
$objPHPExcel->getActiveSheet()->SetCellValue('F2', '2019-09-14 00:54:14');

foreach (array('A', 'B', 'C', 'D', 'E', 'F') as $columnID) {

    $objPHPExcel->getActiveSheet()->getStyle($columnID . '1')->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()->setARGB('f3f3f2');

    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($columnID)
        ->setWidth(20);
}

try {
    $db = new DB();
    $conn = $db->Connect();

    if ($conn) {

        $query = "SELECT * FROM `attendee` WHERE `status` = 1 ORDER BY `pkid` ASC";
        $statement = $conn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $index => $row) {
            $i = $index + 2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $row["event"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $row["session"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $row["name"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $row["phone"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $row["email"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $row["created_at"]);
        }

    } else {
        $error = 'Connection Error';
        throw new Exception($error);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit();
}


// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="GVM_Event_報名名單.xlsx"');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="GVM_Event_報名名單.xls"');
header('Cache-Control: max-age=0');

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
ob_end_clean();

$objWriter->save('php://output');
