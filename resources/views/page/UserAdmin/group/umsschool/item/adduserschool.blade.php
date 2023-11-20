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

                <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a>/ <a
                        href="{{ route('schoolManage') }}">จัดการสถานศึกษา</a>/ {{ $school->school_name }}</div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="datatable" class="table w3-hoverable">
                            <div class="dataTables_filter text-right">
                                <label>ค้นหา
                                    <input type="search" id="myInput" class="form-control" placeholder=""
                                        aria-controls="datatable">
                                </label>
                            </div>

                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ </th>
                                    <th width="20%">รหัสผู้ใช้</th>
                                    <th>ชื่อ สกุล</th>
                                    <th>ระดับ</th>
                                    <th width="20%">กลุ่มผู้ใช้งาน </th>

                                </tr>
                            </thead>

                            <tbody>
                                @include('page.UserAdmin.group.umsschool.item.viewuser')
                            </tbody>



                        </table>


                    </div>

                    <form method="POST" action="{{ route('saveSelectedSchool', ['school_code' => $school->school_code]) }}">
                        @csrf

                        <div class="table-responsive">
                            <div class="input-group mb-3">
                                <form action="" method="post" action="/admin/ums/umsgroupuser/1">
                                    <input type="text" class="form-control" name="search" id="searchNa"
                                        aria-describedby="search" placeholder="ค้นหาโดยการพิมพ์ ชื่อ สกุล " value="">

                                </form>
                            </div>
                            @include('page.UserAdmin.group.umsschool.item.adduser')

                        </div>
                    </form>
                    <!-- tr -->
                </div>
            </div>
        </div>
    </div>
        <script>
            $(function() {
                $("#checkall").click(function() {
                    $('.custom-control-input').prop('checked', $(this).prop('checked'));
                });

            });
        </script>
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

                $('#myInput').on('keyup', function() {
                    table.search(this.value).draw();
                });


            });
        </script>
        <script>
            $(document).ready(function() {
                var table2 = $('#datatable2').DataTable({

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

                $('#searchNa').on('keyup', function() {
                    table2.columns(2).search(this.value).draw();
                });


            });
        </script>
    @endsection
