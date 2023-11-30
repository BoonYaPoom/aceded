@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a
                        href="{{ route('surveypage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> / <a
                        href="{{ route('questionpage', [$depart, $sur->survey_id]) }}" style="text-decoration: underline;">
                        {{ $sur->survey_th }}
                    </a>/ เพิ่ม </i>
                </div><!-- /.card-header -->
                <form action="{{ route('storequ', ['department_id' => $depart, 'survey_id' => $sur]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="question_type">ประเภทแบบสำรวจ</label>
                            <select id="question_type" name="question_type" class="form-control" data-toggle="select2"
                                data-placeholder="ประเภทแบบสำรวจ" data-allow-clear="false">
                                <option value="1">ตัวเลือก</option>
                                <option value="2">หลายมิติ</option>
                                <option value="3">เขียนอธิบาย</option>
                            </select>
                        </div>


                        <script>
                            $(document).ready(function() {
                                $('#question_type').change(function() {
                                    var selectedValue = $(this).val();
                                    // ซ่อนข้อมูลทั้งหมด
                                    $('#data1').hide();
                                    $('#data2').hide();
                                    // แสดงข้อมูลที่เลือก
                                    if (selectedValue == '1') {
                                        $('#data1').show();
                                    } else if (selectedValue == '2') {
                                        $('#data2').show();
                                    }
                                });
                            });
                        </script>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="question">คำถาม <span class="badge badge-warning">Required</span></label>
                            <textarea class="editor" data-placeholder="คำถาม" data-height="150" name="question" id="question"></textarea>
                        </div><!-- /.form-group -->
                        @error('question')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror


                        <!-- data == 1 -->
                        @include('page.manages.survey.surveyquestion.itemcreate.data1')
                        <!-- data == 2 -->
                        @include('page.manages.survey.surveyquestion.itemcreate.data2')

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="question_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="question_status" id="question_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                    <!-- .form-actions -->


            </div><!-- /.card -->
            <div class="form-actions ">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
            </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
