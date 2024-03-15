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

                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.select')
                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.js')
                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.text')

                        {{-- <div class="form-group">
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
                                @foreach ($extender1 as $extr)
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
                                var provin = $('#provin');
                                extenderSelect.select2();
                                provin.select2();
                                extenderSelect.on('change', function() {
                                    var selectedExtenderId = $(this).val();

                                    if (selectedExtenderId) {
                                        sch1Div.show();
                                    } else {
                                        sch1Div.hide();
                                    }
                                });
                            });
                        </script> --}}
                        @if ($errors->any())
                            <div class="col-md-9 mb-3">
                                @foreach ($errors->all() as $error)
                                    <span class="badge badge-warning">{{ $error }}</span>
                                @endforeach
                            </div>
                        @endif

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
