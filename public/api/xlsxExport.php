<?php
if (empty($_GET["session"])) {
    http_response_code(404);
    exit();
}

session_start();
if (empty($_SESSION["su"])) {
    http_response_code(401);
    exit();
}

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
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '姓名');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', '身分證字號');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', '手機');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', '信箱');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', '所屬單位');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', '職稱');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', '場次');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', '報名時間');

foreach (array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H') as $columnID) {

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
        $_s = $_GET["session"];
        if ($_s != "全部") {
            $query = "SELECT `pkid`, `session`, `job`, `dept`, `rocid`, `name`, `phone`, `email`, `status`, `created_at` as `created_at` FROM `attendee` WHERE `status` = 1 AND `session` = :session ORDER BY `pkid` DESC";
            $statement = $conn->prepare($query);
            $statement->bindParam(':session', $_s);
        } else {
            $query = "SELECT `pkid`, `session`, `job`, `dept`, `rocid`, `name`, `phone`, `email`, `status`, `created_at` as `created_at` FROM `attendee` WHERE `status` = 1 ORDER BY `pkid` DESC";
            $statement = $conn->prepare($query);
        }
       
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $index => $row) {
            $i = $index + 2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $row["name"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $row["rocid"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $row["phone"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $row["email"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $row["dept"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $row["job"]);$objPHPExcel->getActiveSheet()->SetCellValue('G' . $i, $row["session"]);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, $row["created_at"]);
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
    header('Content-Disposition: attachment;filename="GVM-Event-報名名單_' . $_GET["session"] . '.xlsx"');
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
