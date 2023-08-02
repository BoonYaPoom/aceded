@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <i> แบบสำรวจ</i></div><!-- /.card-header -->

                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
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
                                @foreach ($sur as $item)
                                    @if ($item->subject_id == 0)
                                        <tr>
                                            <td><a href="#">{{ $i++ }}</a></td>
                                            <td>{{ $item->survey_th }}</td>
                                            <td class="d-none"></td>
                                            <td>{{ $item->survey_type == 1 ? 'TH' : 'EN' }}</td>
                                            <td class="text-center">
                                                {!! QrCode::generate(route('responsess', [$item->survey_id])) !!}
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
                                                <a href="{{ route('questionpage', [$item->survey_id]) }}"><i
                                                        class="fas fa-plus-circle fa-lg text-info" data-toggle="tooltip"
                                                        title="เพิ่มคำถาม"></i></a>
                                                <a href="{{ route('wmspage', [$item->survey_id]) }}"><i
                                                        class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                                        title="รายงานผล"></i></a>
                                                <a href="{{ route('editsur', [$item->survey_id]) }}"><i
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
                onclick="window.location='{{ route('createsurvey') }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
