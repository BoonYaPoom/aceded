<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$post = $this->input->post();
$selectcourse = $post['selectcourse'];
$course_id = $this->session->userdata('course_id');
if (empty($course_id)) $course_id = $args[0];
$module = $arg[3];
$class_id = $arg[4];
if (!empty($this->input->post('selectclass'))) $class_id = $this->input->post('selectclass');
if (empty($module)) $module = "D0100";
$hideyear = $hidemonth = "";
if ($module != "D0101") $hidemonth = "d-none";
if (!empty($class_id)) $hideyear = "d-none";

$selectyearth = $selectyear + 543;
$group_id = $data['course'][$course_id]['group_id'];
$montharr = array(10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9);
$reportname = array(
	'T0101' => 'รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร',
	'T0108' => 'รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด',
	'T0103' => 'รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน',
	'T0104' => 'รายงานการ Login ของผู้เรียน',
	//'T0109'=>'การบันทึกการเรียนการสอนและการถ่ายทอดสด',
	'T0110' => 'การสำรองและการกู้คืนข้อมูล',
	'T0111' => 'สรุปรายรับในการฝึกอบรมรายเดือน',
	'T0112' => 'สรุปรายรับในการฝึกอบรมรายไตรมาส',
	'T0113' => 'สรุปรายรับในการฝึกอบรมรายปี',
	'T0114' => 'สำรองข้อมูล  (Backup System)  แบบ  Full Backup',
	'T0115' => 'ข้อมูล Log File ในรูปแบบรายงานทางสถิติ',

	//'T0102'=>'รายชื่อหลักสูตรที่มีผู้เข้าเรียนมากที่สุด',
	// 'T0105'=>'รายงานจำนวนสื่อเสริม'
	// 'T0106'=>'รายงานการเข้าใช้งาน Virtual Classroom',
	//'T0107'=>'รายงานข้อมูลการสอนของวิทยากร',
	// 'D0101'=>'รายงานรายชื่อวิชา',
	//  'A0101'=>'รายงานข้อมูล Application MOC e-Learning (Android) บน Play Store'
);
echo '<!-- .page-inner -->
			<style>
				@media print {
				  body * {visibility: hidden;}
				  #section-to-print, #section-to-print * {visibility: visible;}
				  #section-to-print {position: absolute;left: 0;top: 0;}
				}
				</style>
            <div class="page-inner">
			 
			<form method="post" id="formreport">
			<div class="form-row">
				<!-- form column -->
				<div class="col-md-1" ><span class="mt-1 ' . $hideyear . '">ปี</span></div>
				<div class="col-md-3">
				   <div class="' . $hideyear . '"><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2" data-placeholder="ปี" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
for ($y = $startyear; $y <= date('Y'); $y++) {
	$yth = $y + 543;
	$selected = ($selectyear == $y) ? "selected" : "";
	echo '<option value="' . $y . '" ' . $selected . '> ' . $yth . ' </option>';
}
echo '</select></div>';
if (!empty($class_id)) {
	echo '<select id="selectclass" name="selectclass" class="form-control" data-toggle="select2" data-placeholder="ปี" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	foreach ($class as $classid => $row) {
		$selected = ($classid == $class_id) ? "selected" : "";
		echo '<option value="' . $classid . '" ' . $selected . '> ' . $row['course_name'] . ' </option>';
	}
	echo '</select>';
}

echo '</div>';
if (in_array($module, array('T0101'))) {
	echo '<div class="col-md-4 ">
					<div ><select id="selectcourse" name="selectcourse" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> เลือกหลักสูตร </option>';
	foreach ($select_course as $course_name) {
		$selected = ($course_name == $selectcourse) ? "selected" : "";
		echo '<option value="' . $course_name . '" ' . $selected . '> ' . $course_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
	echo '<div class="col-md-4 ">
					<div ><select id="selectuser_id" name="selectuser_id" class="form-control" data-toggle="select2" data-placeholder="ผู้ใช้งานทั้งหมด" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> ผู้ใช้งานทั้งหมด </option>';
	foreach ($select_user_id as $user_id_name) {
		$selected = ($user_id_name == $selectuser_id) ? "selected" : "";
		echo '<option value="' . $user_id_name . '" ' . $selected . '> ' . $user_id_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
}
/*if(in_array($module,array('T0108'))){
					echo'<div class="col-md-4 ">
					<div ><select id="selectcourse" name="selectcourse" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
					echo'<option value="" '.$selected.'> เลือกหลักสูตร </option>'; 
						   foreach($select_course as $course_name){
						$selected=($course_name==$selectcourse)?"selected":"";
						echo'<option value="'.$course_name.'" '.$selected.'> '.$course_name.' </option>'; 
						}
				  echo'</select>';
				echo'</div></div>';
				 }*/
if (in_array($module, array('T0102'))) {
	echo '<div class="col-md-4 ">
					<div ><select id="selectcourse" name="selectcourse" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> เลือกหลักสูตร </option>';
	foreach ($select_course as $course_name) {
		$selected = ($course_name == $selectcourse) ? "selected" : "";
		echo '<option value="' . $course_name . '" ' . $selected . '> ' . $course_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
}

if (in_array($module, array('T0104'))) {
	echo '<div class="col-md-4 ">
						<div ><select id="selectuser_idt0104" name="selectuser_idt0104" class="form-control" data-toggle="select2" data-placeholder="ผู้ใช้งานทั้งหมด" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> ผู้ใช้งานทั้งหมด </option>';
	foreach ($select_user_id as $user_id_name) {
		$selected = ($user_id_name == $selectuser_id) ? "selected" : "";
		echo '<option value="' . $user_id_name . '" ' . $selected . '> ' . $user_id_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
}

if (in_array($module, array('T0106'))) {
	echo '<div class="col-md-4 ">
							<div ><select id="selectuser_idt0106" name="selectuser_idt0106" class="form-control" data-toggle="select2" data-placeholder="ผู้ใช้งานทั้งหมด" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> ผู้ใช้งานทั้งหมด </option>';
	foreach ($select_user_id as $user_id_name) {
		$selected = ($user_id_name == $selectuser_id) ? "selected" : "";
		echo '<option value="' . $user_id_name . '" ' . $selected . '> ' . $user_id_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
}

if (in_array($module, array('T0107'))) {
	echo '<div class="col-md-4 ">
								<div ><select id="selectuser_idt0107" name="selectuser_idt0107" class="form-control" data-toggle="select2" data-placeholder="ผู้สอนทั้งหมด" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
	echo '<option value="" ' . $selected . '> ผู้สอนทั้งหมด </option>';
	foreach ($select_user_id as $user_id_name) {
		$selected = ($user_id_name == $selectuser_id) ? "selected" : "";
		echo '<option value="' . $user_id_name . '" ' . $selected . '> ' . $user_id_name . ' </option>';
	}
	echo '</select>';
	echo '</div></div>';
}

echo '<div class="col-md-3 ">
				   <div class="' . $hidemonth . '"><select id="selectmonth" name="selectmonth" class="form-control " data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false" onchange="$(\'#formreport\').submit();">';
echo '<option value="0">เดือน</option>';
foreach ($montharr as $_id => $mid) {
	$month = $data['month']['th'][$mid];
	$selected = ($selectmonth == $mid) ? "selected" : "";
	if (!empty($mid)) echo '<option value="' . $mid . '" ' . $selected . '> ' . $month . ' </option>';
}

echo '</select></div>
				</div>
				<div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none" data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
				<!-- /form column -->
			  </div><!-- /form row -->    
			  </form>
                    <!-- .table-responsive -->';
$monthname = '';
if (!empty($selectmonth)) $monthname = ' เดือน' . $data['month']['th'][$selectmonth];
$title = $reportarray[$module] . $monthname . ' ปี ' . $selectyearth;
$titletable = $reportname[$module];
switch ($module) {
	case "D0102":
		$title = "รายงานผู้เข้ารับการอบรมจำแนกตามประเภทตำแหน่งระหว่างเดือน" . $formmonth . ' ถึง ' . $tomonth;
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $title . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
							<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="38">' . $title . '</th></tr>
										  <tr class="text-center">
											<th align="center" width="10" rowspan="5" >ลำดับ</th>
											<th align="center" width="300" rowspan="5" >ชื่อหลักสูตร</th>
											<th align="center" colspan="33">จำนวนคนแยกตามกลุ่ม</th>
											<th align="center"  rowspan="4" colspan="3">ระยะเวลาการอบรม</th>
										  </tr>
										  <tr class="text-center">
											<th align="center"  rowspan="2" colspan="4">ผู้บริหาร</th>
											<th align="center"  rowspan="2" colspan="4">วิชาการ</th>
											<th align="center"  rowspan="2" colspan="4">ทั่วไป</th>
											<th align="center"  colspan="16">อื่นๆ</th>
											<th align="center"  rowspan="2" colspan="4">รวม</th>
											 <th align="center"  rowspan="4" >รวมทั้งสิ้น</th>
										  </tr>		
										  	<tr class="text-center">
											<th align="center"   colspan="4">ลูกจ้างประจำ</th>
											<th align="center"   colspan="4">พนักงานราชการ</th>
											<th align="center"   colspan="4">ลูกจ้างเหมาบริการ</th>
											<th align="center"   colspan="4">อคส / OTCC</th>		
										  </tr>		
										  <tr class="text-center">';
		for ($c = 1; $c <= 8; $c++) {
			$tables .= '<th align="center"  colspan="2" colspan="4">ชาย</th>
										  <th align="center"  colspan="2" colspan="4">หญิง</th>';
		}
		$tables .= '</tr>';
		$tables .= '<tr class="text-center">';
		for ($c = 1; $c <= 16; $c++) {
			$tables .= '<th align="center">คน</th>
										  <th align="center">%</th>';
		}
		$tables .= '<th align="center">วัน</th>
										  <th align="center">ชม.</th>
										  <th align="center">รวมชั่วโมง</th>';
		$tables .= '</tr>';

		$n = 0;
		foreach ($report as $class_id => $row) {

			/*	
											$tables.='<tr><td align="center" >'.$n.'</td>
											<td >'.$row['PN_NAME'].'</td>
											<td >'.$firstname.'</td>
											<td >'.$lastname.'</td>
											<td >'.$position.'</td>
											<td >'.$division.'</td>
											<td >'.$department.'</td>
										  </tr>';*/
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);
		break;
	case "D0103":
		$title = "รายงานผู้เข้ารับการอบรมจำแนกตามระดับตำแหน่งระหว่างเดือน" . $formmonth . ' ถึง ' . $tomonth;
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $title . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
							<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="62">' . $title . '</th></tr>
										  <tr class="text-center">
											<th align="center" width="10" rowspan="4" >ลำดับ</th>
											<th align="center" width="500" rowspan="4" >ชื่อหลักสูตร</th>
											<th align="center" colspan="57">จำนวนคนแยกตามกลุ่ม</th>
											<th align="center"  rowspan="3" colspan="3">ระยะเวลาการอบรม</th>
										  </tr>
										  <tr class="text-center">
											<th align="center"  colspan="4">ปฏิบัติงาน</th>
											<th align="center"  colspan="4">ชำนาญงาน</th>
											<th align="center"  colspan="4">อาวุโส</th>
											<th align="center"  colspan="4">ทักษะพิเศษ</th>
											<th align="center"  colspan="4">ปฏิบัติการ</th>
											<th align="center"  colspan="4">ชำนาญการ</th>
											<th align="center"  colspan="4">ชำนาญการพิเศษ</th>
											<th align="center"  colspan="4">เชี่ยวชาญ</th>
											<th align="center"  colspan="4">ทรงคุณวุฒิ</th>
											<th align="center"  colspan="4">อำนวยการต้น</th>
											<th align="center"  colspan="4">อำนวยการสูง</th>
											<th align="center"  colspan="4">บริหารต้น</th>
											<th align="center"  colspan="4">บริหารสูง</th>
											<th align="center"  colspan="4">รวม</th>
											 <th align="center"  rowspan="3" >รวมทั้งสิ้น</th>
										  </tr>				
										  <tr class="text-center">';
		for ($c = 1; $c <= 14; $c++) {
			$tables .= '<th align="center"  colspan="2" colspan="4">ชาย</th>
										  <th align="center"  colspan="2" colspan="4">หญิง</th>';
		}
		$tables .= '</tr>';
		$tables .= '<tr class="text-center">';
		for ($c = 1; $c <= 28; $c++) {
			$tables .= '<th align="center">คน</th>
										  <th align="center">%</th>';
		}
		$tables .= '<th align="center">วัน</th>
										  <th align="center">ชม.</th>
										  <th align="center">รวมชั่วโมง</th>';
		$tables .= '</tr>';

		$n = 0;
		foreach ($report as $class_id => $row) {

			/*	
											$tables.='<tr><td align="center" >'.$n.'</td>
											<td >'.$row['PN_NAME'].'</td>
											<td >'.$firstname.'</td>
											<td >'.$lastname.'</td>
											<td >'.$position.'</td>
											<td >'.$division.'</td>
											<td >'.$department.'</td>
										  </tr>';*/
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);
		break;
	case "D0105":
		$title = "รายชื่อผู้ผ่านอบรม" . $class_name . $monthname . ' ปี ' . $selectyearth;
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $title . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
							<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="7">' . $title . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
											<th align="center" width="10%" >คำนาหน้า</th>
											<th align="center" width="20%">ชื่อ</th>
											<th align="center" width="20%" >นามสกุล</th>
											<th align="center" width="15%">ตำแหน่งปัจจุบัน</th>
											<th align="center" width="15%" >กรม</th>
											<th align="center" width="15%" >กอง</th>
										  </tr>';
		$n = 0;
		foreach ($report as $class_id => $row) {
			$n++;
			if (!empty($row['per_id'])) {
				$firstname = $row['PER_NAME'];
				$lastname = $row['PER_SURNAME'];
				$position = $row['PL_NAME'];
				$department = $row['DEPARTMENT'];
				$division = $row['ORG_NAME'];
			} else {
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				$position = $row['position'];
				$department = $row['department'];
				$division = "";
			}

			$tables .= '<tr><td align="center" >' . $n . '</td>
											<td >' . $row['PN_NAME'] . '</td>
											<td >' . $firstname . '</td>
											<td >' . $lastname . '</td>
											<td >' . $position . '</td>
											<td >' . $division . '</td>
											<td >' . $department . '</td>
										  </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);
		break;
	case "D0101":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $title . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
							<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $title . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
											<th align="center" width="45%" >ชื่อหลักสูตร</th>
											<th align="center" width="10%">สถานะหลักสูตร</th>
											<th align="center" width="30%" >รุ่น / ช่วงเวลาเรียน / ผู้เข้าอบรม</th>
										  </tr>';
		$n = 0;
		foreach ($subjectlist as $row) {
			$n++;
			if ($row['subject_status'] == "1") {
				$status = "เปิดเรียนหลักสูตร";
			} else if ($row['subject_status'] == "2") {
				$status = "ยกเลิกหลักสูตร";
			} else {
				$status = "ปิดหลักสูตร";
			}

			foreach ($row['classlist'] as $id => $rowclass) {
				//var_dump("<pre>",$rowclass);
				$datalist .= $rowclass['class_name'] . " / " . ($rowclass['diffdate'] == null ? "ไม่มีกำหนด" : $rowclass['diffdate']) . " / ผู้เข้าอบรม " . ($rowclass['amount'] == null ? "0" : $rowclass['amount']) . " คน <br/><br/>";
			}

			$tables .= '<tr>
												<td align="center" style="vertical-align: top">' . $n . '</td>
												<td style="vertical-align: top">' . $row['subject_th'] . '</td>
												<td align="center" style="vertical-align: top">' . $status . '</td>
												<td >' . ($datalist == null ? "-" : $datalist) . '</td>
											</tr>';
			$datalist = "";
		}

		// 
		//exit();
		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "A0101":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
											<th align="center" width="50%" >รายราย</th>
											<th align="center" width="50%">รายละเอียด</th>
										  </tr>';
		$n = 0;
		$android = $table['android'];
		$tables .= '<tr><td >title</td><td >' . $android['title'] . '</td></tr>
												<tr><td >author</td><td > ' . $android['author'] . '</td></tr>
												<tr><td >categories</td><td > ' . $android['categories'][0] . '</td></tr>																						
												<tr><td >description</td> <td >' . $android['description_html'] . '</td></tr>		
												<tr><td >rating</td><td > ' . $android['rating'] . '</td></tr>	
												<tr><td >votes</td><td > ' . $android['votes'] . '</td></tr>		
												<tr><td >last_updated</td><td > ' . $android['last_updated'] . '</td></tr>	
												<tr><td >size</td><td > ' . $android['size'] . '</td></tr>	
												<tr><td >downloads</td><td > ' . $android['downloads'] . '</td></tr>		
												<tr><td >version</td><td > ' . $android['version'] . '</td></tr>	
												<tr><td >supported_os</td><td > ' . $android['supported_os'] . '</td></tr>		
												<tr><td >url</td><td > <a href="' . $android['url'] . '" target=_blank>' . $android['url'] . '</a></td></tr>
												<tr><td >screenshots</td><td > <img src="' . $android['screenshots'][0] . '" /> <img src="' . $android['screenshots'][1] . '" /></td></tr>				
												';


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0101":
		$contents = '<br><!-- .card -->
						<div class="card card-fluid">
							<!-- .card-header -->
							<div class="card-header bg-muted">
									<div class="d-flex align-items-center">
									<span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
									</div>
								</div><!-- /.card-header -->
							<!-- .card-body -->
							<div class="card-body">
							<div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
								<!-- thead -->
									<thead>
									<tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
									<tr class="text-center">
									<th align="center" width="5%" >ลำดับ</th>
										<th align="center" >ชื่อผู้ใช้งาน</th>
										<th align="center" width="15%">ชื่อ - สกุล</th>
										
										<th align="center" >หลักสูตร</th>
										<th align="center" width="10%" >วันที่ลงทะเบียนเรียน</th>
										<th align="center" width="10%" >วันที่จบหลักสูตร</th>
									</tr>';
		$n = 0;
		foreach ($table['learn'] as $name => $logs) {
			foreach ($logs as $arr) {
				//var_dump("<pre>",$arr);exit();
				$n++;
				$tables .= '<tr><td align="center" >' . $n . '</td>
											<td >' . $name . '</td>
											<td >' . $arr['name'] . '</td>

											<td >' . $arr['course'] . '</td>
											<td align="center">' . $arr['registerdate'] . '</td>
											<td align="center">' . $arr['realcongratulationdate'] . '</td>
										</tr>';
			}
		}

		$tables .= '
									</tbody><!-- /tbody -->
								</table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
							</div><!-- /.card-body -->
								</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);
		break;
	case "T0103":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
											<th align="center" width="45%" >เอกสาร e-book Multimedia</th>
											<th align="center" width="20%">จำนวน</th>
										  </tr>';
		$n = 0;
		foreach ($table['book'] as $name => $value) {
			$n++;
			$tables .= '<tr><td align="center" >' . $n . '</td>
											<td >' . $name . '</td>
											<td class="text-right" >' . $value . ' &nbsp;</td>
										  </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0102":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
											<th align="center" >ชื่อหลักสูตร</th>
											<th align="center" width="15%">จำนวนผู้เข้าเรียน(คน)</th>
										  </tr>';
		$n = 0;

		foreach ($table['learncount'] as $name => $countlearner) {
			$n++;
			$tables .= '<tr><td align="center" >' . $n . '</td>
											<td >' . $name . '</td>
											<td align="center">' . $countlearner . '</td>
										  </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0104":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
										  <th align="center" >ชื่อ - สกุล</th>

										  <th align="center" width="15%">จำนวนการเข้าระบบ(ครั้ง)</th>
										  </tr>';
		$n = 0;
		foreach ($table['learn'] as $name => $row) {
			$n++;
			// $num=$table['learncount'][$name];
			// var_dump("<pre>", $row);exit();
			$tables .= '<tr><td align="center" >' . $n . '</td>
										   <td >' . $row['username'] . '</td>
										   <td >' . $row['name'] . '</td>
										   <td class="text-right" >' . $row['num'] . ' &nbsp;</td>
										 </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0110":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >เดือน</th>
										   <th align="center" width="15%">การสำรองไฟล์</th>
										   <th align="center" width="15%">การสำรองฐานข้อมูล</th>
										  </tr>';
		$n = 0;

		$tables .= '<tr><td align="center" >1</td>
										   <td >ตุลาคม 2565</td>
										   <td class="text-right" >17.10 GB. </td>
										   <td class="text-right" >3.42 MB. </td>
										 </tr>
										 <tr><td align="center" >2</td>
										   <td >พฤศจิกายน 2565</td>
										   <td class="text-right" >18.10 GB. </td>
										   <td class="text-right" >3.52 MB. </td>
										 </tr>';
		/*$tables.='<tr><td align="center" >1</td>
										   <td >พฤศจิกายน 2565</td>
										   <td class="text-right" >สำเร็จ </td>
										 </tr>';*/

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0111":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >เดือน</th>
										  <th align="center" width="15%">จำนวนรายการ (คน)</th>
										   <th align="center" width="15%">รายรับ (บาท)</th>
	
										  </tr>';
		$n = 0;
		$moneydata = array(
			/* 	11=>array(5,5000),
										  	12=>array(3,3000)*/);
		foreach ($data['month']['th'] as $m => $_name) {

			$tables .= '<tr><td align="center" >' . $m . '</td>
										   <td >' . $_name . '</td>
										   <td class="text-right" >' . number_format($moneydata[$m][0]) . ' </td>
										   <td class="text-right" >' . number_format($moneydata[$m][1]) . ' </td>
										 </tr>';
		}


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0112":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >ไตรมาส</th>
										  <th align="center" width="15%">จำนวนรายการ (คน)</th>
										   <th align="center" width="15%">รายรับ (บาท)</th>
	
										  </tr>';
		$n = 0;
		$moneydata = array(
			//	4=>array(8,8000)

		);
		$quarterlyarr = array(1 => 'ไตรมาสที่ 1', 2 => 'ไตรมาสที่ 2', 3 => 'ไตรมาสที่ 3', 4 => 'ไตรมาสที่ 4');
		foreach ($quarterlyarr as $m => $_name) {

			$tables .= '<tr><td align="center" >' . $m . '</td>
										   <td >' . $_name . '</td>
										   <td class="text-right" >' . number_format($moneydata[$m][0]) . ' </td>
										   <td class="text-right" >' . number_format($moneydata[$m][1]) . ' </td>
										 </tr>';
		}


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0113":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >ปี</th>
										  <th align="center" width="15%">จำนวนรายการ (คน)</th>
										   <th align="center" width="15%">รายรับ (บาท)</th>
	
										  </tr>';
		$n = 0;
		$moneydata = array(
			//2023=>array(8,8000)

		);
		$yearlyarr = array(2023);
		$quarterlyarr = array(1 => 'ไตรมาสที่ 1', 2 => 'ไตรมาสที่ 2', 3 => 'ไตรมาสที่ 3', 4 => 'ไตรมาสที่ 4');
		foreach ($yearlyarr as  $m) {
			$mm++;
			$tables .= '<tr><td align="center" >' . $mm . '</td>
										   <td >' . ($m + 543) . '</td>
										   <td class="text-right" >' . number_format($moneydata[$m][0]) . ' </td>
										   <td class="text-right" >' . number_format($moneydata[$m][1]) . ' </td>
										 </tr>';
		}


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0114":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >เดือน</th>
										  <th align="center" width="15%">สัปดาห์ที่ 1</th>
										  <th align="center" width="15%">สัปดาห์ที่ 2</th>
										  <th align="center" width="15%">สัปดาห์ที่ 3</th>
										  <th align="center" width="15%">สัปดาห์ที่ 4</th>
	
										  </tr>';
		$n = 0;
		$backupdata = array(
			1 => array(1 => 1, 2 => 1),


		);

		foreach ($data['month']['th'] as  $m => $_name) {
			$mm++;

			$tables .= '<tr><td align="center" >' . $m . '</td>
										   <td >' . $_name . '</td>';
			for ($i = 1; $i <= 4; $i++) {
				$iconstatus = ($backupdata[$m][$i] == 1) ? "<i class='fas fa-check-circle text-success' style='font-size:24px' ></i>" : "<i class='fas fa-check-circle text-secondary' style='font-size:24px' ></i>";
				$tables .= '<td class="text-center" >' . $iconstatus . ' </td>';
			}

			$tables .= '</tr>';
		}


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0115":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >เดือน</th>
										  <th align="center" width="15%">Log File</th>
	
										  </tr>';
		$n = 0;


		foreach ($data['month']['th'] as  $m => $_name) {
			$num = $result[$m];
			$tables .= '<tr><td align="center" >' . $m . '</td>
										   <td >' . $_name . '</td>
										   <td class="text-right">' . number_format($num) . '</td>';


			$tables .= '</tr>';
		}


		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0109":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" >รายการ</th>

										  <th align="center" width="15%">จำนวนการ(ครั้ง)</th>
										  </tr>';
		$n = 0;

		$tables .= '<tr><td align="center" >1</td>
										   <td >การบันทึกการเรียนการสอน</td>
										   <td class="text-right" >2 </td>
										 </tr>';
		$tables .= '<tr><td align="center" >1</td>
										   <td >การถ่ายทอดสด</td>
										   <td class="text-right" >0 </td>
										 </tr>';

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0108":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
										  <th align="center" >ชื่อ - สกุล</th>

										  <th align="center" width="15%">จำนวนลงทะเบียน</th>
										  </tr>';
		$n = 0;
		foreach ($table['registration'] as $name => $row) {
			$n++;
			// $num=$table['learncount'][$name];
			// var_dump("<pre>", $row);exit();
			$tables .= '<tr><td align="center" >' . $n . '</td>
										   <td >' . $row['username'] . '</td>
										   <td >' . $row['name'] . '</td>
										   <td class="text-right" >' . $row['num'] . ' &nbsp;</td>
										 </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0105":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="7">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th class="text-center" width="5%"  rowspan="2">ลำดับ</th>
											<th class="text-center" width="45%"  rowspan="2">วิชา</th>
											<th class="text-center" width="50%" colspan="4">สื่อเสริม</th>

										  </tr>
										  <tr>
											<th class="text-center" width="12%" >ห้องสมุด</th>
											<th class="text-center" width="12%">เอกสาร</th>
											<th class="text-center" width="12%" >มัลติมีเดีย</th>
											<th class="text-center" width="12%" >เชื่อมโยง</th>
										  </tr>										  
										  ';
		$n = 0;
		foreach ($table['supplymentary'] as $name => $arr) {
			$n++;
			$dept = $table['name'][$name];
			$tables .= '<tr><td class="text-center" >' . $n . '</td>
											<td >' . $name . '</td>
											<td  class="text-center">' . number_format($arr['ห้องสมุด']) . '</td>
											<td  class="text-center">' . number_format($arr['เอกสาร']) . '</td>
											<td  class="text-center">' . number_format($arr['มัลติมีเดีย']) . '</td>
											<td  class="text-center">' . number_format($arr['เชื่อมโยง']) . '</td>
										  </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0106":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
										  <th align="center" >ชื่อ - สกุล</th>
										  <th align="center" width="15%">จำนวนการเข้า(ครั้ง)</th>
										  </tr>';
		$n = 0;
		foreach ($table['learn'] as $name => $row) {
			$n++;
			$tables .= '<tr><td align="center" >' . $n . '</td>
										   <td >' . $row['username'] . '</td>
										   <td >' . $row['name'] . '</td>

										   <td class="text-right" >' . $row['num'] . ' &nbsp;</td>
										 </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "T0107":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $titletable . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
									<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $titletable . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="5%" >ลำดับ</th>
										  <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
										  <th align="center" >ชื่อ - สกุล</th>

										  <th align="center" width="15%">จำนวนการเข้าระบบ(ครั้ง)</th>
										  </tr>';
		$n = 0;
		foreach ($table['learn'] as $name => $row) {
			$n++;
			// $num=$table['learncount'][$name];
			// var_dump("<pre>", $row);exit();
			$tables .= '<tr><td align="center" >' . $n . '</td>
										   <td >' . $row['username'] . '</td>
										   <td >' . $row['name'] . '</td>

										   <td class="text-right" >' . $row['num'] . ' &nbsp;</td>
										 </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "table":
		$contents = '<br><!-- .card -->
										<div class="card card-fluid">
								  <!-- .card-header -->
								  <div class="card-header bg-muted">
										<div class="d-flex align-items-center">
										  <span class="mr-auto">' . $title . '</span> <a href="' . site_url('export/pdf') . '"  class="btn btn-icon btn-outline-danger" ><i class="fa fa-file-pdf"></i></a>&nbsp;<a href="' . site_url('export/excel') . '" class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
										</div>
									  </div><!-- /.card-header -->
								  <!-- .card-body -->
								  <div class="card-body">
								  <div class="table-responsive">';
		$tables = '<table border="1" style="width:100%" id="section-to-print">
							<!-- thead -->
										<thead>
										  <tr ><th class="text-center" colspan="6">' . $title . '</th></tr>
										  <tr class="text-center">
										  <th align="center" width="10%" >ลำดับ</th>
											<th align="center" width="80%" >ชื่อรายงาน</th>
											<th align="center" width="10%" >รายงาน</th>
										  </tr>';
		$n = 0;



		foreach ($reportname as $id => $name) {
			$n++;

			$tables .= '<tr><td align="center" >' . $n . '</td>
											<td >' . $name . '</td>
											<td align="center"><a href="' . site_url('report/home/' . $id) . '"><i class="fas fa-chart-bar text-teal mr-2"></i></a></td>

										  </tr>';
		}

		$tables .= '
										</tbody><!-- /tbody -->
									  </table><!-- /.table -->';

		$contents .= $tables;
		$contents .= '</div><!-- /.table-responsive -->
								   </div><!-- /.card-body -->
									</div><!-- /.card -->';
		$datatable = array("title" => $title, "table" => $tables);

		break;
	case "dashboard":
		$contents = '<div class="row mt-3">
								<!-- grid column -->
						<div class="col-12 col-lg-12 col-xl-6">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="graphlearner" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->
						<div class="col-12 col-lg-12 col-xl-6">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="coursedoc" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->

						<div class="col-12 col-lg-12 col-xl-6 ">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="coursemulti" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->

						<div class="col-12 col-lg-12 col-xl-6">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="courserating" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->
				
						<div class="col-12 col-lg-12 col-xl-6">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="coursesearch" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->
						<div class="col-12 col-lg-12 col-xl-6">
							<!-- .card -->
							<div class="card card-fluid">
							<!-- .card-body -->
							<div class="card-body">
								<div id="courselogin" style="min-width: 310px; height: 450px; margin: 0 auto">
								</div>
							</div><!-- /.card-body -->
							</div><!-- /.card -->
						</div><!-- /grid column -->						
								</div>';



	case "D0100":
	default:
		$contents = '<!-- .section-block -->
									<div class="section-block">
									  <!-- metric row -->
									  <div class="metric-row">
										<div class="col-lg-12">
										  <div class="metric-row metric-flush">';
		$icon = array('', 'fas fa-user-cog', 'fas fa-user-edit', 'fas fa-user-tie', 'fas fa-user-graduate');
		foreach ($data['user_type'] as $user_type => $name) {
			$contents .= '<!-- metric column -->
											<div class="col">
											  <!-- .metric -->
											  <a href="' . site_url('ums/home/' . $user_type) . '" class="metric metric-bordered align-items-center">
												<h2 class="metric-label"> ' . $name . ' </h2>
												<p class="metric-value h3">
												 <sub><i class="' . $icon[$user_type] . ' fa-lg"></i> </sub> <span class="value ml-1">' . number_format($reportusers[$user_type]) . '</span>
												</p>
											  </a> <!-- /.metric -->
											</div><!-- /metric column -->';
		}

		$contents .= '
										  </div>
										</div>
									  </div><!-- /metric row -->
									  <!-- grid row -->
										<div class="row">
										  <!-- grid column -->
										  <div class="col-12 col-lg-12 col-xl-6">
											<!-- .card -->
											<div class="card card-fluid">
											  <!-- .card-body -->
											  <div class="card-body">
												<div id="chartregister" style="min-width: 310px; height: 330px; margin: 0 auto"></div>
											  </div><!-- /.card-body -->
											</div><!-- /.card -->
										  </div><!-- /grid column -->
										   <!-- grid column -->
										  <div class="col-12 col-lg-12 col-xl-6">
											<!-- .card -->
											<div class="card card-fluid">
											  <!-- .card-body -->
											  <div class="card-body">
												<div id="chartcongratulation" style="min-width: 310px; height: 330px; margin: 0 auto">
												</div>
											  </div><!-- /.card-body -->
											</div><!-- /.card -->
										  </div><!-- /grid column -->
										   <!-- grid column -->
										  <div class="col-12 col-lg-12 col-xl-12">
											<!-- .card -->
											<div class="card card-fluid">
											  <!-- .card-body -->
											  <div class="card-body">
												<div id="chartyearregister" style="min-width: 310px; height: 330px; margin: 0 auto">
												</div>
											  </div><!-- /.card-body -->
											</div><!-- /.card -->
										  </div><!-- /grid column -->
										</div><!-- /grid row -->
									</div><!-- /.section-block -->
									<!-- grid row -->';
		break;
		/*
					default:
                      $contents='<!-- .table -->
                      <table id="datatable2" class="table w3-hoverable d-none" >
                        <!-- thead -->
                        <thead>
                          <tr class="bg-infohead">
                            <th class="align-middle" style="width:10%"> ลำดับ </th>
                            <th class="align-middle" style="width:80%"> รายการ </th>
							 <th class="align-middle" style="width:10%"> กระทำ </th>
                          </tr>
                        </thead><!-- /thead -->
                        <!-- tbody -->
                        <tbody>';

                           $contents.='
                        </tbody><!-- /tbody -->
                      </table><!-- /.table -->';

					break;*/
} //case
$this->session->set_userdata('EXPORTTABLE', $datatable);
echo $contents;
echo '<!-- .page-title-bar -->

            </div><!-- /.page-inner -->
			<!-- .page-sidebar -->
            <div class="page-sidebar">
              <!-- .sidebar-header -->
              <header class="sidebar-header d-sm-none">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                      <a href="#" onclick="Looper.toggleSidebar()"><i class="breadcrumb-icon fa fa-angle-left fa-lg mr-2"></i>Back</a>
                    </li>
                  </ol>
                </nav>
              </header><!-- /.sidebar-header -->
              <!-- .sidebar-section-fill -->
              <div class="sidebar-section-fill">
                <!-- .card -->
                <div class="card card-reflow">
                  <!-- .card-body -->
                  <div class="card-body">
                    <button type="button" class="close mt-n1 d-none d-xl-none d-sm-block" onclick="Looper.toggleSidebar()" aria-label="Close"><span aria-hidden="true">×</span></button>
                   <!-- grid row -->

					<!-- .card-body -->
                  <div class="card-body  pb-1">
                    <h3 > รายงาน </h3><!-- .progress -->
                  </div><!-- /.card -->
                  <!-- .list-group -->
                  <div class="list-group list-group-bordered list-group-reflow">';

foreach ($reportarray as $reportid => $reportname) {
	$color = "";
	if ($module == $reportid) $color = "bg-muted";
	echo '<!-- .list-group-item -->
                    <div class="list-group-item justify-content-between align-items-center ' . $color . '">
                      <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="' . site_url('report/home/' . $reportid) . '" class="small">' . $reportname . '</a></span> 
                    </div><!-- /.list-group-item -->';
}

echo '</div><!-- /.list-group -->
                   
                  </div><!-- /.card-body -->
                </div><!-- /.card -->
              </div><!-- /.sidebar-section-fill -->
          </div><!-- /.page -->
        </div><!-- .app-footer -->';

if ($module == "D0100" || $module == "dashboard") {
	$graphregister = $graphgratulation = "";
	for ($pid = 1; $pid <= 2; $pid++) {
		$name = $data['person_type'][$pid]['person'];
		//$name=trim($arr['name_short_th']);
		if ($pid == 0) $name = "อื่นๆ";
		$val = $reportregister[$pid];
		$val = (!empty($val)) ? $val : 0;

		if ($val > 0) $graphregister .= (empty($graphregister)) ? "{name: '" . $name . "',y: " . $val . "}" : ",{name: '" . $name . "',y: " . $val . "}";
		$val = $reportcongratulation[$pid];
		$val = (!empty($val)) ? $val : 0;
		if ($val > 0) $graphgratulation .= (empty($graphgratulation)) ? "{name: '" . $name . "',y: " . $val . "}" : ",{name: '" . $name . "',y: " . $val . "}";
	}
	$xAxis = "";

	foreach ($montharr as $mid) {
		$month = $data['month_short']['th'][$mid];
		$xAxis .= (empty($xAxis)) ? "'$month'" : ",'$month'";
		$val = $reportyearregister[$mid];
		$val = (!empty($val)) ? $val : 0;
		$linedata1 .= (!isset($linedata1)) ? $val : ",$val";
		$val = $reportyearcongratulation[$mid];
		$val = (!empty($val)) ? $val : 0;
		$linedata2 .= (!isset($linedata2)) ? $val : ",$val";
	}
	$linedata = "{name: 'ผู้สมัครเรียน',data: [$linedata1]},{name: 'ผู้สำเร็จการเรียน',data: [$linedata2]}";

?>
	<script src="<?php echo base_url(); ?>vendor/Highcharts-6.0.7/code/highcharts.js"></script>
	<script src="<?php echo base_url(); ?>vendor/Highcharts-6.0.7/code/modules/exporting.js"></script>
	<script src="<?php echo base_url(); ?>vendor/Highcharts-6.0.7/code/modules/export-data.js"></script>
	<script src="<?php echo base_url(); ?>vendor/Highcharts-6.0.7/code/modules/accessibility.js"></script>
	<?php if ($module == "D0100") { ?>
		<script>
			//Highcharts.chart("chartcongratulation", { chart: {type: 'column'},title: {text: 'ผู้สมัครเรียน ปี <?= $selectyear; ?>'},subtitle: {text: 'รายงานข้าราชการจำแนกตามระดับการศึกษา'},xAxis: {type: 'category'},yAxis: {title: {text: 'จำนวนข้าราชการ'}},legend: {enabled: false},plotOptions: {lang: {thousandsSep: ','},series: {borderWidth: 0,dataLabels: {enabled: true,data: '{point.y}'}}},tooltip: {headerFormat: '<span style="font-size:12px">{series.name}</span><br>',pointFormat: '<span>{point.name}</span>: <b>{point.y}</b> คน<br/>'},series: [{name: 'ระดับการศึกษา',colorByPoint: true,data: [<?php echo $grapheducate; ?>]}]});
			Highcharts.chart("chartcongratulation", {
				chart: {
					style: {
						fontFamily: 'prompt'
					},
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'ผู้สำเร็จการเรียน <?= $monthname; ?> ปี <?= $selectyearth; ?>'
				},
				subtitle: {
					text: 'รายงานจำนวนผู้สำเร็จการเรียนจำแนกกลุ่มผู้ใช้งาน'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>:{point.percentage:.1f}% ',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					name: 'ผู้สำเร็จการเรียน',
					colorByPoint: true,
					data: [<?php echo $graphgratulation; ?>]
				}]
			});
			Highcharts.chart("chartyearregister", {
				chart: {
					type: 'line',
					style: {
						fontFamily: 'prompt'
					}
				},
				title: {
					text: 'สรุปข้อมูลประจำ <?= $monthname; ?> ปี <?= $selectyearth; ?>'
				},
				subtitle: {
					text: 'รายงานจำนวนผู้เรียนทั้งหมดจำแนกรายเดือน'
				},
				yAxis: {
					title: {
						text: 'จำนวน'
					}
				},
				xAxis: {
					categories: [<?= $xAxis; ?>]
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},
				plotOptions: {
					line: {
						allowPointSelect: false,
						cursor: 'pointer',
						dataLabels: {
							enabled: true
						}
					}
				},
				series: [<?php echo $linedata; ?>]
			});
			Highcharts.chart("chartregister", {
				chart: {
					style: {
						fontFamily: 'prompt'
					},
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'ผู้สมัครเรียน <?= $monthname; ?> ปี <?= $selectyearth; ?>'
				},
				subtitle: {
					text: 'รายงานจำนวนผู้สมัครเรียนจำแนกกลุ่มผู้ใช้งาน'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>:{point.percentage:.1f}% ',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					name: 'จำนวนผู้สมัคร',
					colorByPoint: true,
					data: [<?php echo $graphregister; ?>]
				}]
			});
		</script>
	<?php } else if ($module == "dashboard") {
		//$reportname=array('จำนวนผู้เรียนทั้งหมด','จำนวนเอกสารทั้งหมด/หลักสูตร','จำนวนสื่อ Multimedia ทั้งหมด ','หลักสูตร/บทเรียนยอดนิยม(Rating)','คำค้นหารหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ','สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์');

		foreach ($dashboard['learner'] as $name => $val) {
			//$val=$result['position'][$DEPARTMENT_ID][1];
			$val = (!empty($val)) ? $val : 0;
			$graphlearner .= (empty($graphlearner)) ? "{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}" : ",{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}";
		}
	?>
		<script>
			Highcharts.chart("graphlearner", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'จำนวนผู้เรียนทั้งหมด'
				},
				subtitle: {
					text: 'รายงานจำนวนผู้เรียนทั้งหมด'
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'จำนวนผู้เรียนทั้งหมด'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
				},
				series: [{
					name: 'จำนวนผู้เรียน',
					colorByPoint: true,
					data: [<?php echo $graphlearner; ?>]
				}]
			});
		</script>
		<?php


		foreach ($dashboard['multimedia'] as $name => $val) {
			//$val=$result['position'][$DEPARTMENT_ID][1];
			$val = (!empty($val)) ? $val : 0;
			$coursemulti .= (empty($coursemulti)) ? "{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}" : ",{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}";
		}
		?>
		<script>
			Highcharts.chart("coursemulti", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'จำนวนสื่อ Multimedia ทั้งหมด'
				},
				subtitle: {
					text: 'จำนวนสื่อ Multimedia ทั้งหมด'
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'จำนวนสื่อ Multimedia ทั้งหมด'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> รายการ<br/>'
				},
				series: [{
					name: 'จำนวนสื่อ Multimedia',
					colorByPoint: true,
					data: [<?php echo $coursemulti; ?>]
				}]
			});
		</script>

		<?php
		$yeararr = array('ภารกิจกระทรวงพาณิชย์' => 10, 'นักวิชาการพาณิชย์' => 13);

		foreach ($dashboard['course'] as $name => $val) {
			//$val=$result['position'][$DEPARTMENT_ID][1];
			$val = (!empty($val)) ? $val : 0;
			$courserating .= (empty($courserating)) ? "{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}" : ",{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}";
		}
		?>
		<script>
			Highcharts.chart("courserating", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
				},
				subtitle: {
					text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'หลักสูตร/บทเรียนยอดนิยม(Rating)'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
				},
				series: [{
					name: 'จำนวน Rating',
					colorByPoint: true,
					data: [<?php echo $courserating; ?>]
				}]
			});
		</script>
		<?php
		foreach ($dashboard['search'] as $name => $val) {
			$val = (!empty($val)) ? $val : 0;
			$coursesearch .= (empty($coursesearch)) ? "{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}" : ",{name: '" . $name . "',y: " . $val . ",color: '" . $color . "'}";
		}
		?>
		<script>
			Highcharts.chart("coursesearch", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
				},
				subtitle: {
					text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'คำค้นหาหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> คน<br/>'
				},
				series: [{
					name: 'จำนวนค้นหา',
					colorByPoint: true,
					data: [<?php echo $coursesearch; ?>]
				}]
			});
		</script>
		<?php



		$coursedoc = "series: [";
		$g = 0;
		$categoriesarr = array();
		foreach ($dashboard['ebook'] as $type => $arr) {
			if ($g > 0) $coursedoc .= ",";
			$coursedoc .= " {name: '$type',data: [";
			$_val = "";
			foreach ($arr as $mm => $val) {
				$_val .= (empty($_val)) ? "$val" : ",$val";
				$categoriesarr[$mm] = $mm;
			}
			$coursedoc .= "$_val]}";
			$g++;
		}
		$coursedoc .= "]";
		foreach ($categoriesarr as $name) {
			$categories .= (empty($categories)) ? "'$name'" : ",'$name'";
		}
		//$categories=implode(",",$categoriesarr);
		?>


		<script>
			Highcharts.chart("coursedoc", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'จำนวนเอกสาร, ebook /หลักสูตร'
				},
				subtitle: {
					text: 'จำนวนเอกสาร, ebook /หลักสูตร'
				},
				xAxis: {
					categories: [<?php echo $categories; ?>],
					crosshair: true
				},
				yAxis: {
					title: {
						text: 'จำนวนเอกสาร, ebook /หลักสูตร'
					}
				},
				legend: {
					enabled: true
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> รายการ<br/>'
				},
				<?php echo $coursedoc; ?>
			});
		</script>
		<?php

		/*$yeararr=array(2562=>30,2563=>22);
		foreach($dashboard['login'] as $name => $val){
			//$val=$result['position'][$DEPARTMENT_ID][1];
			$val=(!empty($val))?$val:0;
			$courselogin.=(empty($courselogin))?"{name: '".$name."',y: ".$val.",color: '".$color."'}":",{name: '".$name."',y: ".$val.",color: '".$color."'}";
		}*/

		$courselogin = "series: [";
		$g = 0;
		foreach ($dashboard['login'] as $logplatform => $arr) {
			if ($g > 0) $courselogin .= ",";
			$courselogin .= " {name: '$logplatform',data: [";
			$_val = "";
			foreach ($arr as $mm => $val) {
				$_val .= (empty($_val)) ? "$val" : ",$val";
			}
			$courselogin .= "$_val]}";
			$g++;
		}
		$courselogin .= "]";

		?>
		<script>
			Highcharts.chart("courselogin", {
				chart: {
					type: 'column'
				},
				title: {
					text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
				},
				subtitle: {
					text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
				},
				xAxis: {
					categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					crosshair: true
				},
				yAxis: {
					title: {
						text: 'สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์'
					}
				},
				legend: {
					enabled: true
				},
				plotOptions: {
					lang: {
						thousandsSep: ','
					},
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							data: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:12px">{series.name}</span><br>',
					pointFormat: '<span>{point.name}</span> : <b>{point.y}</b> ครั้ง<br/>'
				},
				<?php echo $courselogin; ?>
			});
		</script>

<?php
	}
}
// $reportname=array('จำนวนผู้เรียนทั้งหมด','จำนวนเอกสารทั้งหมด/หลักสูตร','จำนวนสื่อ Multimedia ทั้งหมด ','หลักสูตร/บทเรียนยอดนิยม(Rating)','คำค้นหารหลักสูตร/บทเรียนที่มีการค้นหาสูง 20 อันดับ','สถิติช่วงเวลาการเข้าระบบ (Login)แยกตามอุปกรณ์');

?>
