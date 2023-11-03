<div class="modal fade " id="clientUploadModal" tabindex="-1" user_role="dialog" aria-labelledby="clientUploadModalLabel"
    aria-modal="true">
    <!-- .modal-dialog -->
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog  modal-lg" user_role="document">
            <!-- .modal-content -->
            <div class="modal-content">
                <!-- .modal-header -->
                <div class="modal-header" style="background-color: #F04A23;">
                    <h6 id="clientUploadModalLabel" class="modal-title text-white">
                        <span class="sr-only">Upload</span> <span><i class="fas fa-user-plus text-white"></i>
                            เลือกหน่วยงาน</span>
                    </h6>
                </div><!-- /.modal-header -->
                <!-- .modal-body -->
                <div class="modal-body">
                    <!-- เนื้อหาภายในโมดัล -->

                    <div class="table-responsive">
                        <table class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width: 10%"><input type="checkbox"
                                           name="checkall" id="checkall"
                                            value="1">เลือก</th>
                                    <th class="align-middle" style="width: 40%">ชื่อหน่วยงาน</th>
                                    <th class="align-middle" style="width: 40%">ชื่อย่อ</th>

                                </tr>
                            </thead>
                            <!-- tbody -->
                            <tbody>
                                @php
                                    $Department = \App\Models\Department::all();
                                @endphp
                                @foreach ($Department->sortBy('department_id') as $part)
                                    <tr>
                                        <td class="align-middle" style="width: 10%">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="department_data[]"
                                                    id="department_data{{ $part->department_id }}"
                                                    value="{{ $part->department_id }}">
                                                <label class="custom-control-label"
                                                    for="department_data{{ $part->department_id }}"></label>

                                        </td>
                                        <td class="align-middle" style="width: 40%">{{ $part->name_th }}</td>
                                        <td class="align-middle" style="width: 40%">{{ $part->name_en }}</td>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- .modal-footer -->
                <div class="modal-footer">
               
                    <button type="button" class="btn btn-success" style="background-color: #F04A23;"
                        data-dismiss="modal" ><i class="fas fa-user-plus"></i> ยืนยันหน่วยงาน</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                </div><!-- /.modal-footer -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
    <script>
        $(function() {
            $("#checkall").click(function() {
                $('.custom-control-input').prop('checked', $(this).prop('checked'));
            });

        });
    </script>
</div>
