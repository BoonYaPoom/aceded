<form method="POST"
action="{{ route('updateusertype', ['person_type' => $pertype->person_type]) }}">
@csrf
@method('PUT')
<!-- tr -->


@foreach ($usersnulls as $user)
    <tr>
        <td width="5%">

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="user_data[]"
                    id="user_data{{ $user->uid }}" value="{{ $user->uid }}">
                <label class="custom-control-label"
                    for="user_data{{ $user->uid }}"></label>

            </div>
        </td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->firstname }} </td>
        <td> </td>

    </tr>
@endforeach

<!-- tr -->
<tr>

    <td colspan="5" class="text-center"><button class="btn btn-primary"
            type="submit" id="Userselectdata"><i class="fas fa-user-plus"></i>
            เพิ่มเข้ากลุ่มผู้ใช้งาน</button></td>
</tr>

</form>