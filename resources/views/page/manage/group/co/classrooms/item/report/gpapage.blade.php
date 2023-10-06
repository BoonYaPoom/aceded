@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',


            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif
    <!-- Include axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Include XLSX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.3/xlsx.full.min.js"></script>


    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('learn', ['department_id' => $depart->department_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href="{{ route('learn', ['department_id' => $courses->first()->department_id]) }}"
                        style="text-decoration: underline;">จัดการวิชา</a> / <i></i></div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info"
                            href="{{ route('class_page', ['course_id' => $cour->course_id]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">
                    <div class="dt-buttons btn-group"><button id="exportButton"
                            class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable"
                            type="button"><span>Excel</span></button> </div>
                    <!-- .table-responsive -->
                    <script>
                        document.getElementById('exportButton').addEventListener('click', function() {
                            // Get selected column names
                            const selectedColumns = Array.from(document.querySelectorAll('.export-checkbox:checked')).map(
                                checkbox => checkbox.getAttribute('data-column'));

                            // Create a new table with selected columns
                            const table = document.createElement('table');
                            const thead = document.createElement('thead');
                            const tbody = document.createElement('tbody');

                            // Clone the existing table headers
                            const originalHeaders = document.querySelectorAll('thead th[data-column]');
                            originalHeaders.forEach(header => {
                                const columnKey = header.getAttribute('data-column');
                                if (selectedColumns.includes(columnKey)) {
                                    const newHeader = document.createElement('th');
                                    newHeader.textContent = header.textContent;
                                    newHeader.setAttribute('style', header.getAttribute('style'));
                                    thead.appendChild(newHeader);
                                }
                            });

                            // Clone the data rows with selected columns
                            const dataRows = document.querySelectorAll('tbody tr');
                            dataRows.forEach(row => {
                                const newRow = document.createElement('tr');
                                const cells = Array.from(row.querySelectorAll('td[data-column]'));
                                cells.forEach(cell => {
                                    const columnKey = cell.getAttribute('data-column');
                                    if (selectedColumns.includes(columnKey)) {
                                        const newCell = document.createElement('td');
                                        newCell.textContent = cell.textContent;
                                        newCell.setAttribute('style', cell.getAttribute('style'));
                                        newRow.appendChild(newCell);
                                    }
                                });
                                tbody.appendChild(newRow);
                            });

                            table.appendChild(thead);
                            table.appendChild(tbody);

                            // Create a worksheet
                            const tableData = [];
                            const headerRow = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
                            tableData.push(headerRow);

                            const rows = Array.from(table.querySelectorAll('tbody tr'));
                            rows.forEach(row => {
                                const rowData = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
                                tableData.push(rowData);
                            });

                            const ws = XLSX.utils.aoa_to_sheet(tableData);

                            // Create a workbook
                            const wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

                            // Save the workbook as an Excel file
                            XLSX.writeFile(wb, 'exported_data.xlsx');
                        });
                    </script>

                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable" border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%" data-column="ลำดับ"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%" data-column="ชื่อ-สกุล"> ชื่อ-สกุล </th>


                                    <th class="align-middle" style="width:10%" data-column="คะแนนรวม"> คะแนนรวม </th>
                                    <th class="align-middle" style="width:10%" data-column="ผลการสอบ"> GPA </th>

                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->

                            <tbody>
                                <!-- tr -->
                                @php
                                    $n = 1;
                                    $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                                    $uniqueUserIds = [];
                                    $countUsersLogs = null;
                                    $totalDuration = null;
                                    $ScoreUser = null;
                                    
                                @endphp
                                @foreach ($learners as $l => $learns)
                                    @php
                                        $dataLearn = $learns->registerdate;
                                        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                        $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                        $users = \App\Models\Users::find($learns->user_id);
                                        
                                    @endphp
                                    @if ($users !== null)
                                    @if ($monthsa == $m)
                                            @if (!in_array($learns->user_id, $uniqueUserIds))
                                                @php
                                                    array_push($uniqueUserIds, $learns->user_id);
                                                    
                                                    $ScoreLog = \App\Models\Score::where('user_id', $learns->user_id)
                                                        ->whereHas('examlog', function ($query) {
                                                            $query->where('exam_type', 2);
                                                        })->orderBy('score', 'desc')
                                                        ->get();
                                                   
                                                    foreach ($ScoreLog as $score) {
                                                        $scoreDateMonth = \ltrim(\Carbon\Carbon::parse($score->score_date)->format('m'), '0');
                                                        $scorefull = $score->fullscore;
                                                        $scorehef = $score->score;
                                                  
                                                        
                                                            if ($scorefull > 0) {
                                                                $percentage = ($scorehef / $scorefull) * 100;
                                                            } 
                                                        }
                                                    
                                                @endphp
                                                @if ($scoreDateMonth == $m) 
                                                <tr>
                                                    <td>{{ $n++ }}</td>

                                                    <td>{{ $users->firstname }} {{ $users->lastname }}</td>
                                                    <td>
                                                        @if ($score->score !== null)
                                                            {{ number_format($percentage, 2) }}
                                                        @elseif ($score->fullscore == null)
                                                            รอลงคะแนน
                                                        @else
                                                            ลงคะแนน
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($percentage >= 80)
                                                            A
                                                        @elseif ($percentage >= 70 && $percentage < 79)
                                                            B
                                                        @elseif ($percentage >= 60 && $percentage < 69)
                                                            C
                                                        @elseif ($percentage >= 50 && $percentage < 59)
                                                            D
                                                        @elseif ($percentage < 49)
                                                            F
                                                        @else
                                                            ลงคะแนน
                                                        @endif


                                                    </td>
                                                </tr><!-- /tr -->
                                            @elseif ($users == null)
                                            @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!--
                                                                                                                <header class="page-title-bar">
                                                                                                                  
                                                                                                                    <input type="hidden" />
                                                                                                                    <button type="button" onclick="window.location=''" class="btn btn-success btn-floated btn-add "
                                                                                                                        id="registeradd" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
                                                                                                                    
                                                                                                                </header> -->
    </div><!-- /.page-inner -->
@endsection
