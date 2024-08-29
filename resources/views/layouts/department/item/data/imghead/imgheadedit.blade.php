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
                    <fieldset>
                        <legend>สร้าง pop up</legend>
                        <form method="POST" action="{{ route('CreatePopup') }}" enctype="multipart/form-data">
                            @csrf
                            <label for="detail">Pop Up</label> <input type="file" class="form-control" id="detail"
                                name="detail" placeholder="โลโก้" accept="image/*">
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
                            <div class="form-actions">
                                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                                    บันทึก</button>
                            </div>
                        </form>

                    </fieldset>
                    <style>
                        .scrollable-container {
                            width: 100%;
                            height: 800px;
                            overflow-y: auto;
                            border: 1px solid #ddd;
                            padding: 40px;
                            margin-top: 50px;
                        }
                    </style>

                    <div class="form-group scrollable-container">
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
                                                        id="flatpickr03" value="{{ $genaral->startdate }}" />
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="flatpickr04">วันที่สิ้นสุด</label>
                                                    <input type="text" class="form-control" name="enddate"
                                                        id="flatpickr04" value="{{ $genaral->enddate }}" />
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
                                            <a href="{{ route('general.destroy', $genaral->id) }}"
                                                onclick="deleteRecord(event)" class="switcher-delete" data-toggle="tooltip"
                                                title="ลบ">
                                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>

                                        </div>
                                    </div>
                                    <br>
                                    <div style="border-bottom: 1px solid #e7d8d5;">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <script>
                            $(document).ready(function() {

                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                    $('#loadingSpinner1').show();
                                    var status = $(this).prop('checked') ? 1 : 0;
                                    var id = $(this).data('id');
                                    console.log('status:', status);
                                    console.log('id:', id);
                                    $.ajax({
                                        type: "GET",
                                        dataType: "json",
                                        url: '{{ route('changeStatusGenPop') }}',
                                        data: {
                                            'status': status,
                                            'id': id
                                        },
                                        success: function(data) {
                                            console.log(data.message);
                                            if (data.updated_ids) {
                                                data.updated_ids.forEach(function(id) {
                                                    $('.switcher-input[data-id="' + id + '"]').prop(
                                                        'checked', false);
                                                });
                                            }
                                            $('#loadingSpinner1').hide();
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(error.message);
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#flatpickr03", {
                altInput: true,
                altFormat: "j F, Y H:i", // เพิ่มรูปแบบเวลาในการแสดงผล
                dateFormat: "Y-m-d H:i", // เพิ่มรูปแบบเวลาในการเก็บข้อมูล
                enableTime: true, // เปิดใช้งานการเลือกเวลา
                time_24hr: true, // ใช้รูปแบบเวลา 24 ชั่วโมง
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
            flatpickr("#flatpickr04", {
                altInput: true,
                altFormat: "j F, Y",
                dateFormat: "Y-m-d",
                altFormat: "j F, Y H:i", // เพิ่มรูปแบบเวลาในการแสดงผล
                dateFormat: "Y-m-d H:i", // เพิ่มรูปแบบเวลาในการเก็บข้อมูล
                enableTime: true, // เปิดใช้งานการเลือกเวลา
                time_24hr: true, // ใช้รูปแบบเวลา 24 ชั่วโมง
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
