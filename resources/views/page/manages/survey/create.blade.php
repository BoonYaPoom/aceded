@extends('layouts.adminhome')
@section('content')
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('surveypage') }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> /
                    <i> เพิ่มแบบสำรวจ</i>
                </div><!-- /.card-header -->
                <form action="{{ route('storesurvey') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_th">ชื่อ </label> <input type="text" class="form-control" id="survey_th"
                                name="survey_th" placeholder="ชื่อ (ไทย)" required="" value="">
                        </div><!-- /.form-group -->
                        @error('survey_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="survey_en">ชื่อ (อังกฤษ) </label> <input type="text" class="form-control"
                                id="survey_en" name="survey_en" placeholder="ชื่อ (อังกฤษ)" value="">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="detail_th">รายละเอียด </label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด" data-height="200" name="detail_th"></textarea>
                        </div><!-- /.form-group -->
                        @error('detail_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->

                        <div class="row">
                            <div class="form-group">
                                <label class="control-label" for="survey_type">ภาษา</label>
                                <select id="survey_type" name="survey_type" class="form-control" data-toggle="select2"
                                    data-placeholder="ภาษา" data-allow-clear="false">
                                    <option value="1">TH </option>
                                    <option value="2">EN </option>
                                </select>
                            </div><!-- /.form-group -->
                        </div>

                        <div class="form-group">
                            <label for="survey_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="survey_status" id="survey_status"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span></label>
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
