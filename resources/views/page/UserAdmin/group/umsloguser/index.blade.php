@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"> <a href="{{ route('UserManage') }}">ประวัติการใช้งาน
                        {{ $users->firstname }} ({{ $users->firstname }})</a></div>
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->

                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ </th>
                                    <th width="15%">ประวัติ </th>
                                    <th width="12%">วันที่ </th>
                                    <th width="8%">ไอพี </th>
                                    <th width="12%">เบราว์เซอร์ </th>
                                    <th width="8%">ระบบปฏิบัติการ </th>

                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>

                                @php
                                    $indexlog = 1;
                                @endphp

                                @foreach ($logss as $index => $loguser)
                                    <tr>
                                        <td>{{ $indexlog++ }}</td>
                                        <td>{{ $loguser->Logid->description }}</td>
                                        <td>{{ $loguser->logdate }}</td>
                                        <td>{{ $loguser->logip }}</td>
                                        <td>{{ $loguser->logagents }}</td>
                                        <td>{{ $loguser->logplatform }}</td>
                                    </tr>
                                    <!-- /tr -->
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <hr>
                    <!-- .table-responsive -->
                    <script>
                        $(document).ready(function() {
                            var table = $('#datatable').DataTable({

                                lengthChange: false,
                                responsive: true,
                                info: false,
                                pageLength: 30,
                                language: {
                                    info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
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
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
