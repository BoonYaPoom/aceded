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
                    <a href="http://tcct.localhost:8080/admin/lms/department.html"
                        style="text-decoration: underline;">หมวดหมู่</a>
                </div>
                <!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link " href="{{ route('class_page', [$depart,'course_id' => $cour]) }}"><i
                                class="fas fa-users"></i> ผู้เรียน ความรู้เบื้องต้นเกี่ยวกับกฎหมายการแข่งขันทางการค้า </a>
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
                                    <th class="align-middle" style="width:10%"> วันที่ชำระเงิน </th>
                                    <th class="align-middle" style="width:10%"> สถานะชำระเงิน</th>
                                    <th class="align-middle" style="width:10%"> ราคา</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php
                                    $n = 0;
                                @endphp
                                @foreach ($learn as $le)
                                    @php
                                        $registerTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $le->registerdate)->format('d/m/Y H:i:s');

                                        $paymentTime = '';
                                        if ($le->payment_date) {
                                            $paymentTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $le->payment_date)->format('d/m/Y H:i:s');
                                        }

                                        $amount = '';
                                        if ($le->payment_amount == null) {
                                            $amount = 0;
                                        } else {
                                            $amount = $le->payment_amount;
                                        }

                                        $users = \App\Models\Users::find($le->user_id);
                                        $n++;
                                    @endphp

                                    <tr>
                                        <td><a href="#">{{ $n }}</a></td>
                                        <td>{{ $users->username }}</td>
                                        <td>{{ $users->firstname }} {{ $users->lastname }}</td>

                                        <td>{{ $registerTime }}</td>
                                        <td>

                                            {{ $paymentTime }}

                                        </td>
                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit" value="1"
                                                    id="5f5feb96256660c8f9061a64bd76c322__course_learner__payment_status__learner_id__235__1691648060">
                                                <span class="switcher-indicator"></span> <span
                                                    class="switcher-label-on">ชำระแล้ว</span> <span
                                                    class="switcher-label-off text-red">รอชำระ</span></label>
                                        </td>
                                        <td>
                                            {{ $amount }}
                                        </td>

                                    </tr><!-- /tr --><!-- tr -->
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
        <header class="page-title-bar d-none">
            <!-- floating action -->

            <button type="button" class="btn btn-success btn-floated btn-add " id="paymentadd" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
