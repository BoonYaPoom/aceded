@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->

    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a
                        href="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}">ผู้ใช้งาน</a> / <a
                        href="{{ route('schoolManageDepart', ['department_id' => $depart->department_id]) }}">จัดการสถานศึกษา</a>
                </div>
                <!-- .card-body -->
                <div class="card-body">


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
                            <label>จังหวัด
                                <select id="drop2" name="drop2" class="form-control form-control-sm"
                                    data-allow-clear="false">
                                    <option value="0"selected>ทั้งหมด</option>
                                    @php
                                        $Provinces = \App\Models\Provinces::all();
                                    @endphp
                                    @foreach ($Provinces as $provin)
                                        <option value="{{ $provin->name_in_thai }}"> {{ $provin->name_in_thai }} </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <!-- thead -->
                        <thead>
                            <tr class="bg-infohead">
                                <th width="5%">ลำดับ</th>
                                <th>สถานศึกษา</th>
                                <th width="8%">จังหวัด</th>
                                <th width="8%">จำนวน</th>
                                <th width="8%">เพิ่มสมาชิก</th>
                                <th width="12%" class="text-center">กระทำ</th>
                            </tr>
                        </thead>
                        <!-- /thead -->
                        <!-- tbody -->
                        <tbody>
                            @php
                                $i = 1;
                                
                            @endphp
                            <!-- tr -->
                            @foreach ($school as $scho)
                                @php
                                    // ค้นหา UserSchool ที่มี school_id ตรงกับ $school_id และรวมข้อมูลผู้ใช้ที่มี user_id ตรงกัน
                                    $userschool = UserSchool::where('school_id', $school_id)
                                        ->with('users')
                                        ->get();
                                    
                                    // แสดงข้อมูลผู้ใช้ที่ดึงมาพร้อมกับ UserSchool
                                    foreach ($userschool as $school) {
                                        $user = $school->user;
                                    }
                                    
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $scho->school_name }}</td>
                                    <td>{{ $scho->provinces_id }}</td>
                                    <td class="text-center"><a
                                            href="{{ route('umsschooluser', ['school_id' => $scho->school_id]) }}"><i
                                                class="fas fa-users"></i> (
                                            {{ $userschool->where('school_id', $scho->school_id)->count() }}
                                            )
                                        </a></td>
                                    <td class="text-center"><a
                                            href="{{ route('umsschooluser', ['school_id' => $scho->school_id]) }}"><i
                                                class="fas fa-user-plus"></i></a></td>
                                    <td class="text-center">
                                        <a href="{{ route('editschool', ['school_id' => $scho->school_id]) }}"
                                            data-toggle="tooltip" title="แก้ไข"><i
                                                class="far fa-edit fa-lg text-success mr-3"></i></a>
                                        <a href="{{ route('deleteschool', ['school_id' => $scho->school_id]) }}"
                                            onclick="deleteRecord(event)" rel="" class="switcher-delete"
                                            data-toggle="tooltip" title="ลบ">
                                            <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                    </td>

                                </tr><!-- /tr -->
                            @endforeach


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
    <header class="page-title-bar">
        <!-- floating action -->
        <button type="button" class=" btn btn-success btn-floated btn-addums"
            onclick="window.location='{{ route('createschoolDepart', ['department_id' => $depart->department_id]) }}'"
            data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
