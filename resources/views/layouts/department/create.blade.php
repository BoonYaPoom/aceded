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

 

    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <div class="card-header bg-muted"><a href="{{ route('departmentpage') }}"
                        style="text-decoration: underline;">หน่วยงาน</a>  </div><!-- /.card-header -->
                <form action="{{ route('departmentstore') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="name_th">หน่วยงาน (th)</label>
                            <input type="text" class="form-control" name="name_th" placeholder="หน่วยงาน"
                                required="" value="">
                        </div><!-- /.form-group -->
                        @error('name_th')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                        <div class="form-group">
                            <label for="name_en">หน่วยงาน (en)</label>
                            <input type="text" class="form-control" name="name_en" placeholder="หน่วยงาน"
                                 value="">
                        </div><!-- /.form-group -->
                        @error('name_en')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                        <div class="form-group">
                            <label for="name_short_en">URL (EN)</label>
                            <input type="text" class="form-control" name="name_short_en" placeholder="URL (EN)"
                                required="" value="">
                        </div><!-- /.form-group -->
                      
                        @error('name_short_en')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                   
                        <div class="form-group">
                            <label for="name_short_th">ภาพปก </label>
                            <input type="file" class="form-control" name="name_short_th" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                      
                        @error('name_short_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
    
                        <!-- .form-actions -->
                        <div class="form-group">
                            <label for="department_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="department_status" id="department_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                   
            </div><!-- /.card -->

            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
        </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->


@endsection
