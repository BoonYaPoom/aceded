@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">
        <!-- .page-section -->

        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"> ผู้ใช้งาน</div>
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
                            var baseUrl = '{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}';

                            if (user_roleValue) {
                                window.location.href = baseUrl + '/' + user_roleValue;
                            } else {
                                window.location.href = baseUrl;
                            }
                        }
                    </script>



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


                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dt-buttons btn-group">
                                    <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                        aria-controls="datatable" type="button"
                                        onclick="window.location=''">
                                        <span>Excel</span>
                                    </button>
                                </div>

                                <div class="dataTables_filter ">
                                    <label>ค้นหา
                                        <input type="search" id="myInput" class="form-control" placeholder=""
                                            aria-controls="datatable">
                                    </label>
                                </div>


                            </div>

                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="10%">ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th width="10%">เบอร์โทรศัพท์</th>
                                    <th width="20%">email</th>
                                    <th width="10%"> จังหวัด</th>
                                    <th width="15%">สถานศึกษา</th>
                                    <th width="10%">สถานะ</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->

                                    
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td>
                                    </td>

                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr><!-- /tr -->




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
                onclick="window.location='{{ route('DPcreateUser', ['department_id' => $depart->department_id]) }}'"
                id="add_umsform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
