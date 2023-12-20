<div id="clientPermissionModal-{{ $item->user_id }}" data-user_id="{{ $item->user_id }}" class="modal fade"
    aria-modal="true" tabindex="-1" user_role="dialog">
    <div class="modal-dialog" user_role="document">
        <div class="modal-content">
            <form action="{{ route('updateRoleUser', ['user_id' => $item->user_id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- .modal-header -->
                <div class="modal-header bg-theme-primary">
                    <h6 id="clientPermissionModalLabel" class="modal-title text-white">
                        <span class="sr-only">Permission</span> <span><i class="fas fa-user-shield text-white"></i>
                            กำหนดสิทธิ์ผู้ใช้งาน</span>
                    </h6>
                </div><!-- /.modal-header -->

                <div class="modal-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        <div class="form-label-group">
                            <div class="section-block text-center text-sm">

                                @foreach ($roles->sortBy('user_role_id') as $ro)
                                @if ($ro->user_role_id > 1)
                                    
                          
                                    <div class="visual-picker visual-picker-sm has-peek px-3">
                                        <input type="radio" id="user_role{{$ro->user_role_id}}" name="user_role" value="{{$ro->user_role_id}}"
                                            {{ $item->user_role == $ro->user_role_id ? 'checked' : '' }}>
                                        <label class="visual-picker-figure" for="user_role{{$ro->user_role_id}}">
                                            <span class="visual-picker-content">
                                                <span class="tile tile-sm user_role{{$ro->user_role_id}} user_roleactive bg-muted">
                                                    <i class="{{$ro->role_cover_path}} fa-lg"></i>
                                                </span>
                                            </span>
                                        </label>
                                        <span class="visual-picker-peek">{{$ro->role_name}}</span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary-theme" id="btnsetuser_role">
                            <i class="fas fa-user-shield"></i> กำหนดสิทธิ์
                        </button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


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
