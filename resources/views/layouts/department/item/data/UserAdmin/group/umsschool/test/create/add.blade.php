@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <form action="{{ route('addextendersubmit', $depart) }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">

                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a
                            href="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}">ผู้ใช้งาน</a>/ <a
                            href="{{ route('testumsschool', ['department_id' => $depart->department_id]) }}">จัดการสถานศึกษา</a>
                    </div><!-- /.card-header -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->


                        <div class="form-group" id='sch'>
                            <label for="extender_id" class="col-md-1">สังกัด </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select class="form-control " name="extender_id" id="extender_id" required="">
                                <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
                                @foreach ($extendernull as $extr)
                                    <option value="{{ $extr->extender_id }}">{{ $extr->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" id="testsch" style="display: none;">
                            <label for="school_name" class="col-md-1">สถานศึกษา </label>
                            <label for="school_name"> <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="school_name" name="school_name"
                                placeholder="สถานศึกษา" required="" value="">
                        </div><!-- /.form-group -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var sch1Div = $('#testsch');
                                var extenderSelect = $('#extender_id');

                                extenderSelect.select2();

                                extenderSelect.on('change', function() {
                                    var selectedExtenderId = $(this).val();

                                    if (selectedExtenderId) {
                                              sch1Div.show();
                                    } else {           
                                           sch1Div.hide();
                                    }
                                });
                            });
                        </script>
                        {{-- <div class="form-group" id='sch1' style="display: none;">
                            <label for="extender_1_id" class="col-md-1">สังกัดย่อย </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select name="extender_1_id" id="extender_1_id" class="form-control form-control-sm"
                                data-toggle="select2" required="">
                                <option value="" selected disabled>-- เลือกสังกัดย่อย --</option>
                            </select>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var sch1Div = $('#sch1');
                                $('#extender_id').select2();
                                $('#extender_id').on('change', function() {
                                    var selectedextender_idCode = $(this).val();
                                    var schoolSelect1 = $('#extender_1_id');
                                    schoolSelect1.empty().append(
                                        '<option value="" selected disabled>-- เลือกสถานศึกษา --</option>');
                                    var extender_1 = {!! $extender_1Json !!};
                                    var foundMatch = false;

                                    extender_1.forEach(function(exten1) {
                                        if (exten1.item_parent_id == selectedextender_idCode) {
                                            schoolSelect1.append('<option value="' + exten1.extender_id + '">' + exten1
                                                .name + '</option>');
                                            foundMatch = true;
                                        }
                                    });
                                    if (!foundMatch) {
                                        schoolSelect1.append('<option value="default_value">Default School Name</option>');
                                    }
                                    sch1Div.css('display', foundMatch ? '' : 'none');
                                });
                            });
                        </script> --}}

                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

    </form>
@endsection
