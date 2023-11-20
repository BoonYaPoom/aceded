
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            ajax: {
                url: '{{ route('getSchools') }}',
                dataSrc: 'schoolsaa',
            },
            columns: [{
                    data: 'num'
                }, // Replace with your actual column name
                {
                    data: 'school_name'
                }, // Replace with your actual column name
                {
                    data: 'province_name'
                },
                {
                    data: 'userCount',
                    render: function(data, type, row) {

                        var link = '<i class="fas fa-users"></i> (' + data + ')';
                        return link;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {

                        var schoolcode = data.code;
                        var url =
                            "{{ route('umsschooluser', ['school_code' => 'schoolcode']) }}";
                        url = url.replace('schoolcode', schoolcode);

                        var link = '<a href="' + url + '"><i class="fas fa-user-plus"></i></a>';
                        return link;
                    },
                },
                {
                    data: null,
                    render: function(data, type, row) {

                        var schoolId = data.id;

                        var deleteschool =
                            "{{ route('deleteschool', ['school_id' => 'schoolId']) }}";
                        deleteschool = deleteschool.replace('schoolId', schoolId);

                        var editschool =
                            "{{ route('editschool', ['school_id' => 'schoolId']) }}";
                        editschool = editschool.replace('schoolId', schoolId);

                        var linkb = '<a href="' + editschool +
                            '" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit fa-lg text-success mr-3"></i></a>';
                        var linkc = '<a href="' + deleteschool +
                            '" onclick="deleteRecord(event)" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning"></i></a>';
                        return linkb + linkc;

                    },

                },
            ],
            deferRender: true,
            success: function(data) {
                if (data.success) {
                    // การเข้าถึงข้อมูลสำเร็จ
                    console.log('การเข้าถึงข้อมูลสำเร็จ:', data.message);
                } else {
                    // การเข้าถึงข้อมูลไม่สำเร็จ
                    console.error('การเข้าถึงข้อมูลไม่สำเร็จ:', data.message);
                }
            },

            lengthChange: false,
            responsive: true,
            info: false,
            serverSide: false,
            pageLength: 20,
            scrollY: '100%',

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
        $('#drop2').on('change', function() {
            var selecteddrop2Id = $(this).val();
            if (selecteddrop2Id == 0) {
                table.columns(2).search('').draw();
            } else {
                // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                table.columns(2).search(selecteddrop2Id).draw();
            }
        });
        $('#myInput').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>

