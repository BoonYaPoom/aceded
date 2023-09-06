@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')


<!-- .page-inner -->
<div class="page-inner">
    <!-- .page-section -->
      <div class="page-section">
				<!-- .card -->
          <div class="card card-fluid">
            <!-- .card-header -->
              <div class="card-header bg-muted">กิจกรรม</div>
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
							                    <th width="10%" class="">กระทำ</th>
                                </tr>
                              </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                              <tbody>
                                <tr>
                                           <td><a>1</a></td>
                                           <td><a href="{{route('activi', ['department_id' => $depart])}}" ><i class="fas fa-folder-plus  fa-lg text-primary"></i> ถ่ายทอดสด</a></td>
                                           <td><a href="{{route('activi', ['department_id' => $depart])}}" >
                                                <i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i>
                                               </a>
                                           </td>
                                           </tr><tr>
                                           <td><a>2</a></td>
                                           <td> <a href="{{route('meeti', ['department_id' => $depart])}}" ><i class="fas fa-folder-plus  fa-lg text-primary"></i> ประชุมออนไลน์</a></td>
                                           <td><a href="{{route('meeti', ['department_id' => $depart])}}" >
                                                <i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i>
                                               </a>
                                           </td>
                                           </tr>                              </tbody>
                            <!-- /tbody -->
                          </table>
                        <!-- /.table -->
                      </div>
                    <!-- /.table-responsive -->
                  </div>
                <!-- /.card-body -->
          </div>
        <!-- /.card -->
      </div>
    <!-- /.page-section -->
  </div>
<!-- /.page-inner -->

@endsection