<script>
    $(document).ready(function() {

        var user_roleValue = "{{ request('user_role') }}";


        var table = $('#datatable').DataTable({
            ajax: {
                url: '{{ route('UserManagejson') }}' + user_roleValue,

                dataSrc: 'userAll',
            },
            columns: [{
                    data: 'num'
                },
                {
                    data: 'username'
                },
                {
                    data: 'fullname'
                },
                {
                    data: 'mobile'
                },
                {
                    data: 'email'
                },
                {
                    data: 'proviUser'
                },
                {
                    data: 'department'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        // สร้าง HTML สำหรับสวิทช์ ON/OFF โดยใช้ข้อมูล 'page_status'
                        var switcherHtml =
                            '<td class="align-middle"><label class="switcher-control switcher-control-success switcher-control-lg">' +
                            '<input type="checkbox" class="switcher-input switcher-edit" ' + (
                                data == 1 ? 'checked' : '') +
                            ' data-user_id="' + row.id + '" data-user_status="' + data +
                            '">' +
                            '<span class="switcher-indicator"></span>' +
                            '<span class="switcher-label-on">ON</span>' +
                            '<span class="switcher-label-off text-red">OFF</span>' +
                            '</label></td>';

                        return switcherHtml;

                    },

                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var userRole = data.user_role;
                        var user_id = data.id;
                        // ในสคริปต์ Blade คุณสามารถรับค่า user_role จาก Laravel
                        var user_dataLogin = {!! json_encode($data->user_role) !!};
                        
                        // กำหนด route และ id 
                        var logusers = "{{ route('logusers', ['user_id' => 'user_id']) }}";
                        logusers = logusers.replace('user_id', user_id);
                        var deleteuser = "{{ route('deleteUser', ['user_id' => 'user_id']) }}";
                        deleteuser = deleteuser.replace('user_id', user_id);
                        var edituser = "{{ route('editUser', ['user_id' => 'user_id']) }}";
                        edituser = edituser.replace('user_id', user_id);

                        // สร้างตัวแปรเก็บhtml stype
                        var linkedituser = '<a href="' + edituser +
                            '" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit text-success mr-1"></i></a>';

                        var linkdeleteuser = '<a href="' + deleteuser +
                            '" onclick="deleteRecord(event)" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบข้อมูล"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>';

                        var linklogusers = '<a href="' + logusers +
                            '" data-toggle="tooltip" title="ดูประวัติการใช้งาน"><i class="fas fa-history text-info"></i></a>';

                        var modelPass =
                            '<button class="btn sendtemppwd " data-toggle="modal" data-target="#clientWarningModal-' +
                            user_id +
                            '" title = "ส่งรหัสผ่าน" > <i class = "fas fa-key text-info" > </i></button > ';

                        var modelRole =
                            ' <a data-toggle="modal" data-target="#clientPermissionModal-' +
                            user_id +
                            '" title="กำหนดสิทธิ์"><i class="fas fa-user-shield text-danger"></i></a>';

                        var Admina =
                            ' <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์"><i class="fas fa-user-shield text-bg-muted "></i></a>';

                        // ตรวจสอบเงื่อนไข
                        if (row.user_role == 1 || row.user_role == 8) {
                            return Admina + (user_dataLogin == 1 || user_dataLogin == 8 ?
                                linkedituser : '');
                        } else {
                            return linkedituser + linklogusers + modelPass + modelRole +
                                linkdeleteuser;
                        }
                    },
                },
            ],
            lengthChange: false,
            responsive: true,
            info: true,
            pageLength: 50,
            scrollY: '100%',
            language: {
                zeroRecords: "ไม่พบข้อมูลที่ต้องการ",
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
        $('#myInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // คำค้นโดยการเลือกค่าจาก select box 'department_id'
        $('#department_id').on('change', function() {
            var selectedDepartmentId = $(this).val();
            if (selectedDepartmentId == 0) {
                table.column(6).search('').draw();
            } else {
                table.column(6).search(selectedDepartmentId).draw();
            }
        });

        // คำค้นโดยการเลือกค่าจาก select box 'drop2'
        $('#drop2').on('change', function() {
            var selectedDrop2Id = $(this).val();
            if (selectedDrop2Id == 0) {
                table.column(5).search('').draw();
            } else {
                table.column(5).search(selectedDrop2Id).draw();
            }
        });
    });


    $(document).on('change', '.switcher-input', function() {
        var user_id = $(this).data('user_id');
        var user_status = $(this).data('user_status');
        var changeStatusUrl = '{{ route('changeStatusUser', ['user_id' => ':user_id']) }}';
        changeStatusUrl = changeStatusUrl.replace(':user_id', user_id);
        $.get(changeStatusUrl, function(response) {
            if (response.message) {
                console.log(response.message);
            }
        });
    });
</script>
