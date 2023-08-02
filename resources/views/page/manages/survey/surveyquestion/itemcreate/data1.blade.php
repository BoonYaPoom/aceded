<div id="data1" style="display:none;  display: block;">
    <!-- แสดงข้อมูลที่ 1 -->
    <div class="form-group qtype1 ">
        <label for="opt">เลือกคำตอบได้มากว่า 1 ข้อ </label> <label
            class="switcher-control switcher-control-success switcher-control-lg"><input
                type="checkbox" class="switcher-input" name="opt" id="opt" value="1">
            <span class="switcher-indicator"></span>
            <span class="switcher-label-on">ON</span>
            <span class="switcher-label-off text-red">OFF</span></label>
    </div><!-- /.form-group -->
    <!-- .form-group -->
    <div class="form-group qtype1 ">
        <label class="control-label" for="numchoice">จำนวนตัวเลือก</label>
        <select id="numchoice" name="numchoice" class="form-control" data-toggle="select2"
            data-placeholder="จำนวนตัวเลือก" data-allow-clear="false">
            @for ($i = 1; $i <= 8; $i++)
                <option value="{{ $i }}" {{ $i == 4 ? 'selected' : '' }}>
                    {{ $i }}</option>
            @endfor
        </select>

        @for ($i = 1; $i <= 8; $i++)
            <div class="form-group qtype1" id="showchoice{{ $i }}"
                style="{{ $i > 4 ? 'display:none' : '' }}">
                <label for="choice{{ $i }}">ตัวเลือกที่ {{ $i }}</label>
                <input type="text" class="form-control" id="choice{{ $i }}"
                    name="choice{{ $i }}" placeholder="ตัวเลือกที่ {{ $i }}"
                    value="">
            </div>
        @endfor

        <script>
            $(document).ready(function() {
                $('#numchoice').change(function() {
                    var numchoice = $(this).val();

                    // hide/show choice fields based on selected number of choices
                    for (var i = 1; i <= 8; i++) {
                        if (i <= numchoice) {
                            $('#showchoice' + i).show();
                        } else {
                            $('#showchoice' + i).hide();
                        }
                    }
                });
            });
        </script>
    </div>
    <!-- grid row -->
</div>
