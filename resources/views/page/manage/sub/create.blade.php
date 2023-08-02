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

   

    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">
                    <a href="{{ route('learn',['department_id' => $depart]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a>
                    / <a href="{{route('suppage',['department_id' => $depart])}}"
                        style="text-decoration: underline;">จัดการวิชา</a>

                </div>

                <form action="{{route('substore',['department_id' => $depart])}}" method="post" enctype="multipart/form-data">
                    @csrf 
                <div class="card-body">
                    <div class="form-group">
                        <label for="subject_code ">รหัสวิชา</label>
                        <input type="text" class="form-control " name="subject_code" placeholder="รหัสวิชา"
                            value="">
                    </div>
                    @error('subject_code')
                    <span class="badge badge-warning">{{ $message }}</span>
                @enderror
                    <div class="form-group">
                        <label for="subject_th">วิชา (ไทย)
                            <span class="badge badge-warning">Required</span></label>
                        <input type="text" class="form-control" name="subject_th" placeholder="วิชา (ไทย)" required=""
                            value="">
                    </div>
                    @error('subject_th')
                    <span class="badge badge-warning">{{ $message }}</span>
                @enderror
                    <div class="form-group">
                        <label for="subject_en">วิชา (อังกฤษ) </label>
                        <input type="text" class="form-control" name="subject_en" placeholder="วิชา (อังกฤษ)"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="banner">ภาพแบนเนอร์ </label>
                        <input type="file" class="form-control" id="banner" name="banner" placeholder="ภาพแบนเนอร์"
                        accept="image/*">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="learn_format">รูปแบบการเรียน </label> <select 
                                    name="learn_format" class="form-control" data-toggle="select2"
                                    data-placeholder="รูปแบบการเรียน" data-allow-clear="false">
                                    <option value="0">อิสระ </option>
                                    <option value="1">ตามลำดับ </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="">การประเมินผล </label>
                                <select  name="evaluation" class="form-control" data-toggle="select2"
                                    data-placeholder="การประเมินผล" data-allow-clear="false">
                                    <option value="1"> เกณฑ์คะแนน </option>
                                    <option value="2"> เกณฑ์เวลาเรียน </option>
                                    <option value="3"> เกณฑ์คะแนนและเวลาเรียน </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="checkscore">เกณฑ์คะแนน</label>
                                <select id="checkscore" name="checkscore" class="form-control  " data-toggle="select2"
                                    data-placeholder="เกณฑ์คะแนน" data-allow-clear="false">
                                    <option value="0"> กำหนดคะแนน</option>
                                    @for ($score = 1; $score <= 100; $score++)
                                    @if ($score == 70)
                                        <option value="{{ $score }}" selected>{{ $score }}</option>
                                    @else
                                        <option value="{{ $score }}">{{ $score }}</option>
                                    @endif
                                @endfor
                            </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_en">ผู้สอน</label>
                                <select id="teacher" name="teacher[]" class="form-control" data-toggle="select2"
                                    data-placeholder="ผู้สอน" data-allow-clear="false" multiple>
                                    <option value="0">เลือกผู้สอน </option>
                                    <option value="24130"> สำนักงาน ป.ป.ช. </option>
                                    <option value="24131"> สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="department_id" name="department_id" value="12">
                    <div class="form-group d-none">
                        <label class="control-label" for="department_id">หมวดหมู่</label>
                        <select id="department_ids" name="department_ids" class="form-control" data-toggle="select2"
                            data-placeholder="กระทรวง กรม/สำนัก" data-allow-clear="false">
                            <option value="12"> สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subject_status">สถานะ </label>
                        <label class="switcher-control switcher-control-success switcher-control-lg">
                            <input type="checkbox" class="switcher-input" name="subject_status" id="subject_status"
                                value="1"> <span class="switcher-indicator"></span>
                            <span class="switcher-label-on">ON</span> <span class="switcher-label-off text-red">OFF</span>
                        </label>
                    </div>



                </div>
               
            </div>
            <div class="form-actions ">
                <button class="btn btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i> บันทึก</button>
            </div>
        </form>
        </div>
    </div>
 
@endsection
