<div class="form-group">
    <label for="provin" class="col-md-1">จังหวัด </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="provin" id="provin">
        <option value="0" selected disabled>-- เลือกจังหวัด --</option>
        @foreach ($provin as $pro)
            <option value="{{ $pro->id }}">{{ $pro->name_in_thai }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group" id='distri' style="display: none;">
    <label for="distrits" class="col-md-1">อำเภอ </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="distrits" id="distrits">
        <option value="" selected disabled>-- เลือกอำเภอ --</option>
    </select>
</div>

<div class="form-group" id='subdis' style="display: none;">
    <label for="subdistrits" class="col-md-1">ตำบล </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="subdistrits" id="subdistrits">
        <option value="" selected disabled>-- เลือกตำบล --</option>
    </select>
</div>

<div class="form-group" id='sch'>
    <label for="extender_id" class="col-md-1">สังกัด </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="extender_id" id="extender_id">
        <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
        @foreach ($extender1 as $extr1)
            <option value="{{ $extr1->extender_id }}">{{ $extr1->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group" id='sch2' style="display: none;">
    <label for="extender_id2" class="col-md-1">สังกัดย่อย </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="extender_id2" id="extender_id2">
        <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
    </select>
</div>
<div class="form-group" id='sch3' style="display: none;">
    <label for="extender_id3" class="col-md-1">สังกัดย่อย </label>
    <span class="badge badge-warning">Required</span></label>
    <select class="form-control " name="extender_id3" id="extender_id3">
        <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
    </select>
</div>
