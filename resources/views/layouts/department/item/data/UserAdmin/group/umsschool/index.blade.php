@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->

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
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a
                        href="{{ route('DPUserManage', [$depart]) }}">ผู้ใช้งาน</a> / <a
                        href="{{ route('umsschooldepartment', [$depart]) }}">จัดการสถานศึกษาของ ระดับ {{$depart->name_th}}</a>
                </div>
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">

                            <div class="dataTables_filter text-right">
                                <label>ค้นหา
                                    <input type="search" id="myInput" class="form-control" placeholder=""
                                        aria-controls="datatable">
                                </label>
                                @if ($data->user_role == 1 || $data->user_role == 8)
                                    <label>จังหวัด
                                        <select id="drop2" name="drop2" class="form-control form-control-sm"
                                            data-allow-clear="false">
                                            <option value="0"selected>ทั้งหมด</option>
                                            @php
                                                $Provinces = \App\Models\Provinces::all();
                                            @endphp
                                            @foreach ($Provinces as $provin)
                                                <option value="{{ $provin->name_in_thai }}"> {{ $provin->name_in_thai }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </label>

                                @endif
                            </div>

                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ</th>
                                    <th>สถานศึกษา</th>
                                    <th width="8%">จังหวัด</th>
                                    <th width="8%">จำนวน</th>
                                    <th width="8%">เพิ่มสมาชิก</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php
                                    $i = 1;

                                @endphp
                                <!-- tr -->
                                @foreach ($school as $scho)
                                    @php

                                        $proviUser = \App\Models\Provinces::where('id', $scho->provinces_id)
                                            ->pluck('name_in_thai')
                                            ->first();

                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $scho->school_name }}</td>
                                        <td>{{ $proviUser }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('umsschooluserDepart', ['department_id' => $depart, 'school_code' => $scho->school_code]) }}">
                                                <i class="fas fa-users"></i>

                                            </a></td>

                                        <td class="text-center"><a
                                                href="{{ route('umsschooluserDepart', ['department_id' => $depart, 'school_code' => $scho->school_code]) }}"><i
                                                    class="fas fa-user-plus"></i></a></td>

                                        <td class="text-center">
                                            @if ($data->user_role == 1 || $data->user_role == 7 || $data->user_role == 8)
                                                <a href="{{ route('editschoolDepart', ['department_id' => $depart, 'school_id' => $scho->school_id]) }}"
                                                    data-toggle="tooltip" title="แก้ไข"><i
                                                        class="far fa-edit fa-lg text-success mr-3"></i></a>
                                                <a href="{{ route('deleteschoolDepart', ['school_id' => $scho->school_id]) }}"
                                                    onclick="deleteRecord(event)" rel="" class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ">
                                                    <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            @else
                                                <a href="{{ route('editschoolDepart', [ $depart,'school_id' => $scho->school_id]) }}"
                                                    data-toggle="tooltip" title="แก้ไข"><i
                                                        class="far fa-edit fa-lg text-success mr-3"></i></a>
                                            @endif
                                        </td>

                                    </tr><!-- /tr -->
                                @endforeach


                                <!-- tr -->
                                <script>
                                    $(document).ready(function() {
                                        var table = $('#datatable').DataTable({

                                            lengthChange: false,
                                            responsive: true,
                                            info: false,
                                            language: {
                                                infoEmpty: "ไม่พบรายการ",
                                                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                                paginate: {
                                                    first: "หน้าแรก",
                                                    last: "หน้าสุดท้าย",
                                                    previous: "ก่อนหน้า",
                                                    next: "ถัดไป" // ปิดการแสดงหน้าของ DataTables
                                                }
                                            }

                                        });

                                        $('#drop2').on('change', function() {
                                            var selecteddrop2Id = $(this).val();
                                            if (selecteddrop2Id == 0) {
                                                table.columns(2).search('').draw();
                                            } else {
                                                // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                                                table.columns(2).search(selecteddrop2Id).draw();
                                            }
                                        });
                                        $('#myInput').on('keyup', function() {
                                            table.search(this.value).draw();
                                        });
                                    });
                                </script>

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <input type="hidden" id="useruser_role" name="useruser_role">
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <button type="button" class=" btn btn-success btn-floated btn-addums"
                onclick="window.location='{{ route('createschoolDepart', ['department_id' => $depart->department_id]) }}'"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
