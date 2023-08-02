@extends('layouts.adminhome')
@section('content')

@if (Session::has('message'))
<script>
  toastr.options ={
      "progressBar" : true,
      "positionClass" : 'toast-top-full-width',
      "extendedTimeOut " : 0,
      "timeOut" : 3000,
      "fadeOut" : 250,
      "fadeIn" : 250,
      "positionClass" : 'toast-top-right',
      

  } 
    toastr.success("{{ Session::get('message')}}");

</script>
@endif
<div class="page-inner">
    <!-- .page-title-bar -->

      <!-- .page-section -->
      <div class="page-section">
        <!-- .card -->
        <div class="card card-fluid">
          <!-- .card-header -->
          <div class="card-header bg-muted"><a href="{{route('manage')}}" style="text-decoration: underline;">จัดการเว็บ </a>  / <i>		ข้อมูลพื้นฐาน</i></div>
          <!-- .card-body -->
          <div class="card-body">
            
            <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table id="datatable2" class="table w3-hoverable" >
                <!-- thead -->
                <thead>
                  <tr class="bg-infohead">
                    <th width="10%">ลำดับ</th>
                    <th>รายการ</th>
                    <th width="10%">กระทำ</th>
                  </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody><!-- tr -->
          
                      <tr>
                        <td><a>1</a></td>
                        <td><a >โลโก้</a></td>
                        <td><a href="{{route('logo')}}" ><i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i></a></td>
                      </tr><!-- /tr --><!-- tr -->
                      <tr>
                        <td><a>2</a></td>
                        <td><a >ภาพประชาสัมพันธ์</a></td>
                        <td><a href="{{route('hightpage')}}" ><i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i></a></td>
                      </tr><!-- /tr -->
                </tbody><!-- /tbody -->
              </table><!-- /.table -->
            </div><!-- /.table-responsive -->

          </div><!-- /.card-body -->
        </div><!-- /.card -->



      </div><!-- /.page-section -->

     <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection