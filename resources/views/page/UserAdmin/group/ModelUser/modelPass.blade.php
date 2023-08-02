<div class="modal fade " id="clientWarningModal-{{ $item->uid }}" data-uid="{{ $item->uid }}" tabindex="-1"
    role="dialog" aria-labelledby="clientWarningModalLabel" aria-modal="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
        <form action="{{ route('updatePassword', ['uid' => $item->uid]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- .modal-content -->
            <div class="modal-content">
                <!-- .modal-header -->
                <div class="modal-header bg-warning">
                    <h6 id="clientWarningModalLabel" class="modal-title">
                        <span class="sr-only">"Warning</span> <span><i class="far fa-bell fa-lg "></i>
                            กำหนดรหัสผ่าน</span>
                    </h6>
                </div><!-- /.modal-header -->
                <!-- .modal-body -->
                <div class="modal-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        <div class="form-label-group">
                            <p></p>
                            <div id="warningmsgx" class="h6">รหัสผ่านใหม่</div>
                            <input type="text" class="form-control placeholder-shown" id="usearch" name="usearch"
                                placeholder="รหัสผ่านใหม่" required="">
                            <p>
                            </p>
                        </div>
                    </div><!-- /.form-group -->
                </div><!-- /.modal-body -->
                <!-- .modal-footer -->
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">ตกลง</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
