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
                <div class="card-header bg-muted"><span class="menu-icon fas fa-globe  "></span>
                    จัดการเว็บ</div>
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <table id="datatable2" class="table w3-hoverable">
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> รหัส </th>
                                    <th class="align-middle" style="width:30%"> หมวดหมู่ </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:2%"> กระทำ </th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if ($data->user_role == 1)
                                    <tr>
                                        <td><a href="{{ route('dataci') }}">
                                                DPM</a>
                                        </td>
                                        <td><a href="{{ route('dataci') }}">
                                                จัดการDepartment LOGO / IMAGE</a>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>

                                    </tr>
                                @endif --}}
                                @foreach ($department->sortBy('department_id') as $depart)
                                    @php
                                        $userdepart = \App\Models\UserDepartment::where('user_id', $data->user_id)
                                            ->where('department_id', $depart->department_id)
                                            ->first();
                                    @endphp
                                    @if (
                                        ($userdepart && ($data->user_role == 3 || $data->user_role == 6 || $data->user_role == 7)) ||
                                            ($data->user_role == 1 || $data->user_role == 8))
                                        <tr>
                                            <td><a
                                                    href="{{ route('manage', ['department_id' => $depart->department_id]) }}">
                                                    {{ $depart->name_short_en }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('manage', ['department_id' => $depart->department_id]) }}">
                                                    {{ $depart->name_th }}</a>
                                            </td>
                                            <td class="align-middle">
                                                @if ($data->user_role == 1 || $data->user_role == 8)
                                                    <label
                                                        class="switcher-control switcher-control-success switcher-control-lg">
                                                        <input type="checkbox" class="switcher-input switcher-edit"
                                                            {{ $depart->department_status == 1 ? 'checked' : '' }}
                                                            data-department-id="{{ $depart->department_id }}">
                                                        <span class="switcher-indicator"></span>
                                                        <span class="switcher-label-on">ON</span>
                                                        <span class="switcher-label-off text-red">OFF</span>
                                                    </label>
                                                @endif
                                            </td>
                                            <script>
                                                $(document).ready(function() {
                                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                        var department_status = $(this).prop('checked') ? 1 : 0;
                                                        var department_id = $(this).data('department-id');
                                                        console.log('department_status:', department_status);
                                                        console.log('department_id:', department_id);
                                                        $.ajax({
                                                            type: "GET",
                                                            dataType: "json",
                                                            url: '{{ route('changeStatusDepart') }}',
                                                            data: {
                                                                'department_status': department_status,
                                                                'department_id': department_id
                                                            },
                                                            success: function(data) {
                                                                console.log(data.message); // แสดงข้อความที่ส่งกลับ
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.log('ข้อผิดพลาด');
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <td class="align-middle">
                                                <a
                                                    href="{{ route('departmentedit', ['from' => $from, 'department_id' => $depart->department_id]) }}">
                                                    <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        @if ($data->user_role == 1 || $data->user_role == 8)
            <header class="page-title-bar">
                <button type="button" class="btn btn-success btn-floated btn-add"
                    onclick="window.location='{{ route('departmentcreate', ['from' => $from]) }}'" data-toggle="tooltip"
                    title="เพิ่ม"><span class="fas fa-plus"></span></button>
            </header>
        @endif
        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
