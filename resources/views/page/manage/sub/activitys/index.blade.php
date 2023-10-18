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

    <!-- .card-body -->
    <div class="card-body">

        <!-- .table-responsive -->
        <div class="table-responsive">
            <!-- .table -->
            <table id="datatable2" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:10%"> ลำดับ </th>
                        <th class="align-middle" style="width:80%"> รายการ </th>
                        <th class="align-middle" style="width:10%"> กระทำ </th>
                    </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>
                    <!-- tr -->
                    <tr>
                        <td><a href="">1</a></td>
                        <td><a>แบบสำรวจ</a></td>
                        <td><a href="{{ route('surveyact', [$depart,$subs->subject_id]) }}"><i
                                    class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                        </td>
                    </tr><!-- /tr -->
                    <!-- tr -->
                    <tr>
                        <td><a href="#">2</a></td>
                        <td><a>กระดานสนทนา</a></td>
                        <td><a href="{{ route('categoryac', [$depart,$subs->subject_id]) }}"><i
                                    class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                        </td>
                    </tr><!-- /tr -->
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->
@endsection
