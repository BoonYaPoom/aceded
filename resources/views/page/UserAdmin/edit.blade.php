@extends('layouts.adminhome')
@section('content')
    <form action="{{ route('updateUser', ['user_id' => $usermanages->user_id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="page-inner">
            <div class="page-section">
                <div class="card card-fluid">
                    <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a> / ข้อมูลส่วนตัว ของ {{ $usermanages->firstname }} {{ $usermanages->lastname }}</div>
                    <div class="col-lg">
                        <h6 class="card-header"> ข้อมูลส่วนตัว </h6>
                        <div class="card-body">
                            <div class="media mb-3">
                                <div class="user-avatar user-avatar-xl fileinput-button">
                                    <div class="fileinput-button-label"> Change photo </div>
                                    <img src="{{ asset($usermanages->avatar) }}" alt="{{ $usermanages->avatar }}">

                                    <input id="fileupload-avatar" type="file" name="avatar" accept="image/*">
                                </div>
                                <!-- .media-body -->
                                <div class="media-body pl-3">
                                    <h3 class="card-title"><i class="fas fa-camera"></i> รูปส่วนตัว </h3>
                                    <h6 class="card-subtitle text-muted"> Click the current avatar to change your photo.
                                    </h6>
                                    <p class="card-text ">
                                        <small>JPG, GIF or PNG 400x400, &lt; 2 MB.</small>
                                    </p>
                                    <!-- The avatar upload progress bar -->
                                    <div id="progress-avatar" class="progress progress-xs fade">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            user_role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div><!-- /avatar upload progress bar -->
                                </div>
                                <!-- /.media-body -->
                            </div>
                            <!-- form row -->


                            <!-- /form row -->
                            <div class="form-row " id="department_id">
                                <label for="department_id" class="col-md-2">เลือกหน่วยงาน </label>
                                <div class="col-md-9 mb-3">
                                    <button type="button" class="ml-1 btn btn-success btn-md"
                                        style="background-color: #F04A23;"
                                        onclick="$('#clientUploadModal').modal('toggle');">
                                        <i class="fas fa-user-plus"></i> เลือกหน่วยงาน</button>

                                </div>
                            </div>
                            @include('page.UserAdmin.modeleditDpart')

                            <div class="form-row " id="user_role">
                                <label for="user_role" class="col-md-2">เลือกประเภทผู้ใช้งาน <span
                                        class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <select id="user_role" name="user_role" class="form-control form-control-md"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0" disabled>เลือกประเภทผู้ใช้งาน</option>
                                        @foreach ($role as $roles)
                                            @if ($roles->role_status == 1)
                                                @if ($data->user_role == 1)
                                                    <option value="{{ $roles->user_role_id }}"
                                                        {{ $roles->user_role_id == $usermanages->user_role ? 'selected' : '' }}>
                                                        {{ $roles->role_name }}
                                                    </option>
                                                @else
                                                    @if ($roles->user_role_id > 1)
                                                        <option value="{{ $roles->user_role_id }}"
                                                            {{ $roles->user_role_id == $usermanages->user_role ? 'selected' : '' }}>
                                                            {{ $roles->role_name }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('user_role')
                                <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row">
                                <label for="username" class="col-md-2">Username <span
                                        class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control inputuname " id="username"
                                        name="username" placeholder="username" value="{{ $usermanages->username }}"
                                        minlength="5" maxlength="20" readonly required=""><small
                                        class="form-text text-muted">ตัวอักษรอังกฤษหรืออีเมล
                                        ความยาว 5-20 ตัวอักษร</small>
                                </div>
                            </div>
           
                            <div class="form-row">
                                <label for="password" class="col-md-2"> รหัสผ่าน</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="password" name="password"
                                        placeholder="รหัสผ่าน" value="" minlength="8" maxlength="20">
                                    <small class="form-text text-muted">ตัวอักษรอังกฤษและตัวเลขความยาว 8-20 ตัวอักษร</small>
                                </div>
                            </div>
        
                            <div class="form-row">
                                <label for="citizen_id" class="col-md-2">เลขประจำตัวประชาชน</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="citizen_id" name="citizen_id"
                                        placeholder="เลขประจำตัวประชาชน" value="{{ $usermanages->citizen_id }}" >
                                </div>
                            </div>
                   
                            <div class="form-row">
                                <label for="input04" class="col-md-2">เพศ</label>
                                <div class="col-md-9 mb-3">
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="male" value="1"
                                            {{ $usermanages->gender == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="male">ชาย</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="female" value="2"
                                            {{ $usermanages->gender == 2 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="female">หญิง</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /form row -->
                            <div class="form-row">
                                <label for="birthday" class="col-md-2">วันเกิด</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control" name="birthday" id="birthday"
                                        value="{{ $usermanages->birthday }}" disabled />
                                </div>
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    flatpickr("#birthday", {
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

                            <!-- form row -->
                            <div class="form-row">
                                <label for="firstname" class="col-md-2">ชื่อ <span
                                        class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="firstname" name="firstname"
                                        placeholder="ชื่อ" value="{{ $usermanages->firstname }}" required="">
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row">
                                <label for="lastname" class="col-md-2">นามสกุล</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="lastname" name="lastname"
                                        placeholder="นามสกุล" value="{{ $usermanages->lastname }}">
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row">
                                <label for="email" class="col-md-2">อีเมล</label>
                                <div class="col-md-9 mb-3">
                                    <input type="email" class="form-control " id="email" name="email"
                                        placeholder="อีเมล" value="{{ $usermanages->email }}">
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row">
                                <label for="mobile" class="col-md-2">เบอร์โทรศัพท์มือถือ</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="mobile" name="mobile"
                                        value="{{ $usermanages->mobile }}" placeholder="เบอร์โทรศัพท์มือถือ">
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none " id="set_workplace">
                                <label for="workplace" class="col-md-2">ที่อยู่</label>
                                <div class="col-md-9 mb-3">
                                    <textarea type="text" class="form-control form-control-sm" rows="6" id="workplace" name="workplace"
                                        placeholder="ที่อยู่">123</textarea>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row " id="set_province_id">
                                <label for="province_id" class="col-md-2">จังหวัด </label>
                                <div class="col-md-9 mb-3">
                                    <select id="province_id" name="province_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกจังหวัด</option>
                                        @php
                                            $Provinces = \App\Models\Provinces::all();
                                        @endphp
                                        @foreach ($Provinces as $provin)
                                            <option
                                                value="{{ $provin->id }}"{{ $usermanages->province_id == $provin->id ? 'selected' : '0' }}>
                                                {{ $provin->name_in_thai }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none " id="set_district_id">
                                <label for="district_id" class="col-md-2">เขต/อำเภอ </label>
                                <div class="col-md-9 mb-3">
                                    <select id="district_id" name="district_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="86"> เมืองอ่างทอง </option>
                                        <option value="87"> ไชโย </option>
                                        <option value="88" selected> ป่าโมก </option>
                                        <option value="89"> โพธิ์ทอง </option>
                                        <option value="90"> แสวงหา </option>
                                        <option value="91"> วิเศษชัยชาญ </option>
                                        <option value="92"> สามโก้ </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none " id="set_subdistrict_id">
                                <label for="subdistrict_id" class="col-md-2">แขวง/ตำบล </label>
                                <div class="col-md-9 mb-3">
                                    <select id="subdistrict_id" name="subdistrict_id"
                                        class="form-control form-control-sm" data-toggle="select2"
                                        data-allow-clear="false">
                                        <option value="547"> บางปลากด </option>
                                        <option value="548" selected> ป่าโมก </option>
                                        <option value="549"> สายทอง </option>
                                        <option value="550"> โรงช้าง </option>
                                        <option value="551"> บางเสด็จ </option>
                                        <option value="552"> นรสิงห์ </option>
                                        <option value="553"> เอกราช </option>
                                        <option value="554"> โผงเผง </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->


                            <div class="form-row " id="set_pos_name">
                                <label for="pos_name" class="col-md-2">ตำแหน่ง</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="pos_name" name="pos_name"
                                        value="{{ $usermanages->pos_name }}" placeholder="ตำแหน่ง">

                                </div>
                            </div>
                            <!--/form row -->


                            <!-- form row -->
                            <div class="form-row d-none d-none" id="set_pos_level">
                                <label for="mobile" class="col-md-2">ระดับตำแหน่ง</label>
                                <div class="col-md-9 mb-3">
                                    <select id="pos_level" name="pos_level" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกระดับตำแหน่ง</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <label for="reviewser" class="col-md-2">หน่วยงาน</label>
                                <div class="col-md-9 mb-3">
                                    <fieldset>
                                        <div class="custom-control custom-control-inline custom-radio">
                                            <input type="radio" class="custom-control-input" name="reviewser"
                                                id="reviewser1" value="1" checked>
                                            <label class="custom-control-label" for="reviewser1">ข้อมูล</label>
                                        </div>
                                        <div class="custom-control custom-control-inline custom-radio">
                                            <input type="radio" class="custom-control-input" name="reviewser"
                                                id="reviewser2" value="2">
                                            <label class="custom-control-label" for="reviewser2">แก้ไข</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    var ser1 = $('#sers1');
                                    var ser2 = $('#sers2');

                                    $('input[name="reviewser"]').on('change', function() {
                                        var reviewsersec = $(this).val();

                                        if (reviewsersec == 1) {
                                            ser2.show();
                                            ser1.hide();
                                        } else if (reviewsersec == 2) {
                                            ser1.show();
                                            ser2.hide();
                                        }
                                    });

                                    // Trigger change event initially
                                    $('input[name="reviewser"]:checked').trigger('change');
                                });
                            </script>
                            <div id="sers2">
                                @php

                                    $user_affiliation = DB::table('users_extender')
                                        ->where('content_name', 'like', '%' . $usermanages->user_affiliation . '%')
                                        ->first();
                                    if ($user_affiliation) {
                                        $af1 = DB::table('users_extender')
                                            ->where('extender_id', $user_affiliation->id_ref)
                                            ->first();
                                        if ($af1) {
                                            $af2 = DB::table('users_extender')
                                                ->where('extender_id', $af1->id_ref)
                                                ->first();
                                        }
                                    }

                                    $organization = DB::table('users_extender2')
                                        ->where('extender_id', $usermanages->organization)
                                        ->first();

                                    if ($organization) {
                                        $parent = DB::table('users_extender2')
                                            ->where('extender_id', $organization->item_parent_id)
                                            ->first();

                                        if ($parent) {
                                            $parent_i = $parent->name;

                                            $parent2 = DB::table('users_extender2')
                                                ->where('extender_id', $parent->item_parent_id)
                                                ->first();

                                            if ($parent2) {
                                                $parent_i2 = $parent2->name;

                                                $parent3 = DB::table('users_extender2')
                                                    ->where('extender_id', $parent2->item_parent_id)
                                                    ->first();

                                                if ($parent3) {
                                                    $parent_i3 = $parent3->name;

                                                    $parent4 = DB::table('users_extender2')
                                                        ->where('extender_id', $parent3->item_parent_id)
                                                        ->first();

                                                    if ($parent4) {
                                                        $parent_i4 = $parent4->name;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                @endphp
                                <div class="form-row">
                                    <label for="seraas" class="col-md-2">สังกัด / หน่วยงาน</label>
                                    <div class="col-md-9 mb-3">
                                        @if ($usermanages->organization > 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value=" {{ $organization->name }}" disabled placeholder="หน่วยงาน"
                                                style="font-size: 22px;">
                                        @elseif ($usermanages->organization == 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ $user_affiliation->content_name ?? $usermanages->user_affiliation }}" disabled
                                                placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="seraas" class="col-md-2"></label>
                                    <div class="col-md-9 mb-3">

                                        @if ($usermanages->organization > 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($parent_i) ? $parent_i : '' }}" disabled
                                                placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @elseif ($usermanages->organization == 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($af1->content_name) ? $af1->content_name : '' }}"
                                                disabled placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label for="seraas" class="col-md-2"></label>
                                    <div class="col-md-9 mb-3">


                                        @if ($usermanages->organization > 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($parent_i2) ? $parent_i2 : '' }}" disabled
                                                placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @elseif ($usermanages->organization == 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($af2->content_name) ? $af2->content_name : '' }}"
                                                disabled placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="seraas" class="col-md-2"></label>
                                    <div class="col-md-9 mb-3">

                                        @if ($usermanages->organization > 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($parent_i3) ? $parent_i3 : '' }}" disabled
                                                placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @elseif ($usermanages->organization == 0)
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label for="seraas" class="col-md-2"></label>
                                    <div class="col-md-9 mb-3">

                                        @if ($usermanages->organization > 0)
                                            <input type="text" class="form-control " id="seraas" name="seraas"
                                                value="{{ isset($parent_i3) ? $parent_i3 : '' }}" disabled
                                                placeholder="หน่วยงาน" style="font-size: 22px;">
                                        @elseif ($usermanages->organization == 0)
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="sers1" style="display: none;">
                                <div class="form-row" id='departse'>
                                    <label for="departmentselect" class="col-md-2">รูปแบบสังกัด <span
                                            class="badge badge-warning">Required</span></label>
                                    <div class="col-md-9 mb-3">
                                        <select id="departmentselect" name="departmentselect" class="form-control "
                                            data-toggle="select2" data-allow-clear="false">
                                            <option value="" selected disabled>-- เลือกรูปแบบสังกัด --</option>
                                            <option value="1">
                                                โรงเรียน
                                            </option>
                                            <option value="2">
                                                อุดมศึกษา สถาบัน
                                            </option>
                                            <option value="3">
                                                ข้าราชการ
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row" id='sch1' style="display: none;">
                                    <label for="extender_id" class="col-md-2">สังกัด </label>
                                    <div class="col-md-9 mb-3">
                                        <select id="extender_id" name="extender_id" class="form-control "
                                            data-toggle="select2" data-allow-clear="false">
                                            <option value="" selected disabled>-- เลือกสังกัด --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row" id="sch2" style="display: none;">
                                    <label for="extender_id2" class="col-md-2">หน่วยงาน </label>
                                    <div class="col-md-9 mb-3">
                                        <select id="extender_id2" name="extender_id2" class="form-control "
                                            data-toggle="select2" data-allow-clear="false">
                                            <option value="" selected disabled>-- เลือกหน่วยงาน --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row" id="sch3" style="display: none;">
                                    <label for="extender_id3" class="col-md-2">หน่วยงานย่อย </label>
                                    <div class="col-md-9 mb-3">
                                        <select id="extender_id3" name="extender_id3" class="form-control "
                                            data-toggle="select2" data-allow-clear="false">
                                            <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row" id="sch4" style="display: none;">
                                    <label for="extender_id4" class="col-md-2"> </label>
                                    <div class="col-md-9 mb-3">
                                        <select id="extender_id4" name="extender_id4" class="form-control "
                                            data-toggle="select2" data-allow-clear="false">
                                            <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                                        </select>
                                    </div>
                                    <div class="form-row" id="sch5" style="display: none;">
                                        <label for="extender_id5" class="col-md-2"> </label>
                                        <div class="col-md-9 mb-3">
                                            <select id="extender_id5" name="extender_id5" class="form-control "
                                                data-toggle="select2" data-allow-clear="false">
                                                <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                                            </select>
                                        </div>
                                    </div>

                                    @include('page.UserAdmin.edit.addjs')

                                </div>
                                <div class="form-row " id="user_affiliation" style="display: none;">
                                    <label for="user_affiliation" class="col-md-2">ระดับ</label>
                                    <div class="col-md-9 mb-3">
                                        <input type="text" class="form-control " id="user_affiliation"
                                            name="user_affiliation" value="{{ $usermanages->user_affiliation }}"
                                            placeholder="สังกัด" style="font-size: 22px;">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary-theme ml-auto btn-lg"><i
                                        class="far fa-save"></i> บันทึก</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
