@extends('page.manage.sub.navsubject')
@section('subject-data')
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
                        <th class="align-middle" style="width:40%"> ชื่อ (ไทย) </th>
                        <th class="align-middle" style="width:40%"> ชื่อ (อังกฤษ) </th>
                        <th class="align-middle" style="width:5%"> สถานะ </th>
                        <th class="align-middle" style="width:10%"> กระทำ</th>
                    </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>
                    @php($i = 1)
                    @foreach ($suracts->sortBy('survey_id')  as $item)
                        <!-- tr -->

                        <tr>
                            <td><a href="#">{{ $i++ }}</a></td>
                            <td>{{ $item->survey_th }}</td>
                            <td>{{ $item->survey_en }}</td>

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
                                @if ($item->survey_type == 1 || $item->survey_type == 2)
                                    <a href="{{ route('surveyquestion', [$depart, $item->survey_id]) }}"><i
                                            class="fas fa-plus-circle fa-lg text-info" data-toggle="tooltip"
                                            title="เพิ่มคำถาม"></i></a>
                                    <a href="{{ route('reportpageSubject', [$depart, $item->survey_id]) }}"><i
                                            class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                            title="รายงาน"></i></a>
                                    <a href="{{ route('surveyform', [$depart, $item->survey_id]) }}"><i
                                            class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                            title="แก้ไข"></i></a>
                                @elseif ($item->survey_type == 0)
                                    <a href="{{ route('surveyquestion', [$depart, $item->survey_id]) }}"><i
                                            class="fas fa-plus-circle fa-lg text-info" data-toggle="tooltip"
                                            title="เพิ่มคำถาม"></i></a>
                                    <a href="{{ route('reportpageSubject', [$depart, $item->survey_id]) }}"><i
                                            class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                            title="รายงาน"></i></a>
                                    <a href="{{ route('surveyform', [$depart, $item->survey_id]) }}"><i
                                            class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                            title="แก้ไข"></i></a>
                                    <a href="{{ route('dessur', [$item->survey_id]) }}" onclick="deleteRecord(event)"
                                        rel="แบบประเมินความพึงพอใจที่มีต่อบทเรียนออนไลน์ รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                        class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                        <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                @endif
                            </td>
                        </tr><!-- /tr -->
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->
    <header class="page-title-bar">
        <!-- floating action -->
        <input type="hidden" name="__id" />
        <button type="button"
            onclick="window.location='{{ route('suycreate', [$depart, 'subject_id' => $subs]) }}'"class="btn btn-success btn-floated btn-add"
            id="add_surveyform" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
@endsection
