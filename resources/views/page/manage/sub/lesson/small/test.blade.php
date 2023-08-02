<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
$subject_id = $this->session->userdata('subject_id');
if (empty($subject_id)) {
    $subject_id = $args[0];
}
$department_id = $data['course_subject'][$subject_id]['department_id'];
$title = 'บทเรียน';
echo '
<!-- .page-inner -->
            <div class="page-inner">

              <!-- .page-section -->
              <div class="page-section">
              <!-- .card -->
                <div class="card card-fluid">
                  <!-- .card-header -->
                  <div class="card-header bg-muted">';

if (in_array($profile['role'], [1, 2])) {
    echo '<a href="' . site_url('lms/department') . '" style="text-decoration: underline;">' . $this->lang->line('category') . '</a> / <a href="' . site_url('lms/subject/' . $department_id) . '" style="text-decoration: underline;">' . $this->lang->line('managesubject') . '</a> / <i>' . $data['course_subject'][$subject_id]['subject_th'] . '</i>';
} else {
    echo '<a href="' . site_url('lms/teach') . '" style="text-decoration: underline;">' . $this->lang->line('lms') . '</a> / <i>' . $data['course_subject'][$subject_id]['subject_th'] . '</i>';
}

echo '</div><!-- /.card-header -->
    ' .
    $lessonmenu .
    '

                  <!-- .card-body -->
                  <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive ">
                      <!-- .table -->
                      <table id="datatable" class="table w3-hoverable" >
                        <!-- thead -->
                        <thead>
                          <tr class="bg-infohead">
                            <!--<th class="align-middle " style="width:10%"> ประเภท </th>  -->
       <th class="align-middle" style="width:10%"> ลำดับ  </th>
                            <th class="align-middle" style="width:25%"> ชื่อ (ไทย) </th>
                            <th class="align-middle w3-hide-small" style="width:25%"> ชื่อ (อังกฤษ) </th>
       <th class="align-middle" style="width:10%"> ชนิดสื่อ  </th>
       <th class="align-middle" style="width:10%"> สถานะ  </th>
       
       <th class="align-middle" style="width:10%"> กระทำ</th>
                          </tr>
                        </thead><!-- /thead <th class="align-middle" style="width:10%"> เรียง  </th>-->
                        <!-- tbody -->
                        <tbody>';
/*	$n=0;
      $num=0;
      foreach($tree[0] as $lesson_id => $lesson_th){
       $n++;
       $row=$result[$lesson_id];
       $checked=(!empty($row['lesson_status']))?"checked":"";
       echo'<!-- tr -->
       <tr id="lesson__lesson_status__lesson_id__'.$lesson_id.'__'.time().'__row">
        <td >'.$data['lesson_type'][$row['lesson_type']]['type_th'].'</td>
        <td >'.$n.'</td>
        <td>'.$lesson_th.'</td>
        <td class="w3-hide-small">'.$row['lesson_en'].'</td>
        <td><i class="'.$data['content_type'][$row['content_type']]['icon'].' fa-lg text-success" data-toggle="tooltip" title="'.$data['content_type'][$row['content_type']]['content_th'].'"></i></td>
        <td class="align-middle"> <label class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox" class="switcher-input switcher-edit" '.$checked.' value="1" id="lesson__lesson_status__lesson_id__'.$lesson_id.'__'.time().'"> <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span class="switcher-label-off text-red">OFF</span></label> </td>
        <td class="align-middle text-center" >';
        if($row['ordering']>1)  echo'<a href="'.base_url().'switcher/lesson/sortup/'.$lesson_id.'.html" data-toggle="tooltip" title="ขึ้น"><i class="far fa-arrow-alt-circle-up fa-lg text-info"></i></a>';
        if($n<count($tree[0])) echo'<a href="'.base_url().'switcher/lesson/sortdown/'.$lesson_id.'.html" data-toggle="tooltip" title="ลง"><i class="far fa-arrow-alt-circle-down fa-lg text-success"></i></a>';
        echo'</td>
        <td class="align-middle">
        <a href="'.base_url().'lms/addsub_lessonform/'.$lesson_id.'.html" data-toggle="tooltip" title="เพิ่มย่อย"><i class="fas fa-plus-circle fa-lg text-danger"></i></a>
        <a href="'.base_url().'lms/lessonform/'.$lesson_id.'.html" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit fa-lg text-success"></i></a>
        <a href="#clientDeleteModal"  id="lesson__lesson_status__lesson_id__'.$lesson_id.'__'.time().'" rel="'.$row['lesson_th'].'" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
        </td>
       </tr><!-- /tr -->';
       }*/
showTree($tree, $result, $data);

echo '
                        </tbody><!-- /tbody -->
                      </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                  </div><!-- /.card-body -->
                </div><!-- /.card -->
              </div><!-- /.page-section -->

   <!-- .page-title-bar -->
              <header class="page-title-bar">
                <!-- floating action -->
    <input type="hidden" name="__id" id="__id" value="' .
    $subject_id .
    '" />
                <button type="button" class="btn btn-success btn-floated btn-add" id="add_lessonform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
    <!-- /floating action -->
              </header><!-- /.page-title-bar -->
            </div><!-- /.page-inner -->
          </div><!-- /.page -->
        </div><!-- .app-footer -->';

/*
function myTree($arrays, $parent = 0,$level=0) {
   $level++;
  foreach($arrays[$parent] as $_key => $_val){
   if(is_array($arrays[$_key])) {//print_r($arrays[$_key]);
    echo'<li class="menu-item has-child">'.$_val;
     echo'<ul class="menu">';
    myTree($arrays,$_key,$level);
    echo'</ul>';
    echo'</li>';
   }
  }
}

echo"<ul>";
myTree($arrays);
echo"</ul>";
*/

function showTree($arrays, $array, $data, $parent = 0, $level = 0, $lesson = '')
{
    $n = 0;
    if (empty($level)) {
        $sublesson = '';
    } else {
        $sublesson = 'small';
    }
    $level++;
    if (is_array($arrays[$parent])) {
        foreach ($arrays[$parent] as $lesson_id => $lesson_th) {
            $n++;
            $row = $array[$lesson_id];
            if ($parent == 0 || ($arrays[$lesson_id] > 0 && $parent != $row['lesson_id_ref'])) {
                $lesson = $n;
            }
            if (!empty($parent) && !empty($lesson)) {
                $showlesson = $lesson . '.';
            } else {
                $showlesson = '';
            }
            $lessonnum = $showlesson . $n;
            if (count($arrays[$lesson_id]) > 0) {
                $lesson = $lessonnum;
            }
            $prefix = md5('moc' . date('Ymd'));
            $left = ($level - 1) * 25;
            $checked = !empty($row['lesson_status']) ? 'checked' : '';
            $iconcolor = !empty($row['content_path']) ? 'text-success' : 'text-muted';
            if (count($arrays[$lesson_id]) == 0) {
                $icon1 = $icon2 = '<i class="fas fa-minus fa-xs text-success " ></i>';
            } else {
                $icon1 = '<i class="fas fa-minus-circle text-success " style="cursor:pointer" id="icon1_' . $lesson_id . '" onclick="togglerows(' . $lesson_id . ');"></i>';
                $icon2 = '<i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer" id="icon2_' . $lesson_id . '" onclick="togglerows(' . $lesson_id . ');"></i>';
            }
            echo '<!-- tr -->
       <tr id="' .
                $prefix .
                '__course_lesson__lesson_status__lesson_id__' .
                $lesson_id .
                '__' .
                time() .
                '__row"  class="rows_' .
                $parent .
                ' ' .
                $display .
                ' ' .
                $sublesson .
                '" >
        <!--<td class="">' .
                $data['lesson_type'][$row['lesson_type']]['type_th'] .
                '</td> -->
        <td >' .
                $row['lesson_number'] .
                '</td>
        <td style="padding-left:' .
                $left .
                'px">' .
                $icon1 .
                ' ' .
                $lesson_th .
                '</td>
        <td class="w3-hide-small" style="padding-left:' .
                $left .
                'px">' .
                $icon2 .
                ' ' .
                $row['lesson_en'] .
                '</td>
        <td><i style="cursor:pointer;" class="' .
                $data['content_type'][$row['content_type']]['icon'] .
                ' fa-lg ' .
                $iconcolor .
                ' switcher-upload" data-toggle="tooltip" title="' .
                $data['content_type'][$row['content_type']]['content_th'] .
                '" id="' .
                $lesson_id .
                '"></i></td>
        <td class="align-middle" s> <label class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox" class="switcher-input switcher-edit" ' .
                $checked .
                ' value="1" id="' .
                $prefix .
                '__course_lesson__lesson_status__lesson_id__' .
                $lesson_id .
                '__' .
                time() .
                '"> <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span class="switcher-label-off text-red">OFF</span></label> </td>';
            /*echo'<td class="align-middle text-center d-one" >';
        if($row['ordering']>1)  echo'<a href="'.base_url().'switcher/sortlesson/sortup/'.$row['subject_id'].'/'.$row['lesson_id_ref'].'/'.$lesson_id.'.html" data-toggle="tooltip" title="ขึ้น"><i class="far fa-arrow-alt-circle-up fa-lg text-info"></i></a>';
        if($n<count($arrays[$parent])) echo'<a href="'.base_url().'switcher/sortlesson/sortdown/'.$row['subject_id'].'/'.$row['lesson_id_ref'].'/'.$lesson_id.'.html" data-toggle="tooltip" title="ลง"><i class="far fa-arrow-alt-circle-down fa-lg text-success"></i></a>';
        echo'</td>';*/
            echo '<td class="align-middle">
        <a href="' .
                base_url() .
                'lms/addsub_lessonform/' .
                $row['subject_id'] .
                '/' .
                $lesson_id .
                '.html" data-toggle="tooltip" title="เพิ่มย่อย"><i class="fas fa-plus-circle fa-lg text-danger"></i></a>
        <a href="' .
                base_url() .
                'lms/lessonform/' .
                $lesson_id .
                '.html" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit fa-lg text-success"></i></a>
        <a href="#clientDeleteModal"  id="' .
                $prefix .
                '__course_lesson__lesson_status__lesson_id__' .
                $lesson_id .
                '__' .
                time() .
                '" rel="' .
                strip_tags($row['lesson_th']) .
                '" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
        </td>
       </tr><!-- /tr -->';
            showTree($arrays, $array, $data, $lesson_id, $level, $lesson);
        }
    }
} //
