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


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('departmentwmspage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <i> แก้ไขข้อมูล</i></div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        @foreach ($genarals as $genaral)
                            @if ($genaral->title === 'popup')
                                <div class="form-group">
                                    <div class="row mb-5">

                                        <div class="col-lg-6">
                                            <img src="{{ env('URL_FILE_SFTP') . $genaral->detail }}"
                                                alt="{{ env('URL_FILE_SFTP') . $genaral->detail }}" style="width:100%">
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="flatpickr03">วันที่เริ่ม</label>
                                                    <input type="text" class="form-control" name="startdate"
                                                        id="flatpickr03" value="" />
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="flatpickr04">วันที่สิ้นสุด</label>
                                                    <input type="text" class="form-control" name="enddate"
                                                        id="flatpickr04" value="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="status">สถานะ </label> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit"
                                                        {{ $genaral->status == 1 ? 'checked' : '' }}
                                                        data-id="{{ $genaral->id }}">
                                                    <span class="switcher-indicator"></span>
                                                    <span class="switcher-label-on" data-on="ON">เปิด</span>
                                                    <span class="switcher-label-off text-red" data-off="OFF">ปิด</span>
                                            </div>

                                        </div>
                                    </div>

                                    <br>
                                    <div style="border-bottom: 1px solid #e7d8d5;">

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <fieldset>
                        <legend>สร้าง</legend>
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <label for="detail">โลโก้ ( ขนาด 450x65 px )</label> <input type="file"
                                class="form-control" id="detail" name="detail" placeholder="โลโก้" accept="image/*">
                            @error('detail')
                                <span class="badge badge-warning">{{ $message }}</span>
                            @enderror
                            <div class="form-row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label for="flatpickr03">วันที่เริ่ม</label>
                                    <input type="text" class="form-control" name="startdate" id="flatpickr03"
                                        value="" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="flatpickr04">วันที่สิ้นสุด</label>
                                    <input type="text" class="form-control" name="enddate" id="flatpickr04"
                                        value="" />
                                </div>
                            </div>

                        </form>
                        <div class="form-actions">
                            <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                                บันทึก</button>
                        </div>
                    </fieldset>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#flatpickr03", {
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                locale: {
                    firstDayOfWeek: 1, // Monday
                    weekdays: {
                        shorthand: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
                        longhand: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]
                    },
                    months: {
                        shorthand: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ],
                        longhand: [
                            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                        ]
                    }
                }
            });
            flatpickr("#flatpickr04", {
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
                        longhand: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"]
                    },
                    months: {
                        shorthand: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
                            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ],
                        longhand: [
                            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                        ]
                    }
                }
            });
        });
    </script>
@endsection
