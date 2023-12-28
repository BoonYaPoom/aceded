<div class="modal fade " id="clientUploadModal-{{ $c->claim_user_id }}" tabindex="-1" user_role="dialog"
    aria-labelledby="clientUploadModalLabel" aria-modal="true">
    <!-- .modal-dialog -->
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog  modal-lg" user_role="document">
            <!-- .modal-content -->
            <div class="modal-content">
                <!-- .modal-header -->
                <div class="modal-header" style="background-color: #F04A23;">
                    <h6 id="clientUploadModalLabel" class="modal-title text-white">
                        <span class="sr-only">Upload</span> <span><i class="fas fa-user-plus text-white"></i>
                            {{ $c->claim_user_id }} เลือกหน่วยงาน</span>
                    </h6>
                </div>

                <div class="modal-body" data-claim-user-id="">

                    <table class="table w3-hoverable">

                        <thead>
                            <tr class="bg-infohead">
                                <th class="align-middle" style="width: 10%">ลำดับ</th>
                                <th class="align-middle" style="width: 40%">ชื่อหน่วยงาน</th>
                                <th class="align-middle" style="width: 40%">สถานะ</th>

                            </tr>
                        </thead>
                        <tbody id="modalTable-{{ $c->claim_user_id }}">
                            <!-- ข้อมูลจะถูกแทรกที่นี่โดยใช้ JavaScript -->
                        </tbody>
                    </table>
                    <script>
                        function showModal(claimUserId) {
                            // เปิด Modal ด้วย claimUserId
                            $('#clientUploadModal-' + claimUserId).modal('show');

                            // ดึงข้อมูล claim_user_id จากตาราง 'department_claim'
                            $.ajax({
                                type: 'GET',
                                url: '/admin/req/get-claim-data/' + claimUserId,
                                success: function(data) {
                                    console.log(data);
                                    var html = '';
                                    var num = 1;
                                    for (var i = 0; i < data.claimData.length; i++) {
                                        if (data.claimData[i].claim_status == 1 || data.claimData[i].claim_status == 0) {
                                            html += '<tr>';
                                            html += '<td>' + (num++) + '</td>';
                                            html += '<td>' + data.claimData[i].department_name + '</td>';
                                            html += '<td>' + (data.claimData[i].claim_status == 0 ? 'ไม่ต้องการ' : (data.claimData[i]
                                                .claim_status == 1 ? 'ขอรับสิทธิ์' : 'Unknown Status')) + '</td>';

                                            html += '</tr>';
                                        }

                                    }
                                    // นำ HTML ไปแทรกในตาราง
                                    $('#modalTable-' + claimUserId).html(html);
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        }
                    </script>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>
                </div><!--/.modal-footer-->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
  
</div>
