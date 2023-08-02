@extends('layouts.adminhome')
@section('content')
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

    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->


                <div class="card-header bg-muted"><a href="{{ route('lessonpage', [$subs->subject_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href="{{ route('categoryac', [$subs->subject_id]) }}" style="text-decoration: underline;">
                        กระดานสนทนา</a>
                    / <i> {{ $Category->category_th }}</i></div><!-- /.card-header -->

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
                                    <th class="align-middle" style="width:30%"> เรื่อง </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->@php($i = 1)
                                @foreach ($topic as $t)
                                    <tr id="">
                                        <td><a href="#">{{ $i++ }}</a></td>
                                        <td>{{ $t->topic_th }}</td>
                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $t->topic_status == 1 ? 'checked' : '' }}
                                                    data-topic-id="{{ $t->topic_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label>
                                        </td>


                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var topic_status = $(this).prop('checked') ? 1 : 0;
                                                    var topic_id = $(this).data('topic-id');
                                                    console.log('topic_status:', topic_status);
                                                    console.log('topic_id:', topic_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatuCategoryTopic') }}',
                                                        data: {
                                                            'topic_status': topic_status,
                                                            'topic_id': topic_id
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
                                            <a href="" target=_blank><i class="fas fa-eye fa-lg text-success"
                                                    data-toggle="tooltip" title="ข้อมูล"></i></a>
                                            <a href="{{ route('topic_destroy', [$t->topic_id]) }}" id=""
                                                rel="test" onclick="deleteRecord(event)" class="switcher-delete"
                                                data-toggle="tooltip" title="ลบ"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->



            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    @endsection
