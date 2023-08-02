@extends('layouts.adminhome')
@section('content')
    <!-- เพิ่มส่วนนี้เป็นส่วนของ JavaScript -->




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
                                            placeholder="นำเข้าผู้ใช้งาน" required="">
                                        <small class="form-text text-muted"><a
                                                href="https://aced.dlex.ai/childhood/admin/upload-files/example/uploaduser.xlsx">
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


                <div class="d-flex justify-content-between align-items-center">
                    <div class="dt-buttons btn-group">
                        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                            aria-controls="datatable" type="button" onclick="window.location='{{ route('UsersExport') }}'">
                            <span>Excel</span>
                        </button>
                    </div>

                    <div id="datatable_filter" class="dataTables_filter text-right">
                        <label>ค้นหา
                            <input type="search" class="form-control" placeholder="" aria-controls="datatable">
                        </label>
                    </div>
                </div>

                <!-- .table-responsive -->
                <div class="table-responsive">
                    <!-- .table -->
                    <table id="datatable" class="table w3-hoverable">
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
                                    $rowNumber = ($usermanages->currentPage() - 1) * $usermanages->perPage() + $index + 1;
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

                                <tr>
                                    <td>{{ $rowNumber }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                    <td>{{ substr($item->mobile, 0, 3) }}-{{ substr($item->mobile, 3, 3) }}-{{ substr($item->mobile, 6, 4) }}
                                    </td>

                                    <td>{{ $item->email }}</td>
                                    <td class="align-middle"> <label
                                            class="switcher-control switcher-control-success switcher-control-lg">
                                            <input type="checkbox" class="switcher-input switcher-edit"
                                                {{ $item->userstatus == 1 ? 'checked' : '' }}
                                                data-uid="{{ $item->uid }}">
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on">ON</span>
                                            <span class="switcher-label-off text-red">OFF</span>
                                        </label></td>

                                    <script>
                                        $(document).ready(function() {
                                            $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                var userstatus = $(this).prop('checked') ? 1 : 0;
                                                var uid = $(this).data('uid');
                                                console.log('userstatus:', userstatus);
                                                console.log('uid:', uid);
                                                $.ajax({
                                                    type: "GET",
                                                    dataType: "json",
                                                    url: '{{ route('changeStatusUser') }}',
                                                    data: {
                                                        'userstatus': userstatus,
                                                        'uid': uid
                                                    },
                                                    success: function(data) {
                                                        console.log(data.message); // แสดงข้อความที่ส่งกลับ
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.log('ข้อผิดพลาด');
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <td>
                                        <a href="{{ route('editUser', ['uid' => $item->uid]) }}" data-toggle="tooltip"
                                            title="แก้ไข"><i class="far fa-edit text-success mr-1"></i></a>

                                        @if ($roleadmin)
                                            <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์">
                                                <i class="fas fa-user-shield text-bg-muted "></i>
                                            </a>
                                        @else
                                            <a href="{{ route('logusers', ['uid' => $item->uid]) }}"
                                                data-toggle="tooltip" title="ดูประวัติการใช้งาน"><i
                                                    class="fas fa-history text-info"></i></a>

                                            <a data-toggle="modal"
                                                data-target="#clientPermissionModal-{{ $item->uid }}"
                                                title="กำหนดสิทธิ์">
                                                <i class="fas fa-user-shield text-danger"></i>
                                            </a>
                                            <button class="btn sendtemppwd " data-toggle="modal"
                                                data-target="#clientWarningModal-{{ $item->uid }}"
                                                title="ส่งรหัสผ่าน"><i class="fas fa-key text-info"></i></button>
                                        @endif



                                    </td>
                                </tr><!-- /tr -->


                                <script>
                                    $(document).ready(function() {
                                        $('.modal').on('shown.bs.modal', function() {
                                            var uid = $(this).data('uid');
                                            console.log('ID ที่เข้าถึงโมเดล:', uid);
                                        });
                                    });
                                </script>
                                <script>
                                    // เมื่อตัวเลือกถูกเลือก
                                    document.querySelectorAll('input[name="role"]').forEach(function(radio) {
                                        radio.addEventListener('change', function() {
                                            // รับค่าของตัวเลือกที่ถูกเลือก
                                            var selectedRole = document.querySelector('input[name="role"]:checked').value;

                                            // ดำเนินการตามต้องการสำหรับตัวเลือกที่ถูกเลือก
                                            console.log('ตัวเลือกที่ถูกเลือก:', selectedRole);

                                        });
                                    });



                                    $(function() {
                                        $(".visual-picker").click(function() {
                                            var radioBtn = $(this).find("input[type='radio']");
                                            radioBtn.prop('checked', true);

                                        });

                                        // ส่วนอื่น ๆ ของรหัส



                                    });

                                    function setRoleColor(role) {
                                        var color = ['', 'info', 'danger', 'success', 'warning'];
                                        $('#role' + role).prop("checked", true);
                                        $('.roleactive').removeClass('bg-info bg-warning bg-danger bg-success');
                                        $('.role' + role).removeClass('bg-muted').addClass('bg-' + color[role]);
                                    }
                                </script>



                                <div id="clientPermissionModal-{{ $item->uid }}" data-uid="{{ $item->uid }}"
                                    class="modal fade" aria-modal="true" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('updateRoleUser', ['uid' => $item->uid]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <!-- .modal-header -->
                                                <div class="modal-header bg-theme-primary">
                                                    <h6 id="clientPermissionModalLabel" class="modal-title text-white">
                                                        <span class="sr-only">Permission</span> <span><i
                                                                class="fas fa-user-shield text-white"></i>
                                                            กำหนดสิทธิ์ผู้ใช้งาน</span>
                                                    </h6>
                                                </div><!-- /.modal-header -->

                                                <div class="modal-body">
                                                    <!-- .form-group -->
                                                    <div class="form-group">
                                                        <div class="form-label-group">
                                                            <div class="section-block text-center text-sm">
                                                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                                                    <br>
                                                                    <input type="radio" id="role1" name="role"
                                                                        value="1"
                                                                        {{ $item->role == 1 ? 'checked' : '' }}>
                                                                    <label class="visual-picker-figure" for="role1">
                                                                        <span class="visual-picker-content">
                                                                            <span
                                                                                class="tile tile-sm role1 roleactive bg-muted">
                                                                                <i class="fas fa-user-cog fa-lg"></i>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                    <span class="visual-picker-peek">ผู้ดูแลระบบ</span>
                                                                </div>
                                                                <!-- <div class="visual-picker visual-picker-sm has-peek px-3 d-none">
                                 <input type="radio" id="role2" name="role" value="2" {{ $item->role == 2 ? 'checked' : '' }}>
                                 <label class="visual-picker-figure" for="role2">
                                 <span class="visual-picker-content"><span class="tile tile-sm role2 roleactive bg-muted"><i class="fas fa-user-edit fa-lg"></i></span></span>  </label>
                                 <span class="visual-picker-peek">ผู้จัดการหลักสูตร</span>
                                </div>  -->
                                                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                                                    <input type="radio" id="role3" name="role"
                                                                        value="3"
                                                                        {{ $item->role == 3 ? 'checked' : '' }}>
                                                                    <label class="visual-picker-figure" for="role3">
                                                                        <span class="visual-picker-content">
                                                                            <span
                                                                                class="tile tile-sm role3 roleactive bg-muted">
                                                                                <i class="fas fa-user-tie fa-lg"></i>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                    <span class="visual-picker-peek">ผู้สอน</span>
                                                                </div>

                                                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                                                    <input type="radio" id="role4" name="role"
                                                                        value="4"
                                                                        {{ $item->role == 4 ? 'checked' : '' }}>
                                                                    <label class="visual-picker-figure" for="role4">
                                                                        <span class="visual-picker-content">
                                                                            <span
                                                                                class="tile tile-sm role4 roleactive bg-muted">
                                                                                <i class="fas fa-user-graduate fa-lg"></i>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                    <span class="visual-picker-peek">ผู้เรียน</span>
                                                                </div>

                                                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                                                    <input type="radio" id="role5" name="role"
                                                                        value="5"
                                                                        {{ $item->role == 5 ? 'checked' : '' }}>
                                                                    <label class="visual-picker-figure" for="role5">
                                                                        <span class="visual-picker-content">
                                                                            <span
                                                                                class="tile tile-sm role5 roleactive bg-muted">
                                                                                <i class="fas fa-user fa-lg"></i>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                    <span class="visual-picker-peek">ผู้เยี่ยมชม</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary-theme"
                                                            id="btnsetrole">
                                                            <i class="fas fa-user-shield"></i> กำหนดสิทธิ์
                                                        </button>
                                                        <button type="button" class="btn btn-light"
                                                            data-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade " id="clientWarningModal-{{ $item->uid }}"
                                    data-uid="{{ $item->uid }}" tabindex="-1" role="dialog"
                                    aria-labelledby="clientWarningModalLabel" aria-modal="true">
                                    <!-- .modal-dialog -->
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('updatePassword', ['uid' => $item->uid]) }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <!-- .modal-content -->
                                            <div class="modal-content">
                                                <!-- .modal-header -->
                                                <div class="modal-header bg-warning">
                                                    <h6 id="clientWarningModalLabel" class="modal-title">
                                                        <span class="sr-only">"Warning</span> <span><i
                                                                class="far fa-bell fa-lg "></i> กำหนดรหัสผ่าน</span>
                                                    </h6>
                                                </div><!-- /.modal-header -->
                                                <!-- .modal-body -->
                                                <div class="modal-body">
                                                    <!-- .form-group -->
                                                    <div class="form-group">
                                                        <div class="form-label-group">
                                                            <p></p>
                                                            <div id="warningmsgx" class="h6">รหัสผ่านใหม่</div>
                                                            <input type="text" class="form-control placeholder-shown"
                                                                id="usearch" name="usearch" placeholder="รหัสผ่านใหม่"
                                                                required="">
                                                            <p>
                                                            </p>
                                                        </div>
                                                    </div><!-- /.form-group -->
                                                </div><!-- /.modal-body -->
                                                <!-- .modal-footer -->
                                                <div class="modal-footer">
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">ตกลง</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ยกเลิก</button>
                                                    </div>
                                                </div><!-- /.modal-footer -->
                                            </div><!-- /.modal-content -->
                                        </form>
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <script></script>
                            @endforeach

                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->

            </div><!-- /.card-body -->


            <ul class="pagination justify-content-center">
                @if ($usermanages->onFirstPage())
                    <li class="paginate_button page-item previous disabled" id="datatable_previous">
                        <a href="#" aria-controls="datatable" data-dt-idx="0" tabindex="0"
                            class="page-link">ก่อนหน้า</a>
                    </li>
                @else
                    <li class="paginate_button page-item previous" id="datatable_previous">
                        <a href="{{ $usermanages->previousPageUrl() }}" aria-controls="datatable" data-dt-idx="0"
                            tabindex="0" class="page-link">ก่อนหน้า</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $usermanages->lastPage(); $i++)
                    <li class="paginate_button page-item {{ $i === $usermanages->currentPage() ? 'active' : '' }}">
                        <a href="{{ $usermanages->url($i) }}" aria-controls="datatable"
                            data-dt-idx="{{ $i }}" tabindex="0" class="page-link">{{ $i }}</a>
                    </li>
                @endfor

                @if ($usermanages->hasMorePages())
                    <li class="paginate_button page-item next" id="datatable_next">
                        <a href="{{ $usermanages->nextPageUrl() }}" aria-controls="datatable" data-dt-idx="4"
                            tabindex="0" class="page-link">ถัดไป</a>
                    </li>
                @else
                    <li class="paginate_button page-item next disabled" id="datatable_next">
                        <a href="#" aria-controls="datatable" data-dt-idx="4" tabindex="0"
                            class="page-link">ถัดไป</a>
                    </li>
                @endif
            </ul>



        </div><!-- /.card -->

    </div><!-- /.page-section -->
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <!-- floating action -->
        <button type="button" class="btn btn-success btn-floated btn-addums" id="add_umsform" data-toggle="tooltip"
            title="เพิ่ม"><span class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
