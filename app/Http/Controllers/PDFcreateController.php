<?php

namespace App\Http\Controllers;

use App\Models\CourseLearner;
use App\Models\PersonType;
use App\Models\Users;
use Barryvdh\DomPDF\Facade\Pdf;

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
class PDFcreateController extends Controller
{


    public function generatePdf()
    {
        $html =

            '    
            <style>
            table {
                border-collapse: collapse;
                border: 1px solid black;
            }
        
            table th, table td {
                border: 1px solid black;
                padding: 5px;
            }
        </style>
        <table border="1" style="width:100%" id="section-to-print">
     
        <thead>
            <tr>
                <th class="text-center" colspan="6">รายงานเชิงตาราง ปี 2566</th>
            </tr>
            <tr class="text-center">
                <th align="center" width="10%">ลำดับ</th>
                <th align="center" width="80%">ชื่อรายงาน</th>
                <th align="center" width="10%">รายงาน</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td>รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</td>
                <td align="center"><a href=""><i
                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

            </tr>
            <tr>
                <td align="center">2</td>
                <td>รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด</td>
                <td align="center"><a href=""><i
                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

            </tr>

            <tr>
                <td align="center">3</td>
                <td>รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</td>
                <td align="center"><a href=""><i
                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

            </tr>
            <tr>
                <td align="center">4</td>
                <td>รายงานการ Login ของผู้เรียน</td>
                <td align="center"><a href=""><i
                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

            </tr>
         
            <tr>
                <td align="center">5</td>
                <td>ข้อมูล Log File ในรูปแบบรายงานทางสถิติ</td>
                <td align="center"><a
                        href=""><i
                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

            </tr>
            </tbody>
    </table><!-- /.table -->';
    

    $pdf = new Mpdf([
        'fontdata' => [
            'regular' => [
                'R' => 'THSarabun.ttf',
                
            ],
            'bold' => [
                'B' => 'THSarabun Bold.ttf',
            ],
        ],
        
        'mode' => 'th',
        'format' => 'A4',
        'default_font' => 'regular',
    ]);
    
    


        $pdf->WriteHTML($html);

        $pdf->Output('รายงาน.pdf', Destination::DOWNLOAD);


    }
    public function generatePdfT0101()
    {
        $userper = Users::all();
        $jsonContent = file_get_contents('javascript/json/_data.json');
        $mms = json_decode($jsonContent, true);
        $monthdata = $mms['month'];
        $month = $monthdata['th'];
        $perType = PersonType::all();
   
        $learners =  CourseLearner::all();
        $n = 1;
        $result = []; // สร้างตัวแปรเก็บผลลัพธ์
        $uniqueUserIds = [];
        $users = null;
        
        $html = view('page.report.tables.pdf.pdft0101', compact( 'month', 'learners', 'perType', 'userper'))->render();

    
        $pdf = new Mpdf([
                'fontdata' => [
                    'regular' => [
                        'R' => 'THSarabun.ttf',
                        
                    ],
                    'bold' => [
                        'B' => 'THSarabun Bold.ttf',
                    ],
                ],
                
                'mode' => 'th',
                'format' => 'A4',
                'default_font' => 'regular',
            ]);
            
            
        
        
                $pdf->WriteHTML($html);
    

        return $pdf->Output('report.pdf', Destination::FILE);


    }
}
