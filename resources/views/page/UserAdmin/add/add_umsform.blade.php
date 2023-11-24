@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <form action="{{ route('storeUser') }}" method="post" enctype="multipart/form-data">
        @csrf


        <!-- .page-inner -->
        <div class="page-inner">
            <div class="page-section">
                <div class="card card-fluid">
                    <div class="card-header bg-muted"><a href="{{ route('UserManage') }}">ผู้ใช้งาน</a> / ข้อมูลส่วนตัว</div>
                    <div class="col-lg">
                        <h6 class="card-header"> ข้อมูลส่วนตัว </h6>
                        <div class="card-body">
                            <!-- form row -->
      
                            <div class="form-row " id="department_id">
                                <label for="department_id" class="col-md-2">เลือกหน่วยงาน <span
                                    class="badge badge-warning">Required</span></label>
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
                                        <option value="0"selected disabled>เลือกประเภทผู้ใช้งาน</option>
                                        @foreach ($role as $roles)
                                            @if ($roles->role_status == 1)
                                                @if ($roles->user_role_id > 1)
                                                    <option value="{{ $roles->user_role_id }}">{{ $roles->role_name }}
                                                    </option>
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
                            <div class="container mt-5">

                            </div>


                            <!-- form row -->
                            <div class="form-row">
                                <label for="username" class="col-md-2">Username <span
                                        class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control inputuname " id="username" name="username"
                                        placeholder="username" value="" minlength="5" maxlength="20"
                                        required=""><small class="form-text text-muted">ตัวอักษรอังกฤษหรืออีเมล ความยาว
                                        5-20 ตัวอักษร</small>
                                </div>
                            </div>
                            <!-- /form row -->
                            @error('username')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row">
                                <label for="password" class="col-md-2"> รหัสผ่าน <span
                                    class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="password" name="password"
                                        placeholder="รหัสผ่าน" minlength="8" maxlength="20">
                                    <small class="form-text text-muted">ตัวอักษรอังกฤษและตัวเลขความยาว 8-20 ตัวอักษร</small>
                                </div>
                            </div>
                            @error('password')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- /form row -->
                            <div class="form-row ">
                                <label for="user_type_card" class="col-md-2">ประเภทบุคลากร <span
                                    class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <div class="custom-control custom-control-inline custom-radio mr-3">
                                        <input type="radio" class="custom-control-input user_type_cardselect"
                                            name="user_type_card" id="user_type_card1" value="1"
                                            onchange="if(this.value==1) $('.showdiscount').addClass('d-none'); ">
                                        <label class="custom-control-label" for="user_type_card1">เลขบัตรประชาชน
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio mr-3">
                                        <input type="radio" class="custom-control-input user_type_cardselect"
                                            name="user_type_card" id="user_type_card2" value="2"
                                            onchange="if(this.value==2)  $('.showdiscount').addClass('d-none');">
                                        <label class="custom-control-label" for="user_type_card2">เลข Passport
                                        </label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio mr-3">
                                        <input type="radio" class="custom-control-input user_type_cardselect"
                                            name="user_type_card" id="user_type_card3" value="3"
                                            onchange="if(this.value==3) $('.showdiscount').removeClass('d-none'); else $('.showdiscount').addClass('d-none');">
                                        <label class="custom-control-label" for="user_type_card3">อื่นๆ
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('user_type_card')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row ">
                                <label for="citizen_id" class="col-md-2">เลขประจำตัวประชาชน <span
                                    class="badge badge-warning">Required</span></label>
                                <div class="col-xs-1 mb-1  showdiscount  d-none">
                                    <select id="citizen_id_select" class="form-control" data-toggle="select2"
                                        data-allow-clear="false">
                                        <option value="0">อื่นๆ</option>
                                        <option value="00">00</option>
                                        <option value="0">0</option>
                                        <option value="G-">G-</option>
                                    </select>
                                </div>
                                <div class="col-md-9 mb-3">
                                    <div class="col-md-9 mb-3">
                                        <input type="text" class="form-control" id="citizen_id_input"
                                            name="citizen_id" placeholder="เลขประจำตัวประชาชน" value="">
                                    </div>
                                </div>
                            </div>
                            <!-- /form row -->
                            @error('citizen_id')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const select = document.getElementById("citizen_id_select");
                                    const input = document.getElementById("citizen_id_input");

                                    // Store the initial input field value
                                    const initialValue = input.value;

                                    // Add an event listener to the select element
                                    select.addEventListener("change", function() {
                                        // Get the selected option's value
                                        const selectedValue = this.value;

                                        // Set the input field's value to the selected option's value
                                        input.value = selectedValue;

                                        // If the selected option is not "อื่นๆ," append the initial value
                                        if (selectedValue !== "0") {
                                            input.value += initialValue;
                                        }
                                    });
                                });
                            </script>


                            <!-- form row -->
                            <div class="form-row">
                                <label for="input04" class="col-md-2">เพศ <span
                                    class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="male" value="1">
                                        <label class="custom-control-label" for="male">ชาย</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="female" value="2">
                                        <label class="custom-control-label" for="female">หญิง</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /form row -->

                            @error('gender')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row">
                                <label for="firstname" class="col-md-2">ชื่อ <span
                                        class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="firstname" name="firstname"
                                        placeholder="ชื่อ" value="" required="">
                                </div>
                            </div>
                            <!-- /form row -->
                            @error('firstname')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row">
                                <label for="lastname" class="col-md-2">นามสกุล</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="lastname" name="lastname"
                                        placeholder="นามสกุล" value="">
                                </div>
                            </div>
                            <!-- /form row -->

                            <div class="form-row">
                                <label for="birthday" class="col-md-2">วันเกิด</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control" name="birthday" id="birthday"
                                        value="" />
                                </div>
                            </div>
                            @error('birthday')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
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
                                <label for="email" class="col-md-2">อีเมล <span
                                    class="badge badge-warning">Required</span></label>
                                <div class="col-md-9 mb-3">
                                    <input type="email" class="form-control " id="email" name="email"
                                        placeholder="อีเมล" value="">
                                </div>
                            </div>
                            <!-- /form row -->
                            @error('email')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!-- form row -->
                            <div class="form-row">
                                <label for="mobile" class="col-md-2">เบอร์โทรศัพท์มือถือ</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control number" id="mobile" name="mobile"
                                        value="" placeholder="เบอร์โทรศัพท์มือถือ">
                                </div>
                            </div>
                    
                            <!-- form row -->
                            <div class="form-row d-none " id="set_workplace">
                                <label for="workplace" class="col-md-2">ที่อยู่</label>
                                <div class="col-md-9 mb-3">
                                    <textarea type="text" class="form-control form-control-sm" rows="6" id="workplace" name="workplace"
                                        placeholder="ที่อยู่"></textarea>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row " id="set_province_id">
                                <label for="province_id" class="col-md-2">จังหวัด</label>
                                <div class="col-md-9 mb-3">
                                    <select id="province_id" name="province_id" class="form-control "
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกจังหวัด</option>
                                        @php
                                            $Provinces = \App\Models\Provinces::all();
                                        @endphp
                                        @foreach ($Provinces as $provin)
                                            <option value="{{ $provin->code }}"> {{ $provin->name_in_thai }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- form row -->
                            <div class="form-row d-none " id="set_district_id">
                                <label for="district_id" class="col-md-2">เขต/อำเภอ </label>
                                <div class="col-md-9 mb-3">
                                    <select id="district_id" name="district_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกเขต/อำเภอ</option>
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
                                        <option value="0">โปรดเลือกแขวง/ตำบล</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->
                            <div class="form-row">
                                <label for="school" class="col-md-2">โรงเรียน / มหาลัย </label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control inputuname " id="search" name="school"
                                        placeholder="school" value="" required=""><small
                                        class="form-text text-muted">โรงเรียน / มหาลัย </small>
                                </div>
                            </div>
                            @error('school')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <script type="text/javascript">
                                var path = "{{ route('autocompleteSearch') }}";

                                $("#search").autocomplete({
                                    source: function(request, response) {
                                        $.ajax({
                                            url: path,
                                            type: 'GET',
                                            dataType: "json",
                                            data: {
                                                search: request.term
                                            },
                                            success: function(data) {
                                                response(data);
                                            }
                                        });
                                    },
                                    select: function(event, ui) {
                                        $('#search').addClass("form-control form-control-sm");

                                        // Log the ui.item to the console
                                        console.log(ui.item);

                                        // Set the input value to the selected item's label
                                        $('#search').val(ui.item.label);

                                        return false;
                                    }
                                });
                            </script>
                            <!-- form row -->
                            <div class="form-row " id="set_pos_name">
                                <label for="pos_name" class="col-md-2">ตำแหน่ง</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="pos_name" name="pos_name"
                                        value="" placeholder="ตำแหน่ง">
                                    <!-- <select id="pos_namexx" name="pos_namexx" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                                                                                                    </select> -->
                                </div>
                            </div>
                            @error('pos_name')
                                    <div class="col-md-9 mb-3">
                                    <span class="badge badge-warning">{{ $message }}</span>
                                </div>
                            @enderror
                            <!--/form row -->
                            <div class="form-row " id="user_affiliation">
                                <label for="user_affiliation" class="col-md-2">สังกัด</label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control " id="user_affiliation"
                                        name="user_affiliation" value="" placeholder="สังกัด">

                                </div>
                            </div>
                            <!-- form row -->
                            <div class="form-row d-none " id="set_pos_level">
                                <label for="mobile" class="col-md-2">ระดับตำแหน่ง</label>
                                <div class="col-md-9 mb-3">
                                    <select id="pos_level" name="pos_level" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกระดับตำแหน่ง</option>
                                        <option value="1"> ปฏิบัติงาน </option>
                                        <option value="2"> ชำนาญงาน </option>
                                        <option value="3"> อาวุโส </option>
                                        <option value="4"> ทักษะพิเศษ </option>
                                        <option value="5"> ปฏิบัติการ </option>
                                        <option value="6"> ชำนาญการ </option>
                                        <option value="7"> ชำนาญการพิเศษ </option>
                                        <option value="8"> เชี่ยวชาญ </option>
                                        <option value="9"> ทรงคุณวุฒิ </option>
                                        <option value="10"> อำนวยการต้น </option>
                                        <option value="11"> อำนวยการสูง </option>
                                        <option value="12"> บริหารต้น </option>
                                        <option value="13"> บริหารสูง </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none " id="set_sector_id">
                                <label for="sector_id" class="col-md-2">ส่วนกลาง / ต่างจังหวัด</label>
                                <div class="col-md-9 mb-3">
                                    <select id="sector_id" name="sector_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกส่วนกลาง/ต่างจังหวัด</option>
                                        <option value="1"> ภาค1 </option>
                                        <option value="2"> ภาค2 </option>
                                        <option value="3"> ภาค3 </option>
                                        <option value="4"> ภาค4 </option>
                                        <option value="5"> ภาค5 </option>
                                        <option value="6"> ภาค6 </option>
                                        <option value="7"> ภาค7 </option>
                                        <option value="8"> ภาค8 </option>
                                        <option value="9"> ภาค9 </option>
                                        <option value="10"> ส่วนกลาง </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none " id="set_office_id">
                                <label for="office_id" class="col-md-2">สำนักงาน</label>
                                <div class="col-md-9 mb-3">
                                    <select id="office_id" name="office_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-allow-clear="false">
                                        <option value="0">โปรดเลือกสำนักงาน</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none">
                                <label for="editflag" class="col-md-2">อนุญาตแก้ไขข้อมูลส่วนตัว</label>
                                <div class="col-md-9 mb-3">
                                    <label class="switcher-control switcher-control-success switcher-control-lg">
                                        <input type="checkbox" class="switcher-input switcher-edit" value="1"
                                            id="2d9ccf81cb655e2b71796f3083674343__users__editflag__user_id____1690788225"
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
    </form>
@endsection
