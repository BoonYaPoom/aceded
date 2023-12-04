
<div class="form-group row">
    <div class="col-sm-4" align="right">
        <label class="control-label fadeIn first"><span class="required">*</span> จังหวัด
        </label>
    </div>
    <div class="col-sm-7" align="left">
        <select class="form-control w-100 fadeIn first" name="provines_code" id="provines_code" required="">
            <option value="" selected disabled>-- เลือกจังหวัด --</option>
            @foreach ($provinces->sortBy('id') as $pro)
                <option value="{{ $pro->code }}">{{ $pro->name_in_thai }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="form-group row">
    <div class="col-sm-4" align="right">
        <label class="control-label fadeIn first"><span class="required">*</span> สถานศึกษา
        </label>
    </div>
    <div class="col-sm-7" align="left">
        <select class="form-control w-100 fadeIn first" name="school_code" id="school_code" required="">
            <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
        </select>
    </div>

</div>
@error('school')
    <div class="col-md-9 mb-3">
        <span class="badge badge-warning">{{ $message }}</span>
    </div>
@enderror
<script>
    document.getElementById('provines_code').addEventListener('change', function() {
        // รหัสจังหวัดที่เลือก
        var selectedProvinceCode = this.value;

        // เลือกรายการ "เลือกสถานศึกษา"
        var schoolSelect = document.getElementById('school_code');

        // ล้างรายการเดิม
        schoolSelect.innerHTML = '<option value="" selected disabled>-- เลือกสถานศึกษา --</option>';

        // เลือกรายการโรงเรียนที่มีรหัสจังหวัดที่ตรงกัน
        @foreach ($school as $schoolItem)
            if ("{{ $schoolItem->provinces_code }}" === selectedProvinceCode) {
                var option = document.createElement('option');
                option.value = "{{ $schoolItem->school_code }}";
                option.textContent = "{{ $schoolItem->school_name }}";
                schoolSelect.appendChild(option);
            }
        @endforeach
    });
</script>