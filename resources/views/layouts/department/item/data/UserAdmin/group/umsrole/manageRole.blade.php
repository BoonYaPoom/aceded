@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->

    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a> / <a
                        href="{{ route('personTypes') }}">กลุ่มประเภทผู้ใช้งาน</a></div>
                <!-- .card-body -->
                <div class="card-body">
                    <div class="form-actions ">
                        <button class="btn btn-lg btn-icon btn-light ml-auto d-none" type="button" id="btnsearch"><i
                                class="fas fa-search"></i></button>
                    </div>

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <div class="dataTables_filter text-right">
                                <label>ค้นหา
                                    <input type="search" id="myInput" class="form-control" placeholder=""
                                        aria-controls="datatable">
                                </label>
                            </div>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ</th>
                                    <th>ประเภทผู้ใช้งาน</th>
                                    <th width="8%">จำนวน</th>
                                    <th width="8%">เพิ่มสมาชิก</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->

                                <tr>

                                    <td>1</td>
                                    <td>ผู้สอน</td>
                                    <td class="text-center"><a href=""><i class="fas fa-users"></i>
                                        ({{ $count3 }})
                                        </a></td>
                                    <td class="text-center"><a href=""><i class="fas fa-user-plus"></i></a></td>
                                    <td class="text-center">

                                    </td>

                                </tr><!-- /tr -->
                                <tr>

                                    <td>2</td>
                                    <td>ผู้เรียน</td>
                                    <td class="text-center"><a href=""><i class="fas fa-users"></i>
                                            ({{ $count4 }})
                                        </a></td>
                                    <td class="text-center"><a href=""><i class="fas fa-user-plus"></i></a></td>
                                    <td class="text-center">

                                    </td>

                                </tr><!-- /tr -->
                                <tr>

                                    <td>3</td>
                                    <td>ผู้เยี่ยมชม</td>
                                    <td class="text-center"><a href=""><i class="fas fa-users"></i>
                                        ({{ $count5}})
                                        </a></td>
                                    <td class="text-center"><a href=""><i class="fas fa-user-plus"></i></a></td>
                                    <td class="text-center">

                                    </td>

                                </tr><!-- /tr -->
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
       
    </div><!-- /.page-inner -->
@endsection
