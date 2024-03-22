@extends('layouts.department.item.data.report2.index')
@section('reports22')
    @include('layouts.department.item.data.report2.count.rolecount')
    <div class="form-row">

        <!-- form column -->
        <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
        <div class="col-md-3">
                 @php
                use Carbon\Carbon;
            @endphp
            <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                    data-placeholder="ปี" data-allow-clear="false">
                    @for ($i = Carbon::now()->year + 543 - 2; $i <= Carbon::now()->year + 543 + 2; $i++)
                        <option value="{{ $i }}" {{ $i == Carbon::now()->year + 543 ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor

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
           
            <div class="col-12 col-lg-12 col-xl-6">
               
                <div class="card card-fluid">
                
                    <div class="card-body">
                        <div id="chartregister" style="min-width: 310px; height: 330px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-12 col-lg-12 col-xl-6">
               
                <div class="card card-fluid">
                
                    <div class="card-body">
                        <div id="chartcongratulation" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-12 col-lg-12 col-xl-12">
               
                <div class="card card-fluid">
                
                    <div class="card-body">
                        <div id="chartyearregister" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div>
                </div>
            </div>
                <div class="col-12 col-lg-12 col-xl-12">
               
                <div class="card card-fluid">
                
                    <div class="card-body">
                        <div id="chartyearregister2" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /grid row -->
    </div><!-- /.section-block -->
    @include('layouts.department.item.data.report2.graphA')
@endsection
