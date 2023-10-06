
<tr>
    <td>{{ $r }}</td>
    <td>{{ $item->username }}</td>
    <td>{{ $item->firstname }} {{ $item->lastname }}</td>

    <td>{{ substr($item->mobile, 0, 3) }}-{{ substr($item->mobile, 3, 3) }}-{{ substr($item->mobile, 6, 4) }}
    </td>

    <td>{{ $item->email }}</td>
    <td>{{ $proviUser }}</td>
    <td>{{ $person }}</td>
    <td class="align-middle"> <label class="switcher-control switcher-control-success switcher-control-lg">
            <input type="checkbox" class="switcher-input switcher-edit" {{ $item->userstatus == 1 ? 'checked' : '' }}
                data-user_id="{{ $item->user_id }}">
            <span class="switcher-indicator"></span>
            <span class="switcher-label-on">ON</span>
            <span class="switcher-label-off text-red">OFF</span>
        </label></td>

    <script>
        $(document).ready(function() {
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

                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
        });
    </script>

    <td>
        <a href="{{ route('DPeditUser', ['user_id' => $item->user_id]) }}" data-toggle="tooltip" title="แก้ไข"><i
                class="far fa-edit text-success mr-1"></i></a>
        @if ($data->user_role == 1)
            @if ($user_roleadmin)
                <a data-toggle="modal" data-target="" title="กำหนดสิทธิ์">
                    <i class="fas fa-user-shield text-bg-muted "></i>
                </a>
            @else
                <a href="{{ route('logusers', ['user_id' => $item->user_id]) }}" data-toggle="tooltip"
                    title="ดูประวัติการใช้งาน"><i class="fas fa-history text-info"></i></a>

                <a data-toggle="modal" data-target="#clientPermissionModal-{{ $item->user_id }}" title="กำหนดสิทธิ์">
                    <i class="fas fa-user-shield text-danger"></i>
                </a>
                <button class="btn sendtemppwd " data-toggle="modal"
                    data-target="#clientWarningModal-{{ $item->user_id }}" title="ส่งรหัสผ่าน"><i
                        class="fas fa-key text-info"></i></button>
                        <a data-toggle="modal" data-target="#clientPermissionModal-{{ $item->user_id }}" title="กำหนดสิทธิ์">
                            <i class="fas fa-trash-alt fa-lg text-warning "></i>
                        </a>
            @endif
        @endif
    </td>
</tr><!-- /tr -->

<script>
    // เมื่อตัวเลือกถูกเลือก
    document.querySelectorAll('input[name="user_role"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // รับค่าของตัวเลือกที่ถูกเลือก
            var selecteduser_role = document.querySelector('input[name="user_role"]:checked').value;
            // ดำเนินการตามต้องการสำหรับตัวเลือกที่ถูกเลือก
            console.log('ตัวเลือกที่ถูกเลือก:', selecteduser_role);

        });
    });
    $(function() {
        $(".visual-picker").click(function() {
            var radioBtn = $(this).find("input[type='radio']");
            radioBtn.prop('checked', true);

        });
        // ส่วนอื่น ๆ ของรหัส
    });

    function setuser_roleColor(user_role) {
        var color = ['', 'info', 'danger', 'success', 'warning'];
        $('#user_role' + user_role).prop("checked", true);
        $('.user_roleactive').removeClass('bg-info bg-warning bg-danger bg-success');
        $('.user_role' + user_role).removeClass('bg-muted').addClass('bg-' + color[user_role]);
    }
</script>
