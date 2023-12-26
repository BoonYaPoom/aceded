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
                <div class="card-header bg-muted">คำขอย้ายหน่วยงาน และ คำขอแก้ใบประกาศ</div>
                <div class="card-body">
                    <!-- .table-responsive -->
                    <fieldset>
                        <legend style="font-size: 20px;">คำขอย้ายหน่วยงาน</legend>

                        @include('layouts.department.item.data.request.CerAndDepart.item.table1')
                    </fieldset>
                    <fieldset>
                        <legend style="font-size: 20px;">คำขอแก้ใบประกาศ</legend>
                        @include('layouts.department.item.data.request.CerAndDepart.item.table2')
                    </fieldset>
                    <br>
                </div><!-- /.card-body -->
            </div>
        </div>

    </div>
@endsection