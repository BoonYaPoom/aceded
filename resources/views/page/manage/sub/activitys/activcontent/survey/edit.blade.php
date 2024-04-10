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


    <!-- .page-inner -->
    <form action="{{ route('Updatesuy', [$depart,'survey_id' => $suruy]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

      
                    <div class="card-header bg-muted"> <a
                        href="{{ route('surveyact', [$depart,$subs->subject_id]) }}" style="text-decoration: underline;">
                        {{ $suruy->survey_th }}</a></div><!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_th">ชื่อ (ไทย) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="survey_th" name="survey_th"
                                placeholder="ชื่อ (ไทย)" required="" value="{{ $suruy->survey_th }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="survey_en">ชื่อ (อังกฤษ) </label> <input type="text" class="form-control"
                                id="survey_en" name="survey_en" placeholder="ชื่อ (อังกฤษ)" value="{{ $suruy->survey_en }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th">{{  html_entity_decode($suruy->detail_th, ENT_QUOTES, 'UTF-8') }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en">{{  html_entity_decode($suruy->detail_en, ENT_QUOTES, 'UTF-8') }}</textarea>
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
                        <div class="form-actions ">
                            <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                                บันทึก</button>
                        </div>
                    </div><!-- /.card-body -->
    
    </form>
@endsection
