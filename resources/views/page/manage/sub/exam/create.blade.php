@extends('page.manage.sub.navsubject')
@section('subject-data')
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

    <form action="{{ route('store_examform', [$depart, 'subject_id' => $subs]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <!-- .form-group -->
            <div class="form-group">
                <label for="exam_th">ชื่อข้อสอบ (ไทย) <span class="badge badge-warning">Required</span></label>
                <input type="text" class="form-control" id="exam_th" name="exam_th" placeholder="ชื่อข้อสอบ (ไทย)"
                    required="" value="">
            </div><!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
                <label for="exam_en">ชื่อข้อสอบ (อังกฤษ) </label> <input type="text" class="form-control" id="exam_en"
                    name="exam_en" placeholder="ชื่อข้อสอบ (อังกฤษ)" value="">
            </div><!-- /.form-group -->
            <div class="form-row">
                <!-- grid column -->
                <div class="col-md-6 mb-3 d-none">
                    <label for="group_th">จำนวนข้อสอบแสดงต่อหน้า </label> <select id="perpage" name="perpage"
                        class="form-control " data-toggle="select2" data-placeholder="จำนวนข้อสอบ" data-allow-clear="false">
                        <option value="0">ทุกข้อ </option>
                    </select>
                </div>
                <div class="col-md-6 mb-3 ">
                    <label for="group_th">จำนวนครั้งที่ให้ทำ </label> <select id="maxtake" name="maxtake"
                        class="form-control " data-toggle="select2" data-placeholder="จำนวนตัวเลือก"
                        data-allow-clear="false">
                        <option value="0" selected>ไม่จำกัด </option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">
                                {{ $i }}</option>
                        @endfor


                    </select>
                </div><!-- /.form-group -->

                <!-- grid column -->
                <div class="col-md-6 mb-3 d-none">
                    <label for="exam_score">คะแนนเก็บ </label>
                    <select id="exam_score" name="exam_score" class="form-control " data-toggle="select2"
                        data-placeholder="คะแนน" data-allow-clear="false">
                        <option value="0">ไม่เก็บคะแนน </option>
                        @for ($i = 1; $i <= 100; $i++)
                            <option value="{{ $i }}" {{ $i == 50 ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor

                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="score_pass">คะแนนผ่าน (เปอร์เซ็นต์) </label> <select id="score_pass" name="score_pass"
                        class="form-control " data-toggle="select2" data-placeholder="คะแนน" data-allow-clear="false">
                        @for ($i = 1; $i <= 100; $i++)
                            <option value="{{ $i }}" {{ $i == 50 ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-row">
                <!-- grid column -->
                <div class="col-md-6 mb-3">
                    <label for="randomquestion">สุ่มโจทย์ </label> <select id="randomquestion" name="randomquestion"
                        class="form-control " data-toggle="select2" data-placeholder="สุ่มโจทย์" data-allow-clear="false">
                        <option value="0">ไม่สุ่มโจทย์ </option>
                        <option value="1">สุ่มโจทย์ทั้งหมด </option>
                        <option value="2">สุ่มโจทยตามหมวด </option>
                    </select>
                </div><!-- /.form-group -->
                <!-- .form-group -->
                <div class="col-md-6 mb-3">
                    <label for="randomquestion">สุ่มตัวเลือก </label> <select id="randomchoice" name="randomchoice"
                        class="form-control " data-toggle="select2" data-placeholder="สุ่มตัวเลือก"
                        data-allow-clear="false">
                        <option value="0">ไม่สุ่มตัวเลือก </option>
                        <option value="1">สุ่มตัวเลือก </option>
                    </select>
                </div>
            </div>

            <!-- .form-group -->
            <div class="form-group">
                <label for="showscore">แสดงคะแนน </label> <label
                    class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                        class="switcher-input" name="showscore" id="showscore" value="1"> <span
                        class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                        class="switcher-label-off text-red">OFF</span> </label>
            </div><!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
                <label for="showanswer">แสดงเฉลย </label> <label
                    class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                        class="switcher-input" name="showanswer" id="showanswer" value="1"> <span
                        class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                        class="switcher-label-off text-red">OFF</span></label>
            </div><!-- /.form-group -->
            <!-- .form-group -->

            <!-- .form-group -->
            <div class="form-group">
                <label for="group_en">สถานะข้อสอบ </label> <label
                    class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                        class="switcher-input" name="exam_status" id="exam_status" value="1"> <span
                        class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                        class="switcher-label-off text-red">OFF</span></label>
            </div><!-- /.form-group -->
            <!-- .section-block -->
            <div class="section-block text-center text-sm-left">
                <h3 class="section-title">เลือกคลังข้อสอบ </h3><!-- .visual-picker -->


                <div class="visual-picker visual-picker has-peek">
                    <!-- visual-picker input -->
                    <input type="radio" id="exam_select0" name="exam_select" value="0">
                    <!-- .visual-picker-figure -->
                    <label class="visual-picker-figure" for="exam_select0" href="#clientQuestionModal0"
                        data-toggle="modal">
                        <!-- .visual-picker-content -->
                        <span class="visual-picker-content"><span class="h6 d-block">เลือกข้อสอบ</span><span
                                class="tile tile-sm exam_select exam_select0 bg-bg-muted"><i
                                    class="oi oi-question-mark"></i></span></span>
                        <!-- /.visual-picker-content -->
                    </label> <!-- /.visual-picker-figure -->
                    <!-- .visual-picker-peek -->
                </div><!-- /.visual-picker -->
                <!-- .visual-picker -->


                <div class="visual-picker visual-picker has-peek">
                    <!-- visual-picker input -->
                    <input type="radio" id="exam_select1" name="exam_select" value="1">
                    <!-- .visual-picker-figure -->
                    <label class="visual-picker-figure" for="exam_select1" href="#clientQuestionModal1"
                        data-toggle="modal">
                        <!-- .visual-picker-content -->
                        <span class="visual-picker-content"><span class="h6 d-block">สุ่มทุกครั้ง</span> <span
                                class="tile tile-sm exam_select exam_select1  bg-bg-muted"><i
                                    class="oi oi-question-mark"></i></span></span>
                        <!-- /.visual-picker-content -->
                    </label> <!-- /.visual-picker-figure -->
                    <!-- .visual-picker-peek -->
                </div><!-- /.visual-picker -->
                <!-- .visual-picker -->
            </div><!-- /.section-block -->

            <div class="form-group">
                <label for="limitdatetime">กำหนดวันทำข้อสอบ</label>
                <label class="switcher-control switcher-control-success switcher-control-lg">
                    <input type="checkbox" class="switcher-input" name="limitdatetime" id="limitdatetime"
                        value="1">
                    <span class="switcher-indicator"></span>
                    <span class="switcher-label-on">ON</span>
                    <span class="switcher-label-off text-red">OFF</span>
                </label>
            </div>

            <!-- .form-row -->
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="flatpickr01">วันที่เริ่มต้น</label>
                    <input id="flatpickr01" name="date1" value="" type="text"
                        class="form-control setdatetime" data-toggle="flatpickr" disabled>
                </div>

                <!-- /grid column -->
                <div class="col-md-6 mb-3">
                    <label for="flatpickr02">เวลาเริ่มต้น</label> <input id="flatpickr02" name="time1" value=""
                        type="text" class="form-control setdatetime " data-toggle="flatpickr" data-enable-time="true"
                        data-no-calendar="true" data-date-format="H:i" data-default-date="" disabled>
                </div><!-- /grid column -->
            </div><!-- /.form-row -->
            <!-- .form-row -->
            <div class="form-row">
                <!-- grid column -->
                <div class="col-md-6 mb-3">
                    <label for="flatpickr03">วันที่ สิ้นสุด</label> <input id="flatpickr03" name="date2"
                        value="" type="text" class="form-control setdatetime " data-toggle="flatpickr"
                        disabled>
                </div><!-- /grid column -->
                <!-- /grid column -->
                <div class="col-md-6 mb-3">
                    <label for="flatpickr04">เวลาสิ้นสุด</label> <input id="flatpickr04" name="time2" value=""
                        type="text" class="form-control setdatetime " data-toggle="flatpickr" data-enable-time="true"
                        data-no-calendar="true" data-date-format="H:i" data-default-date="" disabled>
                </div><!-- /grid column -->
            </div><!-- /.form-row -->
            <div class="form-group">
                <label for="limittime">กำหนดเวลาทำข้อสอบ </label> <label
                    class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                        class="switcher-input" name="limittime" id="limittime" value="1"> <span
                        class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                        class="switcher-label-off text-red">OFF</span></label>
            </div><!-- /.form-group -->
            <div class="form-row">



                <!-- grid column -->
                <div class="col-md-6 mb-3">
                    <label for="sethour">ชั่วโมง</label> <select id="sethour" name="sethour"
                        class="form-control Array settime" data-toggle="select2" data-placeholder="ชั่วโมง"
                        data-allow-clear="false" disabled>
                        <option disabled>เลือกชั่วโมง </option>
                        <option value="0" selected> 0 </option>

                        <option value="0" selected> 0 </option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">
                                {{ $i }}</option>
                        @endfor
                    </select>
                    <!-- /grid column -->
                </div>
                <div class="col-md-6 mb-3">
                    <label for="setminute">นาที</label> <select id="setminute" name="setminute"
                        class="form-control Array settime" data-toggle="select2" data-placeholder="ชั่วโมง"
                        data-allow-clear="false" disabled>
                        <option disabled>เลือกนาที </option>
                        <option value="0" selected> 0 </option>
                        @for ($i = 1; $i <= 59; $i++)
                            <option value="{{ $i }}">
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-row d-none">

                <div class="col-md-6 mb-3">
                    <label for="sethour">ทำแบบสำรวจก่อนสอบ</label> <select id="survey_before" name="survey_before"
                        class="form-control " data-toggle="select2" data-placeholder="ทำแบบสำรวจก่อนสอบ"
                        data-allow-clear="false">
                        <option value="0">ไม่มี </option>
                    </select>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="setminute">ทำแบบสำรวจหลังสอบ</label> <select id="survey_after" name="survey_after"
                        class="form-control " data-toggle="select2" data-placeholder="ทำแบบสำรวจหลังสอบ"
                        data-allow-clear="false">
                        <option value="0">ไม่มี </option>
                    </select>
                </div>
            </div>

            <div class="form-actions ">
                <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div>

        </div>
        @include('page.manage.sub.exam.Model.modelExam')


     
        <script>
            var limittimeCheckbox = document.getElementById('limittime');
            var sethourInput = document.getElementById('sethour');
            var setminuteInput = document.getElementById('setminute');


            limittimeCheckbox.addEventListener('change', function() {
                sethourInput.disabled = !limittimeCheckbox.checked;
                setminuteInput.disabled = !limittimeCheckbox.checked;
            });
        </script>


        <script>
            var limitdatetimeCheckbox = document.getElementById('limitdatetime');
            var flatpickrInput1 = document.getElementById('flatpickr01');
            var flatpickrInput2 = document.getElementById('flatpickr02');
            var flatpickrInput3 = document.getElementById('flatpickr03');
            var flatpickrInput4 = document.getElementById('flatpickr04');

            limitdatetimeCheckbox.addEventListener('change', function() {
                flatpickrInput1.disabled = !limitdatetimeCheckbox.checked;
                flatpickrInput2.disabled = !limitdatetimeCheckbox.checked;
                flatpickrInput3.disabled = !limitdatetimeCheckbox.checked;
                flatpickrInput4.disabled = !limitdatetimeCheckbox.checked;
            });
        </script>



        <!--  end model  -->
    </form>
@endsection
