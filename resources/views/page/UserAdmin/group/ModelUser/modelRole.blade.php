<div id="clientPermissionModal-{{ $item->uid }}" data-uid="{{ $item->uid }}" class="modal fade" aria-modal="true"
    tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('updateRoleUser', ['uid' => $item->uid]) }}" method="post"
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
                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                    <br>
                                    <input type="radio" id="role1" name="role" value="1"
                                        {{ $item->role == 1 ? 'checked' : '' }}>
                                    <label class="visual-picker-figure" for="role1">
                                        <span class="visual-picker-content">
                                            <span class="tile tile-sm role1 roleactive bg-muted">
                                                <i class="fas fa-user-cog fa-lg"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="visual-picker-peek">ผู้ดูแลระบบ</span>
                                </div>
                                <!-- <div class="visual-picker visual-picker-sm has-peek px-3 d-none">
<input type="radio" id="role2" name="role" value="2" {{ $item->role == 2 ? 'checked' : '' }}>
<label class="visual-picker-figure" for="role2">
<span class="visual-picker-content"><span class="tile tile-sm role2 roleactive bg-muted"><i class="fas fa-user-edit fa-lg"></i></span></span>  </label>
<span class="visual-picker-peek">ผู้จัดการหลักสูตร</span>
</div>  -->
                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                    <input type="radio" id="role3" name="role" value="3"
                                        {{ $item->role == 3 ? 'checked' : '' }}>
                                    <label class="visual-picker-figure" for="role3">
                                        <span class="visual-picker-content">
                                            <span class="tile tile-sm role3 roleactive bg-muted">
                                                <i class="fas fa-user-tie fa-lg"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="visual-picker-peek">ผู้สอน</span>
                                </div>

                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                    <input type="radio" id="role4" name="role" value="4"
                                        {{ $item->role == 4 ? 'checked' : '' }}>
                                    <label class="visual-picker-figure" for="role4">
                                        <span class="visual-picker-content">
                                            <span class="tile tile-sm role4 roleactive bg-muted">
                                                <i class="fas fa-user-graduate fa-lg"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="visual-picker-peek">ผู้เรียน</span>
                                </div>

                                <div class="visual-picker visual-picker-sm has-peek px-3">
                                    <input type="radio" id="role5" name="role" value="5"
                                        {{ $item->role == 5 ? 'checked' : '' }}>
                                    <label class="visual-picker-figure" for="role5">
                                        <span class="visual-picker-content">
                                            <span class="tile tile-sm role5 roleactive bg-muted">
                                                <i class="fas fa-user fa-lg"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <span class="visual-picker-peek">ผู้เยี่ยมชม</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary-theme" id="btnsetrole">
                            <i class="fas fa-user-shield"></i> กำหนดสิทธิ์
                        </button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
