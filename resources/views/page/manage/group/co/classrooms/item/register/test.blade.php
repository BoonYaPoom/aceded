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
                    <a href="{{ route('departmentpage') }}" style="text-decoration: underline;">หมวดหมู่</a>
                </div>
                <!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info" href="{{ route('class_page', ['course_id' => $cour]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
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
                                <!-- tr -->
                                @php
                    $n = 0;
                            @endphp
                                @foreach ($learn as $le)
                                @php
                                $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $le->registerdate)->format('d/m/Y H:i:s');
                                $users = \App\Models\Users::find($le->user_id);
                                $n++;
                            @endphp
                            @if($le->class_id  > 0)
                                    <tr>
                                        <td><a href="#">{{$n}}</a></td>
                                        <td>{{$users->username}}</td>
                                        <td>{{$users->firstname}}  {{$users->lastname}}</td>

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
                                                            <h6 id="clientChangeModal" class="modal-title inline-editable">
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
                                                                            class="form-control mt-2" data-toggle="select2"
                                                                            data-placeholder="รุ่น/ชั้นเรียน"
                                                                            data-allow-clear="false">
                                                                        </select>
                                                                        <input type="hidden" name="subjectid"
                                                                            value="">
                                                                        <input type="hidden" name="classid" value="2">

                                                                    </div>
                                                                </div><!-- /.form-group -->
                                                            </div><!-- /.modal-body -->
                                                            <!-- .modal-footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary-theme"
                                                                    id="confirm">บันทึก</button> <button type="button"
                                                                    class="btn btn-light"
                                                                    data-dismiss="modal">ยกเลิก</button>
                                                            </div>
                                                        </form><!-- /.modal-footer -->
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>

                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>


                                            <script>
                                                $(".changeclass").click(function() {
                                                    $('#clientChangeModal').modal('toggle');
                                                    var idleaner = $(this).prop('id');
                                                    $('#confirm').on("click", function() {
                                                        var Data = new FormData($("#Formchangeclass")[0]);
                                                        Data.append('id', idleaner);
                                                        $.ajax({
                                                            url: '',
                                                            contentType: false,
                                                            processData: false,
                                                            type: "POST",
                                                            data: Data,
                                                            dataType: "json",
                                                            cache: false,
                                                            success: function(result) {
                                                                if (result['status'] != null) {
                                                                    setTimeout(function() {
                                                                        $("#clientChangeModal").removeClass('d-none');
                                                                        window.location.href =
                                                                            "" +
                                                                            result['classold'];
                                                                    }, 200);
                                                                } else {
                                                                    setTimeout(function() {
                                                                        window.location.href =
                                                                            "" +
                                                                            result['subjectid'];
                                                                    }, 200);
                                                                }
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <a href="" class="d-none"><i class="fas fa-user fa-lg text-info"
                                                    data-toggle="tooltip" title="ข้อมูลผู้เรียน"></i></a>
                                            <a href="#clientDeleteModal" rel="aced_admin " class="switcher-delete"
                                                data-toggle="tooltip" title="ลบ"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                    @endif
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <br>
                    <form method="post" action="">
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
                                        placeholder="ค้นหารหัส ,ค้นหาหลายคนพิมพ์เว้นวรรค 1ครั้ง (space bar) เช่น 111111 222222 333333, ค้นหาแบบช่วงพิมพ์ - ระหว่างข้อมูล เช่น 100000-100010"
                                        name="stusearch" id="stusearch" required="" value="">
                                </div><!-- /.input-group -->
                            </div><!-- /.col -->
                            <div class="col-auto d-none d-sm-flex"><button type="submit" class="btn btn-success">ค้นหา
                                    <span class="fa fa-search"></span></button></div>
                        </div>
                    </form>
                    <form action="https://aced.dlex.ai/childhood/admin/lms/savedata/registerinsert/4" method="post"
                        accept-charset="utf-8">
                        <input type="hidden" name="__csrf_token_name" value="720927c2b99c7c37abebdf761a388b00" />
                        <div class="table-responsive">
                            <!-- .table -->
                            <table id="datatable2" class="table w3-hoverable">
                                <!-- thead -->
                                <thead>
                                    <tr class="bg-infohead">
                                        <th class="align-middle" style="width:10%"> ลำดับ </th>
                                        <th class="align-middle" style="width:30%"> รหัสผู้ใช้ </th>
                                        <th class="align-middle" style="width:30%"> ชื่อ-สกุล </th>

                                    </tr>
                                </thead><!-- /thead -->
                                <!-- tbody -->
                                <tbody>

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
        <header class="page-title-bar">
            <!-- floating action -->

            <button type="button" onclick="window.location=''" class="btn btn-success btn-floated btn-add "
                id="registeradd" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
