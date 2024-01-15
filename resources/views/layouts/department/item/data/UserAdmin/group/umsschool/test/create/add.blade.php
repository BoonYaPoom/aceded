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


                        <div class="form-group">
                            <label for="provin" class="col-md-1">จังหวัด </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select class="form-control " name="provin" id="provin" required="">
                                <option value="0" selected disabled>-- เลือกจังหวัด --</option>
                                @foreach ($provin as $pro)
                                    <option value="{{ $pro->name_in_thai }}">{{ $pro->name_in_thai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id='sch'>
                            <label for="extender_id" class="col-md-1">สังกัด </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select class="form-control " name="extender_id" id="extender_id" required="">
                                <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
                                @foreach ($extender1 as $extr1)
                                    <option value="{{ $extr1->extender_id }}">{{ $extr1->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group" id='sch2' style="display: none;">
                            <label for="extender_id2" class="col-md-1">สังกัดย่อย </label>
                            <span class="badge badge-warning">Required</span></label>
                            <select class="form-control " name="extender_id2" id="extender_id2" required="">
                                <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
                            </select>
                        </div>
                        <div class="form-group" id="textsch1" style="display: none;">
                            <label for="school_name" class="col-md-1">สถานศึกษา </label>
                            <label for="school_name"> <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="school_name" name="school_name"
                                placeholder="สถานศึกษา" required="" value="">
                        </div><!-- /.form-group -->
                        <script>
                            $(document).ready(function() {
                                var sch2Div = $('#sch2');
                                var extender2 = {!! $extender2 !!};
                                var extender_id2 = $('#extender_id2');
                                // var sch3Div = $('#sch3');
                                // var extender3 = {!! $extender3 !!};
                                // var extender_id3 = $('#extender_id3');
                                // var sch4Div = $('#sch4');
                                // var extender_id4 = $('#extender_id4');
                                // var extender4 = {!! $extender4 !!};
                                // var sch5Div = $('#sch5');
                                // var extender_id5 = $('#extender_id5');
                                // var extender5 = {!! $extender5 !!};

                                var provin = $('#provin');
                                $('#extender_id').select2();
                                provin.select2();
                                $('#extender_id').on('change', function() {
                      
                                    var selectedExtenderId = $(this).val();
                                    console.log(selectedExtenderId);
                                    
                                    var foundMatch = false;
                                    extender_id2.select2();
                                    extender_id2.empty();
                                    extender_id2.append('<option value="" selected disabled>-- เลือกสังกัด --</option>');
                                    $.each(extender2, function(index, exten2) {
                                        if (exten2.item_parent_id == selectedExtenderId) {
                                            extender_id2.append($('<option></option>')
                                                .attr('value', exten2.extender_id)
                                                .text(exten2.name));
                                            foundMatch = true;
                                        }
                                        sch2Div.show();
                                    });
                                });
                            });
                        </script>
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
