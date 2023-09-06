@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- .page-inner -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('surveyact', [$sur->subject_id]) }}"
                        style="text-decoration: underline;"> จัดการวิชา </a> / <a
                        href="{{ route('surveyquestion', [$sur->survey_id]) }}" style="text-decoration: underline;">แบบสำรวจ</a>
                    / <i>{{ $sur->survey_th }} </i></div><!-- /.card-header -->
                <!-- .nav-scroller -->

                <div class="nav-scroller border-bottom">

                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <div class="form-actions mb-2">
                            <form id="surveyform" name="surveyform" action="">
                                <select class="form-control form-control-lg" name="class_id" id="class_id"
                                    onchange="$('#surveyform').submit();">
                                    <option name="">เลือกกลุ่มเรียน</option>
                                </select>
                            </form>
                            <a class="btn btn-lg btn-success ml-auto mr-4 text-white" href=""><i
                                    class="fa fa-file"></i>
                                Exoprt CSV</a>
                        </div>
                        <table class="table " border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle"> คำถาม </th>
                                    <th class="align-middle" style="width:40%"> ประเภท </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>

                            </thead><!-- /thead -->
                            <!-- tbody -->

                            <tbody>
                                @foreach ($surques as $item)
                                    <tr>
                                        <td><a href="#">{{ $item->question_id }}</a></td>
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
                                            <a href="{{ route('editreport', ['question_id' => $item]) }}"><i
                                                    class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destoryReport', ['question_id' => $item]) }}"
                                                onclick="deleteRecord(event)" rel="คำถาม" class="switcher-delete"
                                                data-toggle="tooltip" title="ลบ"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
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
            <input type="hidden" name="__id" />
            <button type="button" onclick="window.location='{{ route('createreport', ['survey_id' => $sur]) }}'"
                class="btn btn-success btn-floated btn-addwms" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
