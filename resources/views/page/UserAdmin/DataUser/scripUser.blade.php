<script>
    $(document).ready(function() {
        var user_roleValue = "{{ request('user_role') }}";
        var table = $('#datatable').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('UserManagejson') }}' + user_roleValue,
                data: function(d) {
                    d.myInput = $('#myInput').val();
                    d.drop2 = $('#drop2').val();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('DataTables Error:', errorThrown);
                    location.reload();
                }
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
                    data: 'name_in_thai'
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

                        var classroom =
                            "{{ route('classroom_all', ['user_id' => ':user_id']) }}";
                        classroom = classroom.replace(':user_id',
                            user_id);
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
                            ' <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์"><i class="fas fa-user-shield text-bg-muted "></i></a>  &nbsp;';

                        var users =
                            ' <i class="fas fa-user text-primary"></i> &nbsp;';

                        var classroom = '<a href="' + classroom +
                            '" data-toggle="tooltip" title="ดูประวัติการใช้งาน"><i class="fas fa-book text-info"></i></a> &nbsp;';
                        // ตรวจสอบเงื่อนไข
                        if (row.user_role == 1 || row.user_role == 8) {
                            return Admina + (user_dataLogin == 1 || user_dataLogin == 8 ?
                               classroom +  linkedituser + linklogusers + linkdeleteuser : '');
                        } else {
                            return users +   (user_dataLogin == 1 || user_dataLogin == 8 ||
                                user_dataLogin == 6 ||
                                user_dataLogin == 7 ?
                              classroom +   linkedituser + linkdeleteuser : '');
                        }

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
            pageLength: 50,
            scrollY: false,

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

        function performSearch() {
            var inputValue = $('#myInput').val();
            var selectedDrop2Id = $('#drop2').val();

            table.search(inputValue);

            if (selectedDrop2Id == 0) {
                table.column(5).search('').draw();
            } else {
                table.column(5).search(selectedDrop2Id).draw();
            }

            table.ajax.reload();
        }

        // ผูกตัวจัดการเหตุการณ์
        $('#myInput, #drop2').on('keyup change', function() {
            performSearch();
        });



    });


    $(document).on('change', '.switcher-input.switcher-edit', function() {
        var userstatus = $(this).prop('checked') ? 1 : 0;
        var user_id = $(this).data('user_id');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('changeStatusUser') }}',
            data: {
                'userstatus': userstatus,
                'user_id': user_id
            },
            success: function(data) {
                console.log(data);
                console.log(user_id);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
</script>
