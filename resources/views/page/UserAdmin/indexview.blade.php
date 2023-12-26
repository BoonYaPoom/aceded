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
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->

        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"> ผู้ใช้งาน </div>
                <!-- .card-body -->
                <div class="card-body">
                    <form id="filterForm" action="{{ route('UserManagejson') }}" method="GET">
                        <div class="form-row">
                            <label for="user_role" class="col-md-3 text-right mt-1">เลือกประเภทผู้ใช้งาน</label>
                            <div class="col-md-6 mb-3">
                                <select id="user_role" name="user_role" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="">ทั้งหมด</option>

                                    @php
                                        $roles = \App\Models\UserRole::all();
                                    @endphp
                                    @foreach ($roles->sortBy('user_role_id') as $ro)
                                        <option value="{{ $ro->user_role_id }}"
                                            {{ request('user_role') == $ro->user_role_id ? 'selected' : '' }}>
                                            {{ $ro->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary-theme btn-md" onclick="filterResults()">
                                Filter</button>

                    </form>

                    <script>
                        function filterResults() {
                            var user_roleValue = document.getElementById('user_role').value;
                            var table = $('#datatable').DataTable();
                            table.ajax.url('{{ route('UserManagejson') }}/' + user_roleValue).load();
                        }
                    </script>

                    <button type="button" class="ml-1 btn btn-success btn-md"
                        onclick="$('#clientUploadModal').modal('toggle');"><i class="fas fa-user-plus"></i>
                        นำเข้าผู้ใช้งาน</button>

                    <a class="ml-1 btn btn-info btn-md " style="color:#fff" href="{{ route('personTypes') }}"><i
                            class="fas fa-users"></i>
                        กลุ่มผู้ใช้งาน</a>

                    {{-- 
                    <a class="ml-1 btn btn-info btn-md " style="color:#fff" href="{{ route('schoolManage') }}"><i
                            class="fas fa-users"></i>
                        จัดการสถานศึกษา</a> --}}


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
                                        <small class="form-text text-muted"><a href="{{ asset('uploads/userimport.xlsx') }}"
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
                                $('#loadingSpinner').show();

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
                                        $('#loadingSpinner').hide();
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
                                        $('#loadingSpinner').hide();
                                        console.log(xhr.responseJSON.error);
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Import failed: ' + xhr.responseJSON.error,
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }

                                });
                                $('#filterButton').on('click', function() {
                                    var userRole = $('#user_role').val();
                                    table.ajax.url('{{ route('UserManagejson') }}?user_role=' + userRole).load();
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
                                        onclick="window.location='{{ route('exportUsersall') }}'">
                                        <span>Excel</span>
                                    </button>
                                </div>

                                <div class="dataTables_filter ">
                                    <label>ค้นหา
                                        <input type="search" id="myInput" class="form-control" placeholder=""
                                            aria-controls="datatable">
                                    </label>
                                    <label>จังหวัด
                                        <select id="drop2" name="drop2" class="form-control" data-allow-clear="false"
                                            aria-controls="datatable">
                                            <option value="0"selected>ทั้งหมด</option>
                                            @php
                                                $Provinces = \App\Models\Provinces::all();

                                            @endphp
                                            @foreach ($Provinces as $provin)
                                                <option value="{{ $provin->code }}"> {{ $provin->name_in_thai }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>

                                </div>


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
                                    <th width="10%">สถานะ</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->

                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->

                    @include('page.UserAdmin.DataUser.scripUser')

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
