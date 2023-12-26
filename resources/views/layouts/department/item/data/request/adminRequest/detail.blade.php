@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->


    <!-- .page-inner -->
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted"><a href="{{ route('departmentwmspage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('requestSchool') }}"
                        style="text-decoration: underline;"> คำขอสมัคร Admin</a> /<i> ตรวจสอบข้อมูลขอการเป็น Admin ของ
                        {{ $school->name }} </i></div>
                <div class="col-lg">
                    <h6 class="card-header"> ตรวจสอบข้อมูล </h6>
                    <div class="card-body">

                        <!-- form row -->
                        <div class="form-row">
                            <label for="username" class="col-md-2">ชื่อสถานศึกษา :</label>
                            <div class="col-md-4 mb-3">
                                <label for="username" class="col-md-12">{{ $school->name }}</label>
                            </div>


                            <label for="username" class="col-md-2">สังกัด :</label>
                            <div class="col-md-4 mb-3">
                
                                <label for="username" class="col-md-12">{{ $extenderData->name }} </label>
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

                                @if ($mit->submit_status == 1)
                                    <label for="username" class="col-md-2">รหัส :</label>
                                    <div class="col-md-4 mb-3">
                                        <label for="username" class="col-md-12">Username : {{ $citizen_id }}</label>
                                        <label for="username" class="col-md-12">Password : {{ $citizen_id }}</label>
                                    </div>
                                @endif

                                <label for="username" class="col-md-2">เช็๋คไฟล์ :</label>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset($mit->submit_path) }}" target="_blank"> ไฟล์ตัวอย่าง
                                        (.pdf)</a>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    @if ($mit->submit_status == 0)
                        <div class="card-body">
                            <div class="form-actions d-flex justify-content-end">

                                <form action="{{ route('storeAdminreq', ['submit_id' => $mit]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary-theme btn-lg"><i class="far fa-save"></i>
                                        อนุมัติการสร้าง Admin </button>
                                </form>

                                <form action="{{ route('storeAdminreq2', ['submit_id' => $mit]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-lg no-margin"><i
                                            class="far fa-save"></i>
                                        ไม่อนุมัติการสร้าง Admin </button>
                                </form>
                            </div>
                        </div>
                    @elseif($mit->submit_status == 1)
                        <div class="card-body">
                            <div class="form-actions d-flex justify-content-end">
                                <a  onclick="window.location='{{ route('requestSchool') }}'" class="btn btn-primary-theme  btn-lg"><i class="far fa-save"></i>
                                    back </a>
                            </div>
                        </div>
                    @elseif($mit->submit_status == 2)
                        <div class="card-body">
                            <div class="form-actions d-flex justify-content-end">
                            <a  onclick="window.location='{{ route('requestSchool') }}'"  class="btn btn-primary-theme  btn-lg"><i class="far fa-save"></i>
                                back </a>
                            </div>
                        </div>
                </div>
                @endif


            </div>


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