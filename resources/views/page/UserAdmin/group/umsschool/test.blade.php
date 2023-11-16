@extends('layouts.adminhome')
@section('content')
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
                <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a> / <a
                        href="{{ route('schoolManage') }}">จัดการสถานศึกษา</a></div>
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
                                <label>จังหวัด
                                    <select id="drop2" name="drop2" class="form-control" data-allow-clear="false">
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
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable').DataTable({
                                        serverSide: true,
                                        processing: true,
                                        ajax: {

                                            url: '{{ route('getSchools') }}',
                                            dataType: 'json',
                                            data: function(d) {
                                                d.user_role = 'your_user_role_value'; 
                                            },
                                            dataSrc: 'dataall'

                                            
                                        },
                                        
                                        columns: [{
                                                data: 'num'
                                            },
                                            {
                                                data: 'school_name'
                                            },
                                            {
                                                data: 'province_name'
                                            },
                                            {
                                                data: 'userCount',
                                                render: function(data, type, row) {

                                                    var link = '<i class="fas fa-users"></i> (' + data + ')';
                                                    return link;
                                                }
                                            },
                                            {
                                                data: null,
                                                render: function(data, type, row) {

                                                    var schoolcode = data.code;
                                                    var url =
                                                        "{{ route('umsschooluser', ['school_code' => 'schoolcode']) }}";
                                                    url = url.replace('schoolcode', schoolcode);

                                                    var link = '<a href="' + url + '"><i class="fas fa-user-plus"></i></a>';
                                                    return link;
                                                },
                                            },
                                            {
                                                data: null,
                                                render: function(data, type, row) {

                                                    var schoolId = data.id;

                                                    var deleteschool =
                                                        "{{ route('deleteschool', ['school_id' => 'schoolId']) }}";
                                                    deleteschool = deleteschool.replace('schoolId', schoolId);

                                                    var editschool =
                                                        "{{ route('editschool', ['school_id' => 'schoolId']) }}";
                                                    editschool = editschool.replace('schoolId', schoolId);

                                                    var linkb = '<a href="' + editschool +
                                                        '" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit fa-lg text-success mr-3"></i></a>';
                                                    var linkc = '<a href="' + deleteschool +
                                                        '" onclick="deleteRecord(event)" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning"></i></a>';
                                                    return linkb + linkc;

                                                },

                                            },
                                        ],

                                        lengthChange: false,
                                        responsive: true,
                                        info: false,

                                        pageLength: 20,
                                        scrollY: '100%',

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
                                    console.log('{{route('getSchools')}}');
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
                onclick="window.location='{{ route('createschool') }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
