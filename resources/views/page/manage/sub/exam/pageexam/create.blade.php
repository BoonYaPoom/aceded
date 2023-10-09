@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',


            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif
    <form action="{{ route('add_questionform', ['subject_id' => $subject_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a href="{{ route('exampage', [$subs->subject_id]) }}"
                            style="text-decoration: underline;">หมวดหมู่</a> / <a
                            href="{{ route('pagequess', [$subs->subject_id]) }}"
                            style="text-decoration: underline;">จัดการวิชา</a> / <i>คลังข้อสอบ</i> / <i></i></div>
                    <!-- /.card-header -->
                    <!-- .nav-scroller -->

                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label class="control-label" for="question_type">ประเภทข้อสอบ</label> <select id="question_type"
                                name="question_type" class="form-control" data-toggle="select2"
                                data-placeholder="ประเภทข้อสอบ" data-allow-clear="false">
                                <option value="0" selected disabled>เลือก</option>
                                @foreach ($typequs as $type)
                                    @if ($type->question_type == 1)
                                        <option value="{{ $type->question_type }}"> {{ $type->question_type_th }} </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('question_type')
                                <span class="badge badge-warning">{{ $message }}</span>
                            @enderror


                            <script>
                                $(document).ready(function() {
                                    $('#question_type').change(function() {
                                        var selectedValue = $(this).val();
                                        // ซ่อนข้อมูลทั้งหมด
                                        $('#data1').hide();
                                        $('#data2').hide();
                                        $('#data3').hide();
                                        $('#data4').hide();
                                        $('#data5').hide();
                                        // แสดงข้อมูลที่เลือก
                                        if (selectedValue == '1') {
                                            $('#data1').show();
                                        } else if (selectedValue == '2') {

                                        } else if (selectedValue == '3') {
                                            $('#data3').show();
                                        } else if (selectedValue == '4') {
                                            $('#data4').show();
                                        } else if (selectedValue == '5') {
                                            $('#data5').show();
                                        }
                                    });
                                });
                            </script>



                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label class="control-label" for="lesson_id">หมวดข้อสอบ</label> <select id="lesson_id"
                                name="lesson_id" class="form-control" data-toggle="select2" data-placeholder="หมวดข้อสอบ"
                                data-allow-clear="false">
                                <option value="0" selected>ข้อสอบ </option>

                                @foreach ($lossen as $lession)
                                    <option value="{{ $lession->lesson_id }}">{{ $lession->lesson_th }} </option>
                                @endforeach
                            </select>
                        </div><!-- /.form-group -->
                        @error('lesson_id')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label class="control-label" for="score">คะแนน</label> <select id="score" name="score"
                                class="form-control" data-toggle="select2" data-placeholder="คะแนน"
                                data-allow-clear="false">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div><!-- /.form-group -->


                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="question">คำถาม <span class="badge badge-warning">Required</span></label>
                            <textarea class="editor" data-placeholder="คำถาม" data-height="150" name="question" id="question">

                        </textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        @error('question')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror


                        <div id="data1" style="display:none;">
                            <div class="form-group qtype1 ">
                                <label class="control-label" for="numchoice">จำนวนตัวเลือก</label> <select id="numchoice"
                                    name="numchoice" class="form-control" data-toggle="select2"
                                    data-placeholder="จำนวนตัวเลือก" data-allow-clear="false">
                                    @for ($i = 4; $i <= 8; $i++)
                                        <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>

                            </div><!-- /.form-group -->

                            @for ($i = 1; $i <= 8; $i++)
                                <div class="form-group qtype1" id="showchoice{{ $i }}"
                                    style="{{ $i > 4 ? 'display:none' : '' }}">
                                    <label for="choice{{ $i }}">ตัวเลือกที่ {{ $i }}</label>
                                    <div class="custom-control custom-control-inline custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check{{ $i }}"
                                            name="checkanswer[]" value="{{ $i }}">
                                        <label class="custom-control-label"
                                            for="check{{ $i }}">คำตอบถูกต้อง</label>
                                    </div>
                                    <textarea class="editor" data-placeholder="ตัวเลือกที่ {{ $i }}" data-height="120"
                                        name="choice{{ $i }}" id="choice{{ $i }}"></textarea>
                                </div><!-- /.form-group -->
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
                        <div id="data3" style="display:none;">
                            <div class="form-group qtype3 ">
                                <label class="d-block">คำตอบ</label>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" class="custom-control-input" name="checktruefalse" id="radio1"
                                        value="1"> <label class="custom-control-label" for="radio1">ถูก</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" class="custom-control-input" name="checktruefalse" id="radio2"
                                        value="2"> <label class="custom-control-label" for="radio2">ผิด</label>
                                </div>
                            </div><!-- /.form-group -->
                        </div>



                        <div id="data4" style="display:none;">

                            <!-- grid row -->
                            <div class="row qtype4 ">
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
                                            <div class="list-group-item-figure">
                                                <select id="ans1" name="ans1" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 1"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q1" name="q1" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans2" name="ans2" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 2"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q2" name="q2" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans3" name="ans3" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 3"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q3" name="q3" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans4" name="ans4" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 4"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q4" name="q4" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans5" name="ans5" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 5"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q5" name="q5" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans6" name="ans6" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 6"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q6" name="q6" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans7" name="ans7" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 7"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q7" name="q7" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans8" name="ans8" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 8"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q8" name="q8" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans9" name="ans9" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 9"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="q9" name="q9" placeholder="คำถาม" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure">
                                                <select id="ans10" name="ans10" class="form-control"
                                                    data-toggle="select2" data-placeholder="คำตอบ 10"
                                                    data-allow-clear="false">
                                                    <option value="0">เลือกคำตอบ</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ chr($i + 64) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
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
                                            <div class="list-group-item-figure h6">A</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c1" name="c1" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">B</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c2" name="c2" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">C</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c3" name="c3" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">D</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c4" name="c4" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">E</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c5" name="c5" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">F</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c6" name="c6" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">G</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c7" name="c7" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">H</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c8" name="c8" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">I</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c9" name="c9" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="list-group-item-figure h6">J</div>
                                            <div class="list-group-item-body"> <input type="text" class="form-control"
                                                    id="c10" name="c10" placeholder="ตัวเลือก" value="">
                                            </div>
                                        </div>
                                    </div><!-- /.list-group -->
                                </div><!-- /grid column -->

                            </div><!-- /grid row -->


                        </div>



                        <div id="data5" style="display:none;">
                            <!-- grid row -->
                            <div class="form-group qtype5 ">
                                <!-- .list-group -->
                                <div class="list-group list-group mb-3">
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">
                                            <span class="tile tile-circle bg-success"><i
                                                    class="fas fa-sort-amount-down"></i></span>
                                        </div>
                                        <div class="list-group-item-header"> เรียงลำดับ </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">1.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o1" name="o1" placeholder="ลำดับ  1" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">2.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o2" name="o2" placeholder="ลำดับ  2" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">3.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o3" name="o3" placeholder="ลำดับ  3" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">4.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o4" name="o4" placeholder="ลำดับ  4" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">5.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o5" name="o5" placeholder="ลำดับ  5" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">6.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o6" name="o6" placeholder="ลำดับ  6" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">7.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o7" name="o7" placeholder="ลำดับ  7" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">8.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o8" name="o8" placeholder="ลำดับ  8" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">9.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o9" name="o9" placeholder="ลำดับ  9" value="">
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="list-group-item-figure">10.</div>
                                        <div class="list-group-item-body"> <input type="text" class="form-control"
                                                id="o10" name="o10" placeholder="ลำดับ  10" value="">
                                        </div>
                                    </div>
                                </div><!-- /.list-group -->

                            </div><!-- /grid row -->
                            <!-- .form-group -->
                        </div>




                        <div class="form-group">
                            <label for="explain">คำอธิบาย </label>
                            <textarea class="editor" data-placeholder="คำอธิบาย" data-height="150" name="explain" id="explain"></textarea>
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="question_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="question_status" id="question_status"
                                    value="1" checked> <span class="switcher-indicator"></span> <span
                                    class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

    </form>
@endsection
