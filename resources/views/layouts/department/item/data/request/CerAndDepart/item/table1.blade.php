<div class="table-responsive">
    <!-- .table -->
    <table id="datatable1" class="table w3-hoverable">
        <!-- thead -->
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width:10%"> ลำดับ </th>
                <th class="align-middle" style="width:50%"> ชื่อ </th>
                <th class="align-middle" style="width:10%"> ย่อย </th>
                <th class="align-middle" style="width:10%"> กระทำ </th>
            </tr>
        </thead><!-- /thead -->
        <!-- tbody -->
        <tbody>

            @php
                $displayedIds = [];
                $i = 1;
            @endphp
            @foreach ($claimuser->sortBy('claim_id') as $c)
        
                @if (!in_array($c->claim_user_id, $displayedIds))
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $c->claim_user_id }}</td>
                        <td><i class="fa fas fa-plus-circle text-success pointer" style="cursor:pointer" id="icon1"
                                onclick="$('#clientUploadModal-{{ $c->claim_user_id }}').modal('show');"></i>
                        </td>
                        <td>
                            <a href=""><i class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                    title="เพิ่มแบบฝึกหัด"></i></a>
                        </td>
                    </tr>
                    @php
                        $displayedIds[] = $c->claim_user_id;
                    @endphp
                @endif
            @endforeach

        </tbody><!-- /tbody -->
    </table><!-- /.table -->
                @foreach ($claimuser->sortBy('claim_id') as $c)
      @include('layouts.department.item.data.request.CerAndDepart.item.modeleditDpart')
           @endforeach
</div><!-- /.table-responsive -->

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