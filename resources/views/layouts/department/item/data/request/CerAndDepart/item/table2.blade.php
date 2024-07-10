<div class="table-responsive">
    <!-- .table -->
    <table id="datatable1" class="table w3-hoverable">
        <!-- thead -->
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width:10%"> ลำดับ </th>
                <th class="align-middle" style="width:50%"> ชื่อคนขอแก้ใบประกาศ </th>
                <th class="align-middle" style="width:30%"> ชื่อไฟล์ใบประกาศ </th>
                <th class="align-middle" style="width:10%"> สถานะ </th>
                <th class="align-middle" style="width:10%"> กระทำ </th>
            </tr>
        </thead>
        <tbody>
            @php
                $c = 1;
            @endphp
            @foreach ($cert_file as $cer)
                @php
                    $users = \App\Models\Users::where('user_id', $cer->user_id)->first();
                @endphp
                <tr>
                    <td>{{ $c++ }}</td>
                    <td>{{ $users->firstname }} {{ $users->lastname }}</td>
                    <td><img onerror="this.onerror=null; this.src='{{ asset('/uploads/cer/errorcer1.png') }}';" 
                        src="{{ 'https://aced.nacc.go.th/' . $cer->certificate_file_path }}" width="100px"
                            height="100px" alt=""
                            onclick="$('#previewimage').prop('src',$(this).prop('src'));$('#modal01').css('display','block');">
                    </td>
                    <td>ขอแก้ไข</td>
                    <td>
                        <a href="{{ route('updateceryes', $cer->certificate_file_id) }}"
                            onclick="updateceryes(event)"><i class="fas fa-check fa-lg text-success"
                                data-toggle="tooltip" title="อนุมัติผ่าน"></i></a>
                        <a href="{{ route('updatecerno', $cer->certificate_file_id) }}" onclick="updatecerno(event)"><i
                                class="fas fa-times fa-lg text-danger" data-toggle="tooltip"
                                title="อนุมัติไม่ผ่าน"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody><!-- /tbody -->
    </table><!-- /.table -->
</div><!-- /.table-responsive -->
<div id="modal01" class="w3-modal" onclick="this.style.display='none'">
    <span class="w3-button w3-hover-red w3-xlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom">
        <img src="{{ env('URL_FILE_SFTP') . 'uploads/cer02_0.png' }}" style="width:100%" id="previewimage">
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#datatable1').DataTable({

            lengthChange: false,
            responsive: true,
            info: true,
            pageLength: 10,
            language: {
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
    });
</script>
