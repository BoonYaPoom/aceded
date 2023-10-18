@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <form action="{{ route('updatecour', [$depart,'group_id' => $courses->group_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="page-inner">
            <div class="page-section">
                <div class="card card-fluid">
                    <div class="card-header bg-muted"><a href="{{ route('courgroup',['department_id' =>$courses->department_id]) }}"
                            style="text-decoration: underline;">หมวดหมู่</a> / แก้ไขหมวดหมู่ / {{ $courses->group_th }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="group_th">หมวดหมู่ (ไทย)
                            </label>
                            <input type="text" class="form-control" name="group_th" placeholder="หมวดหมู่ (ไทย)"
                                required="" value="{{ $courses->group_th }}">
                        </div>
                        @error('group_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="group_en">หมวดหมู่ (อังกฤษ) </label>
                            <input type="text" class="form-control" name="group_en" placeholder="หมวดหมู่ (อังกฤษ)"
                                value="{{ $courses->group_en }}">
                        </div>

                        <div class="form-group d-none">
                            <label class="control-label" for="department_id">หน่วยงาน</label>
                            <select id="department_id" name="department_id" class="form-control" data-toggle="select2"
                                data-placeholder="กระทรวง กรม/สำนัก" data-allow-clear="false">
                                <option value="12"> สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="group_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="group_status" value="1">
                                <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div>
            </div>
        </div>
    </form>
@endsection
