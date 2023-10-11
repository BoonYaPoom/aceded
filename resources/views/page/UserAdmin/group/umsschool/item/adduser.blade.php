<table id="datatable2" class="table w3-hoverable">

    <!-- thead -->
    <thead>
        <tr class="bg-infohead">
            <th width="5%">เลือก <input type="checkbox" name="checkall" id="checkall" value="1">
            </th>
            <th width="20%">รหัสผู้ใช้ </th>
            <th>ชื่อ สกุล</th>
            <th>ระดับ</th>
            <th>กลุ่มผู้ใช้งาน</th>
            
        </tr>
    </thead>
    <!-- /thead -->
    <!-- tbody -->
    <tbody>

        <!-- tr -->
        @php
            $userSchoolIds = [];
            foreach ($userschool as $school) {
                $userSchoolIds[] = $school->user_id;
            }
        @endphp
        @foreach ($users as $user)
            @php
                $departuser = \App\Models\Department::find($user->department_id);
            @endphp
            @if (in_array($user->user_id, $userSchoolIds))
            @else
                <tr>
                    <td width="5%">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="user_data[]"
                                id="user_data{{ $user->user_id }}" value="{{ $user->user_id }}">
                            <label class="custom-control-label" for="user_data{{ $user->user_id }}"></label>

                        </div>
                    </td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td>
                        @if ($departuser)
                            {{ $departuser->name_th }}
                        @else
                        @endif

                    </td>
                    <td> ยังไม่มีโรงเรียน </td>

                </tr>
            @endif
        @endforeach
    </tbody><!-- /tbody -->
    <tr>

        <td colspan="4" class="text-center"><button class="btn btn-primary" type="submit" id="Userselectdata"><i
                    class="fas fa-user-plus"></i>
                เพิ่มเข้ากลุ่มผู้ใช้งาน</button></td>
    </tr>
</table><!-- /.table -->
