<?php
error_reporting(E_ERROR | E_PARSE);
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
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '報名時間');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', '活動名稱');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', '活動場次');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', '職稱');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', '所屬單位');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', '身分證字號');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', '姓名');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', '電話');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', '信箱');



foreach (array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I') as $columnID) {

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

        $query = "SELECT `pkid`, `event`, `session`, `job`, `dept`, `rocid`, `name`, `phone`, `email`, `status`, CONVERT_TZ(`created_at`,'+00:00','+08:00') as `created_at` FROM `attendee` WHERE `status` = 1 ORDER BY `pkid` ASC";
        $statement = $conn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $index => $row) {
            $i = $index + 2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $row["created_at"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $row["event"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $row["session"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $row["job"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $row["dept"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $row["rocid"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $i, $row["name"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, $row["phone"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $i, $row["email"]);
        }

    } else {
        $error = 'Connection Error';
        throw new Exception($error);
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit();
}

try {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="GVM_Event_報名名單.xlsx"');
    // header('Content-Type: application/vnd.ms-excel');
    // header('Content-Disposition: attachment;filename="GVM_Event_報名名單.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    ob_end_clean();

    $objWriter->save('php://output');

} catch (PDOException $ex) {
    echo $ex->getMessage();
    exit();
}
