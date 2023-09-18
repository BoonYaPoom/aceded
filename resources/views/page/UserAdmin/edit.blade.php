@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <form action="{{ route('updateUser',['uid'=>$usermanages->uid]) }}" method="post" enctype="multipart/form-data">
        @csrf 
        @method('PUT')
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted"></div>
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
                                <h6 class="card-subtitle text-muted"> Click the current avatar to change your photo. </h6>
                                <p class="card-text ">
                                    <small>JPG, GIF or PNG 400x400, &lt; 2 MB.</small>
                                </p>
                                <!-- The avatar upload progress bar -->
                                <div id="progress-avatar" class="progress progress-xs fade">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div><!-- /avatar upload progress bar -->
                            </div>
                            <!-- /.media-body -->
                        </div>
                        <!-- form row -->
                        <div class="form-row">
                            <label for="usertype" class="col-md-2">ประเภทบุคลากร </label>
                            <div class="col-md-9 mb-3">
                                <div class="custom-control custom-control-inline custom-radio mr-3">
                                    <input type="radio" class="custom-control-input usertypeselect" name="user_type"
                                        id="usertype1" value="1" {{ $usermanages->user_type == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="usertype1">บุคลากรของสำนักงาน</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio mr-3">
                                    <input type="radio" class="custom-control-input usertypeselect" name="user_type"
                                        id="usertype2" value="2" {{ $usermanages->user_type == 2 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="usertype2">บุคคลทั่วไป</label>
                                </div>
                            </div>
                        </div>

                        <!-- /form row -->
                        <div class="form-row " id="department_id">
                            <label for="department_id" class="col-md-2">เลือกหน่วยงาน </label>
                            <div class="col-md-9 mb-3">
                                <select id="department_id" name="department_id" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="0"selected disabled>เลือกหน่วยงาน</option>
                                    @php
                                    $Department = \App\Models\Department::all();
                                @endphp
                                @foreach ($Department as $part)
                                    <option value="{{ $part->department_id }}"> {{ $part->name_th }} </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- form row -->
                        <div class="form-row">
                            <label for="username" class="col-md-2">Username <span
                                    class="badge badge-warning">Required</span></label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control inputuname bg-muted" id="username"
                                    name="username" placeholder="username" value="{{$usermanages->username}}" minlength="5" maxlength="20"
                                    readonly required=""><small class="form-text text-muted">ตัวอักษรอังกฤษหรืออีเมล
                                    ความยาว 5-20 ตัวอักษร</small>
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <label for="password" class="col-md-2"> รหัสผ่าน</label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="password" name="password"
                                    placeholder="รหัสผ่าน" value="" minlength="8" maxlength="20">
                                <small class="form-text text-muted">ตัวอักษรอังกฤษและตัวเลขความยาว 8-20 ตัวอักษร</small>
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <label for="firstname" class="col-md-2">เลขประจำตัวประชาชน</label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="citizen_id" name="citizen_id" minlength="13"
                                    maxlength="13" value="{{$usermanages->citizen_id}}" placeholder="เลขประจำตัวประชาชน" value="">
                            </div>
                        </div>
                        <!-- /form row -->


                        <!-- form row -->
                        <div class="form-row">
                            <label for="input04" class="col-md-2">เพศ</label>
                            <div class="col-md-9 mb-3">
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" class="custom-control-input is-valid" name="gender"
                                        id="male" value="1" {{ $usermanages->gender == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="male">ชาย</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input type="radio" class="custom-control-input " name="gender" id="female"
                                        value="2" {{ $usermanages->gender == 2 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="female">หญิง</label>
                                </div>
                            </div>
                        </div>
                        <!-- /form row -->


                        <!-- form row -->
                        <div class="form-row">
                            <label for="firstname" class="col-md-2">ชื่อ <span
                                    class="badge badge-warning">Required</span></label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="firstname" name="firstname"
                                    placeholder="ชื่อ" value="{{$usermanages->firstname}}" required="">
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <label for="lastname" class="col-md-2">นามสกุล</label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="lastname" name="lastname"
                                    placeholder="นามสกุล" value="{{$usermanages->lastname}}">
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <label for="email" class="col-md-2">อีเมล</label>
                            <div class="col-md-9 mb-3">
                                <input type="email" class="form-control " id="email" name="email"
                                    placeholder="อีเมล" value="{{$usermanages->email}}">
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row">
                            <label for="mobile" class="col-md-2">เบอร์โทรศัพท์มือถือ</label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="mobile" name="mobile"
                                    value="{{$usermanages->mobile}}" placeholder="เบอร์โทรศัพท์มือถือ">
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
                                    <option value="{{ $provin->id }}"{{  $usermanages->province_id == $provin->id  ? 'selected' : '0' }}> {{ $provin->name_in_thai }} </option>
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
                                <select id="subdistrict_id" name="subdistrict_id" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
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

                        <!-- form row -->
                        <div class="form-row " id="set_pos_name">
                            <label for="pos_name" class="col-md-2">ตำแหน่ง</label>
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control " id="pos_name" name="pos_name"
                                    value="{{$usermanages->pos_name}}" placeholder="ตำแหน่ง">
                  
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
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row d-none d-none" id="set_sector_id">
                            <label for="sector_id" class="col-md-2">ส่วนกลาง / ต่างจังหวัด</label>
                            <div class="col-md-9 mb-3">
                                <select id="sector_id" name="sector_id" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="0">โปรดเลือกส่วนกลาง/ต่างจังหวัด</option>
                                    @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{$i}}"> ภาค{{$i}} </option>
                       
                                    @endfor
                                    <option value="10"> ส่วนกลาง </option>
                                </select>
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row d-none d-none" id="set_office_id">
                            <label for="office_id" class="col-md-2">สำนักงาน</label>
                            <div class="col-md-9 mb-3">
                                <select id="office_id" name="office_id" class="form-control form-control-sm"
                                    data-toggle="select2" data-allow-clear="false">
                                    <option value="0">โปรดเลือกสำนักงาน</option>
                                    <option value="8"> สำนักงานการสอบสวน 4 </option>
                                    <option value="45"> สำนักงานอัยการพิเศษฝ่ายคุ้มครองผู้บริโภค </option>
                                    <option value="46"> สำนักงานอัยการพิเศษฝ่ายคุ้มครองสิทธิ </option>
                                    <option value="47"> สำนักงานอัยการพิเศษฝ่ายคุ้มครองสิทธิประชาชนระหว่างประเทศ
                                    </option>
                                    <option value="49"> สำนักงานอัยการพิเศษฝ่ายช่วยเหลือทางกฎหมาย 1 </option>
                                    <option value="50"> สำนักงานอัยการพิเศษฝ่ายช่วยเหลือทางกฎหมาย 4 (มีนบุรี) </option>
                                    <option value="51"> สำนักงานอัยการพิเศษฝ่ายบริหารจัดการความรู้ (KM) </option>
                                    <option value="53"> สำนักงานอัยการพิเศษฝ่ายพัฒนากฎหมาย </option>
                                    <option value="54"> สำนักงานอัยการพิเศษฝ่ายสารสนเทศ </option>
                                </select>
                            </div>
                        </div>
                        <!-- /form row -->

                        <!-- form row -->
                        <div class="form-row d-none">
                            <label for="editflag" class="col-md-2">อนุญาตแก้ไขข้อมูลส่วนตัว</label>
                            <div class="col-md-9 mb-3">
                                <label class="switcher-control switcher-control-success switcher-control-lg">
                                    <input type="checkbox" class="switcher-input switcher-edit" checked value="1"
                                        id="8cd306b95d82314da5402c4bd7fc299b__users__editflag__uid__2__1684987166"
                                        name="editflag">
                                    <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                    <span class="switcher-label-off text-red">OFF</span>
                                </label>
                            </div>
                        </div>
                        <!-- /form row -->
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
