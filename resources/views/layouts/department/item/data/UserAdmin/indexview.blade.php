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
                <div class="card-header bg-muted"> ผู้ใช้งาน ระดับ {{ $depart->name_th }}</div>
                <!-- .card-body -->
                <div class="card-body">
                    <form id="filterForm" action="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}"
                        method="GET">
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
                            table.ajax.url('{{ route('DPUserManagejson', ['department_id' => $depart]) }}/' + user_roleValue).load();
                        }
                    </script>
                    @if ($data->user_role == 1 || $data->user_role == 8)
                        <button type="button" class="ml-1 btn btn-success btn-md"
                            onclick="$('#clientUploadModal').modal('toggle');"><i class="fas fa-user-plus"></i>
                            นำเข้าผู้ใช้งาน</button>
                    @endif
                    @if (
                        (($depart->department_id == 1 ||
                            $depart->department_id == 2 ||
                            $depart->department_id == 3 ||
                            $depart->department_id == 4) &&
                            $data->user_role == 1) ||
                            $data->user_role == 6 ||
                            $data->user_role == 7 ||
                            $data->user_role == 8 ||
                            $data->user_role == 9)
                        <a class="ml-1 btn btn-info btn-md " style="color:#fff"
                            href="{{ route('testumsschool', [$depart]) }}"><i class="fas fa-users"></i>
                            จัดการสถานศึกษา</a>
                    @elseif (
                        ($depart->department_id == 1 ||
                            $depart->department_id == 2 ||
                            $depart->department_id == 3 ||
                            $depart->department_id == 4) &&
                            $data->user_role == 7)
                        <a class="ml-1 btn btn-info btn-md " style="color:#fff"
                            href="{{ route('testumsschool', [$depart]) }}"><i class="fas fa-users"></i>
                            จัดการสถานศึกษา</a>
                    @endif


                    {{-- <div class="col-md-6 mb-3">
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
                    </div> --}}
                    {{-- <div class="col-md-6 mb-3">
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
                    </div> --}}

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
                                <div class="modal-header " style="background-color: {{ $depart->color }};">
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
                                                href="{{ asset('uplade/testuserschool.xlsx') }}" target="_blank">
                                                ไฟล์ตัวอย่าง
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
                                    url: '{{ route('UsersDepartImport', ['department_id' => $depart]) }}',
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
                                            // Duplicate data error
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

                    @php
                        $provicValue = $data->province_id;
                    @endphp
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dt-buttons btn-group">
                                    @if ($data->user_role == 1 || $data->user_role == 8)
                                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('UsersExport', ['department_id' => $depart]) }}'">
                                            <span>Excel</span>
                                        </button>
                                    @elseif ($data->user_role == 7)
                                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('exportUsersPro', ['department_id' => $depart, 'provicValue' => $provicValue]) }}'">
                                            <span>Excel</span>
                                        </button>
                                    @elseif ($data->user_role == 6)
                                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('exportUsersSchool', ['department_id' => $depart, 'provicValue' => $provicValue]) }}'">
                                            <span>Excel</span>
                                        </button>
                                    @elseif ($data->user_role == 9)
                                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('exportUsersZone', ['department_id' => $depart]) }}'">
                                            <span>Excel</span>
                                        </button>
                                    @endif
                                &nbsp;&nbsp;&nbsp;
                                    @if ($data->user_role == 7)
                                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('exportUserProvicAll', ['provicValue' => $provicValue]) }}'">
                                            <span>Excel รายชื่อทั้งจังหวัด</span>
                                        </button>
                                    @endif
                                </div>



                                <div class="dataTables_filter ">
                                    <label>ค้นหา
                                        <input type="search" id="myInput" class="form-control" placeholder=""
                                            aria-controls="datatable">
                                    </label>

                                    @php
                                        $Provinces = \App\Models\Provinces::all();

                                        $zones = DB::table('user_admin_zone')
                                            ->where('user_id', $data->user_id)
                                            ->pluck('province_id')
                                            ->toArray();
                                        $zonesad = DB::table('provinces')->whereIn('id', $zones)->get();
                                    @endphp


                                    @if ($data->user_role == 1 || $data->user_role == 8)
                                        <label>จังหวัด
                                            <select id="drop2" name="drop2" class="form-control form-control"
                                                data-allow-clear="false">
                                                <option value="0"selected>ทั้งหมด</option>
                                                @foreach ($Provinces as $provin)
                                                    <option value="{{ $provin->id }}" style="font-size: 16px;">
                                                        {{ $provin->name_in_thai }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    @elseif($data->user_role == 9)
                                        <label>จังหวัด
                                            <select id="drop2" name="drop2" class="form-control form-control"
                                                data-allow-clear="false">
                                                <option value="0"selected>ทั้งหมด</option>
                                                @foreach ($zonesad as $provin)
                                                    <option value="{{ $provin->id }}" style="font-size: 16px;">
                                                        {{ $provin->name_in_thai }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    @endif
                                </div>


                            </div>

                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="10%">ลำดับ</th>
                                    <th width="15%">รหัสผู้ใช้</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th width="10%">เบอร์โทรศัพท์</th>
                                    <th width="20%">email</th>
                                    <th width="10%"> จังหวัด</th>
                                    <th width="10%">สถานะ</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->



                            @include('layouts.department.item.data.UserAdmin.DataUser.scripUser')


                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->

                </div><!-- /.card-body -->

            </div><!-- /.card -->

        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        @if ($data->user_role == 1 || $data->user_role == 8)
            <header class="page-title-bar">

                <button type="button" class="btn btn-success btn-floated btn-addums"
                    onclick="window.location='{{ route('DPcreateUser', ['department_id' => $depart->department_id]) }}'"
                    id="add_umsform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>

            </header>
        @endif
    </div><!-- /.page-inner -->
@endsection
