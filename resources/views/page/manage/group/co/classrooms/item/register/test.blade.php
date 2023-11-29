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


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('learn', ['department_id' => $depart->department_id]) }}" style="text-decoration: underline;">หมวดหมู่</a>
                </div>
                <!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info" href="{{ route('class_page', ['course_id' => $cour->course_id]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน {{$depart->name_th}} </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:10%"> รหัสผู้ใช้ </th>
                                    <th class="align-middle" style="width:15%"> ชื่อ-สกุล </th>

                                    <th class="align-middle" style="width:15%"> วันที่ลงทะเบียน </th>
                                    <th class="align-middle" style="width:5%"> สถานะ</th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>

                                @php
                                    $n = 1;
                                    
                                @endphp
                                
                                @foreach ($learners as $l => $learns)
                                    @php
                                        
                                        $dataLearn = $learns->registerdate;
                                        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                        $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                        $users = \App\Models\Users::find($learns->user_id);
                                   
                                    @endphp
                                    @if ($monthsa == $m)
                                        <tr>
                                            <td><a href="#">{{ $n++ }}</a></td>

                                            <td>   @if (optional($users)->username)
                                                {{ $users->username }}
                                            @else
                                                Username not found
                                            @endif</td>
                                            <td>   @if (optional($users)->firstname )
                                                {{ $users->firstname }} 
                                            @else
                                          
                                            @endif
                                            @if (optional($users)->lastname)
                                            {{ $users->lastname }}
                                                  @else
                                                   
                                                  @endif</td>
                                            

                                            <td>{{ $newDateTime }}</td>
                                            <td class="align-middle"> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit" checked
                                                        value="1">
                                                    <span class="switcher-indicator"></span> <span
                                                        class="switcher-label-on">ON</span> <span
                                                        class="switcher-label-off text-red">OFF</span></label>
                                            </td>
                                            <td class="align-middle">
                                                <a href="#clientChangeModal" class="changeclass"><i
                                                        class="fas fa-sync fa-lg text-danger" data-toggle="tooltip"
                                                        title="เปลี่ยนแปลงรุ่น"></i></a>



                                                <div class="modal fade" id="clientChangeModal" tabindex="-1" user_role="dialog"
                                                    aria-labelledby="clientChangeModal" aria-hidden="true">
                                                    <!-- .modal-dialog -->
                                                    <div class="modal-dialog" user_role="document">
                                                        <!-- .modal-content -->
                                                        <div class="modal-content">
                                                            <!-- .modal-header -->

                                                            <div class="modal-header bg-warning">
                                                                <h6 id="clientChangeModal"
                                                                    class="modal-title inline-editable">
                                                                    <span
                                                                        class="sr-only form-control form-control-lg text-primary">เปลี่ยนแปลงรุ่น/ชั้นเรียน</span>
                                                                    <input type="text"
                                                                        class="form-control form-control-lg text-primary"
                                                                        placeholder="เปลี่ยนแปลงรุ่น" required="">
                                                                </h6>
                                                            </div>

                                                            <!-- .modal-body -->
                                                            <form id="Formchangeclass">
                                                                <div class="modal-body">
                                                                    <!-- .form-group -->
                                                                    <div class="form-group">
                                                                        <div class="form-label-group">
                                                                            <span
                                                                                class="text-black-70 mb-4 mt-4">เลือกรุ่น/ชั้นเรียน</span>
                                                                            <select id="listclass" name="listclass"
                                                                                class="form-control mt-2"
                                                                                data-toggle="select2"
                                                                                data-placeholder="รุ่น/ชั้นเรียน"
                                                                                data-allow-clear="false">
                                                                            </select>
                                                                            <input type="hidden" name="subjectid"
                                                                                value="">
                                                                            <input type="hidden" name="classid"
                                                                                value="2">

                                                                        </div>
                                                                    </div><!-- /.form-group -->
                                                                </div><!-- /.modal-body -->
                                                                <!-- .modal-footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary-theme"
                                                                        id="confirm">บันทึก</button> <button
                                                                        type="button" class="btn btn-light"
                                                                        data-dismiss="modal">ยกเลิก</button>
                                                                </div>
                                                            </form><!-- /.modal-footer -->
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div>

                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>


                                                <a href="" class="d-none"><i class="fas fa-user fa-lg text-info"
                                                        data-toggle="tooltip" title="ข้อมูลผู้เรียน"></i></a>
                                                <a href="#clientDeleteModal" rel="aced_admin " class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ"><i
                                                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr -->
                                    @endif
                                @endforeach

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
                                                },
                                                emptyTable: "ไม่พบรายการแสดงข้อมูล"
                                            },
                                        });
                                    });
                                </script>
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <br>
                    <form method="post" action="{{ route('searchUsers', ['course_id' => $cour, 'm' => $m]) }}">    
                        @csrf       
                        <div class="row h4">เพิ่มผู้เรียน </div>
                        <div class="row mb-2">
                            <div class="col-10">
                                <!-- .col -->
                                <!-- .input-group -->
                                <div class="input-group has-clearable">
                                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true"><i
                                                class="fa fa-times-circle"></i></span></button>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>
                                    </div>
                                    <input type="text" class="form-control"
                                        placeholder="ค้นหารหัส"
                                        name="stusearch" id="search_query" required="" value="">
                                </div><!-- /.input-group -->
                            </div><!-- /.col -->
                            <div class="col-auto d-none d-sm-flex"><button type="submit" class="btn btn-success">ค้นหา
                                    <span class="fa fa-search"></span></button></div>
                        </div>
                    </form>
                    <form method="post" action="">    
                   
                        <input type="hidden" name="__csrf_token_name" value="720927c2b99c7c37abebdf761a388b00" />
                        <div class="table-responsive">
                            <!-- .table -->
                            <table id="datatable2" class="table w3-hoverable">
                                <!-- thead -->
                                <thead>
                                    <tr class="bg-infohead">
                                     
                                        <th width="10%">ลำดับ 
                                    </th>
                                        <th class="align-middle" style="width:30%"> รหัสผู้ใช้ </th>
                                        <th class="align-middle" style="width:30%"> ชื่อ-สกุล </th>

                                    </tr>
                                </thead><!-- /thead -->
                                <!-- tbody -->
                                <tbody>
                                    @foreach ($usersser as $usersers)
                                    
                                    @if ($usersers->user_role == 3)
                                        <tr>
                                    
                                           
                                            <td class="align-middle">{{ $usersers->user_role }}</td>
                                            <td class="align-middle">{{ $usersers->username }}</td>
                                            <td class="align-middle">                   
                                                <form action="{{ route('storeLearn', ['course_id' => $cour, 'm' => $m]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_data" value="{{ $usersers->user_id }}">
                                                    <button class="btn btn-lg btn-primary-theme ml-auto" type="submit">
                                                        <i class="fa fa-user-plus"></i> เพิ่มผู้เรียน
                                                    </button>
                                                </form>               
                                             </td>
                                        </tr>
                                    @endif
                                @endforeach
             
                                </tbody><!-- /tbody -->
                            </table><!-- /.table -->
                        </div><!-- /.table-responsive -->
                        <div class="row">
                            <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i
                                    class="fa fa-user-plus"></i> เพิ่มผู้เรียน</button>
                        </div>
                    </form>
                
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        
    </div><!-- /.page-inner -->
@endsection
