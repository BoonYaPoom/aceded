 <!--  Model 0 -->
 <div class="modal fade show has-shown" id="clientQuestionModal0" tabindex="-1" user_role="dialog"
     aria-labelledby="clientQuestionModalLabel" aria-modal="true" style="padding-right: 17px;">
     <!-- .modal-dialog -->
     <div class="modal-dialog modal-xl" user_role="document">
         <!-- .modal-content -->
         <div class="modal-content">
             <!-- .modal-header -->
             <div class="modal-header " style="background-color: {{ $depart->color }};">
                 <h6 id="clientQuestionModalLabel" class="modal-title">
                     <span class="sr-only">"Warning</span> <span><i class="fas fa-question-circle fa-lg "></i>
                         เลือกคลังข้อสอบ</span>
                 </h6>
             </div><!-- /.modal-header -->
             <!-- .modal-body -->
             <div class="modal-body">
                 <!-- .form-group -->
                 <div class="form-group">
                     <div class="form-label-group">
                         <div class="table-responsive">

                             <table id="exam0" class="table w3-hoverable showexam "
                                 style="width:100% display:none;">
                                 <thead>
                                     <tr class="bg-infohead">
                                         <th class="align-middle" style="width:10%">
                                             <div class="custom-control custom-checkbox"> <input type="checkbox"
                                                     class="custom-control-input" name="checkall" value="1"
                                                     id="checkall"><label class="custom-control-label" for="checkall">
                                                     เลือกทั้งหมด</label>
                                             </div>
                                         </th>
                                         <th class="align-middle" style="width:45%">ข้อสอบ</th>
                                         <th class="align-middle" style="width:10%">คะแนน</th>
                                         <th class="align-middle" style="width:10%">ประเภท</th>
                                         <th class="align-middle" style="width:35%">หมวดหมู่</th>
                                     </tr>
                                 </thead>
                                 <script>
                                     $(function() {


                                         $('#examselectdata').click(function(e) {
                                             e.preventDefault();
                                             var all_qusr = [];

                                             $("input:checkbox[name='exam_data[]']:checked").each(function() {
                                                 all_qusr.push($(this).val());
                                             });

                                             var all_less = [];
                                             $('select[name^="randomdata"]').each(function(index) {
                                                 var selectedValue = $(this).val();
                                                 var selectId = $(this).attr('id');

                                                 // เพิ่มเงื่อนไขเช็ค selectedValue ไม่เป็น 0 ก่อนเพิ่มข้อมูลลงใน all_less
                                                 if (selectedValue !== '0') {
                                                     var data = {
                                                         [selectId]: selectedValue
                                                     };
                                                     all_less.push(data);
                                                 }
                                             });

                                             console.log(all_qusr);
                                             console.log(all_less);
                                         });
                                     });
                                 </script>
                                 <tbody id="dataexam0" class="dataexam">

                                     @php
                                         $qu = 0;
                                     @endphp
                                     @foreach ($ques as $questions)
                                         @php
                                             $questionType = \App\Models\QuestionType::find($questions->question_type);
                                             $lessonItem = \App\Models\CourseLesson::find($questions->lesson_id);
                                             $qu++;
                                             $examnum = $exams->exam_data;
                                             $jsonexam = json_decode($examnum);
                                             $datajsonexam = collect($jsonexam);
                                         @endphp

                                         <tr>
                                             @if (in_array($questions->question_status, [1]))
                                                 <td>
                                                     <div class="form-group">
                                                         <div class="custom-control custom-checkbox">
                                                             <input type="checkbox" class="custom-control-input"
                                                                 name="exam_data[]"
                                                                 id="exam_data{{ $questions->question_id }}"
                                                                 value="{{ $questions->question_id }}"
                                                                 {{ in_array($questions->question_id, $datajsonexam->toArray()) ? 'checked' : '' }}>
                                                             <label class="custom-control-label"
                                                                 for="exam_data{{ $questions->question_id }}"></label>
                                                             {{ $qu }}
                                                         </div>
                                                     </div>

                                                 </td>
                                                 <td>{{ strip_tags(html_entity_decode($questions->question)) }}</td>

                                                 <td>{{ $questions->score }} </td>
                                                 <td>{{ $questionType->question_type_th }}</td>
                                                 @if ($questions->lesson_id == 0)
                                                     <td>ข้อสอบ</td>
                                                 @elseif($questions->lesson_id > 0)
                                                     <td>{{ $lessonItem->lesson_th }}</td>
                                                 @endif
                                             @elseif (in_array($questions->question_status, [0]))
                                             @endif
                                         </tr>
                                     @endforeach
                                 </tbody>
                             </table>

                         </div>
                     </div>
                 </div><!-- /.form-group -->
             </div><!-- /.modal-body -->
             <!-- .modal-footer -->
             <div class="modal-footer">
                 <button type="button" class="btn btn-success" data-dismiss="modal" id="examselectdata">
                     เลือกข้อสอบ
                 </button>
                 <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
             </div><!-- /.modal-footer -->
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div>
 <!--  end model  -->



 <!--  Model 1 -->
 <div class="modal fade show has-shown" id="clientQuestionModal1" tabindex="-1" user_role="dialog"
     aria-labelledby="clientQuestionModalLabel" aria-modal="true" style="padding-right: 17px;">
     <!-- .modal-dialog -->
     <div class="modal-dialog modal-xl" user_role="document">
         <!-- .modal-content -->
         <div class="modal-content">
             <!-- .modal-header -->
             <div class="modal-header " style="background-color: {{ $depart->color }};">
                 <h6 id="clientQuestionModalLabel" class="modal-title">
                     <span class="sr-only">"Warning</span> <span><i class="fas fa-question-circle fa-lg "></i>
                         เลือกคลังข้อสอบ</span>
                 </h6>
             </div><!-- /.modal-header -->
             <!-- .modal-body -->
             <div class="modal-body">
                 <!-- .form-group -->
                 <div class="form-group">
                     <div class="form-label-group">
                         <div class="table-responsive">

                             <table id="exam1" class="table w3-hoverable showexam" style="width:100% display:none;">
                                 <thead>
                                     <tr class="bg-infohead">
                                         <th class="align-middle" style="width:10%">ลำดับ</th>
                                         <th class="align-middle" style="width:70%">หมวดหมู่</th>
                                         <th class="align-middle" style="width:20%">จำนวน</th>
                                     </tr>
                                 </thead>
                                 <tbody id="dataexam0" class="dataexam">


                                     @php

                                         $uniqueLessons = $ques->unique('lesson_id');
                                         $q = 0;

                                     @endphp
                                     @foreach ($uniqueLessons as $question)
                                         @php
                                             $lessonItem = \App\Models\CourseLesson::find($question->lesson_id);
                                             $q++;
                                         @endphp
                                         <tr>
                                             @if (in_array($question->question_status, [1]))
                                                 <td>{{ $q }}</td>
                                                 @if ($question->lesson_id == 0)
                                                     <td>ข้อสอบ</td>
                                                 @else
                                                     <td>{{ $lessonItem->lesson_th }}</td>
                                                 @endif
                                                 <td><select id="{{ $question->lesson_id }}"
                                                         name="randomdata[{{ $question->lesson_id }}]"
                                                         class="form-control settime select2-hidden-accessible"
                                                         data-toggle="select2" data-placeholder="จำนวนข้อสอบ"
                                                         data-allow-clear="false" data-select2-id="randomdata0"
                                                         tabindex="-1" aria-hidden="true">
                                                         <option value="0" selected disabled>
                                                             เลือกทั้งหมด </option>
                                                         <option value="0">ไม่เลือก </option>
                                                         @php
                                                             $i = 0;

                                                         @endphp
                                                         @foreach ($ques as $quesaaa)
                                                             @if ($quesaaa->lesson_id == $question->lesson_id)
                                                                 @php
                                                                     $i++;
                                                                     $examnum = $exams->exam_data;
                                                                     $jsonexam = json_decode($examnum);
                                                                     $datajsonexam = collect($jsonexam);
                                                                 @endphp

                                                                 <option value="{{ $i }}"
                                                                     {{ $datajsonexam->contains($i) ? 'selected' : '0' }}>
                                                                     {{ $i }}
                                                                 </option>
                                                             @endif
                                                         @endforeach



                                                     </select></td>
                                             @elseif (in_array($questions->question_status, [0]))
                                             @endif
                                         </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                             <script>
                                 $(document).ready(function() {
                                     var table = $('#exam0').DataTable({

                                         lengthChange: false,
                                         responsive: true,
                                         info: false,
                                         pageLength: 20,
                                         language: {
                                             info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                             infoEmpty: "ไม่พบรายการ",
                                             infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                             paginate: {
                                                 first: "หน้าแรก",
                                                 last: "หน้าสุดท้าย",
                                                 previous: "ก่อนหน้า",

                                                 next: "ถัดไป"
                                             }
                                         },

                                     });
                                     $("#checkall").click(function() {
                                         var isChecked = $(this).prop('checked');
                                         // ทำการตรวจสอบทุกรายการที่แสดงใน DataTables และกำหนดสถานะ checked
                                         table.rows().nodes().to$().find('.custom-control-input').prop('checked', isChecked);
                                     });

                                 });
                             </script>
                             <script>
                                 $(document).ready(function() {
                                     var table = $('#exam1').DataTable({

                                         lengthChange: false,
                                         responsive: true,
                                         info: false,
                                         pageLength: 20,
                                         language: {
                                             info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                             infoEmpty: "ไม่พบรายการ",
                                             infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                             paginate: {
                                                 first: "หน้าแรก",
                                                 last: "หน้าสุดท้าย",
                                                 previous: "ก่อนหน้า",

                                                 next: "ถัดไป"
                                             }
                                         },

                                     });


                                 });
                             </script>
                         </div>
                     </div>
                 </div><!-- /.form-group -->
             </div><!-- /.modal-body -->
             <!-- .modal-footer -->
             <div class="modal-footer">
                 <button type="button" class="btn btn-success" data-dismiss="modal" id="examselectdata">
                     เลือกข้อสอบ
                 </button>
                 <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
             </div><!-- /.modal-footer -->
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div>
 <!--  end model  -->
