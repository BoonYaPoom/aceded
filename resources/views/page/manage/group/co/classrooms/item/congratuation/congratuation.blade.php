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
                    <a href="{{ route('departmentLearnpage') }}"
                        style="text-decoration: underline;">หมวดหมู่</a>
                </div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link " href="{{ route('class_page', ['course_id' => $courses]) }}"><i
                                class="fas fa-users"></i> ผู้เรียน ความรู้เบื้องต้นเกี่ยวกับกฎหมายการแข่งขันทางการค้า </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller --> <!-- .card-body -->
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:65%"> ชื่อ-สกุล </th>
                                    <th class="align-middle" style="width:15%"> ขอใบประกาศนียบัตร </th>
                                    <th class="align-middle" style="width:15%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr --> @php
                                    $n = 1;
                                    $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                                    $uniqueUserIds = [];
                                    
                                @endphp
                                @foreach ($learners as $l => $learns)
                                    @if (!in_array($learns->uid, $uniqueUserIds))
                                        @php
                                            array_push($uniqueUserIds, $learns->uid);
                                            $dataLearn = $learns->registerdate;
                                            $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                            $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                            $users = \App\Models\Users::find($learns->uid);
                                            
                                        @endphp

                                        @if ($monthsa == $m)
                                            @if ($learns->congratulation == 1)
                                                <tr>
                                                    <td><a href="#">{{ $n++ }}</a></td>
                                                    <td>{{ $users->firstname }} {{ $users->lastname }}</td>
                                                    <td></td>
                                                    <td class="align-middle"><a href="#ModalMedia"
                                                            data-modal-target="#ModalMedia"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="พิมพ์ใบประกาศนียบัตร"><img
                                                                class="u-sidebar--account__toggle-img mr-3"
                                                                src="{{ asset('fonts/icon_page_learn-07.png') }}"></a>
                                                    </td>
                                                </tr><!-- /tr --><!-- tr -->
                                            @endif
                                        @endif
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
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" name="__id" id="__id" value="0" />
            <button type="button" class="btn btn-success btn-floated btn-add '.$buttonadd.'" id="registeradd"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
