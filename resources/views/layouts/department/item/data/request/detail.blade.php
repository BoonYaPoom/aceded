@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <form action="" method="post" enctype="multipart/form-data">
        @csrf

        <!-- .page-inner -->
        <div class="page-inner">
            <div class="page-section">
                <div class="card card-fluid">
                    <div class="card-header bg-muted"><a href="{{ route('departmentwmspage') }}"
                            style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('requestSchool') }}"
                            style="text-decoration: underline;"> คำขอสมัคร Admin</a> /<i> ตรวจสอบข้อมูลขอการเป็น Admin ของ
                            {{ $school }} จังหวัด {{ $proviUser }} </i></div>
                    <div class="col-lg">
                        <h6 class="card-header"> ตรวจสอบข้อมูล </h6>
                        <div class="card-body">

                            <!-- form row -->
                            <div class="form-row">
                                <label for="username" class="col-md-2">ชื่อสถานศึกษา :</label>
                                <div class="col-md-4 mb-3">
                                    <label for="username" class="col-md-12">{{ $school }}</label>
                                </div>


                                <label for="username" class="col-md-2">จังหวัด :</label>
                                <div class="col-md-4 mb-3">
                                    <label for="username" class="col-md-12">{{ $proviUser }} </label>
                                </div>

                            </div>

                            <br>
                            <fieldset>
                                <legend>ข้อมูลติดต่อผู้ส่งคำขอ</legend> <!-- .form-group -->
                                <div class="form-row">
                                    <label for="username" class="col-md-2">ชื่อ - นามสกุล :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $mit->firstname }}
                                            {{ $mit->lastname }}</label>
                                    </div>

                                    <label for="username" class="col-md-2">เลขบัครประชาชน :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $mit->citizen_id }} </label>
                                    </div>

                                    <label for="username" class="col-md-2">ตำแหน่ง :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $mit->pos_name }} </label>
                                    </div>

                                    <label for="username" class="col-md-2">เบอร์ติดต่อ :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $fullMobile }} </label>
                                    </div>


                                    <label for="username" class="col-md-2">email :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $mit->email }} </label>
                                    </div>
                                </div>
                            </fieldset>
                            <br><br>
                            <fieldset>
                                <legend>เวลาการขอ</legend> <!-- .form-group -->
                                <div class="form-row">
                                    <label for="username" class="col-md-2">เวลาที่ส่งคำขอ :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">{{ $thaiStartDate }} </label>
                                    </div>

                                    <label for="username" class="col-md-2">การอนุมัติ :</label>
                                    @if (is_string($thaiEndDate))
                                        <div class="col-md-4 mb-3">
                                            <label for="username" class="col-md-12"> {{ $thaiEndDate }} </label>
                                        </div>
                                    @endif


                                </div>
                            </fieldset>
                        </div>

                        @if ($mit->submit_status == 0)
                            <form action="{{ route('storeAdmin', ['submit_id' => $mit->submit_id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary-theme ml-auto btn-lg"><i
                                                class="far fa-save"></i> อนุมัติการสร้าง Admin </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="card-body">
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary-theme ml-auto btn-lg"><i
                                            class="far fa-save"
                                            onclick="window.location='{{ route('requestSchool') }}'"></i> กดเพื่อย้อนกลับ
                                    </button>
                                </div>
                            </div>
                        @endif

    </form>
    </div>
    </div>
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all elements with the "discount-code-input" class
            const discountCodeInputs = document.querySelectorAll(".number");

            // Loop through all the input fields
            discountCodeInputs.forEach(function(discountCodeInput) {
                discountCodeInput.addEventListener("input", function(event) {
                    this.value = this.value.replace(/\D/g, ""); // Allow only numeric values
                });
            });
        });
    </script>
@endsection
