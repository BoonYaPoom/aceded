@extends('page.report2.index')
@section('reports2')
    <!-- .page-inner -->

    <div class="page-inner">

        
        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานสถิติการเข้าใช้งานรายเดือน
                        (กลุ่มการศึกษาขั้นพื้นฐาน)</span>

                   <!-- <a
                                href="https://aced.dlex.ai/childhood/admin/export/pdf.html"
                                class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                                href="https://aced.dlex.ai/childhood/admin/export/excel.html"
                                class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>-->&nbsp;<a
                        href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i
                            class="fa fa-print "></i></a>
                </div>
            </div><!-- /.card-header -->
            <!-- .card-body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th class="text-center" colspan="20">รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มการศึกษาขั้นพื้นฐาน)</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="7%">เดือน</th>
                                <th align="center" width="10%">สังกัด
                                </th>
                                <th align="center" width="5%">จำนวนรายการ (คน)
                                </th>
                                <th align="center" width="10%">โรงเรียน

                                </th>
                                <th align="center" width="5%">จำนวนรายการ (คน)
                                </th>
                                <th align="center" width="10%">ระดับ

                                </th>
                                <th align="center" width="5%">จำนวนรายการ (คน)
                                </th>
                                <th align="center" width="10%">จังหวัด

                                </th>
                                <th align="center" width="5%">จำนวนรายการ (คน)
                                </th>
                            </tr>

                        
                            </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
