@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('surveypage', ['department_id' => $sur->department_id]) }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> / <i>  {{ $sur->survey_th }}</i></div><!-- /.card-header -->

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
                                    <th class="align-middle" style="width:60%"> คำถาม </th>
                                    <th class="align-middle" style="width:10%"> ประเภท </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php($i = 1)
                                @foreach ($surques->sortBy('question_id') as $item)
                                    <tr>
                                        <td><a href="#">{{ $i++ }}</a></td>
                                        <td>{!! $item->question !!}</td>
                                        <td>{{ $item->question_type == 1 ? 'ตัวเลือก' : ($item->question_type == 2 ? 'หลายมิติ' : 'เขียนอธิบาย') }}
                                        </td>
                                        <td class="align-middle"> <label
                                            class="switcher-control switcher-control-success switcher-control-lg">
                                            <input type="checkbox" class="switcher-input switcher-edit"
                                                {{ $item->question_status == 1 ? 'checked' : '' }}
                                                data-question-id="{{ $item->question_id }}">
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on">ON</span>
                                            <span class="switcher-label-off text-red">OFF</span>
                                        </label></td>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var question_status = $(this).prop('checked') ? 1 : 0;
                                                    var question_id = $(this).data('question-id');
                                                    console.log('question_status:', question_status);
                                                    console.log('question_id:', question_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatuQuestion') }}',
                                                        data: {
                                                            'question_status': question_status,
                                                            'question_id': question_id
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
                                            <a href="{{ route('editque', [$item->question_id]) }}"><i
                                                    class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destoryReport', ['question_id' => $item]) }}" onclick="deleteRecord(event)" class="switcher-delete"
                                                data-toggle="tooltip" title="ลบ"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr>
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
                onclick="window.location='{{ route('questionpagecreate', ['survey_id' => $sur]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
