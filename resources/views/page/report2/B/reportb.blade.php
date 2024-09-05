@extends('page.report2.index')
@section('reports2')
    <div class="page-inner">

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

        <div class="row mt-3">
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphTopTenRegis" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegis" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphTopTenRegisHigh" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisHigh" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerHigh" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            @for ($i = 1; $i <= 7; $i++)
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="card card-fluid">
                        <div class="card-body">
                            <div id="graphRegisCerDepart{{ $i }}"
                                style="min-width: 310px; height: 450px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            @endfor
            
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone1" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone2" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone3" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone4" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone5" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone6" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone7" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone8" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xl-6">
                <div class="card card-fluid">
                    <div class="card-body">
                        <div id="graphRegisCerZone9" style="min-width: 310px; height: 450px; margin: 0 auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('page.report2.B.JsgrapB')
    </div><!-- /.page-inner -->
@endsection
