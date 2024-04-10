@extends('page.report2.index')
@section('reports2')
    @include('page.report.item.itemA.rolecount')
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
        <!-- form column -->
        <div class="col-md-1"><span class="mt-1 ">จังหวัด</span></div>
        <div class="col-md-3">
            <div class=""><select id="provin" name="provin" class="form-control" data-toggle="select2"
                    data-placeholder="ปี" data-allow-clear="false">
                    <option value="0">รวมทั้งหมด </option>
                    @foreach ($provin as $pro)
                        <option value="{{ $pro->name_in_thai }}"> {{ $pro->name_in_thai }} </option>
                    @endforeach
                </select>
            </div>
        </div>


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
            <div class="col-12 col-lg-12 col-xl-12">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="chartyearregister2" style="min-width: 310px; height: 330px; margin: 0 auto">

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /grid column -->
        </div><!-- /grid row -->
    </div><!-- /.section-block -->

    @include('page.report2.A.graphA')
@endsection
