@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
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
                        href="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}">ผู้ใช้งาน</a>/ <a
                        href="{{ route('testumsschool', ['department_id' => $depart->department_id]) }}">จัดการสถานศึกษาของ
                        {{ $extender->name }} ระดับ {{ $depart->name_th }}</a>
                </div>
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

                            <div class="dataTables_filter">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="button" class="btn btn-success btn-md"
                                            onclick="$('#clientUploadModal').modal('toggle');">
                                            <i class="fas fa-user-plus"></i> นำเข้าผู้ใช้งาน
                                        </button>
                                        <button type="button" class="btn btn-danger btn-md"
                                            onclick="$('#clientDeleteModal').modal('toggle');">
                                            <i class="fas fa-user-plus"></i> ลบผู้ใช้งาน
                                        </button>
                                    </div>
                                    <div>
                                        <label>ค้นหา
                                            <input type="search" id="myInput" class="form-control" placeholder=""
                                                aria-controls="datatable">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ </th>
                                    <th width="20%">รหัสผู้ใช้</th>
                                    <th>ชื่อ สกุล</th>
                                    <th width="20%">ระดับ </th>
                                    <th width="20%">กลุ่มผู้ใช้งาน </th>

                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @include('layouts.department.item.data.UserAdmin.group.umsschool.test.add.viewuser')
                            </tbody><!-- /tbody -->



                        </table><!-- /.table -->


                    </div><!-- /.table-responsive -->
                    <hr>
                    <!-- .table-responsive -->


                    <form method="POST"
                        action="{{ route('saveExtender_umsform', ['department_id' => $depart, 'extender_id' => $extender->extender_id]) }}">
                        @csrf

                        <div class="table-responsive">
                            <div class="input-group mb-3">
                                <form action="" method="post" action="/admin/ums/umsgroupuser/1">
                                    <input type="text" class="form-control" name="search" id="searchNa"
                                        aria-describedby="search" placeholder="ค้นหาโดยการพิมพ์ ชื่อ สกุล " value="">

                                </form>
                            </div>
                            @include('layouts.department.item.data.UserAdmin.group.umsschool.test.add.adduser')

                        </div><!-- /.table-responsive -->
                    </form>
                    <!-- tr -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        {{-- <header class="page-title-bar">

            <button type="button" class="btn btn-success btn-floated btn-addums"
                onclick="window.location='{{ route('DPSchoolcreateUser', ['department_id' => $depart, 'school_code' => $school->school_code]) }}'"
                id="add_umsform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>

        </header> --}}
    </div><!-- /.page-inner -->

    <div class="modal fade " id="clientUploadModal" tabindex="-1" user_role="dialog"
        aria-labelledby="clientUploadModalLabel" aria-modal="true">
        <!-- .modal-dialog -->
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog" user_role="document">
                <!-- .modal-content -->
                <div class="modal-content">
                    <!-- .modal-header -->
                    <div class="modal-header bg-success">
                        <h6 id="clientUploadModalLabel" class="modal-title text-white">
                            <span class="sr-only">Upload</span> <span><i class="fas fa-user-plus text-white"></i>
                                นำเข้าผู้ใช้งาน</span>
                        </h6>
                    </div><!-- /.modal-header -->
                    <!-- .modal-body -->
                    <div class="modal-body">
                        <!-- .form-group -->
                        <div class="container">
                            <input type="file" class="form-control" id="uploaduser" name="fileexcel" accept=".xlsx"
                                required>
                            <small class="form-text text-muted"><a href="{{ asset('uplade/testuserschool.xlsx') }}"
                                    target="_blank">
                                    ไฟล์ตัวอย่าง
                                    (.xlsx)</a>
                            </small>
                        </div>
                    </div><!-- /.modal-body -->
                    <!-- .modal-footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btnsetuser_role"><i class="fas fa-user-plus"></i>
                            นำเข้าผู้ใช้งาน</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    </div><!-- /.modal-footer -->
                </div><!-- /.modal-content -->
            </div>
        </form>
    </div>

    <!--  Model  -->
    <div class="modal fade show has-shown" id="clientDeleteModal" tabindex="-1" user_role="dialog"
        aria-labelledby="clientDeleteModalLabel" aria-modal="true" style="padding-right: 17px;">
        <div class="modal-dialog modal-xl" user_role="document">
            <div class="modal-content">
                <div class="modal-header " style="background-color: {{ $depart->color }};">
                    <h6 id="clientDeleteModalLabel" class="modal-title">
                        <span class="sr-only">"Warning</span> <span><i class="fas fa-question-circle fa-lg "></i>
                            ลบผู้ใช้งาน</span>
                    </h6>
                </div>
                <form
                    action="{{ route('deleteAllUser', ['department_id' => $depart->department_id, 'extender_id' => $extender->extender_id]) }}"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-label-group">
                                <div class="table-responsive">
                                    <table id="exam0" class="table w3-hoverable showexam "
                                        style="width:100% display:none;">
                                        <thead>
                                            <tr class="bg-infohead">
                                                <th class="align-middle" style="width:10%">
                                                    <div class="custom-control custom-checkbox"> <input type="checkbox"
                                                            class="custom-control-input" name="checkall1" value="1"
                                                            id="checkall1"><label class="custom-control-label"
                                                            for="checkall1">
                                                            เลือกทั้งหมด</label></div>
                                                </th>
                                                <th class="align-middle" style="width:45%">รหัสผู้ใช้งาน</th>
                                                <th class="align-middle" style="width:10%">ชื่อ สกุล</th>
                                                <th class="align-middle" style="width:10%">ระดับ</th>
                                                <th class="align-middle" style="width:35%">สถานศึกษา</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataexam0" class="dataexam">
                                            @foreach ($usersnotnull->sortBy('user_id') as $unotnull)
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    name="user_data[]"
                                                                    id="user_data{{ $unotnull->user_id }}"
                                                                    value="{{ $unotnull->user_id }}">
                                                                <label class="custom-control-label"
                                                                    for="user_data{{ $unotnull->user_id }}"></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $unotnull->username }}</td>
                                                    <td>{{ $unotnull->firstname }} {{ $unotnull->lastname }}</td>
                                                    <td>{{ $unotnull->user_affiliation }}</td>
                                                    <td>{{ $extender->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div><!-- /.form-group -->
                    </div><!-- /.modal-body -->
                    <!-- .modal-footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-user-plus"></i>
                            ลบผู้ใช้งาน</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    </div><!-- /.modal-footer -->
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div>
        <script>
            $(document).ready(function() {
                var table01 = $('#exam0').DataTable({
                    lengthChange: false,
                    responsive: true,
                    info: false,
                    pageLength: 10,
                    language: {
                        info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        infoEmpty: "ไม่พบรายการ",
                        infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                        paginate: {
                            first: "หน้าแรก",
                            last: "หน้าสุดท้าย",
                            previous: "ก่อนหน้า",
                            next: "ถัดไป"
                        }
                    },
                });
                $("#checkall1").click(function() {
                    var isChecked = $(this).prop('checked');
                    // ทำการตรวจสอบทุกรายการที่แสดงใน DataTables และกำหนดสถานะ checked
                    table01.rows().nodes().to$().find('.custom-control-input').prop('checked', isChecked);
                });

            });
        </script>

        <script>
            $(document).ready(function() {
                $('#uploadForm').on('submit', function(e) {
                    e.preventDefault();
                    $('#loadingSpinner').show();
                    var formData = new FormData(this);
                    $.ajax({
                        url: '{{ route('UsersDepartSchoolImport', ['department_id' => $depart->department_id, 'extender_id' => $extender->extender_id]) }}',
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#loadingSpinner').hide();
                            console.log(response);
                            if (response.message) {
                                Swal.fire({
                                    title: 'User Successful',
                                    text: 'ข้อมูล User ถูกบันทึกเรียบร้อย จำนวน ' + response
                                        .inserted_count + ' รายการ',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function(result) {
                                    if (result.isConfirmed) {
                                        // รีเซ็ตแบบฟอร์มเมื่อกด OK
                                        $('#uploadForm')[0].reset();
                                        $('#clientUploadModal').modal(
                                            'hide');
                                        location.reload();
                                    }
                                });
                            } else {
                                const duplicateFields = response.error.split('\n').filter(
                                    field => field.trim() !== '');
                                Swal.fire({
                                    title: 'ผิดพลาด!',
                                    html: 'ผิดพลาด:<br>' + duplicateFields.join(
                                        '<br>'),
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#loadingSpinner').hide();
                            console.log(xhr.responseJSON.error);
                            if (xhr.responseJSON.error.includes('ผิดพลาด')) {
                                const duplicateFields = xhr.responseJSON.error.split('\n').filter(
                                    field => field.trim() !== '');
                                Swal.fire({
                                    title: 'ผิดพลาด!',
                                    html: 'ผิดพลาด:<br>' + duplicateFields.join(
                                        '<br>'),
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                }).then(function(result) {
                                    if (result.isConfirmed) {
                                        // รีเซ็ตแบบฟอร์มเมื่อกด OK
                                        $('#uploadForm')[0].reset();
                                        $('#clientUploadModal').modal(
                                            'hide');
                                        location.reload();
                                    }

                                });
                            } else {
                                // Other non-duplicate data errors
                                Swal.fire({
                                    title: 'ผิดพลาด!',
                                    text: 'การนำเข้าข้อมูลล้มเหลว: ' + xhr.responseJSON
                                        .error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                });
            });
        </script>
        <script></script>
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

                $("#checkall").click(function() {
                    var isChecked = $(this).prop('checked');
                    // ทำการตรวจสอบทุกรายการที่แสดงใน DataTables และกำหนดสถานะ checked
                    table2.rows().nodes().to$().find('.custom-control-input').prop('checked', isChecked);
                });

            });
        </script>
    @endsection
