@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('surveypage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> / <i> แก้ไข {{ $sur->survey_th }}</i></div><!-- /.card-header -->
                <form action="{{ route('updatesur', ['department_id' => $depart,'survey_id' => $sur->survey_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_th">ชื่อ <span class="badge badge-warning">Required</span></label> <input
                                type="text" class="form-control" id="survey_th" name="survey_th" placeholder="ชื่อ (ไทย)"
                                required="" value="{{ $sur->survey_th }}">
                        </div><!-- /.form-group -->
                        @error('survey_th')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="survey_en">ชื่อ (อังกฤษ) </label> <input type="text" class="form-control"
                                id="survey_en" name="survey_en" placeholder="ชื่อ (อังกฤษ)" value="">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด </label>
                            <textarea class="editor" data-placeholder="รายละเอียด" data-height="200" name="detail_th"
                                value="{{ $sur->detail_th }}">{{ $sur->detail_th }}</textarea>
                        </div><!-- /.form-group -->
                        @error('detail_th')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on" {{ $sur->recommended == 1 ? 'checked' : '' }}>ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label" for="survey_lang">ภาษา</label>
                                <select id="survey_lang" name="survey_lang" class="form-control" data-toggle="select2"
                                    data-placeholder="ภาษา" data-allow-clear="false">
                                    <option value="th">TH </option>
                                    <option value="en">EN </option>
                                </select>
                            </div><!-- /.form-group -->
                        </div>
                        <div class="form-group">
                            <label for="survey_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="survey_status" id="survey_status"
                                    value="1"  {{ $sur->survey_status == 1 ? 'checked' : '' }}>
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
