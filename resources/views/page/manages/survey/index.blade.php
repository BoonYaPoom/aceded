@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <i> แบบสำรวจ</i></div><!-- /.card-header -->

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
                                    <th class="align-middle" style="width:30%"> ชื่อ </th>
                                    <th class="align-middle d-none" style="width:30%"> ชื่อ (อังกฤษ) </th>
                                    <th class="align-middle" style="width:10%"> ภาษา </th>
                                    <th class="align-middle text-center" style="width:10%"> QR </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->

                                @php($i = 1)
                                @foreach ($sur->sortBy('survey_id') as $item)
                                    @if ($item->subject_id == 0)
                                        <tr>
                                            <td><a href="#">{{ $i++ }}</a></td>
                                            <td>{{ $item->survey_th }}</td>
                                            <td class="d-none"></td>
                                            <td>{{ $item->survey_lang }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset($item->cover) }}" download="{{ $item->cover }}">
                                                    <img src="{{ asset($item->cover) }}" alt="{{ $item->cover }}" width="100" height="100">
                                                </a>
                                            </td>
                                            
                                            <td class="align-middle"> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit"
                                                        {{ $item->survey_status == 1 ? 'checked' : '' }}
                                                        data-survey-id="{{ $item->survey_id }}">
                                                    <span class="switcher-indicator"></span>
                                                    <span class="switcher-label-on">ON</span>
                                                    <span class="switcher-label-off text-red">OFF</span>
                                                </label></td>

                                            <script>
                                                $(document).ready(function() {
                                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                        var survey_status = $(this).prop('checked') ? 1 : 0;
                                                        var survey_id = $(this).data('survey-id');
                                                        console.log('survey_status:', survey_status);
                                                        console.log('survey_id:', survey_id);
                                                        $.ajax({
                                                            type: "GET",
                                                            dataType: "json",
                                                            url: '{{ route('changeStatuSurvey') }}',
                                                            data: {
                                                                'survey_status': survey_status,
                                                                'survey_id': survey_id
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
                                                <a
                                                    href="{{ route('questionpage', ['department_id' => $depart, $item->survey_id]) }}"><i
                                                        class="fas fa-plus-circle fa-lg text-info" data-toggle="tooltip"
                                                        title="เพิ่มคำถาม"></i></a>
                                                <a
                                                    href="{{ route('wmspage', ['department_id' => $depart, $item->survey_id]) }}"><i
                                                        class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                                        title="รายงานผล"></i></a>
                                                <a
                                                    href="{{ route('editsur', ['department_id' => $depart, $item->survey_id]) }}"><i
                                                        class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>
                                                <a href="{{ route('dessur', [$item->survey_id]) }}"
                                                    onclick="deleteRecord(event)"
                                                    rel="แบบประเมินความพึงพอใจที่มีต่อบทเรียนออนไลน์ รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                                    class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                                    <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr -->
                                    @endif
                                    <!-- tr -->
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
                onclick="window.location='{{ route('createsurvey', ['department_id' => $depart]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
