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
                        href="{{ route('personTypes') }}">กลุ่มผู้ใช้งาน</a></div>
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
                                    <th>กลุ่มผู้ใช้งาน</th>
                                    <th width="8%">จำนวน</th>
                                    <th width="8%">เพิ่มสมาชิก</th>
                                    <th width="12%" class="text-center">กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @foreach ($pertype as $index => $type)
                                    @php
                                        $numindex = $index + 1;
                                    @endphp
                                    <tr>
                                        <td>{{ $numindex }}</td>
                                        <td>{{ $type->person }}</td>
                                        <td class="text-center"><a href="{{ route('pageperson', ['person_type' => $type->person_type]) }}"><i class="fas fa-users"></i> (
                                                @if ($userper)
                                                    {{ $userper->where('user_type', $type->person_type)->count() }}
                                                @endif
                                                )
                                            </a></td>
                                        <td class="text-center"><a
                                                href="{{ route('pageperson', ['person_type' => $type->person_type]) }}"><i
                                                    class="fas fa-user-plus"></i></a></td>
                                        <td class="text-center">
                                            @if (in_array($type->person_type, [1, 2, 3]))
                                                <a href="{{ route('editperson', ['person_type' => $type->person_type]) }}"
                                                    data-toggle="tooltip" title="แก้ไข"><i
                                                        class="far fa-edit fa-lg text-success mr-3"></i></a>
                                            @else
                                                <a href="{{ route('editperson', ['person_type' => $type->person_type]) }}"
                                                    data-toggle="tooltip" title="แก้ไข"><i
                                                        class="far fa-edit fa-lg text-success mr-3"></i></a>
                                                <a href="{{ route('personDelete', [$type->person_type]) }}"
                                                    onclick="deleteRecord(event)" rel="" class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ">
                                                    <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            @endif

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
                onclick="window.location='{{ route('createperson') }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
