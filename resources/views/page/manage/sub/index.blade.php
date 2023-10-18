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


    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">

                <div class="card-header bg-muted">หน่วยงาน /
                    <a href="{{ route('learn', ['department_id' => $depart->department_id]) }}">หมวดหมู่</a> / จัดการวิชา
                </div>

                <div class="card-body">





                    <table id="datatable" class="table w3-hoverable table-striped no-footer" user_role="grid"
                        aria-describedby="datatable_info">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="top">
                                    <div class="dt-buttons btn-group"> <button
                                            class="btn btn-secondary buttons-excel buttons-html5"
                                            onclick="window.location='{{ route('exportSubject') }}'" tabindex="0"
                                            aria-controls="datatable" type="button">
                                            <span>Excel</span></button> </div>

                                    <div id="datatable_filter" class="dataTables_filter">
                                        <label>ค้นหา<input type="search" id="myInput" class="form-control" placeholder=""
                                                aria-controls="datatable"></label>
                                    </div>

                                </div>
                            </div>
                            <thead>
                                <tr class="bg-infohead" user_role="row">
                                    <th class="align-middle sorting" style="width: 34.6875px;" aria-controls="datatable"
                                        rowspan="1" colspan="1"
                                        aria-label=" ลำดับ : activate to sort column ascending"> ลำดับ </th>
                                    <th class="align-middle sorting" style="width: 166.587px;" tabindex="0"
                                        aria-controls="datatable" rowspan="1" colspan="1"
                                        aria-label=" รหัส : activate to sort column ascending"> รหัส </th>
                                    <th class="align-middle sorting_asc" style="width: 373.888px;" tabindex="0"
                                        aria-controls="datatable" rowspan="1" colspan="1"
                                        aria-label=" ชื่อวิชา (ไทย) : activate to sort column descending"
                                        aria-sort="ascending">
                                        ชื่อวิชา (ไทย) </th>
                                    <th class="align-middle sorting" style="width: 373.95px;" tabindex="0"
                                        aria-controls="datatable" rowspan="1" colspan="1"
                                        aria-label=" ชื่อวิชา (อังกฤษ) : activate to sort column ascending"> ชื่อวิชา
                                        (อังกฤษ)
                                    </th>
                                    <th class="align-middle sorting" style="width: 97.488px;" tabindex="0"
                                        aria-controls="datatable" rowspan="1" colspan="1"
                                        aria-label=" สถานะ : activate to sort column ascending"> สถานะ </th>
                                    <th class="align-middle sorting" style="width: 97.5px;" tabindex="0"
                                        aria-controls="datatable" rowspan="1" colspan="1"
                                        aria-label=" กระทำ: activate to sort column ascending"> กระทำ</th>
                                </tr>
                            </thead>

                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable').DataTable({

                                        lengthChange: false,
                                        responsive: true,
                                        info: false,
                                        language: {

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

                            <tbody>
                                @php

                                    $subnum = 1;
                                @endphp
                                @foreach ($subs->sortBy('subject_id') as $index => $item)
                                    <tr>
                                        <td><a href="#">{{ $subnum++ }}</a></td>
                                        <td><a
                                                href="{{ route('lessonpage', [$depart, $item->subject_id]) }}">{{ $item->subject_code }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('lessonpage', [$depart, $item->subject_id]) }}">{{ $item->subject_th }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('lessonpage', [$depart, $item->subject_id]) }}">{{ $item->subject_en }}</a>
                                        </td>

                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->subject_status == 1 ? 'checked' : '' }}
                                                    data-subject-id="{{ $item->subject_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label></td>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var subject_status = $(this).prop('checked') ? 1 : 0;
                                                    var subject_id = $(this).data('subject-id');
                                                    console.log('subject_status:', subject_status);
                                                    console.log('subject_id:', subject_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatusSubject') }}',
                                                        data: {
                                                            'subject_status': subject_status,
                                                            'subject_id': subject_id
                                                        },
                                                        success: function(data) {
                                                            console.log(data.message);
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.log('ข้อผิดพลาด');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                        <td class="align-middle">
                                            <a href="{{ route('editsub', [$depart, $item->subject_id]) }}"><i
                                                    class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destorysub', [$item->subject_id]) }}"
                                                onclick="deleteRecord(event)"
                                                rel="หน่วยการเรียนรู้ที่ 1 การคิดแยกแยะระหว่างผลประโยชน์ส่วนตนและผลประโยชน์ส่วนรวม"
                                                class="switcher-delete" data-toggle="tooltip" title="ลบข้อมูล"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </div>
                </div>
                </table>
            </div>
        </div>
    </div>
    <header class="page-title-bar">
        <button type="button" class="btn btn-success btn-floated btn-add"
            onclick="window.location='{{ route('subcreate', [$depart->department_id]) }}'" data-toggle="tooltip"
            title="เพิ่ม"><span class="fas fa-plus"></span></button>
    </header>

    </div>
@endsection
