<form method="post" action="{{ route('updateusertype', $pertype) }}">
    @csrf
    @method('PUT')
<table id="datatable2" class="table w3-hoverable">
    <thead>
        <tr class="bg-infohead">
            <th width="5%">เลือก <input type="checkbox" name="checkall" id="checkall" value="1">
            </th>
            <th width="20%">รหัสผู้ใช้ </th>
            <th>ชื่อ สกุล</th>
            <th>กลุ่มผู้ใช้งาน</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usersnulls as $user)
            <tr>
                <td width="5%">

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="user_data[]"
                            id="user_data{{ $user->user_id }}" value="{{ $user->user_id }}">
                        <label class="custom-control-label" for="user_data{{ $user->user_id }}"></label>

                    </div>
                </td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->firstname }} </td>
                <td> </td>

            </tr>
        @endforeach

    </tbody>
    <tbody>
        <tr>

            <td colspan="5" class="text-center"><button class="btn btn-primary" type="submit" id="Userselectdata"><i
                        class="fas fa-user-plus"></i>
                    เพิ่มเข้ากลุ่มผู้ใช้งาน</button>
            </td>

        </tr>
    </tbody>
</table>
</form>
<script>
    $(document).ready(function() {
        var table2 = $('#datatable2').DataTable({
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

        $('#searchNa').on('keyup', function() {
                    table2.columns(2).search(this.value).draw();
                });
    });
</script>
