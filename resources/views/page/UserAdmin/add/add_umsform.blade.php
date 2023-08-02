@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <form action="{{route('storeUser')}}" method="post" enctype="multipart/form-data">
        @csrf 

   <!-- .page-inner -->
<div class="page-inner">
    <div class="page-section">
      <div class="card card-fluid">
        <div class="card-header bg-muted"></div>
        <div class="col-lg">
          <h6 class="card-header"> ข้อมูลส่วนตัว </h6>
            <div class="card-body">
                           <!-- form row -->
               <div class="form-row ">
                    <label for="usertype" class="col-md-2">ประเภทบุคลากร </label>
                    <div class="col-md-9 mb-3">
                        <div class="custom-control custom-control-inline custom-radio mr-3">
                            <input type="radio" class="custom-control-input usertypeselect" name="user_type" id="usertype1"  value="1" >
                            <label class="custom-control-label" for="usertype1">บุคลากรของสำนักงาน</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio mr-3">
                            <input type="radio" class="custom-control-input usertypeselect" name="user_type" id="usertype2"  value="2"  >
                            <label class="custom-control-label" for="usertype2">บุคคลทั่วไป</label>
                        </div>
                        
                    </div>
                      </div>
                <!-- /form row -->
  
              <!-- form row -->
              <div class="form-row">
                <label for="username" class="col-md-2">Username <span class="badge badge-warning">Required</span></label>
                <div class="col-md-9 mb-3">
                  <input type="text" class="form-control inputuname " id="username" name="username" placeholder="username" 
                    value="" minlength="5" maxlength="20"   required=""><small class="form-text text-muted">ตัวอักษรอังกฤษหรืออีเมล ความยาว 5-20 ตัวอักษร</small>
                </div>
              </div>
              <!-- /form row -->
  
              <!-- form row -->
                                      <div class="form-row">
                  <label for="password" class="col-md-2">	รหัสผ่าน</label>
                  <div class="col-md-9 mb-3">
                    <input type="text" class="form-control " id="password" name="password" placeholder="รหัสผ่าน"  minlength="8" maxlength="20"> 
                      <small class="form-text text-muted">ตัวอักษรอังกฤษและตัวเลขความยาว 8-20 ตัวอักษร</small>
                  </div>
                </div>
                                    <!-- /form row -->
              
              <!-- form row -->
              <div class="form-row">
                  <label for="firstname" class="col-md-2">เลขประจำตัวประชาชน</label>
                  <div class="col-md-9 mb-3">
                    <input type="text" class="form-control " id="citizen_id" name="citizen_id" minlength="13" maxlength="13" placeholder="เลขประจำตัวประชาชน" value="">
                  </div>
                </div>
              <!-- /form row -->
  
  
              <!-- form row -->
              <div class="form-row">
                  <label for="input04" class="col-md-2">เพศ</label>
                  <div class="col-md-9 mb-3">
                    <div class="custom-control custom-control-inline custom-radio">
                      <input type="radio" class="custom-control-input " name="gender" id="male" value="1" > 
                        <label class="custom-control-label" for="male">ชาย</label>
                    </div>
                    <div class="custom-control custom-control-inline custom-radio">
                      <input type="radio" class="custom-control-input " name="gender" id="female" value="2" > 
                        <label class="custom-control-label" for="female">หญิง</label>
                    </div>
                  </div>
                </div>
              <!-- /form row -->
  
            
              <!-- form row -->
                <div class="form-row">
                  <label for="firstname" class="col-md-2">ชื่อ <span class="badge badge-warning">Required</span></label>
                  <div class="col-md-9 mb-3">
                    <input type="text" class="form-control " id="firstname" name="firstname" placeholder="ชื่อ" value="" required="">
                  </div>
                </div>
              <!-- /form row -->
  
              <!-- form row -->
                <div class="form-row">
                  <label for="lastname" class="col-md-2">นามสกุล</label>
                  <div class="col-md-9 mb-3">
                    <input type="text" class="form-control " id="lastname" name="lastname" placeholder="นามสกุล" value="" >
                  </div>
                </div>
              <!-- /form row -->
  
              <!-- form row -->
                <div class="form-row">
                  <label for="email" class="col-md-2">อีเมล</label> 
                  <div class="col-md-9 mb-3">
                    <input type="email" class="form-control " id="email" name="email" placeholder="อีเมล" value="" >
                  </div>
                </div>
              <!-- /form row -->
  
              <!-- form row -->
                <div class="form-row">
                  <label for="mobile" class="col-md-2">เบอร์โทรศัพท์มือถือ</label>
                  <div class="col-md-9 mb-3">
                    <input type="text" class="form-control " id="mobile" name="mobile" value="" placeholder="เบอร์โทรศัพท์มือถือ" >
                  </div>
                </div>
              <!-- /form row -->
  
                <!-- form row -->
                <div class="form-row d-none " id="set_workplace">
                    <label for="workplace" class="col-md-2">ที่อยู่</label>
                    <div class="col-md-9 mb-3">
                        <textarea type="text" class="form-control form-control-sm" rows="6"  id="workplace" name="workplace"  placeholder="ที่อยู่"></textarea>
                    </div>
                </div>
                <!-- /form row -->
  
                <!-- form row -->
                <div class="form-row d-none " id="set_province_id">
                        <label for="province_id" class="col-md-2">จังหวัด </label>
                        <div class="col-md-9 mb-3">
                        <select id="province_id" name="province_id" class="form-control form-control-sm" data-toggle="select2"  data-allow-clear="false">
                            <option value="0" >โปรดเลือกจังหวัด</option><option value="1" > กรุงเทพมหานคร </option><option value="2" > สมุทรปราการ </option><option value="3" > นนทบุรี </option><option value="4" > ปทุมธานี </option><option value="5" > พระนครศรีอยุธยา </option><option value="6" > อ่างทอง </option><option value="7" > ลพบุรี </option><option value="8" > สิงห์บุรี </option><option value="9" > ชัยนาท </option><option value="10" > สระบุรี </option><option value="11" > ชลบุรี </option><option value="12" > ระยอง </option><option value="13" > จันทบุรี </option><option value="14" > ตราด </option><option value="15" > ฉะเชิงเทรา </option><option value="16" > ปราจีนบุรี </option><option value="17" > นครนายก </option><option value="18" > สระแก้ว </option><option value="19" > นครราชสีมา </option><option value="20" > บุรีรัมย์ </option><option value="21" > สุรินทร์ </option><option value="22" > ศรีสะเกษ </option><option value="23" > อุบลราชธานี </option><option value="24" > ยโสธร </option><option value="25" > ชัยภูมิ </option><option value="26" > อำนาจเจริญ </option><option value="27" > บึงกาฬ </option><option value="28" > หนองบัวลำภู </option><option value="29" > ขอนแก่น </option><option value="30" > อุดรธานี </option><option value="31" > เลย </option><option value="32" > หนองคาย </option><option value="33" > มหาสารคาม </option><option value="34" > ร้อยเอ็ด </option><option value="35" > กาฬสินธุ์ </option><option value="36" > สกลนคร </option><option value="37" > นครพนม </option><option value="38" > มุกดาหาร </option><option value="39" > เชียงใหม่ </option><option value="40" > ลำพูน </option><option value="41" > ลำปาง </option><option value="42" > อุตรดิตถ์ </option><option value="43" > แพร่ </option><option value="44" > น่าน </option><option value="45" > พะเยา </option><option value="46" > เชียงราย </option><option value="47" > แม่ฮ่องสอน </option><option value="48" > นครสวรรค์ </option><option value="49" > อุทัยธานี </option><option value="50" > กำแพงเพชร </option><option value="51" > ตาก </option><option value="52" > สุโขทัย </option><option value="53" > พิษณุโลก </option><option value="54" > พิจิตร </option><option value="55" > เพชรบูรณ์ </option><option value="56" > ราชบุรี </option><option value="57" > กาญจนบุรี </option><option value="58" > สุพรรณบุรี </option><option value="59" > นครปฐม </option><option value="60" > สมุทรสาคร </option><option value="61" > สมุทรสงคราม </option><option value="62" > เพชรบุรี </option><option value="63" > ประจวบคีรีขันธ์ </option><option value="64" > นครศรีธรรมราช </option><option value="65" > กระบี่ </option><option value="66" > พังงา </option><option value="67" > ภูเก็ต </option><option value="68" > สุราษฎร์ธานี </option><option value="69" > ระนอง </option><option value="70" > ชุมพร </option><option value="71" > สงขลา </option><option value="72" > สตูล </option><option value="73" > ตรัง </option><option value="74" > พัทลุง </option><option value="75" > ปัตตานี </option><option value="76" > ยะลา </option><option value="77" > นราธิวาส </option>                          </select>
                        </div>
                    </div>
                <!-- /form row -->
  
                <!-- form row -->
                 <div class="form-row d-none " id="set_district_id">
                      <label for="district_id" class="col-md-2">เขต/อำเภอ </label>
                      <div class="col-md-9 mb-3">
                      <select id="district_id" name="district_id" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                          <option value="0" >โปรดเลือกเขต/อำเภอ</option>                        </select>
                      </div>
                  </div>
                  <!-- /form row -->
  
                    <!-- form row -->
                    <div class="form-row d-none " id="set_subdistrict_id">
                      <label for="subdistrict_id" class="col-md-2">แขวง/ตำบล </label>
                      <div class="col-md-9 mb-3">
                      <select id="subdistrict_id" name="subdistrict_id" class="form-control form-control-sm" data-toggle="select2"  data-allow-clear="false">
                          <option value="0" >โปรดเลือกแขวง/ตำบล</option>                        </select>
                      </div>
                  </div>
                  <!-- /form row -->
  
               <!-- form row -->
               <div class="form-row " id="set_pos_name">
                  <label for="pos_name" class="col-md-2">ตำแหน่ง</label>
                  <div class="col-md-9 mb-3">
                  <input type="text" class="form-control " id="pos_name" name="pos_name" value="" placeholder="ตำแหน่ง" >
                  <!-- <select id="pos_namexx" name="pos_namexx" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                                                </select> -->
                  </div>
                </div>
              <!--/form row -->
  
               <!-- form row -->
               <div class="form-row d-none " id="set_pos_level">
                  <label for="mobile" class="col-md-2">ระดับตำแหน่ง</label>
                  <div class="col-md-9 mb-3">
                  <select id="pos_level" name="pos_level" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                          <option value="0" >โปรดเลือกระดับตำแหน่ง</option><option value="1" > ปฏิบัติงาน </option><option value="2" > ชำนาญงาน </option><option value="3" > อาวุโส </option><option value="4" > ทักษะพิเศษ </option><option value="5" > ปฏิบัติการ </option><option value="6" > ชำนาญการ </option><option value="7" > ชำนาญการพิเศษ </option><option value="8" > เชี่ยวชาญ </option><option value="9" > ทรงคุณวุฒิ </option><option value="10" > อำนวยการต้น </option><option value="11" > อำนวยการสูง </option><option value="12" > บริหารต้น </option><option value="13" > บริหารสูง </option>                      </select>
                  </div>
                </div>
              <!-- /form row -->
  
               <!-- form row -->
               <div class="form-row d-none " id="set_sector_id">
                  <label for="sector_id" class="col-md-2">ส่วนกลาง / ต่างจังหวัด</label>
                  <div class="col-md-9 mb-3">
                  <select id="sector_id" name="sector_id" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                          <option value="0" >โปรดเลือกส่วนกลาง/ต่างจังหวัด</option><option value="1" > ภาค1 </option><option value="2" > ภาค2 </option><option value="3" > ภาค3 </option><option value="4" > ภาค4 </option><option value="5" > ภาค5 </option><option value="6" > ภาค6 </option><option value="7" > ภาค7 </option><option value="8" > ภาค8 </option><option value="9" > ภาค9 </option><option value="10" > ส่วนกลาง </option>                      </select>
                  </div>
                </div>
              <!-- /form row -->
  
                <!-- form row -->
                <div class="form-row d-none " id="set_office_id">
                  <label for="office_id" class="col-md-2">สำนักงาน</label>
                  <div class="col-md-9 mb-3">
                  <select id="office_id" name="office_id" class="form-control form-control-sm" data-toggle="select2" data-allow-clear="false">
                        <option value="0" >โปรดเลือกสำนักงาน</option>                </select>
                  </div>
                </div>
              <!-- /form row -->
              
              <!-- form row -->
              <div class="form-row d-none">
                <label for="editflag" class="col-md-2">อนุญาตแก้ไขข้อมูลส่วนตัว</label>
                <div class="col-md-9 mb-3">
                  <label class="switcher-control switcher-control-success switcher-control-lg">
                    <input type="checkbox" class="switcher-input switcher-edit"  value="1" 
                      id="2d9ccf81cb655e2b71796f3083674343__users__editflag__uid____1690788225" name="editflag"> 
                    <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> 
                    <span class="switcher-label-off text-red">OFF</span>
                  </label> 
                </div>
              </div>
              <!-- /form row -->  
            </div>
            <div class="card-body">
              <div class="form-actions">
                <button type="submit" class="btn btn-primary-theme ml-auto btn-lg"><i class="far fa-save"></i> บันทึก</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</form>
@endsection
