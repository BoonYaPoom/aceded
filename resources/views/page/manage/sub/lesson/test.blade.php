
@foreach ($lessons as $index => $item)
@php
    $lesson_id = $item->lesson_id;
    
    if (empty($level)) {
        $sublesson = '';
    } else {
        $sublesson = 'small';
    }
    $level++;
@endphp


@php
    $left = 0;
@endphp

<!--  Model -->
@if ($item->lesson_id_ref == 0)
<tr class="rows_{{ $item->lesson_id_ref }}">
    <td>
        {{ $item->lesson_number }}
    </td>
    <td style="padding-left:0px"><i class="fa fas fa-minus-circle text-success pointer"
            style="cursor:pointer" id="icon1_{{ $item->lesson_id }}"
            onclick="togglerows({{ $item->lesson_id }});"></i></i>
        {{ $item->lesson_th }}

    </td>
    <td class="w3-hide-small" style="padding-left:0px"><i
            class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
            id="icon2_{{ $item->lesson_id }}"
            onclick="togglerows({{ $item->lesson_id }});"></i></i>
        {{ $item->lesson_en }}

    </td>
</tr>
@endif

<!--  Lessons Small -->
@php
    $left += $level + 30;
@endphp
@foreach ($lessons as $subitem)
    @if ($subitem->lesson_status == 2 && $subitem->lesson_id_ref === $item->lesson_id)
      
    <tr class="rows_{{ $item->lesson_id }} {{$sublesson}}" style="display: none;">
        <td>{{ $item->lesson_id }}</td>

        <td class="w3-hide-small" style="padding-left:{{ $left }}px">
            <i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
                id="icon2_{{ $subitem->lesson_id }}"
                onclick="togglerows({{ $subitem->lesson_id }});"></i>
            {{ $subitem->lesson_th }}
        </td>
        <td style="padding-left:{{ $left }}px">
            <i class="fa fas fa-minus-circle text-success pointer" style="cursor:pointer"
                id="icon2_{{ $subitem->lesson_id }}"
                onclick="togglerows({{ $subitem->lesson_id }});"></i>
            {{ $subitem->lesson_en }}
        </td>

    </tr>
    @endif
@endforeach
@endforeach