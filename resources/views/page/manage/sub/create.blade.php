@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
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



    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">
                    <a href="{{ route('learn', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a>
                    / <a href="{{ route('suppage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการวิชา</a>

                </div>

                <form action="{{ route('substore', ['department_id' => $depart]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="subject_code ">รหัสวิชา <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control " name="subject_code" placeholder="รหัสวิชา"
                                value="" required="">
                        </div>
                        @error('subject_code')
                            <span class="badge badge-danger">รหัสมีซ้ำในระบบ</span>
                        @enderror
                        <div class="form-group">
                            <label for="subject_th">วิชา (ไทย)
                                <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="subject_th" placeholder="วิชา (ไทย)"
                                required="" value="">
                        </div>
                        @error('subject_th')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="subject_en">วิชา (อังกฤษ) <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" required="" name="subject_en"
                                placeholder="วิชา (อังกฤษ)" value="">
                        </div>
                        <div class="form-group">
                            <label for="banner">ภาพแบนเนอร์ <span class="badge badge-warning">Required</span></label>
                            <input type="file" class="form-control" id="banner" name="banner"
                                placeholder="ภาพแบนเนอร์" accept=" image/jpeg, image/png" required="">
                        </div>
                        <fieldset>
                            <legend style="font-size: 20px;">รูปแบบการเรียน/ผู้สอน</legend>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="learn_format">รูปแบบการเรียน </label> <select name="learn_format"
                                            class="form-control" data-toggle="select2" data-placeholder="รูปแบบการเรียน"
                                            data-allow-clear="false">
                                            <option value="0">อิสระ </option>
                                            <option value="1">ตามลำดับ </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="course_en">ผู้สอน</label>
                                        <select id="teacher" name="teacher[]" class="form-control" data-toggle="select2"
                                            data-placeholder="ผู้สอน" data-allow-clear="false" multiple>
                                            <option value="0">เลือกผู้สอน </option>

                                            @foreach ($users4 as $u => $users)
                                                @if ($users->user_role == 3)
                                                    <option value="{{ $users->user_id }}"> {{ $users->firstname }}
                                                        {{ $users->lastname }} </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend style="font-size: 20px;">รูปแบบเกณฑ์</legend>

                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="">การประเมินผล </label>
                                        <select name="evaluation" class="form-control" data-toggle="select2"
                                            data-placeholder="การประเมินผล" data-allow-clear="false">
                                            <option value="1"> เกณฑ์คะแนน </option>
                                            <option value="2"> เกณฑ์เวลาเรียน </option>
                                            <option value="3"> เกณฑ์คะแนนและเวลาเรียน </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="checkscore">เกณฑ์การประเมินผล</label>
                                        <select id="checkscore" name="checkscore" class="form-control  "
                                            data-toggle="select2" data-placeholder="เกณฑ์การประเมินผล"
                                            data-allow-clear="false">
                                            <option value="0"> กำหนดเกณฑ์การประเมินผล</option>
                                            @for ($score = 1; $score <= 100; $score++)
                                                @if ($score == 70)
                                                    <option value="{{ $score }}" selected>{{ $score }}
                                                    </option>
                                                @else
                                                    <option value="{{ $score }}">{{ $score }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                        </select>
                                    </div>
                                </div>


                        </fieldset>
                        <fieldset>
                            <legend style="font-size: 20px;">รูปแบบตารางการกำหนดะแนน</legend>

                            <table id="datatable" class="table  table-striped no-footer"
                                aria-describedby="datatable_info">
                                <thead>
                                    <tr class="bg-infohead" user_role="row">
                                        <th class="text-center" style="width:15%">-</th>
                                        <th class="align-middle" style="width:10%">บทเรียน</th>
                                        <th class="align-middle" style="width:10%">แบบฝึกหัด</th>
                                        <th class="align-middle" style="width:10%">แบบทดสอบ</th>
                                        <th class="align-middle" style="width:10%">การเข้าใช้งาน</th>
                                        <th class="align-middle" style="width:10%">ส่งงาน</th>
                                        <th class="align-middle" style="width:10%">จิตพิสัย</th>
                                        <th class="text-center" style="width:15%">รวมทั้งสิ้น</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">เกณฑ์</td>
                                        <td class="text-center">
                                            <input type="text" id="input1" class="form-control"
                                                style="width: 100px;" placeholder="บทเรียน" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" id="input2" class="form-control"
                                                style="width: 100px;" placeholder="บทเรียน" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" id="input3" class="form-control"
                                                style="width: 100px;" placeholder="แบบทดสอบ" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" id="input4" class="form-control"
                                                style="width: 100px;" placeholder="การเข้าใช้งาน" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" id="input5" class="form-control"
                                                style="width: 100px;" placeholder="ส่งงาน" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td class="text-center">
                                            <input type="text" id="input6" class="form-control"
                                                style="width: 100px;" placeholder="จิตพิสัย" aria-label=""
                                                pattern="[0-9]*"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateTotal()">
                                        </td>
                                        <td id="total" class="text-center">
                                            0 คะแนน
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="9" style="text-align:center; color:red;"> กรุณาใส่ช่องคะแนนให้เต็ม
                                            100 คะแนน</td>
                                    </tr>
                                </tbody>
                            </table>

                            <script>
                                function updateTotal() {
                                    var input1 = parseInt(document.getElementById('input1').value) || 0;
                                    var input2 = parseInt(document.getElementById('input2').value) || 0;
                                    var input3 = parseInt(document.getElementById('input3').value) || 0;
                                    var input4 = parseInt(document.getElementById('input4').value) || 0;
                                    var input5 = parseInt(document.getElementById('input5').value) || 0;
                                    var input6 = parseInt(document.getElementById('input6').value) || 0;
                                    var total = input1 + input2 + input3 + input4 + input5 + input6;

                                    if (total > 100) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'กรุณากรอกคะแนนใหม่...',
                                            text: 'คะแนนเกินที่กำหนด ห้ามเกิน 100 คะแนน',
                                        });
                                        document.getElementById('input1').value = '';
                                        document.getElementById('input2').value = '';
                                        document.getElementById('input3').value = '';
                                        document.getElementById('input4').value = '';
                                        document.getElementById('input5').value = '';
                                        document.getElementById('input6').value = '';

                                        return;
                                    }
                                    document.getElementById('total').textContent = total + ' คะแนน';
                                }
                            </script>
                        </fieldset>

                        <br>
                        <div class="form-group">
                            <label for="subject_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="subject_status" id="subject_status"
                                    value="1"> <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>
                    </div>
            </div>

        </div>
        <div class="form-actions ">
            <button class="btn btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i> บันทึก</button>
        </div>
        </form>
    </div>
    </div>
@endsection
