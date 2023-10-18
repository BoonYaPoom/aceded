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

    <input type="hidden" name="__csrf_token_name" value="225bd5aba22c8abe72991fc1b8c4b96c" />
    <!-- .page-inner -->
    <form action="{{ route('storesuySupject', [$depart,'subject_id' => $subs]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a href="{{ route('activitypage', [$depart,$subs->subject_id]) }}"
                            style="text-decoration: underline;">หมวดหมู่</a> / <a
                            href="{{ route('surveyact', [$depart,$subs->subject_id]) }}"
                            style="text-decoration: underline;">จัดการวิชา</a> / <a
                            href="{{ route('surveyact', [$depart,$subs->subject_id]) }}" style="text-decoration: underline;">
                            แบบสำรวจ</a></div><!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_th">ชื่อ (ไทย) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="survey_th" name="survey_th"
                                placeholder="ชื่อ (ไทย)" required="" value="">
                        </div><!-- /.form-group -->

                        @error('survey_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_en">ชื่อ (อังกฤษ) </label> <input type="text" class="form-control"
                                id="survey_en" name="survey_en" placeholder="ชื่อ (อังกฤษ)" value="">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        @error('detail_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="survey_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="survey_status" id="survey_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
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
