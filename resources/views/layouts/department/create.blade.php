@extends('layouts.adminhome')
@section('content')
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

    <form action="{{ route('departmentstore', ['from' => $from]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <div class="card-header bg-muted"><a href="{{ $departmentLink }}"
                            style="text-decoration: underline;">หน่วยงาน</a> </div><!-- /.card-header -->

                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="name_th">หน่วยงาน (th) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="name_th" placeholder="หน่วยงาน" required=""
                                value="">
                        </div><!-- /.form-group -->
                        @error('name_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="name_en">หน่วยงาน (en) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="name_en" placeholder="หน่วยงาน" value=""
                                required="">
                        </div><!-- /.form-group -->
                        @error('name_en')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="name_short_en">URL (EN) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="name_short_en" id="name_short_en"
                                placeholder="URL (EN)" required="" value="" maxlength="4">
                        </div><!-- /.form-group -->

                        <script>
                            const inputElement = document.getElementById("name_short_en");

                            inputElement.addEventListener("input", function() {
                                const inputValue = this.value;
                                const englishOnlyValue = inputValue.replace(/[^A-Za-z]/g, "").toUpperCase();
                                this.value = englishOnlyValue;
                            });

                            inputElement.addEventListener("keypress", function(event) {
                                const charCode = event.charCode;
                                if (charCode >= 3585 && charCode <= 3675) {
                                    event.preventDefault(); // หยุดการป้อนอักษรไทย
                                }
                            });
                        </script>



                        @error('name_short_en')
                            <span class="badge badge-warning">คุณใช้ URL นี้ไปแล้ว</span>
                        @enderror

                        <div class="form-group">
                            <label for="name_short_th">ภาพปก <span class="badge badge-warning">Required</span> <small
                                    class=" text-muted">( ขนาด 337px * 48px )</small></label>
                            <input type="file" class="form-control" name="name_short_th" placeholder="ภาพปก"
                                accept="image/*" required="">
                        </div><!-- /.form-group -->

                        @error('name_short_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror

                        <div class="form-group">
                            <label for="detail">logo <span class="badge badge-warning">Required</span><small
                                    class="text-muted">( ขนาด 585px * 350px )</small> </label>
                            <input type="file" class="form-control" name="detail" placeholder="logo" accept="image/*"
                                required="">
                        </div><!-- /.form-group -->
                        @error('detail')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-actions -->
                        <div class="form-group">
                            <label for="department_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="department_status" id="department_status" value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                    <div class="container mt-2">
                        <div class="form-group">
                            <label for="color">Select a color:</label>
                            <input type="color" id="colorPicker" class="form-control" value="#F04A23"
                                data-mdb-color-picker oninput="updateColorCode()">
                            <input type="text" id="colorCode" class="form-control" name="color" value="#F04A23"
                                oninput="updateColorPicker()">
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
                    <br><br>
                    <p style="text-align:center; color:red;">* หลังจากสร้าง "หน่วยงานย่อย" เสร็จแล้วให้ดำเนินการ restart
                        service ตัว API เพื่อให้ระบบทำงานต่อได้</p>





                </div><!-- /.card -->

                <div class="form-actions">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->

            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    </form>
@endsection
