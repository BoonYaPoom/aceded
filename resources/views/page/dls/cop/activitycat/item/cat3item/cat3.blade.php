<tr>
    <td><a href="#">{{ $i }}</a></td>
    <td>{{ $a->title }}</td>
    <td class="align-middle" width="10%"> <label
        class="switcher-control switcher-control-success switcher-control-lg">
        <input type="checkbox" class="switcher-input switcher-edit"
            {{ $a->activity_status == 1 ? 'checked' : '' }}
            data-activity-id="{{ $a->activity_id }}">
        <span class="switcher-indicator"></span>
        <span class="switcher-label-on">ON</span>
        <span class="switcher-label-off text-red">OFF</span>
    </label></td>
    <td class="align-middle">
        <a class="d-none" href="" target=_blank><i class="fa fa-eye fa-lg text-success" data-toggle="tooltip"
                title="ข้อมูล"></i></a>
        <a class="" href="{{ route('activiListform1_edit', [$depart,'activity_id' => $a]) }}">
            <i class="fa fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>

        <a href="#clientDeleteModal" rel="" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i
                class="fas fa-trash-alt fa-lg text-warning "></i></a>
    </td>
</tr><!-- /tr --><!-- tr -->
