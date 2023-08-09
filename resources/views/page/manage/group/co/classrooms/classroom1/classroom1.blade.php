<div class="card-body">
    <form method="post" id="formclassroom">
        <div class="form-row">
            <label for="selectyear text-center" class="col-md-4 w3-hide-small ">&nbsp;</label>
            <div class="col-md-4">
                <p>
                    <select id="selectyear" name="selectyear" class="form-control " data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false" onchange="$('#formclassroom').submit();">
                        <option value="2022"> 2022 </option>
                        <option value="2023" selected> 2023 </option>
                    </select>
                </p>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table id="datatable2" class="table w3-hoverable">
            <thead>
                <tr class="bg-infohead">
                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                    <th class="align-middle" style="width:30%"> รุ่น/กลุ่มเรียน </th>
                    <th class="align-middle" style="width:10%"> จำนวนผู้เรียน </th>
                    <th class="align-middle" style="width:15%"> วันที่อบรม </th>
                    <th class="align-middle" style="width:15%"> วันที่รับสมัคร </th>
                    <th class="align-middle" style="width:5%"> สถานะ </th>
                    <th class="align-middle" style="width:20%"> กระทำ </th>
                </tr>
            </thead>
            <tbody>
                @php

                $c = 1;
                @endphp
                @foreach ($class as $item)
                @php

                $startdate = Illuminate\Support\Carbon::parse($item->startdate);
                $enddate = Illuminate\Support\Carbon::parse($item->enddate);
                $startregisterdate = Illuminate\Support\Carbon::parse($item->startregisterdate);
                $endregisterdate = Illuminate\Support\Carbon::parse($item->endregisterdate);
                @endphp
                
                    <tr>
                        <td><a>{{ $c++ }}</a></td>
                        <td><a>{{ $item->class_name }}</a></td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $startdate->format('d/m/Y H:i') }} - <br>
                            {{ $enddate->format('d/m/Y H:i') }}</td>
                            <td> @if($item->startregisterdate && $item->endregisterdate === null)

                            @elseif($item->startregisterdate && $item->endregisterdate )
                            {{ $startregisterdate->format('d/m/Y H:i') }} - <br>
                                {{ $endregisterdate->format('d/m/Y H:i') }}
                            @endif()
                        </td>

                        <td class="align-middle">
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input switcher-edit" checked value="1"
                                    id="4cf76b3dc0951b6a5a3d6fd9b9903f20__course_class__class_status__class_id__0__1691467017">
                                <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span></label>
                        </td>
                        <td>
                            <a href="http://tcct.localhost:8080/admin/lms/payment/0.html"><i
                                    class="fas fa-money-bill fa-lg text-primary" data-toggle="tooltip"
                                    title="รายชื่อรอชำระเงิน"></i></a>
                            <a href="{{ route('register_page', ['class_id' => $item->class_id]) }}"><i
                                    class="fas fa-user-plus fa-lg text-dark" data-toggle="tooltip"
                                    title="รายชื่อลงทะเบียน"></i></a>

                            <a href="http://tcct.localhost:8080/admin/lms/congratuation/0.html"><i
                                    class="fas fa-book-reader fa-lg text-info" data-toggle="tooltip"
                                    title="แจ้งเตือนวันสิ้นสุดบทเรียน"></i></a>
                            <a href="http://tcct.localhost:8080/admin/lms/report/0.html"><i
                                    class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                    title="รายงาน"></i></a>
                            <a href="http://tcct.localhost:8080/admin/lms/congratuation/0.html"><i
                                    class="fas fa-user-graduate fa-lg text-info" data-toggle="tooltip"
                                    title="ผู้สำเร็จหลักสูตร"></i></a>
                            <a href="http://tcct.localhost:8080/admin/lms/classroomform/0.html"><i
                                    class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                            <a href="#clientDeleteModal"
                                id="4cf76b3dc0951b6a5a3d6fd9b9903f20__course_class__class_status__class_id__0__1691467017"
                                rel="ไม่มีกลุ่มเรียน" class="switcher-delete" data-toggle="tooltip" title="ลบ"><i
                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                        </td>
                    </tr>
                @endforeach

          
            </tbody>
        </table>
    </div>
</div>
