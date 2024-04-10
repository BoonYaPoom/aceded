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
    <form action="{{ route('categoryform_update', [$depart,'category_id' => $catac]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header bg-muted"><a href="{{ route('categoryac', [$depart,$subs->subject_id]) }}"
            style="text-decoration: underline;">กระดานสนทนา {{ $catac->category_th }}</a></div><!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="category_th" name="category_th"
                                placeholder="ชื่อหมวด (ไทย)" required="" value="{{ $catac->category_th }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label> <input type="text" class="form-control"
                                id="category_en" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)"
                                value="{{ $catac->category_en }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th">
{{  html_entity_decode($catac->detail_th , ENT_QUOTES, 'UTF-8') }}
             
                        </textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en">
                            {{ $catac->detail_en }}
                        </textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"
                                    {{ $catac->recommended == 1 ? 'checked' : '' }}> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="category_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="category_status" id="category_status" value="1"
                                    {{ $catac->category_status == 1 ? 'checked' : '' }}> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                    
                <!-- .form-actions -->
                <div class="form-actions">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
                </div><!-- /.card -->

        
    </form>
@endsection
