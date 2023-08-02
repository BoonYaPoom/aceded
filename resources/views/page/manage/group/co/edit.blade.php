@extends('layouts.adminhome')
@section('content')
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
    <form action="{{route('courseform_update', ['course_id' => $cour->course_id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted">
                        <a href="{{ route('learn') }}" style="text-decoration: underline;">จัดการหลักสูตร</a> / <a
                        href="{{ route('courgroup', ['department_id' => $courses->first()->department_id]) }}"
                        style="text-decoration: underline;">
                            หมวดหมู่</a> / <a
                            href="{{ route('courpag', ['group_id' => $cour->group_id]) }}"
                            style="text-decoration: underline;">  
                             @foreach ($courses as $course)
                            {{ $course->group_th }}
                        @endforeach</a> / <i>{{ $cour->course_th }}</i>
                    </div><!-- /.card-header -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="course_code">รหัสหลักสูตร<span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control bg-muted" id="course_code" name="course_code"
                                placeholder="รหัสหลักสูตร" required="" value="{{ $cour->course_code }}" readonly>
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="course_th">ชื่อหลักสูตร (ไทย) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="course_th" name="course_th"
                                placeholder="ชื่อหลักสูตร (ไทย)" required="" value="{{ $cour->course_th }}">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="course_en">ชื่อหลักสูตร (อังกฤษ) </label> <input type="text" class="form-control"
                                id="course_en" name="course_en" placeholder="ชื่อหลักสูตร (อังกฤษ)"
                                value="{{ $cour->course_en }}">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                        <div class="col-lg-10">
                            <img src="{{ Storage::disk('external')->url($cour->cover) }}"
                                alt="{{ $cour->cover }}" style="width:70%">
                        </div>
                        <div class="form-group">
                            <label for="subject">วิชาในหลักสูตร</label> <select id="subject" name="subject[]"
                                class="form-control" data-toggle="select2" data-placeholder="วิชาในหลักสูตร"
                                data-allow-clear="false" multiple>
                                <option value="0">เลือกวิชา </option>
                                @foreach ($subs as $subjects)
                                    @php
                                        $courArray2 = json_decode($cour->subject, true);
                                    @endphp

                                    <option value="{{ $subjects->subject_id }}"
                                        {{ in_array($subjects->subject_id, $courArray2) ? 'selected' : '' }}>
                                        {{ $subjects->subject_th }}</option>
                                @endforeach
                            </select>
                        </div><!-- /.form-group -->
                        <div class="row ">
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="days">จำนวนวันที่เรียน</label> <select
                                        id="days" name="days" days="form-control  " data-toggle="select2"
                                        data-placeholder="จำนวนวัน" data-allow-clear="false">
                                        <option value="0">เลือกจำนวนวัน</option>
                                        @for ($i = 1; $i <= 365; $i++)
                                            <option value="{{ $i }}" {{ $i == $cour->days ? 'selected' : '' }}>
                                                {{ $i }} </option>
                                        @endfor
                                    </select>
                                </div>
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="hours">จำนวนชั่วโมงเรียน</label> <select
                                        id="hours" name="hours" class="form-control  " data-toggle="select2"
                                        data-placeholder="จำนวนวัน" data-allow-clear="false">
                                        <option value="0">เลือกจำนวนชั่วโมงเรียน</option>
                                        @for ($i = 1; $i <= 500; $i++)
                                            <option value="{{ $i }}"
                                                {{ $i == $cour->hours ? 'selected' : '' }}> {{ $i }} </option>
                                        @endfor

                                    </select>
                                </div>
                            </div><!-- /grid column -->
                        </div><!-- /grid row -->
                        <div class="row d-none">
                            <!-- grid column -->
                            <div class="col-md-6">
                                <!-- .form-group -->
                                <div class="form-group">
                                    <label class="control-label" for="levels">ระดับหลักสูตร</label> <select id="levels"
                                        name="levels" class="form-control" data-toggle="select2"
                                        data-placeholder="ระดับหลักสูตร" data-allow-clear="false">
                                        <option value="0">เลือกระดับ </option>
                           
                                        @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{$i}}"> ระดับ {{$i}} </option>
                                        @endfor
                                        <option value="6"> ระดับต้น </option>
                                        <option value="7"> ระดับกลาง </option>
                                        <option value="8"> ระดับสูง </option>
                                    </select>
                                </div><!-- /.form-group -->
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <!-- .form-group -->
                                <div class="form-group">
                                    <label class="control-label" for="lesson_type">ประเภทหัวข้อ</label> <select
                                        id="lesson_type" name="lesson_type" class="form-control" data-toggle="select2"
                                        data-placeholder="ประเภทหัวข้อ" data-allow-clear="false">
                                        <option value="0">เลือกประเภทหัวข้อ </option>
                                        <option value="1"> บทที่ </option>
                                        <option value="2"> สัปดาห์ที่ </option>
                                        <option value="3"> หัวข้อที่ </option>
                                        <option value="4"> หน่วยที่ </option>
                                        <option value="5"> ลำดับ </option>
                                    </select>
                                </div><!-- /.form-group -->

                            </div><!-- /grid column -->
                        </div><!-- /grid row -->
                        <div class="row">
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="learn_format">รูปแบบการเรียน </label> <select id="learn_format"
                                        name="learn_format" class="form-control" data-toggle="select2">
                                         <option value="0" {{ $cour->learn_format == 0 ? 'selected' : '' }}>อิสระ</option>
                                        <option value="1" {{ $cour->learn_format == 1 ? 'selected' : '' }}>ตามลำดับ</option>
                                    
                                    </select>
                                </div>
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label" for="courseformat">รูปแบบหลักสูตร</label> <select
                                        id="courseformat" name="courseformat" class="form-control" data-toggle="select2"
                                        data-placeholder="รูปแบบหลักสูตร" data-allow-clear="false">
                                        <option value="0" {{ $cour->courseformat == 0 ? 'selected' : '' }}> แบบสมัครใจ</option>
                                        <option value="1" {{ $cour->courseformat == 1 ? 'selected' : '' }}> แบบบังคับ</option>
                                    </select>
                                </div>
                            </div><!-- /grid column -->
                        </div><!-- /grid row -->

                        <div class="row d-none">
                            <!-- grid column -->
                            <div class="col-md-6">
                                <!-- .form-group -->
                                <div class="form-group">
                                    <label class="control-label" for="checkscore">เกณฑ์คะแนน</label> <select
                                        id="checkscore" name="checkscore" class="form-control  " data-toggle="select2"
                                        data-placeholder="เกณฑ์คะแนน" data-allow-clear="false">
                                        <option value="0"> กำหนดคะแนน</option>
                                        @for ($i = 1; $i <= 99; $i++)
                                            <option value="{{ $i }}"> {{ $i }} </option>
                                        @endfor

                                    </select>
                                </div><!-- /.form-group -->
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="checktime">เวลาเรียนอย่างน้อย (ชั่วโมง)</label>
                                    <select id="checktime" name="checktime" class="form-control bg-muted "
                                        data-toggle="select2" data-placeholder="กำหนดเกณฑ์คะแนน" data-allow-clear="false"
                                        disabled>
                                        <option value="0"> กำหนดเวลาเรียน</option>
                                        @for ($i = 1; $i <= 99; $i++)
                                            <option value="{{ $i }}"> {{ $i }} </option>
                                        @endfor

                                    </select>
                                </div>
                            </div><!-- /grid column -->
                        </div><!-- /grid row -->

                        <div class="row">
                            <!-- grid column -->
                            <div class="col-md-6 d-none">
                                <!-- .form-group -->
                                <div class="form-group">
                                    <label class="control-label"
                                        for="survey_value">จำนวนวันที่ให้ทำแบบสำรวจความคุ้มค่าหลังจากสำเร็จหลักสูตร</label>
                                    <select id="survey_value" name="survey_value" class="form-control  "
                                        data-toggle="select2"
                                        data-placeholder="จำนวนวันที่ให้ทำแบบสำรวจความคุ้มค่าหลังจากสำเร็จหลักสูตร"
                                        data-allow-clear="false">
                                        <option value="0">ไม่ต้องทำแบบสำรวจความคุ้มค่า</option>
                                        @for ($i = 1; $i <= 90; $i++)
                                            <option value="{{ $i }}"> {{ $i }} </option>
                                        @endfor

                                    </select>

                                </div><!-- /.form-group -->
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group d-none">
                                    <label for="">การประเมินผล </label> <select id="evaluation" name="evaluation"
                                        class="form-control" data-toggle="select2" data-placeholder="การประเมินผล"
                                        data-allow-clear="false">
                                        <option value="1"> เกณฑ์คะแนน </option>
                                        <option value="2"> เกณฑ์เวลาเรียน </option>
                                        <option value="3"> เกณฑ์คะแนนและเวลาเรียน </option>
                                    </select>
                                </div>
                            </div><!-- /grid column -->
                        </div><!-- /grid row -->
                        <div class="row d-none">
                            <!-- grid column -->
                            <div class="col-md-6">
                                <!-- .form-group -->
                                <div class="form-group">
                                    <label class="control-label" for="suvey_complacence">แบบสำรวจความพึงพอใจ</label>
                                    <select id="suvey_complacence" name="suvey_complacence" class="form-control"
                                        data-toggle="select2" data-placeholder="แบบสำรวจความพึงพอใจ"
                                        data-allow-clear="false">
                                        <option value="0"> ไม่ต้องทำแบบสำรวจความพึงพอใจ</option>
                                        <option value="1"> ทำแบบสำรวจเมื่อสำเร็จหลักสูตร</option>
                                    </select>
                                </div><!-- /.form-group -->
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"
                                        for="learnday">จำนวนวันที่เรียนหลังจากลงทะเบียนหลักสูตร</label> <select
                                        id="learnday" name="learnday" class="form-control  " data-toggle="select2"
                                        data-placeholder="จำนวนวันที่เรียนหลังจากลงทะเบียนหลักสูตร"
                                        data-allow-clear="false">
                                        <option value="0"> ไม่จำกัด</option>
                                        @for ($i = 1; $i <= 365; $i++)
                                            <option value="{{ $i }}"> {{ $i }} </option>
                                        @endfor

                                    </select>
                                </div>

                            </div><!-- /grid column -->
                        </div><!-- /grid row -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="shownumber">แสดงลำดับ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="shownumber" id="shownumber"
                                    value="1"> <span class="switcher-indicator"></span> <span
                                    class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="recommended">หลักสูตรแนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="recommended" id="recommended"
                                    value="1" {{ $cour->recommended == 1 ? 'checked' : '' }}> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="course_status">สถานะหลักสูตร</label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="course_status" id="course_status"
                                    value="1" {{ $cour->course_status == 1 ? 'checked' : '' }}>
                                <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span>
                            </label>

                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group  d-none">
                            <label for="course_approve">อนุมัติการฝึกอบรม </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="course_approve" id="course_approve"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="cetificate_status">มีใบประกาศนียบัตร </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="cetificate_status"
                                    id="cetificate_status" value="1"
                                    {{ $cour->cetificate_status == 1 ? 'checked' : '' }}>
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group  d-none">
                            <label for="cetificate_request">ให้ผู้อบรมขอใบประกาศนียบัตร </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                    type="checkbox" class="switcher-input" name="cetificate_request"
                                    id="cetificate_request" value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->

                        <!-- .fieldset -->
                        <fieldset class="d-none">
                            <legend>สมรรถนะของหลักสูตร</legend> <!-- .form-group -->
                            <div class="row">
                                <!-- grid column competencies-->
                                <div class="col-md-6">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="d-block">สมรรถนะเฉพาะด้านภายใต้บริบทของกระทรวงพาณิชย์</label>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies1" name="competencies[]"
                                                value="1"> <label class="custom-control-label"
                                                for="competencies1">การคิดเชิงกลยุทธ์</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies2" name="competencies[]"
                                                value="2"> <label class="custom-control-label"
                                                for="competencies2">การปรับตัวพร้อมรับการเปลี่ยนแปลง</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies3" name="competencies[]"
                                                value="3"> <label class="custom-control-label"
                                                for="competencies3">การดำเนินการเชิงรุก</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies4" name="competencies[]"
                                                value="4"> <label class="custom-control-label"
                                                for="competencies4">การคิดเชิงบวก</label></div>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column competencies-->
                                <div class="col-md-6">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label
                                            class="d-block">สมรรถนะเฉพาะด้านภายใต้บริบทของสำนักงานคณะกรรมการการแข่งขันทางการค้า</label>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies5" name="competencies[]"
                                                value="5"> <label class="custom-control-label"
                                                for="competencies5">การคิดเชิงวิเคราะห์</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies6" name="competencies[]"
                                                value="6"> <label class="custom-control-label"
                                                for="competencies6">การคิดเชิงสร้างสรรค์</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies7" name="competencies[]"
                                                value="7"> <label class="custom-control-label"
                                                for="competencies7">การคิดเชิงนวัตกรรม</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies8" name="competencies[]"
                                                value="8"> <label class="custom-control-label"
                                                for="competencies8">การปรับปรุงและพัฒนาอย่างต่อเนื่อง</label></div>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column competencies-->
                                <div class="col-md-6">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="d-block">สมรรถนะเฉพาะด้านภายใต้บริบทของ กพ.</label>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies9" name="competencies[]"
                                                value="9"> <label class="custom-control-label"
                                                for="competencies9">การมุ่งผลสัมฤทธิ์</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies11" name="competencies[]"
                                                value="11"> <label class="custom-control-label"
                                                for="competencies11">การบริหารงานที่ดี</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies12" name="competencies[]"
                                                value="12"> <label class="custom-control-label"
                                                for="competencies12">การสั่งสมความเชียวชาญในงานอาชีพ</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies13" name="competencies[]"
                                                value="13"> <label class="custom-control-label"
                                                for="competencies13">จริยธรรม</label></div>
                                        <div class="custom-control  custom-checkbox"><input type="checkbox"
                                                class="custom-control-input " id="competencies14" name="competencies[]"
                                                value="14"> <label class="custom-control-label"
                                                for="competencies14">การทำงานเป็นทีม</label></div>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                        </fieldset><!-- /.fieldset --><br>
                        <!-- .fieldset -->
                        <fieldset>
                            <legend>เงื่อนไขการเรียนหลักสูตร</legend> <!-- .form-group -->
                            <div class="row">
                                <!-- grid column -->
                                <div class="col-md-6 d-none">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="prerequisites">หลักสูตรที่ต้องเรียนก่อน</label>
                                        <select id="prerequisites" name="prerequisites[]" class="form-control"
                                            data-toggle="select2" data-placeholder="หลักสูตรที่ต้องเรียนก่อน"
                                            data-allow-clear="false" multiple></select>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_type"> กลุ่มผู้ใช้ </label> <select id="person_type"
                                            name="person_type[]" class="form-control" data-toggle="select2"
                                            data-placeholder="กลุ่มผู้ใช้" data-allow-clear="false" multiple
                                            onchange="$('.showrow').addClass('d-none');for (const value of $(this).val()) $('#showrow'+value).removeClass('d-none')">

                                            @foreach ($pertype as $pypes)
                                                @php
                                                    $courArray = json_decode($cour->person_type, true);
                                                @endphp
                                                <option value="{{ $pypes->person_type }}"
                                                    {{ in_array($pypes->person_type, $courArray) ? 'selected' : '' }}>
                                                    {{ $pypes->person }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->

                            <div class="row">
                                <!-- grid column -->
                                <div class="col-md-6 d-none">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="age">อายุบุคลากร</label> <select id="age"
                                                name="age" class="form-control" data-toggle="select2"
                                                data-placeholder="อายุบุคลากร" data-allow-clear="true">
                                                <option value="0"> </option>
        
                                                @for ($i = 18; $i <= 100; $i++)
                                                <option value="{{ $i }}"> {{ $i }} </option>
                                            @endfor

                                            </select>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6  d-none">
                                    <div class="form-group">
                                        <label class="control-label" for="agework">อายุราชการ</label> <select
                                            id="agework" name="agework" class="form-control" data-toggle="select2"
                                            data-placeholder="อายุบุคลากร" data-allow-clear="true">
                                            <option value="0"> </option>
                                            @for ($i = 1; $i <= 50; $i++)
                                                <option value="{{ $i }}"> {{ $i }} </option>
                                            @endfor

                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->

                            <div class="row">
                                <!-- grid column -->
                                <div class="col-md-6  d-none">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="position_type">ประเภทตำแหน่ง</label> <select
                                            id="position_type" name="position_type[]" class="form-control"
                                            data-toggle="select2" data-placeholder="ประเภทตำแหน่ง"
                                            data-allow-clear="false" multiple>
                                            <option value="1"> ทั่วไป </option>
                                            <option value="2"> วิชาการ </option>
                                            <option value="3"> อำนวยการ </option>
                                            <option value="4"> บริหาร </option>
                                        </select>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6  d-none">
                                    <div class="form-group">
                                        <label for="position_level">ระดับตำแหน่ง </label> <select id="position_level"
                                            name="position_level[]" class="form-control" data-toggle="select2"
                                            data-placeholder="ระดับตำแหน่ง" data-allow-clear="false" multiple>
                                            <option value="1"> ปฏิบัติงาน </option>
                                            <option value="2"> ชำนาญงาน </option>
                                            <option value="3"> อาวุโส </option>
                                            <option value="4"> ทักษะพิเศษ </option>
                                            <option value="5"> ปฏิบัติการ </option>
                                            <option value="6"> ชำนาญการ </option>
                                            <option value="7"> ชำนาญการพิเศษ </option>
                                            <option value="8"> เชี่ยวชาญ </option>
                                            <option value="9"> ทรงคุณวุฒิ </option>
                                            <option value="10"> อำนวยการต้น </option>
                                            <option value="11"> อำนวยการสูง </option>
                                            <option value="12"> บริหารต้น </option>
                                            <option value="13"> บริหารสูง </option>
                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->

                            <div class="row">
                                <!-- grid column -->
                                <div class="col-md-6  d-none">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="position">ตำแหน่ง</label> <select
                                            id="position" name="position[]" class="form-control" data-toggle="select2"
                                            data-placeholder="ตำแหน่ง" data-allow-clear="false" multiple></select>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6  d-none">
                                    <div class="form-group">
                                        <label class="control-label" for="">ระดับการศึกษา</label> <select
                                            id="education_level" name="education_level[]" class="form-control"
                                            data-toggle="select2" data-placeholder="ระดับการศึกษา"
                                            data-allow-clear="false" multiple>
                                            <option value="1"> ต่ำกว่าป.ตรี </option>
                                            <option value="2"> ป.ตรี </option>
                                            <option value="3"> ป.โท </option>
                                            <option value="4"> ป.เอก </option>
                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                        </fieldset><!-- /.fieldset -->

                        <!-- .fieldset -->
                        <fieldset>
                            <legend>ข้อมูลการชำระเงิน</legend> <!-- .form-group -->
                            <div class="row">
                                <!-- grid column -->
                                <div class="col-md-6">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="paymentstatus">ชำระค่าลงทะเบียน</label>
                                        <select id="paymentstatus" name="paymentstatus" class="form-control"
                                            data-toggle="select2" data-placeholder="ชำระค่าลงทะเบียน"
                                            data-allow-clear="false"
                                            onchange="if(this.value==1) $('.showpayment').removeClass('d-none'); else $('.showpayment').addClass('d-none');">
                                            <option value="0" {{ $cour->paymentstatus == 0 ? 'selected' : '' }}>ไม่มีค่าลงทะเบียน </option>
                                            <option value="1" {{ $cour->paymentstatus == 1 ? 'selected' : '' }}>มีค่าลงทะเบียน </option>
                                 
                                
                                        </select>
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6">
                                    <div class="form-group showpayment d-none ">
                                        <label for="person_type">ราคาหลักสูตร (บาท) </label>
                                        <input type="text" class="form-control number" name="price" id="price"
                                            placeholder="ราคาหลักสูตร (บาท)" value="{{$cour->price}}" />
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                            <div class="row d-none   d-none">
                                <div class="col-md-6">
                                    <!-- .form-group -->
                                    <div class="form-group">
                                        <label class="control-label" for="paymentmethod">ค่าลงทะเบียน</label>
                                        <!-- .list-group-item -->
                                        <div class="custom-control  custom-checkbox">
                                            <label
                                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                                    type="checkbox" name="paymentmethod" value="1"
                                                    class="switcher-input"> <span
                                                    class="switcher-indicator"></span></label>
                                            <!-- /.switcher-control -->
                                            <span> ชำระเงิน Payin slip</span> <!-- .switcher-control -->
                                        </div><!-- /.list-group-item -->
                                        <!-- .list-group-item -->

                                        <!-- .list-group-header -->
                                    </div><!-- /.form-group -->
                                </div><!-- /grid column -->
                            </div>
                            <div class="row showpayment d-none">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label class="control-label" for="paymentdetail">ข้อมูลการชำระเงิน</label>
                                        <textarea class="ckeditor" data-placeholder="ข้อมูลการชำระเงิน" data-height="200" id="paymentdetail"
                                            name="paymentdetail"> {{$cour->paymentdetail}}</textarea>
                                    </div>
                                </div><!-- /grid column -->

                            </div><!-- /grid row -->
                        </fieldset><!-- /.fieldset -->
                        <fieldset class=" showpayment d-none">

                            <legend>ส่วนลด</legend> <!-- .form-group -->

                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="">ส่วนลด</label> <select id="discount"
                                            name="discount" class="form-control" data-toggle="select2"
                                            data-placeholder="ส่วนลด" data-allow-clear="false"
                                            onchange="if(this.value==1) $('.showdiscount').removeClass('d-none'); else $('.showdiscount').addClass('d-none');">
                                            <option value="0"  {{ $cour->discount == 0 ? 'selected' : '' }}>ไม่มีส่วนลด </option>
                                            <option value="1"  {{ $cour->discount == 1 ? 'selected' : '' }}>มีส่วนลด </option>
                                          
                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                                <div class="col-md-6 showdiscount d-none">
                                    <div class="form-group">
                                        <label class="control-label" for="">ประเภทการลด</label> <select
                                            id="discount_type" name="discount_type" class="form-control"
                                            data-toggle="select2" data-placeholder="ส่วนลด" data-allow-clear="false">
                                            <option value="percent"  {{ $cour->discount_type == 'percent' ? 'selected' : '' }}>เปอร์เซ็นต์ </option>
                                            <option value="price"  {{ $cour->discount_type == 'price' ? 'selected' : '' }}>ราคาบาท </option>
                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                            <div class="row">
                                <div class="col-md-12 showdiscount d-none">
                                    <div class="form-group">
                                        <table>
                                            <tr>
                                                <td>ทั่วไป</td>
                                                <td><input type="text" class="form-control" name="discount_data[0]"
                                                        id="discount_data0" placeholder="ทั่วไป " value="" /></td>
                                            </tr>
                                            <tr class="showrow d-none" id="showrow1">
                                                <td>ข้าราชการธุรการ</td>
                                                <td><input type="text" class="form-control number"
                                                        name="discount_data[1]" id="discount_data1"
                                                        placeholder="ส่วนลด ข้าราชการธุรการ" value="" /></td>
                                            </tr>
                                            <tr class="showrow d-none" id="showrow2">
                                                <td>พนักงานอัยการ</td>
                                                <td><input type="text" class="form-control number"
                                                        name="discount_data[2]" id="discount_data2"
                                                        placeholder="ส่วนลด พนักงานอัยการ" value="" /></td>
                                            </tr>
                                            <tr class="showrow d-none" id="showrow3">
                                                <td>บุคลากรภายนอก</td>
                                                <td><input type="text" class="form-control number"
                                                        name="discount_data[3]" id="discount_data3"
                                                        placeholder="ส่วนลด บุคลากรภายนอก" value="" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div><!-- /grid column -->

                            </div><!-- /grid row -->

                        </fieldset><!-- /.fieldset -->
                        <fieldset class=" showpayment d-none">

                            <legend>วิธีการชำระเงิน Payin slip</legend> <!-- .form-group -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="">ธนาคาร</label> <select id="bank"
                                            name="bank" class="form-control" data-toggle="select2"
                                            data-placeholder="ธนาคาร" data-allow-clear="false">
                                            <option value="0"  {{ $cour->bank == 0 ? 'selected' : '' }}>เลือกธนาคาร </option>
                                            <option value="ktb"  {{ $cour->bank == 'ktb' ? 'selected' : '' }}>ธนาคารกรุงไทย </option>
                                        </select>
                                    </div>
                                </div><!-- /grid column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_type">Comp Code </label>
                                        <input type="text" class="form-control number" name="compcode" id="compcode"
                                            placeholder="Comp Code" value="{{$cour->compcode}}" />
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_type">Tax ID </label>
                                        <input type="text" class="form-control number" name="taxid" id="taxid"
                                            placeholder="Tax ID" value="{{$cour->taxid}}" />
                                    </div>
                                </div><!-- /grid column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="person_type">Suffix Code</label>
                                        <input type="text" class="form-control number" name="suffixcode"
                                            id="suffixcode" placeholder="Suffix Code" value="{{$cour->suffixcode}}" maxlength="3" />
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->

                        </fieldset><!-- /.fieldset -->

                        <!-- .fieldset -->
                        <fieldset>
                            <legend>รูปแบบใบประกาศนียบัตร</legend> <!-- .form-group -->
                            <!-- grid row -->
                            <div class="row">
                                <!-- grid column -->
                                <div class="col-xl-4 col-lg-4 col-sm-6">
                                    <!-- .card -->
                                    <div class="card card-figure">
                                        <!-- .card-figure -->
                                        <figure class="figure">
                                            <img class="img-fluid" src="{{ Storage::disk('external')->url('cer/certificate_1.png') }}"
                                                alt="ใบประกาศนียบัตร  1 " style="cursor:zoom-in"
                                                onclick="$('#previewimage').prop('src',$(this).prop('src'));$('#modal01').css('display','block');">
                                            <!-- .figure-caption -->
                                            <figcaption class="figure-caption">
                                                <h6 class="figure-title"> ใบประกาศนียบัตร 1 </h6>
                                                <p class="text-muted mb-0 ">
                                                <div class="custom-control custom-radio text-center"><input type="radio"
                                                        class="custom-control-input" name="templete_certificate"
                                                        id="certificate1" value="1"> <label
                                                        class="custom-control-label" for="certificate1"></label></div>
                                                </p>
                                            </figcaption><!-- /.figure-caption -->
                                        </figure><!-- /.card-figure -->
                                    </div><!-- /.card -->
                                </div><!-- /grid column -->
                                <!-- grid column -->
                            </div><!-- /grid row -->
                            <div id="modal01" class="w3-modal" onclick="this.style.display='none'">
                                <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">×</span>
                                <div class="w3-modal-content w3-animate-zoom">
                                    <img src="{{ Storage::disk('external')->url('cer/certificate_1.png') }}" style="width:100%"
                                        id="previewimage">
                                </div>
                            </div>
                            <!-- grid column -->
                            <div class="col-xl-4 col-lg-4 col-sm-6  d-none">
                                <!-- .card -->
                                <div class="card card-figure">
                                    <!-- .card-figure -->
                                    <figure class="figure"><img class="img-fluid"
                                            src="https://aced.dlex.ai/childhood/admin/" alt="ใบประกาศนียบัตร  6 "
                                            style="cursor:zoom-in"
                                            onclick="$('#previewimage').prop('src',$(this).prop('src'));$('#modal01').css('display','block');">
                                        <!-- .figure-caption -->
                                        <figcaption class="figure-caption">
                                            <h6 class="figure-title"> ใบประกาศนียบัตรกำหนดเอง </h6>
                                            <p class="text-muted mb-0 ">
                                            <div class="custom-control custom-radio text-center"><input type="radio"
                                                    class="custom-control-input" name="templete_certificate"
                                                    id="certificate6" value="6"> <label class="custom-control-label"
                                                    for="certificate6"></label></div>
                                            </p>
                                        </figcaption><!-- /.figure-caption -->
                                    </figure><!-- /.card-figure -->
                                </div><!-- /.card -->
                            </div><!-- /grid column -->
                            <!-- grid column -->
                            <!-- /grid row -->
                            <div class="form-group">
                                <label for="cert_custom">เพิ่มรูปแบบใบประกาศนียบัตร </label> <input type="file"
                                    class="form-control" id="cert_custom" name="cert_custom"
                                    placeholder="ใบประกาศนียบัตร	" accept="image/*">
                            </div><!-- /.form-group -->
                        </fieldset><!-- /.fieldset -->
                        <fieldset>
                            <legend>ข้อมูลใบประกาศนียบัตร</legend> <!-- .form-group -->
                            <div class="row ">
                                <!-- grid column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="days">ชื่อ-นามสกุล</label> <input
                                            type="text" class="form-control" name="signature_name"
                                            id="signature_name" placeholder="ชื่อ-นามสกุล" value="{{$cour->signature_name}}" />
                                    </div>
                                </div><!-- /grid column -->
                                <!-- grid column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="hours">ตำแหน่ง</label> <input type="text"
                                            class="form-control" name="signature_position" id="signature_position"
                                            placeholder="ตำแหน่ง" value="{{$cour->signature_position}}" />
                                    </div>
                                </div><!-- /grid column -->
                            </div><!-- /grid row -->
                            <div class="form-group">
                                <label for="signature">ลายเซ็นต์ </label> <input type="file" class="form-control"
                                    id="signature" name="signature" placeholder="ลายเซ็นต์" accept="image/*">
                            </div><!-- /.form-group -->
                        </fieldset><!-- /.fieldset -->
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
