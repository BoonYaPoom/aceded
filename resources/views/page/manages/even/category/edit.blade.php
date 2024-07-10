@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">

        <div class="page-section">
            <form action="{{ route('updatecat', ['department_id' => $depart, 'web_id' => $webs]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card card-fluid">
                    <div class="card-header bg-muted">
                        @if ($category->category_type == 2)
                            <a href="{{ route('manage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">จัดการเว็บ</a> / <a
                                href="{{ route('Webpage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">กิจกรรม</a> / <a
                                href="{{ route('acteven', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">{{ $category->category_th }}</a> /
                        @elseif ($category->category_type == 1)
                            <a href="{{ route('manage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">จัดการเว็บ</a> / <a
                                href="{{ route('Webpage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">ข่าว</a> / <a
                                href="{{ route('evenpage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;"><i> {{ $category->category_th }}</i></a> /
                        @endif
                        <a href="{{ route('catpage', [$depart, $category]) }}" style="text-decoration: underline;"><i>แก้ไข
                                {{ $webs->web_th }}</i> </a>
                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="form-group">
                            <label for="cover"><img src="{{ env('URL_FILE_SFTP') . $webs->cover }}" alt="{{ env('URL_FILE_SFTP') . $webs->cover }}"
                                    style="height:350px">
                        </div>

                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept=" image/jpeg, image/png">
                        </div>
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
                        </div>
                        <div class="form-group">

                            <label for="detail_th">รายละเอียด (ไทย)</label>

                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th" id="detail_th">
                                    {{ html_entity_decode($webs->detail_th, ENT_QUOTES, 'UTF-8') }}
                        </textarea>
                        </div>

                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en" id="detail_en">
                                    {{ html_entity_decode($webs->detail_en, ENT_QUOTES, 'UTF-8') }}
                            </textarea>
                        </div>


                        @if ($category->category_type == 2)
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="flatpickr03">วันที่เริ่ม</label>
                                    <input type="text" class="form-control" name="startdate" id="flatpickr03"
                                        value="{{ $webs->startdate }}" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="flatpickr04">วันที่สิ้นสุด</label>
                                    <input type="text" class="form-control" name="enddate" id="flatpickr04"
                                        value="{{ $webs->enddate }}" />
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
                                    {{ $webs->web_status == 1 ? 'checked' : '' }}> <span
                                    class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div>
            </form>
        </div>
    </div>
@endsection
