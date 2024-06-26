@extends('layouts.department.item.data.report2.index')
@section('reports22')
    <div class="page-inner">

        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานเชิงตาราง </span>
                    {{-- <a href="{{ route('generatePdf') }}"
                        class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a> --}}
                    &nbsp;<a href="{{ route('ReportExp') }}" class="btn btn-icon btn-outline-primary"><i
                            class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();"
                        class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">

                        <thead>
                            <tr>
                                <th class="text-center" colspan="6">รายงานเชิงตาราง </th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="10%">ลำดับ</th>
                                <th align="center" width="80%">ชื่อรายงาน</th>
                                <th align="center" width="10%">รายงาน</th>
                            </tr>

                            @if ($data->user_role == 7 || $data->user_role == 9)
                                <tr>
                                    <td align="center">1</td>
                                    <td>รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</td>
                                    <td align="center"><a href="{{ route('P0101DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                                </tr>

                                <tr>
                                    <td align="center">2</td>
                                    <td>รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)
                                    </td>
                                    <td align="center"><a href="{{ route('P0116DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                            @else
                                <tr>
                                    <td align="center">1</td>
                                    <td>รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</td>
                                    <td align="center"><a href="{{ route('T0101DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                                </tr>

                                <tr>
                                    <td align="center">2</td>
                                    <td>รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)
                                    </td>
                                    <td align="center"><a href="{{ route('T0116DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                                {{-- <tr>
                                <td align="center">3</td>
                                <td>รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</td>
                                <td align="center"><a href="{{ route('T0103DP', $depart) }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr> --}}

                                <tr>
                                    <td align="center">3</td>
                                    <td>รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร (ช่วงที่ 1 อายุไม่เกิน 11 ปี / ช่วงที่
                                        2
                                        อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป)
                                    </td>
                                    <td align="center"><a href="{{ route('T0117DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                                <tr>
                                    <td align="center">4</td>
                                    <td>รายงานสถิติการเข้าใช้งานรายเดือน
                                        (ผู้ใช้งานใหม่)
                                    </td>
                                    <td align="center"><a href="{{ route('T0118DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                                <tr>
                                    <td align="center">5</td>
                                    <td>รายงานสถิติการเข้าใช้งานรายไตรมาส
                                        (ผู้ใช้งานใหม่)
                                    </td>
                                    <td align="center"><a href="{{ route('T0119DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                                <tr>
                                    <td align="center">6</td>
                                    <td> รายงานสถิติการเข้าใช้งานรายปี
                                        (ผู้ใช้งานใหม่)
                                    </td>
                                    <td align="center"><a href="{{ route('T0120DP', $depart) }}"><i
                                                class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                                </tr>
                            @endif

                            </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
