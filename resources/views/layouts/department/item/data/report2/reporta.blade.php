@extends('layouts.department.item.data.report2.index')
@section('reports22')
    @include('layouts.department.item.data.report2.count.rolecount')
    <div class="form-row">

        <!-- form column -->
        <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
        <div class="col-md-3">
            <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                    data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                    <option value="2566"> 2566 </option>
                    <option value="2567" selected> 2567 </option>
                    <option value="2568"> 2568 </option>
                 
                </select>
            </div>
        </div>

        <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
        <!-- /form column -->

    </div><!-- /form row -->

    <!-- .table-responsive -->
    <!-- .section-block -->
    <div class="section-block">
        <!-- metric row -->

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

    @include('page.report2.graphA')
@endsection
