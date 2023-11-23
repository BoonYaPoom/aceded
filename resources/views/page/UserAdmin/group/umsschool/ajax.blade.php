<script>
    $(document).ready(() => {
        $.ajax({
            method: 'get',
            url: '{{ route('getSchools') }}',
            success: (response) => {
            console.log(response.allschool.datas);

          if (response.allschool.datas.length > 0) {
            var html = '';
                    for (var i = 0; i < response.allschool.datas.length; i++) {
                        const dataall = response.allschool.datas[i];

                        var linkcount = '<i class="fas fa-users"></i> (' +  dataall.userCount + ')';
                        var schoolId = dataall.id;
                        var schoolcode = dataall.code;

                        var url =
                            "{{ route('umsschooluser', ['school_code' => 'schoolcode']) }}";
                            url = url.replace('schoolcode', schoolcode);
                        var link = '<a href="' + url + '"><i class="fas fa-user-plus"></i></a>';
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

                        html += `<tr>
                            <td>${i + 1}</td>
                            <td>${dataall.school_name}</td>
                            <td>${dataall.province_name !== null ? dataall.province_name : ''}</td>

                            <td class="align-middle">
                                ${linkcount}
                                </td>
                            <td class="align-middle">
                                ${link}
                                </td>
                            <td>
                                ${linkb} ${linkc}
                            </td>
                        </tr>`;
                    }

                    $('#userallna').html(html).promise().done(() => {
                        var table = $('#datatable').DataTable({
                            lengthChange: false,
                            responsive: true,
                
                            info: true,
                            pageLength: 30,
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


                    })

               

                }
            }
        });

    });
</script>
