@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')

<!-- .page-inner -->
<div class="page-inner">
    <!-- .page-section -->
      <div class="page-section">
				<!-- .card -->
          <div class="card card-fluid">
            <!-- .card-header -->
              <div class="card-header bg-muted"><a href="{{ route('departmentLearnpage') }}">หน่วยงาน</a> / จัดการข้อมูลและความรู้</div>
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
                                           <td><a href="{{route('bookpage', ['department_id' => $depart])}}" ><i class="fas fa-folder-plus  fa-lg text-primary"></i>  หนังสืออิเล็กทรอนิกส์</a></td>
                                           <td><a href="{{route('bookpage', ['department_id' => $depart])}}" >
                                                <i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i>
                                               </a>
                                           </td>
                                           </tr><tr>
                                           <td><a>2</a></td>
                                           <td><a href="{{route('blogpage', ['department_id' => $depart])}}" ><i class="fas fa-folder-plus  fa-lg text-primary"></i>คลังความรู้</a></td>
                                           <td><a href="{{route('blogpage', ['department_id' => $depart])}}" >
                                                <i class="fas fa-edit fa-lg text-success" data-toggle="tooltip" title="จัดการ"></i>
                                               </a>
                                           </td>
                                           </tr><tr>
                                           <td><a>3</a></td>
                                           <td><a href="{{route('cop', ['department_id' => $depart])}}" ><i class="fas fa-folder-plus  fa-lg text-primary"></i> ชุมชนนักปฏิบัติ</a></td>
                                           <td><a href="{{route('cop', ['department_id' => $depart])}}" >
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

    </div>


@endsection