@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->

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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table w3-hoverable">
                            <div class="dataTables_filter text-right">
                                <label>ค้นหา
                                    <input type="search" id="myInput" class="form-control" placeholder=""
                                        aria-controls="datatable">
                                </label>
                            </div>
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="5%">ลำดับ</th>
                                    <th>สถานศึกษา</th>
                                    <th width="20%">หน่วยงาน</th>
                                    <th width="15%">จำนวน</th>

                                    <th width="10%" class="text-center">เพิ่มสมาชิก</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable').DataTable({
                                        ajax: {
                                            url: '{{ route('getExtender', [$depart]) }}',
                                            type: 'GET',
                                            data: function(d) {
                                                d.myInput = $('#myInput').val();
                                            },
                                        },
                                        serverSide: true,

                                        columns: [{
                                                data: 'num'
                                            },
                                            {
                                                data: 'NAME'
                                            },
                                            {
                                                data: 'parentExtender'
                                            },
                                            {
                                                data: null,
                                                render: function(data, type, row) {
                                                    var link = '<i class="fas fa-users"></i> (' + data.count + ')';
                                                    return link;
                                                }
                                            },
                                            {
                                                data: null,
                                                className: "text-center",
                                                render: function(data, type, row) {

                                                    var extender_id = data.EXTENDER_ID;
                                                    var depart = {!! json_encode($depart->department_id) !!};

                                                    var edituser =
                                                        "{{ route('umsschoolDP_add', ['department_id' => ':depart', 'extender_id' => ':extender_id']) }}";
                                                    edituser = edituser.replace(':depart', depart).replace(':extender_id',
                                                        extender_id);
                                                    var update = '<a href="' + edituser +
                                                        '"><i class="fas fa-user-plus"></i></a>';
                                                    return update;
                                                },

                                            },
                                        ],
                                        order: [
                                            [0, 'asc']
                                        ],
                                        deferRender: true,
                                        lengthChange: false,
                                        responsive: true,
                                        info: false,
                                        paging: true,
                                        pageLength: 10,
                                        scrollY: false,
                                        processing: true,
                                        language: {
                                            infoEmpty: "ไม่พบรายการ",
                                            infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                            processing: "<span class='fa-stack fa-lg'>\n\
                                                                                                                                                                        <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                                                                                                                                                                   </span>&emsp;กรุณารอสักครู่",
                                            paginate: {
                                                first: "หน้าแรก",
                                                last: "หน้าสุดท้าย",
                                                previous: "ก่อนหน้า",
                                                next: "ถัดไป"
                                            }
                                        }
                                    });
                                    $('#myInput').on('keyup', function() {
                                        table.search(this.value).draw();
                                    });


                                });
                            </script>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
