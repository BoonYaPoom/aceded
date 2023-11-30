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
                    <a href="{{ route('manage', ['department_id' => $depart]) }}"
                    style="text-decoration: underline;">จัดการเว็บ</a> / 
                    <a href="{{ route('manualpage', ['department_id' => $depart]) }}"
                    style="text-decoration: underline;">คู่มือใช้งาน</a> </div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                                    <th class="align-middle" style="width:70%"> คำถาม </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                    $m = 1;
                                @endphp
                            
                                    @foreach ($manuals->sortBy('manual_id') as $item)
                                        <tr>
                                            <td>{{ $m++ }}</td>
                                            <td>{{ $item->manual }}</td>



                                            <td class="align-middle">
                                                <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit"
                                                        {{ $item->manual_status == 1 ? 'checked' : '' }}
                                                        data-manual-id="{{ $item->manual_id }}">
                                                    <span class="switcher-indicator"></span>
                                                    <span class="switcher-label-on">ON</span>
                                                    <span class="switcher-label-off text-red">OFF</span>
                                                </label>
                                            </td>


                                            <script>
                                                $(document).ready(function() {
                                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                        var manual_status = $(this).prop('checked') ? 1 : 0;
                                                        var manual_id = $(this).data('manual-id');
                                                        console.log('manual_status:', manual_status);
                                                        console.log('manual_id:', manual_id);
                                                        $.ajax({
                                                            type: "GET",
                                                            dataType: "json",
                                                            url: '{{ route('changeStatusManual') }}',
                                                            data: {
                                                                'manual_status': manual_status,
                                                                'manual_id': manual_id
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

                                            <td class="align-middle">
                                                <a href="{{ route('editmanual', [$depart,'manual_id' => $item->manual_id]) }}"><i
                                                        class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>
                                                <a href="{{ route('destorymanual', ['manual_id' => $item->manual_id]) }}"
                                                    onclick="deleteRecord(event)"
                                                    rel="ACED"
                                                    class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                                    <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr -->
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
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('createmanual', ['department_id' => $depart]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
