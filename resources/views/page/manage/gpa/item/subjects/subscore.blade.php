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
                    <a href="{{ route('learn', ['department_id' => $depart->department_id]) }}">หมวดหมู่</a> / จัดการคะแนนวิชา
                </div>

                <div class="card-body">
                    <table id="datatable" class="table w3-hoverable table-striped no-footer" user_role="grid"
                        aria-describedby="datatable_info">
                        <div class="table-responsive">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="top">


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
                                @foreach ($subs as $index => $item)
                                    @php                                    
                                        $subnum = $index + 1;
                                    @endphp
                                    <tr>
                                        <td><a href="#">{{ $subnum }}</a></td>
                                        <td><a href="">{{ $item->subject_code }}</a>
                                        </td>
                                        <td><a href="">{{ $item->subject_th }}</a>
                                        </td>
                                        <td><a href="">{{ $item->subject_en }}</a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('listsubjects', [$item->subject_id]) }}"><i
                                                    class="fa fa-star fa-lg text-success" data-toggle="tooltip"
                                                    title="คะแนนรวยบุคคล"></i></a>

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


    </div>
@endsection
