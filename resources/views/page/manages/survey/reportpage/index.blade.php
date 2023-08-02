@extends('layouts.adminhome')
@section('content')
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/highcharts.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/export-data.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/accessibility.js') }}"></script>

    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('surveypage') }}"
                        style="text-decoration: underline;">แบบสำรวจ</a> / <i>
                        {{ $sur->survey_th }}</i></div>
                <!-- /.card-header -->

                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <div class="form-actions mb-2">
                            <a class="btn btn-lg btn-success ml-auto mr-4 text-white" href=""><i
                                    class="fa fa-file"></i>
                                Exoprt CSV</a>
                        </div>
                        <table class="table " border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle"> คำถาม </th>
                                    <th class="align-middle" style="width:40%"> ประเภท </th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @foreach ($surques as $q => $item)
                                    <!-- tr -->
                                    @php
                                        $rowNumber = $q + 1;
                                    @endphp
                                    <!-- question_type == 1 -->
                                    @if ($item->question_type == 1)
                                        @include('page.manages.survey.reportpage.Highcharts.questionChart01')
                                    @endif

                                    @if ($item->question_type == 2)
                                        <!-- question_type == 2 -->
                                        @include('page.manages.survey.reportpage.Highcharts.questionChart02')
                                    @endif

                                    @if ($item->question_type == 3)
                                        <!-- question_type == 3 -->
                                        @include('page.manages.survey.reportpage.Highcharts.questionChart03')
                                    @endif
                                @endforeach

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" name="__id" />
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('questionpagecreate', ['survey_id' => $sur]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
