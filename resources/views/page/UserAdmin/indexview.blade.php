@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->

        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"> ผู้ใช้งาน</div>
                <!-- .card-body -->
                <div class="card-body">
                    <form action="{{ route('UserManageByRole', ['role' => ':role']) }}" method="GET">

                        <div class="form-row">
                            <label for="mobile" class="col-md-3 text-right mt-1">เลือกประเภทผู้ใช้งาน</label>
                            <div class="col-md-6 mb-3">
                                <select id="selectuserrole" name="selectuserrole" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="0"selected>ทั้งหมด</option>
                                    <option value="4">ผู้เรียน</option>
                                    <option value="3">ผู้สอน</option>
                                    <option value="1">ผู้ดูแลระบบ</option>
                                    <option value="5">ผู้เยี่ยมชม</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary-theme btn-md"> Filter</button>
                    </form>


                    <script>
                        document.getElementById('selectuserrole').addEventListener('change', function() {
                            var selectedRole = this.value;
                            console.log(selectedRole); // แสดงค่าที่ได้ในคอนโซล

                            if (selectedRole === '0') {
                                window.location.href = '{{ route('UserManageByRole', ['role' => '0']) }}';
                            } else {
                                var url = '{{ route('UserManageByRole', ['role' => ':role']) }}';
                                url = url.replace(':role', selectedRole);

                                window.location.href = url;
                            }
                        });
                    </script>
                    <button type="button" class="ml-1 btn btn-success btn-md"
                        onclick="$('#clientUploadModal').modal('toggle');"><i class="fas fa-user-plus"></i>
                        นำเข้าผู้ใช้งาน</button>

                    <a class="ml-1 btn btn-info btn-md " style="color:#fff" href="{{ route('personTypes') }}"><i
                            class="fas fa-users"></i>
                        กลุ่มผู้ใช้งาน</a>


                </div>
                <div class="modal fade " id="clientUploadModal" tabindex="-1" role="dialog"
                    aria-labelledby="clientUploadModalLabel" aria-modal="true">
                    <!-- .modal-dialog -->
                    <form method="post" id="formuploaduser" enctype="multipart/form-data" action="uploaduser">
                        <div class="modal-dialog" role="document">
                            <!-- .modal-content -->
                            <div class="modal-content">
                                <!-- .modal-header -->
                                <div class="modal-header bg-success">
                                    <h6 id="clientUploadModalLabel" class="modal-title text-white">
                                        <span class="sr-only">Upload</span> <span><i
                                                class="fas fa-user-plus text-white"></i> นำเข้าผู้ใช้งาน</span>
                                    </h6>
                                </div><!-- /.modal-header -->
                                <!-- .modal-body -->
                                <div class="modal-body">
                                    <!-- .form-group -->
                                    <div class="container">
                                        <input type="file" class="form-control  " id="uploaduser" name="uploaduser"
                                            placeholder="นำเข้าผู้ใช้งาน" required="uploaduser.xlsx">
                                        <small class="form-text text-muted"><a
                                                href="">
                                                ไฟล์ตัวอย่าง (.xlsx)</a></small>
                                    </div>

                                </div><!-- /.modal-body -->
                                <!-- .modal-footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="btnsetrole"><i
                                            class="fas fa-user-plus"></i> นำเข้าผู้ใช้งาน </button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                                </div><!-- /.modal-footer -->
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </form>
                </div>



                <div class="table-responsive">
                    <!-- .table -->
                    <table id="datatable" class="table w3-hoverable">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="dt-buttons btn-group">
                                <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                    aria-controls="datatable" type="button"
                                    onclick="window.location='{{ route('UsersExport') }}'">
                                    <span>Excel</span>
                                </button>
                            </div>

                            <div class="dataTables_filter text-right">
                                <label>ค้นหา
                                    <input type="search" id="myInput" class="form-control" placeholder=""
                                        aria-controls="datatable">
                                </label>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable').DataTable({
                                       
                                       lengthChange: false,
                                       responsive: true,
                                       info: false,
                                       pageLength: 30,
                                       language: {
                                        info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
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

                        </div>

                        <!-- thead -->
                        <thead>
                            <tr class="bg-infohead">
                                <th width="10%">ลำดับ</th>
                                <th width="15%">รหัสผู้ใช้</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th width="15%">เบอร์โทรศัพท์</th>
                                <th width="25%">email</th>
                                <th width="10%">สถานะ</th>
                                <th width="12%" class="text-center">กระทำ</th>
                            </tr>
                        </thead>
                        <!-- /thead -->
                        <!-- tbody -->
                        <tbody>
                            <!-- tr -->
                       
                            @foreach ($usermanages as $index => $item)
                            @php
                            $rowNumber = $index + 1;
                        @endphp
                                @php
                                    $roleadmin = $item->role == 1;
                                @endphp
                                @php
                                    $statususerss = $item->userstatus == 0;
                                @endphp

                                @php
                                    $clientPermissionModal = 'clientPermissionModal-' . $item->uid;
                                @endphp


                                @include('page.UserAdmin.DataUser.userAll')

                                @include('page.UserAdmin.group.ModelUser.modelRole')
                                @include('page.UserAdmin.group.ModelUser.modelPass')
                            @endforeach

                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->

            </div><!-- /.card-body -->

        </div><!-- /.card -->

    </div><!-- /.page-section -->
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <!-- floating action -->
        <button type="button" class="btn btn-success btn-floated btn-addums"  onclick="window.location='{{ route('createUser') }}'" id="add_umsform" data-toggle="tooltip"
            title="เพิ่ม"><span class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
