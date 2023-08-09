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
                <div class="card-header bg-muted">หน่วยงาน</div>
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <table id="datatable2" class="table w3-hoverable">
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> รหัส </th>
                                    <th class="align-middle" style="width:30%"> หมวดหมู่ </th>
                                    <th class="align-middle" style="width:2%"> กระทำ </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department as $depart)
                                    <tr>
                                        <td><a href="{{ route('learn', ['department_id' => $depart->department_id]) }}">
                                                {{ $depart->name_short_en }}</a>
                                        </td>
                                        <td><a href="{{ route('learn', ['department_id' => $depart->department_id]) }}">
                                                {{ $depart->name_th }}</a>
                                        </td>
                                        <td class="align-middle">
                                            <a
                                                href="{{ route('departmentedit', ['department_id' => $depart->department_id]) }}">
                                                <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <header class="page-title-bar">
            <button type="button" class="btn btn-success btn-floated btn-add"
                onclick="window.location='{{ route('departmentcreate') }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
        </header>
        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
