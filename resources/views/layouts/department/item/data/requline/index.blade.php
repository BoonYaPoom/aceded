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
                <div class="card-header bg-muted">คำขอสมัคร Admin สถานศึกษา</div>
                <div class="card-body">
                    <!-- .table-responsive -->
                    <form action="{{ route('uploadPdf') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="pdf_file">logo <small class="text-muted"></small> </label>
                            <input type="file" class="form-control" name="pdf_file" placeholder="logo" accept="pdf/*">
                        </div><!-- /.form-group -->
                        <div class="form-actions">
                            <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                                บันทึก</button>
                        </div><!-- /.form-actions -->
                    </form>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
