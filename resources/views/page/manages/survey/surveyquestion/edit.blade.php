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
                        href="{{ route('questionpage', [$depart, $surques->survey_id]) }}" style="text-decoration: underline;">
                        {{ html_entity_decode(strip_tags($surques->question)) }}
                    </a> /
                    <i> แก้ไขแบบสำรวจ</i>
                </div><!-- /.card-header -->
                <form action="{{ route('updateque', ['department_id' => $depart, 'question_id' => $surques]) }}"
                    method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="question_type">ประเภทแบบสำรวจ</label>
                            <select id="question_type" name="question_type" class="form-control" data-toggle="select2"
                                data-placeholder="ประเภทแบบสำรวจ" data-allow-clear="false"
                                value="{{ $surques->question_type }}">
                                <option value="1" {{ $surques->question_type == '1' ? 'selected' : '' }}>ตัวเลือก
                                </option>
                                <option value="2" {{ $surques->question_type == '2' ? 'selected' : '' }}>หลายมิติ
                                </option>
                                <option value="3" {{ $surques->question_type == '3' ? 'selected' : '' }}>เขียนอธิบาย
                                </option>

                            </select>
                        </div>
                          <!-- .form-group -->
                          <div class="form-group">
                            <label for="question">คำถาม <span class="badge badge-warning">Required</span></label>
                            <textarea class="editor" data-placeholder="คำถาม" data-height="150" name="question" id="question">{{ $surques->question }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- data == 1 -->
                        @include('page.manages.survey.surveyquestion.itemedit.data1')
                        <!-- data == 2 -->
                        @include('page.manages.survey.surveyquestion.itemedit.data2')

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
                            <label for="question_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="question_status" id="question_status" value="1"
                                    {{ $surques->question_status == 1 ? 'checked' : '' }}> <span
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
