<?php
ini_set('memory_limit', '-1');
set_time_limit(0);

class PDOConnection
{

    private $dbh;

    function __construct()
    {
        try {

            $server         = "127.0.0.1";
            $db_username    = "ACEP";
            $db_password    = "sN4p798gD@M@";
            $service_name   = "platform2.nacc.go.th";
            $sid            = "ORCL";
            $port           = 3334;
            $dbtns          = "(DESCRIPTION = 
            ( ADDRESS_LIST = 
              (ADDRESS = (PROTOCOL = TCP)(HOST = 10.151.210.151)(PORT = 1522)) 
              (ADDRESS = (PROTOCOL = TCP)(HOST = 10.151.210.153)(PORT = 1522)) 
              (ADDRESS = (PROTOCOL = TCP)(HOST = 10.151.210.155)(PORT = 1522)) 
              (LOAD_BALANCE = yes)) 
            (CONNECT_DATA = (SERVER = DEDICATED) 
            (SERVICE_NAME = platform2.nacc.go.th)))";

            $this->dbh = new PDO("oci:dbname=" . $dbtns . ";charset=utf8", $db_username, $db_password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select($sql)
    {
        $sql_stmt = $this->dbh->prepare($sql);
        $sql_stmt->execute();
        $result = $sql_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($sql)
    {
        $sql_stmt = $this->dbh->prepare($sql);
        try {
            $result = $sql_stmt->execute();
        } catch (PDOException $e) {
            trigger_error('Error occured while trying to insert into the DB:' . $e->getMessage(), E_USER_ERROR);
        }
        if ($result) {
            return $sql_stmt->rowCount();
        }
    }

    function __destruct()
    {
        $this->dbh = NULL;
    }
}

$dbh = new PDOConnection();
$select_sql = "SELECT users_department.department_id, users_department.user_id, users.username AS USERNAME, users.firstname AS FIRSTNAME , users.lastname AS LASTNAME, TO_CHAR(users.createdate,'YYYY-MM-DD') AS CREATE_DATE,TO_CHAR(users.createdate,'hh24:mi:ss') AS CREATE_TIME , users.province_id, provinces.name_in_thai AS PROVINCES_NAME, districts.name_in_thai AS DISTRICTS_NAME, subdistricts.name_in_thai AS SUBDISTRICTS_NAME, users.mobile AS MOBILE, users.organization, users.user_affiliation AS USER_AFFILIATION, users.userstatus AS USERSTATUS, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2  WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS newNameExten, CASE WHEN users_department.department_id <= 5 THEN CASE WHEN users.province_id > 0 THEN(SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) ELSE (SELECT NVL(provinces.name_in_thai, '-') FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) END ELSE (SELECT NAME_IN_THAI FROM PROVINCES WHERE id = users.province_id) END AS NEWUSERPROVINCE, CASE WHEN users_department.department_id <= 5 THEN (SELECT provinces.name_in_thai FROM users_extender2 LEFT JOIN provinces ON users_extender2.school_province = provinces.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWPROVINCEEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT districts.name_in_thai FROM users_extender2 LEFT JOIN districts ON users_extender2.school_district = districts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT subdistricts.name_in_thai FROM users_extender2 LEFT JOIN subdistricts ON users_extender2.school_subdistrict = subdistricts.id WHERE users_extender2.extender_id = users.organization) ELSE '-' END AS NEWSUBDISTRICTSEXTEN, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE 0 END AS NEWPARENT, CASE WHEN users_department.department_id <= 5 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = (SELECT users_extender2.item_parent_id FROM users_extender2 WHERE users_extender2.extender_id = users.organization)) ELSE '-' END AS NEWPARENTNAME, CASE WHEN users_department.department_id <= 5 THEN '-' ELSE CASE WHEN INSTR(users.user_affiliation, 'ระดับ') > 0 THEN (SELECT users_extender2.name FROM users_extender2 WHERE users_extender2.extender_id = users.organization) ELSE users.user_affiliation END END AS EXTENNONAME FROM users JOIN users_department ON users.user_id = users_department.user_id LEFT JOIN provinces ON provinces.id = users.province_id LEFT JOIN districts ON districts.id = users.district_id LEFT JOIN subdistricts ON subdistricts.id = users.subdistrict_id WHERE users.user_role = 4 GROUP BY users_department.department_id, users_department.user_id, users.username, users.firstname, users.lastname, users.createdate, users.province_id, provinces.name_in_thai, districts.name_in_thai, subdistricts.name_in_thai, users.mobile, users.organization, users.user_affiliation, users.userstatus";
$select_user = $dbh->select($select_sql);
//$dbh->insert($insert_sql);


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// การกำหนดค่า ข้อมูลเกี่ยวกับไฟล์ excel 
$spreadsheet->getProperties()
    ->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription(
        "Test document for Office 2007 XLSX, generated using PHP classes."
    )
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

$sheet->setCellValue('A1', 'ลำดับ');
$sheet->setCellValue('B1', 'รหัสผู้ใช้');
$sheet->setCellValue('C1', 'ชื่อ-นามสกุล');
$sheet->setCellValue('D1', 'เบอร์');
$sheet->setCellValue('E1', 'มาจาก');
$sheet->setCellValue('F1', 'ระดับ');
$sheet->setCellValue('G1', 'หน่วยงาน');
$sheet->setCellValue('H1', 'จังหวัด');
$sheet->setCellValue('I1', 'วันที่สร้าง');
$sheet->setCellValue('J1', 'เวลา');
$sheet->setCellValue('K1', 'สถานะ');
$sheet->getStyle("A1:K1")->getFont()->setBold(true);

foreach ($select_user as $key => $value) {
    $key + 2;
    $full_name = $value['FIRSTNAME'] . ' ' . $value['LASTNAME'];

    $userstatus_display = 'เปิดใช้งาน';
    if ($value['USERSTATUS'] == 0) {
        $userstatus_display = 'ปิดใช้งาน';
    }

    $from = 'จังหวัด ' . $value['PROVINCES_NAME'] . ' / อำเภอ ' . $value['DISTRICTS_NAME'] . ' / ตำบล ' . $value['SUBDISTRICTS_NAME'];

    $fromExten = $value['NEWNAMEEXTEN'] .  $value['NEWPARENTNAME'] . ' / ตำบล ' . $value['SUBDISTRICTS_NAME'] . ' / อำเภอ ' . $value['DISTRICTS_NAME']  . ' / จังหวัด ' . $value['PROVINCES_NAME'];
    if ($value['DEPARTMENT_ID'] > 5) {
        $fromExten = $value['EXTENNONAME'];
    }

    $sheet->setCellValue('A' . $key + 2, $key + 1);
    $sheet->setCellValue('B' . $key + 2, $value['USERNAME']);
    $sheet->setCellValue('C' . $key + 2, $full_name);
    $sheet->setCellValue('D' . $key + 2, $value['MOBILE']);
    $sheet->setCellValue('E' . $key + 2,  $from);
    $sheet->setCellValue('F' . $key + 2, $value['USER_AFFILIATION']);
    $sheet->setCellValue('G' . $key + 2, $fromExten);
    $sheet->setCellValue('H' . $key + 2, $value['PROVINCES_NAME']);
    $sheet->setCellValue('I' . $key + 2, $value['CREATE_DATE']);
    $sheet->setCellValue('J' . $key + 2, $value['CREATE_TIME']);
    $sheet->setCellValue('K' . $key + 2, $userstatus_display);
}
$writer = new Xlsx($spreadsheet);

// ชื่อไฟล์
$file_export = "Export-" . date("dmY-Hs");


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $file_export . '.xlsx"');
header("Content-Transfer-Encoding: binary ");

$writer->save('php://output');
exit();
