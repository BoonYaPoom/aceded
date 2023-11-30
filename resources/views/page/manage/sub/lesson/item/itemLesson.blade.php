<tr class="rows_{{ $item->lesson_id_ref }}">
    <td>
        {{ $item->lesson_number }}
    </td>
    <td style="padding-left:0px"><i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
            id="icon1_{{ $item->lesson_id }}" onclick="togglerows({{ $item->lesson_id }});"></i></i>
        {{ $item->lesson_th }}

    </td>
    <td class="w3-hide-small" style="padding-left:0px"><i class="fa fas fa-minus-circle text-success pointer"
            style="cursor:pointer" id="icon2_{{ $item->lesson_id }}"
            onclick="togglerows({{ $item->lesson_id }});"></i></i>
        {{ $item->lesson_en }}

    </td>


    <td>

        @if ($contentType)
            @if ($uploadSuccess)
                @if ($item->content_path)
                    <i style="cursor:pointer;" class="{{ $contentType->icon }} fa-lg text-success switcher-upload"
                        data-toggle="modal" data-target="#clientUploadModal-{{ $item->lesson_id }}" title="">
                        <span class="d-none"></span>
                    </i>
                @else
                    <i style="cursor:pointer;" class="{{ $contentType->icon }} fa-lg" data-toggle="modal"
                        data-target="#clientUploadModal-{{ $item->lesson_id }}" title="">
                        <span class="d-none"></span>
                    </i>
                @endif
            @else
                <i style="cursor:pointer;" class="{{ $contentType->icon }} fa-lg" data-toggle="modal"
                    data-target="#clientUploadModal-{{ $item->lesson_id }}" title="">
                    <span class="d-none"></span>
                </i>
            @endif
        @endif
    </td>

    <td class="align-middle"> <label class="switcher-control switcher-control-success switcher-control-lg">
            <input type="checkbox" class="switcher-input switcher-edit"
                {{ $item->lesson_status == 1 ? 'checked' : '' }} data-lesson-id="{{ $item->lesson_id }}">
            <span class="switcher-indicator"></span>
            <span class="switcher-label-on" data-on="ON">เปิด</span>
            <span class="switcher-label-off text-red" data-off="OFF">ปิด</span>
        </label>
    </td>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.switcher-input.switcher-edit', function() {
                var lesson_status = $(this).prop('checked') ? 1 : 0;
                var lesson_id = $(this).data('lesson-id');
                console.log('lesson_status:', lesson_status);
                console.log('lesson_id:', lesson_id);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('changeStatusLesson') }}',
                    data: {
                        'lesson_status': lesson_status,
                        'lesson_id': lesson_id
                    },
                    success: function(data) {
                        console.log(data.message); // แสดงข้อความที่ส่งกลับ
                    },
                    error: function(xhr, status, error) {
                        console.log('ข้อผิดพลาด');
                    }
                });
            });
        });
    </script>

<!--  
    <td>
        {{ $totalMinutes }} : {{ $totalMin }}
    </td>
-->


    <td class="align-middle">
        <a href="{{ route('smallcreate', [$depart,'subject_id' => $subs, 'lesson_id' => $item]) }}
        "
            data-toggle="tooltip" title="เพิ่มย่อย"><i class="fas fa-plus-circle fa-lg text-danger mr-1"></i></a>
        <a href="{{ route('edit_lessonform', [$depart,$subs,'lesson_id' => $item]) }}" data-toggle="tooltip" title="แก้ไข"><i
                class="far fa-edit fa-lg text-success mr-1"></i>
        </a>
        <a href="{{ route('Supply_lessonform', [$depart,'subject_id' => $subs, 'lesson_id' => $item]) }}" data-toggle="tooltip"
            title="สื่อเสริม"><i class="fas fa-file-video fa-lg text-success mr-1"></i>
        </a>

        <a href="{{ route('destroy_lessonform', [$depart,'lesson_id' => $item]) }}" onclick="deleteRecord(event)"
            class="switcher-delete" data-toggle="tooltip" title="ลบ"><i
                class="fas fa-trash-alt fa-lg text-warning "></i></a>
    </td>

</tr>
