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



    <div class="card-body">
        <!-- .table-responsive -->
        <fieldset>
            <legend style="font-size: 20px;">คลังแบบฝึกหัด/แบบทดสอบ</legend>

            @include('page.manage.sub.exam.dataexam.exam1')
        </fieldset>
        <fieldset>
            <legend style="font-size: 20px;">แบบฝึกหัด</legend>
            @include('page.manage.sub.exam.dataexam.exam3')
        </fieldset>

        <fieldset>
            <legend style="font-size: 20px;">แบบทดสอบ</legend>
            @include('page.manage.sub.exam.dataexam.exam2')
        </fieldset>


        <br>
    </div><!-- /.card-body -->
@endsection
