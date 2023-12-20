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
                <div class="card-header bg-muted"> <a href="{{ route('dls', ['department_id' => $depart->department_id]) }}"
                    style="text-decoration: underline;"> จัดการข้อมูลและความรู้</a> / หนังสืออิเล็กทรอนิกส์</div>
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <table id="datatable" class="table w3-hoverable">
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%"> ชื่อหมวด (ไทย) </th>
                                    <th class="align-middle" style="width:25%"> ชื่อหมวด (อังกฤษ) </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach ($book as $item)
                                    <tr>
                                        <td><a href="">{{ $i++ }}</a></td>
                                        <td>{{ $item->category_th }}</td>
                                        <td>{{ $item->category_en }}</td>
                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->category_status == 1 ? 'checked' : '' }}
                                                    data-category-id="{{ $item->category_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label></td>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var category_status = $(this).prop('checked') ? 1 : 0;
                                                    var category_id = $(this).data('category-id');
                                                    console.log('category_status:', category_status);
                                                    console.log('category_id:', category_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatuBookCategory') }}',
                                                        data: {
                                                            'category_status': category_status,
                                                            'category_id': category_id
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
                                            <a
                                                href="{{ route('bookcatpage', [$depart, 'category_id' => $item->category_id]) }}"><i
                                                    class="fas fa-book fa-lg text-info" data-toggle="tooltip"
                                                    title="ข้อมูล"></i></a>
                                            <a href="{{ route('editbook', [$depart, $item->category_id]) }}"><i
                                                    class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('bookdestory', [$depart, $item->category_id]) }}"
                                                onclick="deleteRecord(event)" rel="บทเรียนแบบ e-book ระดับปฐมวัย"
                                                class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
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
                                        }
                                    },

                                });


                            });
                        </script>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>

        <header class="page-title-bar">
            <!-- floating action -->
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('createbook', ['department_id' => $depart]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div>
@endsection
