          <script>
                                $(document).ready(() => {
                                    $.ajax({
                                        method: 'get',
                                        url: '{{ route('requestSchooldataJson') }}',
                                        success: (response) => {
                                            if (response.mitdata.length > 0) {
                                                var html = '';

                                                for (var i = 0; i < response.mitdata.length; i++) {
                                                    const dataall = response.mitdata[i];
                                                    const submit_id = dataall.submit_id;
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

                                                    html += `
                                                    <tr>
                                                        <td class="text-center">${i + 1}</td>
                                                        <td class="text-center">${dataall.fullname !== null ? dataall.fullname : ''}</td>
                                                        <td class="text-center">${dataall.school !== null ? dataall.school : ''}</td>
                                                        <td class="text-center">${dataall.proviUser !== null ? dataall.proviUser : ''}</td>
                                                        <td class="text-center">${dataall.startdate !== null ? dataall.startdate : ''}</td>
                                                        <td class="text-center">${dataall.enddate !== null ? dataall.enddate : ''}</td>
                                                        <td class="text-center align-middle">
                                                             ${dataall.submit_status == 0 ? 'รอ' :
                                                            (dataall.submit_status == 1 ? 'ผ่าน' : 
                                                            (dataall.submit_status == 2 ? 'หมดสิทธิ์' : 'Unknown Status'))}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                                ${linkedata}
                                                        </td>
                                                    </tr>
                                                            `;
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



                                                })



                                            }
                                        }
                                    });
                               
                                });
                            </script>