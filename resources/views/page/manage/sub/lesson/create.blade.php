@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('lessonpage', [$subs->subject_id]) }}"
                        style="text-decoration: underline;">จัดการวิชา</a> / <i>เพิ่ม</i>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('storeless', ['subject_id' => $subs]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_number">ลำดับ </label> <input type="text" class="form-control"
                                name="lesson_number" placeholder="ลำดับ" value="">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_th">ชื่อเรื่อง (ไทย) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="lesson_th" name="lesson_th"
                                placeholder="ชื่อเรื่อง (ไทย)" required="" value="">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_en">ชื่อเรื่อง (อังกฤษ) </label> <input type="text" class="form-control"
                                name="lesson_en" placeholder="ชื่อเรื่อง (อังกฤษ)" value="">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="description">คำอธิบายบทเรียน</label>
                            <textarea class="ckeditor" data-placeholder="คำอธิบายบทเรียน" data-height="200" name="description"></textarea>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="resultlesson">สิ่งที่ได้รับจากบทเรียน</label>
                            <textarea class="ckeditor" data-placeholder="สิ่งที่ได้รับจากบทเรียน" data-height="200" name="resultlesson"></textarea>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label class="control-label" for="content_type">รูปแบบบทเรียน(ชนิดสื่อ)</label>
                            <select name="content_type" class="form-control" data-toggle="select2"
                                data-placeholder="ชนิดสื่อ" data-allow-clear="false">
                                @foreach ($content_types as $content_type)
                                    <option value="{{ $content_type->content_type }}">{{ $content_type->content_th }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_status">สถานะหัวข้อ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="lesson_status" value="1"> <span
                                    class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="exercise">แบบฝึกหัดท้ายบท </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="exercise" value="1">
                                <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                        <!-- /.form-group -->
                        <!-- .fieldset -->

                    </div><!-- /.card-body -->
                    
            </div>
            <!-- .form-actions -->
            <div class="form-actions ">
                <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
        </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
