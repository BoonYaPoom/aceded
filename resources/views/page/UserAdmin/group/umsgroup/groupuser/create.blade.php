@extends('layouts.adminhome')
@section('content')
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a>/ <a
                        href="{{ route('personTypes') }}">กลุ่มผู้ใช้งาน</a>/ {{ $pertype->person }}</div>
                <!-- .card-body -->
                <div class="card-body">
                    <div class="form-actions ">
                        <button class="btn btn-lg btn-icon btn-light ml-auto d-none" type="button" id="btnsearch"><i
                                class="fas fa-search"></i></button>
                    </div>
                    <form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <input type="hidden" name="__csrf_token_name" value="ea0b9ce804a7987cdcdf2cd0892f78be" />
                        <!-- form row -->

                        <!-- /form row -->
                    </form>
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
                                    <th width="5%">ลำดับ </th>
                                    <th width="20%">รหัสผู้ใช้</th>
                                    <th>ชื่อ สกุล</th>
                                    <th width="20%">กลุ่มผู้ใช้งาน </th>

                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @include('page.UserAdmin.group.umsgroup.groupuser.viewuserGroup')
                            </tbody><!-- /tbody -->



                        </table><!-- /.table -->


                    </div><!-- /.table-responsive -->
                    <hr>
     
                        <form method="POST" action="{{ route('updateusertype', ['person_type' => $pertype->person_type]) }}">
                            @csrf
                            @method('PUT')
                            <div class="table-responsive">
                                <div class="input-group mb-3">
                                    <form action="" method="post" action="/admin/ums/umsgroupuser/1">
                                        <input type="text" class="form-control" name="search" id="searchNa"
                                            aria-describedby="search"
                                            placeholder="ค้นหาโดยการพิมพ์ ชื่อ สกุล "
                                            value="">
                        
                                    </form>
                                </div>
                                @include('page.UserAdmin.group.umsgroup.groupuser.adduserGroup')
    
                            </div><!-- /.table-responsive -->
                        </form>
                    </form>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
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
