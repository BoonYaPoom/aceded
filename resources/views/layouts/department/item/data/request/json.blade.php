<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
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
                    className: 'text-center'
                },
                {
                    data: 'school',
                    className: 'text-center'
                },
                {
                    data: 'proviUser',
                    className: 'text-center'
                },
                {
                    data: 'startdate',
                    className: 'text-center'
                },
                {
                    data: 'startdate',
                    className: 'text-center'
                },
                {
                    data: 'enddate',
                    className: 'text-center'
                },
                {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        var submit_id = data.submit_id;
                        var detaildata =
                            "{{ route('detaildata', ['submit_id' => 'submit_id']) }}";
                        detaildata = detaildata.replace('submit_id', submit_id);
                        var storeAdmin =
                            "{{ route('storeAdminreq', ['submit_id' => 'submit_id']) }}";
                        storeAdmin = storeAdmin.replace('submit_id', submit_id);
                        var linkedata =
                            '<a href="' + detaildata +
                            '" data-toggle="tooltip" title="ดูประวัติ"><i class="far fa-address-book text-info  mr-1 fa-lg "></i></a>';

                        var linkdelete =
                            '<a href="" onclick="deleteRecord(event)" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบข้อมูล"><i class="fas fa-trash-alt  text-warning mr-1 fa-lg "></i></a>';
                        var linkPlus =
                            '<a href="' + storeAdmin +
                            '"  rel="" onclick="createRecord(event)" data-toggle="tooltip" title="กดยืนยัน"><i class="fas fa-plus text-success mr-1 fa-lg "></i></a>';

                        return linkPlus + linkedata + linkdelete;

                    },
                },
            ],

            lengthChange: false,
            responsive: true,
            info: true,
            pageLength: 30,
            scrollY: '100%',
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
        $('#provines_code').on('change', function() {
            var selectedprovines_code = $(this).val();
            if (selectedprovines_code == 0) {
                table.columns(3).search('').draw();
            } else {
                // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                table.columns(3).search(selectedprovines_code).draw();
            }
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
