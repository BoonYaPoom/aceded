
        <tr class="rows_{{ $subOrdering->lesson_id }} small " style="display: none;">
            <td>{{ $subOrdering->lesson_number }}</td>

            <td class="w3-hide-small" style="padding-left:{{ $left }}px">
                <i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
                    id="icon2_{{ $subOrdering->lesson_id }}"
                    onclick="togglerows({{ $subOrdering->lesson_id }});"></i>
                {{ $subOrdering->lesson_th }}
            </td>
            <td style="padding-left:{{ $left }}px">
                <i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
                    id="icon2_{{ $subOrdering->lesson_id }}"
                    onclick="togglerows({{ $subOrdering->lesson_id }});"></i>
                {{ $subOrdering->lesson_en }}
            </td>

            <td>
                @if ($contentType)
                    @if ($uploadSuccess)
                        @if ($subOrdering->content_path)
                            <i style="cursor:pointer;"
                                class="{{ $contentType->icon }} fa-lg text-success switcher-upload"
                                data-toggle="modal"
                                data-target="#clientUploadModal-{{ $subOrdering->lesson_id }}"
                                title="">
                                <span class="d-none"></span>
                            </i>
                        @else
                            <i style="cursor:pointer;" class="{{ $contentType->icon }} fa-lg"
                                data-toggle="modal"
                                data-target="#clientUploadModal-{{ $subOrdering->lesson_id }}"
                                title="">
                                <span class="d-none"></span>
                            </i>
                        @endif
                    @else
                        <i style="cursor:pointer;" class="{{ $contentType->icon }} fa-lg"
                            data-toggle="modal"
                            data-target="#clientUploadModal-{{ $subOrdering->lesson_id }}"
                            title="">
                            <span class="d-none"></span>
                        </i>
                    @endif
                @endif
            </td>
            <td class="align-middle" s> <label
                    class="switcher-control switcher-control-success switcher-control-lg">
                    <input type="checkbox" class="switcher-input switcher-edit"
                        {{ $subOrdering->lesson_status == 3 ? 'checked' : '' }}
                        data-lesson-id="{{ $subOrdering->lesson_id }}">
                    <span class="switcher-indicator"></span>
                    <span class="switcher-label-on">ON</span>
                    <span class="switcher-label-off text-red">OFF</span></label>
            </td>
            <td class="align-middle">
                <a href="{{ route('smallsmallcreate', ['subject_id' => $subOrdering, 'lesson_id' => $subOrdering]) }}
"
                    data-toggle="tooltip" title="เพิ่มย่อย"><i
                        class="fas fa-plus-circle fa-lg text-danger mr-1"></i></a>
                <a href="{{ route('edit_lessonform', ['lesson_id' => $subOrdering]) }}"
                    data-toggle="tooltip" title="แก้ไข"><i
                        class="far fa-edit fa-lg text-success mr-1"></i></a><a
                    href="{{ route('destroy_lessonform', ['lesson_id' => $subOrdering]) }}"
                    onclick="deleteRecord(event)" class="switcher-delete"
                    data-toggle="tooltip" title="ลบ"><i
                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
            </td>
        </tr><!-- /tr -->
        
   