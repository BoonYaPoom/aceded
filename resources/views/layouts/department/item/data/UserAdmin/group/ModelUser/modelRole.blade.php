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

                                <!-- <div class="visual-picker visual-picker-sm has-peek px-3 d-none">
<input type="radio" id="user_role2" name="user_role" value="2" {{ $item->user_role == 2 ? 'checked' : '' }}>
<label class="visual-picker-figure" for="user_role2">
<span class="visual-picker-content"><span class="tile tile-sm user_role2 user_roleactive bg-muted"><i class="fas fa-user-edit fa-lg"></i></span></span>  </label>
<span class="visual-picker-peek">ผู้จัดการหลักสูตร</span>
</div>  -->
                                @foreach ($roles->sortBy('user_role_id') as $ro)
                                    @if ($ro->user_role_id > 1 && $ro->user_role_id  < 8)
                                        <div class="visual-picker visual-picker-sm has-peek px-3">
                                            <input type="radio" id="user_role{{ $ro->user_role_id }}" name="user_role"
                                                value="{{ $ro->user_role_id }}"
                                                {{ $item->user_role == $ro->user_role_id ? 'checked' : '' }}>
                                            <label class="visual-picker-figure" for="user_role{{ $ro->user_role_id }}">
                                                <span class="visual-picker-content">
                                                    <span
                                                        class="tile tile-sm user_role{{ $ro->user_role_id }} user_roleactive bg-muted">
                                                        <i class="{{ $ro->role_cover_path }} fa-lg"></i>
                                                    </span>
                                                </span>
                                            </label>
                                            <span class="visual-picker-peek">{{ $ro->role_name }}</span>
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
