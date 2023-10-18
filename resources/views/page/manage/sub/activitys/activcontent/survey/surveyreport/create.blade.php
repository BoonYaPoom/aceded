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
                <div class="card-header bg-muted"><a href="{{ route('surveyact', [$depart, $sur->subject_id]) }}"
                        style="text-decoration: underline;"> จัดการวิชา </a> / <a
                        href="{{ route('surveyquestion', [$depart, $sur->survey_id]) }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> / <a
                        href="{{ route('surveyquestion', [$depart, $sur->survey_id]) }}"
                        style="text-decoration: underline;">{{ $sur->survey_th }}</a> /
                    <i> เพิ่มแบบสำรวจ</i>
                </div><!-- /.card-header -->
                <form action="{{ route('savereport', [$depart, 'survey_id' => $sur->survey_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label" for="question_type">ประเภทแบบสำรวจ</label>
                            <select id="question_type" name="question_type" class="form-control" data-toggle="select2"
                                data-placeholder="ประเภทแบบสำรวจ" data-allow-clear="false">
                                <option value="0" selected disabled>เลือก</option>
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
                        <div id="data1" style="display:none;">
                            <!-- แสดงข้อมูลที่ 1 -->
                            <div class="form-group qtype1 ">
                                <label for="opt">เลือกคำตอบได้มากว่า 1 ข้อ </label> <label
                                    class="switcher-control switcher-control-success switcher-control-lg"><input
                                        type="checkbox" class="switcher-input" name="opt" id="opt" value="1">
                                    <span class="switcher-indicator"></span>
                                    <span class="switcher-label-on">ON</span>
                                    <span class="switcher-label-off text-red">OFF</span></label>
                            </div><!-- /.form-group -->
                            <!-- .form-group -->
                            <div class="form-group qtype1 ">
                                <label class="control-label" for="numchoice">จำนวนตัวเลือก</label>
                                <select id="numchoice" name="numchoice" class="form-control" data-toggle="select2"
                                    data-placeholder="จำนวนตัวเลือก" data-allow-clear="false">
                                    @for ($i = 1; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>

                                @for ($i = 1; $i <= 8; $i++)
                                    <div class="form-group qtype1" id="showchoice{{ $i }}"
                                        style="{{ $i > 4 ? 'display:none' : '' }}">
                                        <label for="choice{{ $i }}">ตัวเลือกที่ {{ $i }}</label>
                                        <input type="text" class="form-control" id="choice{{ $i }}"
                                            name="choice{{ $i }}" placeholder="ตัวเลือกที่ {{ $i }}"
                                            value="">
                                    </div>
                                @endfor

                                <script>
                                    $(document).ready(function() {
                                        $('#numchoice').change(function() {
                                            var numchoice = $(this).val();

                                            // hide/show choice fields based on selected number of choices
                                            for (var i = 1; i <= 8; i++) {
                                                if (i <= numchoice) {
                                                    $('#showchoice' + i).show();
                                                } else {
                                                    $('#showchoice' + i).hide();
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <!-- grid row -->
                        </div>


                        <div id="data2" style="display:none;">
                            <!-- แสดงข้อมูลที่ 1 -->

                            <!-- grid row -->
                            <div class="row qtype2">
                                <div class="col-lg-6">
                                    <!-- .list-group -->
                                    <div class="list-group list-group mb-3">
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <span class="tile tile-circle bg-success"><i
                                                        class="fas fa-question"></i></span>
                                            </div>
                                            <div class="list-group-item-header"> คำถาม </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">1</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q1" name="q1" placeholder="คำถาม" value=""></div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">2</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q2" name="q2" placeholder="คำถาม" value=""></div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">3</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q3" name="q3" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">4</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q4" name="q4" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">5</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q5" name="q5" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">6</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q6" name="q6" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">7</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q7" name="q7" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">8</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q8" name="q8" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">9</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q9" name="q9" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">10</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q10" name="q10" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                    </div><!-- /.list-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-lg-6">
                                    <!-- .list-group -->
                                    <div class="list-group list-group mb-3">
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <span class="tile tile-circle bg-success"><i
                                                        class="fas fa-comment-dots"></i></span>
                                            </div>
                                            <div class="list-group-item-header"> ตัวเลือก </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c1" name="c1" placeholder="ตัวเลือก"
                                                    value="น้อยที่สุด">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c2" name="c2" placeholder="ตัวเลือก" value="น้อย">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c3" name="c3" placeholder="ตัวเลือก"
                                                    value="ปานกลาง"></div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c4" name="c4" placeholder="ตัวเลือก" value="มาก">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c5" name="c5" placeholder="ตัวเลือก"
                                                    value="มากที่สุด">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c6" name="c6" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c7" name="c7" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c8" name="c8" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c9" name="c9" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6"></div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c10" name="c10" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                    </div><!-- /.list-group -->
                                </div><!-- /grid column -->

                            </div><!-- /grid row -->
                        </div>

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="question_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="question_status" id="question_status"
                                    value="1"> <span class="switcher-indicator"></span> <span
                                    class="switcher-label-on">ON</span> <span
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
