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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- .card-body -->

    <div class="card-header bg-muted"> <a href="{{ route('surveyquestion', [$depart, $subs, $sur->survey_id]) }}"
        style="text-decoration: underline;">{!! $sur->survey_th !!}</a>
</div>

    <div class="card-body">

        <!-- .table-responsive -->
        <div class="table-responsive">
            <table class="table w3-hoverable">
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
                    @php
                        $qi = 1;
                    @endphp
                    @foreach ($surques->sortBy('question_id') as $item)
                        <tr>
                            <td><a href="#">{{ $qi++ }}</a></td>
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
                                <a href="{{ route('editreport', [$depart, 'question_id' => $item]) }}"><i
                                        class="far fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                                <a href="{{ route('destoryReport', ['question_id' => $item]) }}"
                                    onclick="deleteRecord(event)" rel="คำถาม" class="switcher-delete"
                                    data-toggle="tooltip" title="ลบ"><i
                                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
                            </td>
                        </tr><!-- /tr -->
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->


            <header class="page-title-bar">
                <!-- floating action -->
                <input type="hidden" name="__id" />
                <button type="button"
                    onclick="window.location='{{ route('createreport', [$depart, $subs, 'survey_id' => $sur]) }}'"
                    class="btn btn-success btn-floated btn-addwms" data-toggle="tooltip" title="เพิ่ม"><span
                        class="fas fa-plus"></span></button>
                <!-- /floating action -->
            </header><!-- /.page-title-bar -->
        </div>
    </div>
@endsection
