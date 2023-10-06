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
                    <form id="filterForm" action="{{ route('UserManage') }}" method="GET">
                        <div class="form-row">
                            <label for="user_role" class="col-md-3 text-right mt-1">เลือกประเภทผู้ใช้งาน</label>
                            <div class="col-md-6 mb-3">
                                <select id="user_role" name="user_role" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="">ทั้งหมด</option>
                                    <option value="4" {{ request('user_role') == '4' ? 'selected' : '' }}>ผู้เรียน
                                    </option>
                                    <option value="3" {{ request('user_role') == '3' ? 'selected' : '' }}>ผู้สอน
                                    </option>
                                    <option value="5" {{ request('user_role') == '5' ? 'selected' : '' }}>ผู้เยี่ยมชม
                                    </option>
                                    <option value="1" {{ request('user_role') == '1' ? 'selected' : '' }}>ผู้ดูแลระบบ
                                    </option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary-theme btn-md" onclick="filterResults()">
                                Filter</button>

                    </form>

                    <script>
                        function filterResults() {
                            var user_roleValue = document.getElementById('user_role').value;
                            var baseUrl = '{{ route('UserManage') }}';

                            if (user_roleValue) {
                                window.location.href = baseUrl + '/' + user_roleValue;
                            } else {
                                window.location.href = baseUrl;
                            }
                        }
                    </script>





                    <button type="button" class="ml-1 btn btn-success btn-md"
                        onclick="$('#clientUploadModal').modal('toggle');"><i class="fas fa-user-plus"></i>
                        นำเข้าผู้ใช้งาน</button>

                    <a class="ml-1 btn btn-info btn-md " style="color:#fff" href="{{ route('personTypes') }}"><i
                            class="fas fa-users"></i>
                        กลุ่มผู้ใช้งาน</a>

            



                    <div class="col-md-6 mb-3">
                        <label for="department_id" class="col-md-3 text-left mt-1">หน่วยงาน</label>
                        <select id="department_id" name="department_id" class="form-control form-control-sm"
                            data-allow-clear="false">
                            <option value="0"selected>ทั้งหมด</option>

                            @php
                                $department = \App\Models\Department::all();
                            @endphp
                            @foreach ($department->sortBy('department_id') as $depart)
                                <option value="{{ $depart->name_en }}"> {{ $depart->name_en }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="drop2" class="col-md-3 text-right mt-1">จังหวัด</label>
                        <select id="drop2" name="drop2" class="form-control form-control-sm" data-allow-clear="false">
                            <option value="0"selected>ทั้งหมด</option>
                            @php
                                $Provinces = \App\Models\Provinces::all();
                            @endphp
                            @foreach ($Provinces as $provin)
                                <option value="{{ $provin->name_in_thai }}"> {{ $provin->name_in_thai }} </option>
                            @endforeach
                        </select>
                    </div>


                </div>

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
                                        <span class="sr-only">Upload</span> <span><i
                                                class="fas fa-user-plus text-white"></i> นำเข้าผู้ใช้งาน</span>
                                    </h6>
                                </div><!-- /.modal-header -->
                                <!-- .modal-body -->
                                <div class="modal-body">
                                    <!-- .form-group -->
                                    <div class="container">
                                        <input type="file" class="form-control" id="uploaduser" name="fileexcel"
                                            accept=".xlsx" required>
                                        <small class="form-text text-muted"><a
                                                href="https://1drv.ms/x/s!Aneojfnh1p7QgepezApvu9n8MZCmBg?e=8RLia9"
                                                target="_blank"> ไฟล์ตัวอย่าง
                                                (.xlsx)</a>
                                        </small>
                                    </div>
                                </div><!-- /.modal-body -->
                                <!-- .modal-footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" id="btnsetuser_role"><i
                                            class="fas fa-user-plus"></i> นำเข้าผู้ใช้งาน</button>
                                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                                </div><!-- /.modal-footer -->
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </form>

                </div>
                <div>
                    <script>
                        $(document).ready(function() {
                            $('#uploadForm').on('submit', function(e) {
                                e.preventDefault();

                                var formData = new FormData(this);

                                $.ajax({
                                    url: '{{ route('UsersImport') }}',
                                    type: 'POST',
                                    data: formData,
                                    dataType: 'json',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        console.log(response);
                                        if (response.message) {
                                            Swal.fire({
                                                title: 'User Successful',
                                                text: 'ข้อมูล User ถูกบันทึกเรียบร้อย',
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
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Import failed: ' + response.error,
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.responseJSON.error);
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Import failed: ' + xhr.responseJSON.error,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            });
                        });
                    </script>


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

                                <div class="dataTables_filter ">
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
                                            info: true,
                                            pageLength: 50,
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

                                        $('#myInput').on('keyup', function() {
                                            table.search(this.value).draw();
                                        });


                                        $('#department_id').on('change', function() {
                                            var selectedDepartmentId = $(this).val();
                                            if (selectedDepartmentId == 0) {
                                                table.columns(6).search('').draw();
                                            } else {
                                                // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                                                table.columns(6).search(selectedDepartmentId).draw();
                                            }
                                        });
                                        $('#drop2').on('change', function() {
                                            var selecteddrop2Id = $(this).val();
                                            if (selecteddrop2Id == 0) {
                                                table.columns(5).search('').draw();
                                            } else {
                                                // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                                                table.columns(5).search(selecteddrop2Id).draw();
                                            }
                                        });

                                    });
                                </script>

                            </div>

                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="10%">ลำดับ</th>
                                    <th width="12%">รหัสผู้ใช้</th>
                                    <th>ชื่อ-นามสกุล</th>

                                    <th width="15%">เบอร์โทรศัพท์</th>
                                    <th width="25%">email</th>
                                    <th width="10%"> จังหวัด</th>
                                    <th>หน่วยงาน</th>
                                    <th width="10%">สถานะ</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                $r =  0;
                                @endphp
                                @foreach ($usermanages->sortBy('user_id') as  $item)
                                @php
                                $r++;
                                @endphp
                                    @php
                                        $user_roleadmin = $item->user_role == 1;
                                    @endphp
                                    @php
                                        $statususerss = $item->userstatus == 0;
                                    @endphp

                                    @php
                                        $clientPermissionModal = 'clientPermissionModal-' . $item->user_id;
                                        $name_short_en = \App\Models\Department::where('department_id', $item->department_id)
                                            ->pluck('name_en')
                                            ->first();
                                        $proviUser = \App\Models\Provinces::where('id', $item->province_id)
                                            ->pluck('name_in_thai')
                                            ->first();
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
            <button type="button" class="btn btn-success btn-floated btn-addums"
                onclick="window.location='{{ route('createUser') }}'" id="add_umsform" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
