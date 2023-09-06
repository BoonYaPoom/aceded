@extends('page.report.index')
@section('reports')
    @php
        $chartData = [];
        $chartDataRe = [];
        $chartDataAll = [];
        $dateAll = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        
        foreach ($perType as $per) {
            $uniqueUserIds = [];
            $personType = $per->person_type;
            $totalCount = 0;
            $totalCountRE = 0;
            $totalCountAll = 0;
        
            foreach ($learners as $l => $lrean) {
                $dataLearn = $lrean->registerdate;
                $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
        
                $year = \Carbon\Carbon::parse($dataLearn)->year + 543;
                $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $lrean->registerdate)->format('d/m/Y H:i:s');
        
                if (!in_array($lrean->uid, $uniqueUserIds)) {
                    array_push($uniqueUserIds, $lrean->uid);
                    if ($lrean->congratulation == 1) {
                        $count = \App\Models\Users::where('uid', $lrean->uid)
                            ->where('user_type', $personType)
                            ->count();
        
                        $totalCount += $count;
                    }
                    if ($lrean->registerdate) {
                        $countregis = \App\Models\Users::where('uid', $lrean->uid)
                            ->where('user_type', $personType)
                            ->count();
        
                        $totalCountRE += $countregis;
                    }
                }
            }
            $chartData[] = [
                'choice' => $per->person,
                'count' => $totalCount,
            ];
            $chartDataRe[] = [
                'choice' => $per->person,
                'count' => $totalCountRE,
            ];
        }
        
    @endphp

    <form method="post" id="formreport">
        <div class="form-row">
            <!-- form column -->
            <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
            <div class="col-md-3">
                <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                        <option value="">  </option>

                    </select></div>
            </div>
            <div class="col-md-3 ">
                <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control " data-toggle="select2"
                        data-placeholder="เดือน" data-allow-clear="false" onchange="$('#formreport').submit();">
                        <option value="0">เดือน</option>
                        <option value="10"> ตุลาคม </option>
                        <option value="11"> พฤศจิกายน </option>
                        <option value="12"> ธันวาคม </option>
                        <option value="1"> มกราคม </option>
                        <option value="2"> กุมภาพันธ์ </option>
                        <option value="3"> มีนาคม </option>
                        <option value="4"> เมษายน </option>
                        <option value="5"> พฤษภาคม </option>
                        <option value="6"> มิถุนายน </option>
                        <option value="7"> กรกฎาคม </option>
                        <option value="8"> สิงหาคม </option>
                        <option value="9"> กันยายน </option>
                    </select></div>
            </div>
            <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                    data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
            <!-- /form column -->

        </div><!-- /form row -->
    </form>

    <!-- .table-responsive -->
    <!-- .section-block -->
    <div class="section-block">
        <!-- metric row -->
        @include('page.report.item.itemA.rolecount')
        <!-- grid row -->
        <div class="row">
            <!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="chartregister" style="min-width: 310px; height: 330px; margin: 0 auto">
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="chartcongratulation" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-12">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="chartyearregister" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- /grid row -->
    </div><!-- /.section-block -->


    @include('page.report.item.itemA.graphA')
@endsection
