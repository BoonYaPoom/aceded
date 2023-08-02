<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$subject_id=$this->session->userdata('subject_id');

if(empty($subject_id)) $subject_id=$args[0];
//var_dump("<pre>",$data['course'][$subject_id]['learn_format']);exit();
$department_id=$data['course_subject'][$subject_id]['department_id'];
$courseformat=$data['course'][$subject_id]['courseformat'];
$selectyear=$this->input->get_post('selectyear', TRUE);
if(empty($selectyear)) $selectyear=date("Y");
?>
<div class="page-inner">
  <div class="page-section">
    <div class="card card-fluid">
      <div class="card-header bg-muted">
        <?php
          if(in_array($profile['role'],array(1,2))){
            echo'<a href="'.site_url('lms/department').'" style="text-decoration: underline;">'.$this->lang->line("category").'</a> ';/// <a href="'.site_url('lms/subject/'.$department_id).'" style="text-decoration: underline;"></a>'.$this->lang->line("managesubject").' / <i>'.$data['course_subject'][$subject_id]['subject_th'].'</i>';
          } else{
            echo'<a href="'.site_url('lms/teach').'" style="text-decoration: underline;">'.$this->lang->line("lms").'</a> / <i>'.$data['course_subject'][$subject_id]['subject_th'].'</i>';
          }
        ?>
      </div>
				<?=$lessonmenu?>
        <div class="card-body">
          <form method="post" id="formclassroom">
            <div class="form-row">
              <label for="selectyear text-center" class="col-md-4 w3-hide-small ">&nbsp;</label>
                <div class="col-md-4">
                  <p>
                    <select id="selectyear" name="selectyear" class="form-control " data-toggle="select2" data-placeholder="ปี" data-allow-clear="false" onchange="$('#formclassroom').submit();">
                    <?php
                      for($y=$startyear;$y<=date('Y');$y++){
                        $selected=($selectyear==$y)?"selected":"";
                        echo'<option value="'.$y.'" '.$selected.'> '.$y.' </option>'; 
                      }
                    ?>
                    </select>
                  </p>
                </div>
            </div>  
          </form>
          <div class="table-responsive">
            <?php 
            if(!empty($courseformat)){
            ?>
            <table id="datatable2" class="table w3-hoverable">
              <thead>
                <tr class="bg-infohead">
                  <th class="align-middle" style="width:5%"> ลำดับ </th>
                  <th class="align-middle" style="width:60%"> รุ่น/กลุ่มเรียน </th>
                  <th class="align-middle" style="width:10%"> จำนวนผู้เรียน </th>
                  <th class="align-middle" style="width:10%"> สถานะ </th>
                  <th class="align-middle" style="width:15%"> กระทำ </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $n=0;
                  foreach($result as $class_id => $row){
                    $n++;
                    $prefix=md5('moc'.date('Ymd'));
                    $checked=(!empty($row['class_status']))?"checked":"";
                    $register=(empty($result[$class_id]['register']))?0:$result[$class_id]['register'];
                ?>
                  <tr id="<?=$prefix?>__course_class__class_status__class_id__<?=$class_id.'__'.time()?>__row">
                    <td><a ><?=$n?></a></td>
                    <td><a ><?=$row['class_name']?></a></td>
                    <td><?=$register?></td>
                    <td class="align-middle"> 
                      <label class="switcher-control switcher-control-success switcher-control-lg">
                      <input type="checkbox" class="switcher-input switcher-edit" <?=$checked?> value="1" id="<?=$prefix?>__course_class__class_status__class_id__<?=$class_id.'__'.time()?>"> 
                      <span class="switcher-indicator"></span> 
                      <span class="switcher-label-on">ON</span> 
                      <span class="switcher-label-off text-red">OFF</span></label>
                    </td>
                    <td>
                      <a href="<?= base_url().'lms/register/'.$class_id?>.html" ><i class="fas fa-user-plus fa-lg text-dark" data-toggle="tooltip" title="รายชื่อลงทะเบียน"></i></a>
                      <a href="<?=base_url().'lms/congratuation/'.$class_id?>.html" ><i class="fas fa-book-reader fa-lg text-info" data-toggle="tooltip" title="แจ้งเตือนวันสิ้นสุดบทเรียน"></i></a>
                      <a href="<?=base_url().'lms/report/'.$class_id?>.html" ><i class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip" title="รายงาน"></i></a>
                      <a href="<?=base_url().'lms/congratuation/'.$class_id?>.html" ><i class="fas fa-user-graduate fa-lg text-info" data-toggle="tooltip" title="ผู้สำเร็จหลักสูตร"></i></a>
                      <a href="<?=base_url().'lms/classroomform/'.$class_id?>.html" ><i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                      <a href="#clientDeleteModal"  id="<?=$prefix.'__course_class__class_status__class_id__'.$class_id.'__'.time()?>" rel="<?=strip_tags($row['class_name'])?>" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                    </td>
                  </tr>
                <?php  }
                ?>
              </tbody>
            </table>
         <?php           
          }else{
                      echo'<table id="datatable2" class="table w3-hoverable" >
                        <!-- thead -->
                        <thead>
                          <tr class="bg-infohead">
                            <th class="align-middle" style="width:10%"> ลำดับ </th>
                            <th class="align-middle" style="width:70%"> เดือน </th>
							<th class="align-middle" style="width:10%"> จำนวนผู้เรียน </th>
							 <th class="align-middle" style="width:10%"> กระทำ </th>
                          </tr>
                        </thead><!-- /thead -->
                        <!-- tbody -->
                        <tbody>';
						$n=0;
						//$result=array();
						foreach($data['month'][$data['lang']] as $m => $month){
							$n++;
							$register=(empty($result[$m]['register']))?0:$result[$m]['register'];
                          echo'<!-- tr -->
                          <tr >
							<td><a >'.$n.'</a></td>
                            <td><a >'.$month.'</a></td>
							 <td><a >'.$register.'</a></td>
                            <td>
							<a href="'.base_url().'lms/register/'.$m.'.html" ><i class="fas fa-user-plus fa-lg text-dark" data-toggle="tooltip" title="รายชื่อลงทะเบียน"></i></a>
							<a href="'.base_url().'lms/report/'.$m.'.html" ><i class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip" title="รายงาน"></i></a>
							<a href="'.base_url().'lms/congratuation/'.$m.'.html" ><i class="fas fa-user-graduate fa-lg text-info" data-toggle="tooltip" title="ผู้สำเร็จหลักสูตร"></i></a>
						

							<!--  -->
							
							</td>
                          </tr><!-- /tr -->';
							
						}
                          echo'
                        </tbody><!-- /tbody -->
                      </table><!-- /.table -->';
					  }
            ?>
          </div>
        </div>
        <header class="page-title-bar">
          <input type="hidden" name="__id" id="__id" value="<?=$course_id?>" />   
            <button type="button" class="btn btn-success btn-floated btn-add" 
            id="add_classroomform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
        </header>
    </div>
  </div>
</div>
</div>

