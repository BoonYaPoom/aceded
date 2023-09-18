<tr>
    <td>{{ $rowNumber }}</td>
    <td>{{ $item->username }}</td>
    <td>{{ $item->firstname }} {{ $item->lastname }}</td>

    <td>{{ substr($item->mobile, 0, 3) }}-{{ substr($item->mobile, 3, 3) }}-{{ substr($item->mobile, 6, 4) }}
    </td>

    <td>{{ $item->email }}</td>
    <td>{{ $proviUser }}</td>
    <td>{{ $name_short_en }}</td>
    <td class="align-middle"> <label class="switcher-control switcher-control-success switcher-control-lg">
            <input type="checkbox" class="switcher-input switcher-edit" {{ $item->userstatus == 1 ? 'checked' : '' }}
                data-uid="{{ $item->uid }}">
            <span class="switcher-indicator"></span>
            <span class="switcher-label-on">ON</span>
            <span class="switcher-label-off text-red">OFF</span>
        </label></td>

    <script>
        $(document).ready(function() {
            $(document).on('change', '.switcher-input.switcher-edit', function() {
                var userstatus = $(this).prop('checked') ? 1 : 0;
                var uid = $(this).data('uid');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('changeStatusUser') }}',
                    data: {
                        'userstatus': userstatus,
                        'uid': uid
                    },
                    success: function(data) {

                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
        });
    </script>

    <td>
        <a href="{{ route('editUser', ['uid' => $item->uid]) }}" data-toggle="tooltip" title="แก้ไข"><i
                class="far fa-edit text-success mr-1"></i></a>
        @if ($data->role == 1)
            @if ($roleadmin)
                <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์">
                    <i class="fas fa-user-shield text-bg-muted "></i>
                </a>
            @else
                <a href="{{ route('logusers', ['uid' => $item->uid]) }}" data-toggle="tooltip"
                    title="ดูประวัติการใช้งาน"><i class="fas fa-history text-info"></i></a>

                <a data-toggle="modal" data-target="#clientPermissionModal-{{ $item->uid }}" title="กำหนดสิทธิ์">
                    <i class="fas fa-user-shield text-danger"></i>
                </a>
                <button class="btn sendtemppwd " data-toggle="modal"
                    data-target="#clientWarningModal-{{ $item->uid }}" title="ส่งรหัสผ่าน"><i
                        class="fas fa-key text-info"></i></button>
            @endif
        @endif
    </td>
</tr><!-- /tr -->

<script>
    // เมื่อตัวเลือกถูกเลือก
    document.querySelectorAll('input[name="role"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // รับค่าของตัวเลือกที่ถูกเลือก
            var selectedRole = document.querySelector('input[name="role"]:checked').value;
            // ดำเนินการตามต้องการสำหรับตัวเลือกที่ถูกเลือก
            console.log('ตัวเลือกที่ถูกเลือก:', selectedRole);

        });
    });
    $(function() {
        $(".visual-picker").click(function() {
            var radioBtn = $(this).find("input[type='radio']");
            radioBtn.prop('checked', true);

        });
        // ส่วนอื่น ๆ ของรหัส
    });

    function setRoleColor(role) {
        var color = ['', 'info', 'danger', 'success', 'warning'];
        $('#role' + role).prop("checked", true);
        $('.roleactive').removeClass('bg-info bg-warning bg-danger bg-success');
        $('.role' + role).removeClass('bg-muted').addClass('bg-' + color[role]);
    }
</script>
