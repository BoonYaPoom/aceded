@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',


            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <div class="card-header bg-muted"><a href="{{ $departmentLink }}"
                        style="text-decoration: underline;">หน่วยงาน</a> </div><!-- /.card-header -->


                <form action="{{ route('departmentupdate', ['from' => $from, 'department_id' => $depart->department_id]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- .card-body -->
                    <div class="card-body">

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="name_th">หน่วยงาน (th)</label>
                            <input type="text" class="form-control" name="name_th" placeholder="หน่วยงาน"
                                value="{{ $depart->name_th }}">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="name_en">หน่วยงาน (en)</label>
                            <input type="text" class="form-control" name="name_en" placeholder="หน่วยงาน"
                                value="{{ $depart->name_en }}">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="name_short_en">URL (EN) ไม่สามารถแก้ไขได้</label>
                            <input type="text" class="form-control" name="name_short_en" disabled
                                placeholder="{{ $depart->name_short_en }}" value="{{ $depart->name_short_en }}">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <div class="form-group">
                                <label for="cover"><img src="{{ asset($depart->name_short_th) }}"
                                        alt="{{ $depart->name_short_th }}" style="height:350px">
                            </div>
                            <label for="name_short_th">ภาพปก </label>
                            <input type="file" class="form-control" name="name_short_th" placeholder="ภาพปก"
                                accept="image/*">
                        </div><!-- /.form-group -->

                        <!-- .form-actions -->
                        <div class="form-group">
                            <label for="department_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="department_status" id="department_status" value="1"
                                    {{ $depart->department_status == 1 ? 'checked' : '' }}>
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                 <span class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->

                        <div class="container mt-2">


                        
                            <div class="form-group">
                                <label for="color">Select a color:</label>
                                <input type="color" id="colorPicker" class="form-control"  value="{{ $depart->color }}" data-mdb-color-picker oninput="updateColorCode()">
                                <input type="text" id="colorCode" class="form-control" name="color"  value="{{ $depart->color }}" oninput="updateColorPicker()">
                            </div>
                            
                            <script>
                            function updateColorCode() {
                                var colorPicker = document.getElementById('colorPicker');
                                var colorCodeInput = document.getElementById('colorCode');
                                var colorCode = colorPicker.value;
                                colorCodeInput.value = colorCode;
                            }
                            
                            function updateColorPicker() {
                                var colorPicker = document.getElementById('colorPicker');
                                var colorCodeInput = document.getElementById('colorCode');
                                var colorCode = colorCodeInput.value;
                                colorPicker.value = colorCode;
                            }
                            </script>

                        </div>
                    </div><!-- /.card-body -->




            </div><!-- /.card -->

            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
            </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
