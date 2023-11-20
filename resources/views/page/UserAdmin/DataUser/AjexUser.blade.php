<script>
    $(document).ready(() => {
        $.ajax({
            method: 'get',
            url: '{{ route('UserManagejson') }}',
            success: (response) => {
                if (response.datauser.length > 0) {
                    var html = '';

                    for (var i = 0; i < response.datauser.length; i++) {
                        const dataall = response.datauser[i];
                        const user_id = dataall.id;

                        var edituser = "{{ route('editUser', ['user_id' => 'user_id']) }}";
                        edituser = edituser.replace('user_id', user_id);
                        var logusers = "{{ route('logusers', ['user_id' => 'user_id']) }}";
                        logusers = logusers.replace('user_id', user_id);
                        var deleteuser = "{{ route('deleteUser', ['user_id' => 'user_id']) }}";
                        deleteuser = deleteuser.replace('user_id', user_id);
                        // สร้างตัวแปรเก็บhtml stype
                        var linkedituser = '<a href="' + edituser +
                            '" data-toggle="tooltip" title="แก้ไข"><i class="far fa-edit text-success mr-1"></i></a>';

                        var linkdeleteuser = '<a href="' + deleteuser +
                            '" onclick="deleteRecord(event)" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบข้อมูล"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>';

                        var linklogusers = '<a href="' + logusers +
                            '" data-toggle="tooltip" title="ดูประวัติการใช้งาน"><i class="fas fa-history text-info"></i></a>';



                        var Admina =
                            ' <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์"><i class="fas fa-user-shield text-bg-muted "></i></a>';
                        var switcherHtml =
                            '<label class="switcher-control switcher-control-success switcher-control-lg">' +
                            '<input type="checkbox" class="switcher-input switcher-edit" ' + (
                                dataall.status == 1 ? 'checked' : '') +
                            ' data-user_id="' + user_id + '" data-user_status="' + dataall.status +
                            '">' +
                            '<span class="switcher-indicator"></span>' +
                            '<span class="switcher-label-on">ON</span>' +
                            '<span class="switcher-label-off text-red">OFF</span>' +
                            '</label>';
                            var modelPass =
                            '<button class="btn sendtemppwd " data-toggle="modal" data-target="#clientWarningModal-' +
                            user_id +
                            '" title = "ส่งรหัสผ่าน" > <i class = "fas fa-key text-info" > </i></button > ';


                        var modelRole =
                            ' <a data-toggle="modal" data-target="#clientPermissionModal-' +
                            user_id +
                            '" title="กำหนดสิทธิ์"><i class="fas fa-user-shield text-danger"></i></a>';




                        const user_dataLogin = {!! json_encode($data->user_role) !!};
                        const isAdmin = dataall.user_role === '1' || dataall.user_role === '8';

                        let tdContent = '';
                        if (isAdmin) {
                            tdContent =
                                `${Admina} ${user_dataLogin === '1' || user_dataLogin === '8' ? linkedituser : ''}`;
                        } else {
                            tdContent =
                                `${linkedituser} ${linklogusers} ${modelPass} ${modelRole} ${linkdeleteuser}`;
                        }

                        html += `<tr>
                            <td>${i + 1}</td>
                            <td>${dataall.username}</td>
                            <td>${dataall.firstname} ${dataall.lastname}</td>
                            <td>${dataall.fullMobile}</td>
                            <td>${dataall.email}</td>
                            <td>${dataall.proviUser}</td>
                            <td>${dataall.department}</td>
                            <td class="align-middle">${switcherHtml}</td>
                            <td>
                                ${tdContent}
                            </td>

                        </tr>`;
                    }
                    //datatable

                    $('#userallna').html(html).promise().done(() => {
                        var table = $('#datatable').DataTable({
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

                    })

                }
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
