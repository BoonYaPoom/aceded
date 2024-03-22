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
            <!-- grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="graphlearner" style="min-width: 310px; height: 450px; margin: 0 auto">



                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->


            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="courserating" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->


            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->

                    <div class="card-body">
                        <div id="courselogin" style="min-width: 310px; height: 450px; margin: 0 auto">


                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->

            {{-- <div class="col-12 col-lg-12 col-xl-6 ">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursemulti" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursesearch" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
            <div class="col-12 col-lg-12 col-xl-6">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="coursedoc" style="min-width: 310px; height: 450px; margin: 0 auto">


                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column --> --}}

        </div><!-- .page-title-bar -->






        @include('page.report2.B.graphB')
    </div><!-- /.page-inner -->
@endsection
