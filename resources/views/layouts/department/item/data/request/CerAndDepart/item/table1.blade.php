<div class="table-responsive">
    <!-- .table -->
    <table id="datatable" class="table w3-hoverable">
        <!-- thead -->
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width:10%"> ลำดับ </th>
                <th class="align-middle" style="width:50%"> ชื่อ </th>
                <th class="align-middle" style="width:10%"> ข้อมูลการย้าย </th>
                <th class="align-middle" style="width:5%"> กระทำ </th>
            </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody>

            @php
                $displayedIds = [];
                $i = 1;
            @endphp
            @foreach ($claimuser as $c)
                @if ($c->claim_status < 2)
                
                    @php
                        $users2 = \App\Models\Users::find($c->claim_user_id);
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $users2->firstname }} {{ $users2->lastname }}</td>

                        <td><i class="fa fas fa-plus-circle text-success pointer" style="cursor:pointer" id="icon1"
                                onclick="showModal('{{ $c->claim_user_id }}')"></i>
                            @include(
                                'layouts.department.item.data.request.CerAndDepart.item.modeleditDpart',
                                [
                                    'claimUserId' => $c->claim_user_id,
                                ]
                            )
                        </td>
                        <td>
                            <a href="{{ route('updateuserdeyes', $c->claim_user_id) }}" onclick="updateceryes(event)"><i
                                    class="fas fa-check fa-lg text-success" data-toggle="tooltip"
                                    title="อนุมัติผ่าน"></i></a>
                            <a href="{{ route('updateuserdeno', $c->claim_user_id) }}" onclick="updatecerno(event)"><i
                                    class="fas fa-times fa-lg text-danger" data-toggle="tooltip"
                                    title="อนุมัติไม่ผ่าน"></i></a>
                        </td>
                    </tr>
                @endif
            @endforeach



        </tbody><!-- /tbody -->
    </table><!-- /.table -->

</div><!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({

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
{{-- <script>
                function togglerows(id) {
                    $(".rows_" + id).toggle();
                    var obj1 = document.getElementById("icon1_" + id);


                    if (obj1.classList.contains('fa-plus-circle')) {
                        obj1.classList.remove('fa-plus-circle');
                        obj1.classList.add('fa-minus-circle');

                    } else {
                        obj1.classList.remove('fa-minus-circle');
                        obj1.classList.add('fa-plus-circle');

                    }

                }
            </script>
            <script>
                $(document).ready(function() {
                    var table = $('#datatable1').DataTable({

                        lengthChange: false,
                        responsive: true,
                        info: false,
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


                });
            </script> --}}
