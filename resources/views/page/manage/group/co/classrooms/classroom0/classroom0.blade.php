<div class="card-body">
    <form method="post" id="formclassroom">
        <div class="form-row">
            <label for="selectyear text-center" class="col-md-4 w3-hide-small ">&nbsp;</label>
          <!--  <div class="col-md-4">
                <p>
                    <select id="selectyear" name="selectyear" class="form-control " data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false" onchange="$('#formclassroom').submit();">
                        <option value="2022"> 2022 </option>
                        <option value="2023" selected> 2023 </option>
                    </select>
                </p>
            </div> -->
        </div>
    </form>
    <div class="table-responsive">
        <table id="datatable2" class="table w3-hoverable">
            <!-- thead -->
            <thead>
                <tr class="bg-infohead">
                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                    <th class="align-middle" style="width:70%"> เดือน </th>
                    <th class="align-middle" style="width:10%"> จำนวนผู้เรียน </th>
                    <th class="align-middle" style="width:10%"> กระทำ </th>
                </tr>
            </thead><!-- /thead -->
            <!-- tbody -->
            <tbody>
                <!-- tr -->
                @php
                    $n = 0;
          
                    $result = []; // สร้างตัวแปรเก็บผลลัพธ์

                    foreach ($learners as $l => $learn) {
                        $dataLearn = $learn->registerdate;
                        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                        $result[$monthsa]['register'] = isset($result[$monthsa]['register']) ? $result[$monthsa]['register'] + 1 : 1;
                    }
               
                @endphp

                @foreach ($month as $m => $months)
                    @php
                        
                        $register = empty($result[$m]['register']) ? 0 : $result[$m]['register'];
                        $prefix = md5('moc' . date('Ymd'));
                        $idm = $monthsa = $m ;
                    @endphp
                    <tr id="{{ $prefix }}'__course_class__class_status__class_id__''__'{{ $m }}'__row">
                        <td><a>{{ $m }}</a></td>
                        <td><a>{{ $months }}</a></td>
                        <td>
                            <a> {{ $register }}</a>
                        </td>
                        <td>
                         
                      <a href="{{ route('register_page', [ 'm' => $m,'course_id' => $cour]) }}"><i class="fas fa-user-plus fa-lg text-dark"
                                    data-toggle="tooltip" title="รายชื่อลงทะเบียน"></i></a>
                                        <a href="{{ route('gpa_page', [ 'm' => $m,'course_id' => $cour]) }}"><i class="fas fa-file-alt fa-lg text-dark"
                                    data-toggle="tooltip" title="GPA"></i></a>
                 
                            <a href="{{ route('report_page', [ 'm' => $m,'course_id' => $cour]) }}"><i class="fas fa-chart-bar fa-lg text-danger"
                                    data-toggle="tooltip" title="รายงาน"></i></a>
                           
                           
                             <a href="{{ route('congratuation_page', [ 'm' => $m,'course_id' => $cour]) }}"><i
                                    class="fas fa-user-graduate fa-lg text-info" data-toggle="tooltip"
                                    title="ผู้สำเร็จหลักสูตร"></i></a>


                            <!--  -->
                            
                        </td>
                    </tr><!-- /tr -->
                @endforeach


            </tbody><!-- /tbody -->
        </table><!-- /.table -->
    </div>
</div>
