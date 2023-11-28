@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid" <!-- .card-header -->
                <div class="card-header bg-muted"><a
                        href="{{ route('manage', ['department_id' => $category->department_id]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a
                        href="{{ route('Webpage', ['department_id' => $category->department_id]) }}"
                        style="text-decoration: underline;">

                        {{ $category->category_th }}

                    </a> / <a href="{{ route('catpage', ['department_id' => $depart,'category_id' => $webs->category_id]) }}"
                        style="text-decoration: underline;">
                        กิจกรรม</a> / <i> เพิ่ม/{{ $webs->web_th }}</i></div><!-- /.card-header -->

                <form action="{{ route('updatecat', ['department_id' => $depart,'web_id' => $webs]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cover"><img src="{{ asset($webs->cover) }}"
                                    alt="{{ $webs->cover }}" style="height:350px">
                        </div>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="web_th">ชื่อข่าว/กิจกรรม (ไทย) <span
                                    class="badge badge-warning">Required</span></label> <input type="text"
                                class="form-control" id="web_th" name="web_th" placeholder="ชื่อข่าว/กิจกรรม (ไทย)"
                                required="" value="{{ $webs->web_th }}">
                        </div><!-- /.form-group -->
                        @error('web_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="web_en">ชื่อข่าว/กิจกรรม (อังกฤษ) </label> <input type="text"
                                class="form-control" id="web_en" name="web_en" placeholder="ชื่อข่าว/กิจกรรม (อังกฤษ)"
                                value="{{ $webs->web_en }}">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th"
                                value="{{ $webs->detail_th }}">{{ $webs->detail_th }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"
                                value="{{ $webs->detail_en }}">{{ $webs->detail_en }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->

                        @if ($category->category_type == 2)

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr03">วันที่เริ่ม</label>
                                <input type="text" class="form-control" name="startdate" id="flatpickr03"
                                    value="{{$webs->startdate}}" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="flatpickr04">วันที่สิ้นสุด</label>
                                <input type="text" class="form-control" name="enddate" id="flatpickr04"
                                    value="{{$webs->enddate}}" />
                            </div>

                        </div>
                        @endif
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
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"
                                    {{ $webs->recommended == 1 ? 'checked' : '' }}> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="web_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="web_status" id="web_status" value="1"
                                    {{ $webs->web_status == 1 ? 'checked' : '' }}> <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->

            </div><!-- /.card -->

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
    <!-- .form-actions -->
    <div class="form-actions">
        <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
            บันทึก</button>
    </div><!-- /.form-actions -->
    </form>
    </div><!-- /.card -->
@endsection
