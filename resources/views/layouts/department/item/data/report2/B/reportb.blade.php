@extends('layouts.department.item.data.report2.index')
@section('reports22')
    <div class="page-inner">

        <div class="form-row">

            <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
            <div class="col-md-3">
                <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false">
                        <option value="2566"> 2566 </option>
                        <option value="2567" selected> 2567 </option>
                        <option value="2568"> 2568 </option>

                    </select>
                </div>
            </div>

            <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                    data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>


        </div>

        <div class="row mt-3">

            <div class="col-12 col-lg-12 col-xl-6">

                <div class="card card-fluid">
    
                    <div class="card-body">
                        <div id="graphlearner" style="min-width: 310px; height: 450px; margin: 0 auto">



                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-12 col-xl-6">
  
                <div class="card card-fluid">
              
                    <div class="card-body">
                        <div id="courserating" style="min-width: 310px; height: 450px; margin: 0 auto">

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-12 col-xl-6">
             
                <div class="card card-fluid">
         

                    <div class="card-body">
                        <div id="courselogin" style="min-width: 310px; height: 450px; margin: 0 auto">


                        </div>
                    </div>
            </div>



        </div><!-- .page-title-bar -->






        @include('page.report2.B.graphB')
    </div><!-- /.page-inner -->
@endsection
