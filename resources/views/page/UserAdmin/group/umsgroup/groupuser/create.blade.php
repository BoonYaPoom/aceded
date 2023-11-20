@extends('layouts.adminhome')
@section('content')
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a>/ <a
                        href="{{ route('personTypes') }}">กลุ่มผู้ใช้งาน</a>/ {{ $pertype->person }}</div>

                <div class="card-body">
                    <div class="form-actions ">
                        <button class="btn btn-lg btn-icon btn-light ml-auto d-none" type="button" id="btnsearch"><i
                                class="fas fa-search"></i></button>
                    </div>

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
                                    <th width="20%">กลุ่มผู้ใช้งาน </th>

                                </tr>
                            </thead>

                            <tbody>
                                @include('page.UserAdmin.group.umsgroup.groupuser.viewuserGroup')
                            </tbody>
                        </table>


                    </div>


                        <input type="search" class="form-control" name="searchNa" id="searchNa"
                            aria-describedby="searchNa" placeholder="ค้นหาโดยการพิมพ์ ชื่อ สกุล " >
                        <br>
                        <div class="table-responsive">

                            @include('page.UserAdmin.group.umsgroup.groupuser.adduserGroup')

                        </div>


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
@endsection
