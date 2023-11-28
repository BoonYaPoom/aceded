@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <form action="{{ route('act1Update',[$depart,'activity_id' => $act->activity_id] ) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('cop', ['department_id' => $actCat->department_id]) }}"
                    style="text-decoration: underline;">กิจกกรรม</a> / <a href="{{ route('activi', ['department_id' => $actCat->department_id]) }}"
                    style="text-decoration: underline;">ชุมนุมนักปฏิบัติ </a> / <a href="{{ route('activiList' ,[$depart,$act->category_id]) }}"
                    style="text-decoration: underline;">{{ $act->title }}</a>
  
                  </div>
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        <label for="title">ชื่อเรื่อง <span class="badge badge-warning">Required</span></label> <input
                            type="text" class="form-control" id="title" name="title" placeholder="ชื่อเรื่อง"
                          value="{{$act->title}}">
                    </div><!-- /.form-group -->

                    <!-- .form-group -->
                    <div class="form-group ">
                        <label for="detail">รายละเอียด </label>
                        <textarea class="editor" data-placeholder="รายละเอียด" data-height="200" name="detail">{{$act->detail}}</textarea>
                    </div><!-- /.form-group -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="flatpickr03">วันที่เริ่ม</label>
                            <input type="text" class="form-control" name="startdate" id="flatpickr03"
                                value="{{$act->startdate}}" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="flatpickr04">วันที่สิ้นสุด</label>
                            <input type="text" class="form-control" name="enddate" id="flatpickr04"
                                value="{{$act->enddate}}" />
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
                        });
                        document.addEventListener("DOMContentLoaded", function() {
                            flatpickr("#flatpickr04", {
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
                        });
                    </script>
                    <div class="form-group">
                        <label for="activity_status">สถานะ </label> <label
                            class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                class="switcher-input" name="activity_status" id="activity_status" value="1"> <span
                                class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                class="switcher-label-off text-red">OFF</span></label>
                    </div><!-- /.form-group -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->

            <!-- .form-actions -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i> บันทึก</button>
            </div><!-- /.form-actions -->
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
    </form>
@endsection
