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
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">คำขอสมัคร Admin สถานศึกษา</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="dataTables_filter text-right">
                            <label>ค้นหา
                                <input type="search" id="myInput" class="form-control" placeholder=""
                                    aria-controls="datatable">
                            </label>
                        </div>
                        <table id="datatable2" class="table w3-hoverable">
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" width="5%"> รหัส </th>
                                    <th class="align-middle" width="20%"> ชื่อผู้ขอ </th>
                                    <th class="align-middle" width="20%"> โรงเรียน </th>
                                    <th class="align-middle" width="15%"> สังกัด </th>
                                    <th class="align-middle" width="10%"> วันที่ขอ </th>
                                    <th class="align-middle" width="10%"> วันที่ยืนยัน </th>
                                    <th class="align-middle" width="10%"> สถานะ </th>
                                    <th class="align-middle" width="10%"> กระทำ </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            var table = $('#datatable2').DataTable({
                ajax: {
                    url: '{{ route('requestSchooldataJson') }}',
                    dataSrc: 'mitdata',
                },
                columns: [{
                        data: 'num',
                        className: 'text-center'
                    },
                    {
                        data: 'fullname',

                    },
                    {
                        data: 'school',

                    },
                    {
                        data: 'proviUser',

                    },
                    {
                        data: 'startdate',
       
                    },
                    {
                        data: 'enddate',
                  
                    },
                    {
                        data: 'submit_status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var linkedata = '<td class="align-middle">';
                            console.log(row.submit_status);
                            linkedata += (row.submit_status == 0 ? 'รอ' :
                                (row.submit_status == 1 ? 'ผ่าน' :
                                    (row.submit_status == 2 ? 'หมดสิทธิ์' : 'Unknown Status')));

                            linkedata += '</td>';
                            return linkedata;
                        },

                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            var submit_id = data.submit_id;
                            var detaildata =
                                "{{ route('detaildata', ['submit_id' => 'submit_id']) }}";
                            detaildata = detaildata.replace('submit_id', submit_id);

                            var linkedata =
                                '<a href="' + detaildata +
                                '" data-toggle="tooltip" title="ดูประวัติ"><i class="far fa-address-book text-info  mr-1 fa-lg "></i></a>';
                            return linkedata;

                        },
                    },
                ],

                lengthChange: false,
                responsive: true,
                info: true,
                pageLength: 30,

                language: {
                    zeroRecords: "ไม่พบข้อมูลที่ต้องการ",
                    info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    infoEmpty: "ไม่พบข้อมูลที่ต้องการ",
                    infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        previous: "ก่อนหน้า",
                        next: "ถัดไป"
                    }
                },

            });

            $('#myInput').on('keyup', function() {
                var searchTerm = this.value;
                table.columns().search('').draw(); // รีเซ็ตการค้นหาทั้งหมด
                if (searchTerm !== '') {
                    table.columns(2).search(searchTerm, true, false).draw(); // ค้นหาเฉพาะในคอลัมน์ 'school'
                }
            });


        });
    </script>
@endsection
