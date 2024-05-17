<?php

namespace App\Exports;



use App\Models\CourseLearner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Extender_AllExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\FromCollection
     */
    use Exportable;
    protected $department_id;


    public function __construct($department_id)
    {
        $this->department_id = $department_id;
    }
    public function collection()
    {

        $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
        $orgs = $data->organization;

        $provins = $data->province_id;

        $query = DB::table('users_extender2');
        if ($data->user_role == 1 || $data->user_role == 8) {
            switch ($this->department_id) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->whereIn('users_extender2.item_lv', [2, 3, 4])
                        ->where('users_extender2.item_group_id', 1)
                        ->select('provinces.*', 'users_extender2.*');
                    break;

                case 5:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('users_extender2.item_group_id', 2)
                        ->select('provinces.*', 'users_extender2.*');
                    break;
                case 6:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->whereIn('users_extender2.item_lv', [3, 4])
                        ->whereIn('users_extender2.item_group_id', [3, 4])
                        ->select('provinces.*', 'users_extender2.*');
                    break;
                default:
                    break;
            }
        } elseif ($data->user_role == 7) {
            switch ($this->department_id) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)
                        ->select('provinces.*', 'users_extender2.*');
                    break;
                case 5:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)->select('provinces.*', 'users_extender2.*');
                    break;
                case 6:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)->select('provinces.*', 'users_extender2.*');
                    break;
                default:
                    break;
            }
        } elseif ($data->user_role == 6 || $data->user_role == 3) {
            switch ($this->department_id) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $query->where('extender_id', $orgs)->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->select('provinces.*', 'users_extender2.*');
                    break;

                case 5:
                    $query->where('extender_id', $orgs)->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->select('provinces.*', 'users_extender2.*');
                    break;
                case 6:
                    $query->where('extender_id', $orgs)->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->select('provinces.*', 'users_extender2.*');

                    break;
                default:
                    break;
            }
        } elseif ($data->user_role == 9) {
            $zones = DB::table('user_admin_zone')->where('user_id', $data->user_id)->pluck('province_id')->toArray();

            switch ($this->department_id) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
                    break;
                case 5:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
                    break;
                case 6:
                    $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
                    break;
                default:
                    break;
            }
        }

        $results = $query->get();

        $dataexten = collect(); // Initialize an empty collection to store processed data
        $i = 0; // Initialize the counter

        $results->chunk(1000)->each(function ($chunk) use (&$dataexten, &$i) {
            // Process each item in the chunk
            $chunk->map(function ($item) use (&$dataexten, &$i) {
                // Process each item and add it to the collection
                $UserSchoolcount = DB::table('users')
                ->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                ->where('users_department.department_id', '=', $this->department_id)
                    ->where('organization', $item->extender_id)
                    ->count() ?? 0;
                $number = $i + 1;
                $parentExtender = DB::table('users_extender2')->where('extender_id', $item->item_parent_id)->first();
                $dataexten->push([
                    'i' => $number++,
                    'name' => $item->name,
                    'parentExtender' => $parentExtender ? $parentExtender->name : '-',
                    'name_in_thai' => $item->name_in_thai,
                    'count' => $UserSchoolcount ,
                ]);
            });
        });

        return $dataexten;

    }

    public function headings(): array
    {
        return [
            'ลำดับ.',
            'ชื่อสถานศึกษา',
            'หน่วยงาน',
            'จังหวัด',
            'จำนวน',

        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $alignment = [
                    'alignment' => [
                        'horizontal' => 'left', // กำหนดให้ชิดซ้าย
                    ],
                ];

                // กำหนดการจัดวางเฉพาะคอลัมน์ที่คุณต้องการ
                $event->sheet->getStyle('A1:G1')->applyFromArray($alignment);

                // ต่อไปเพิ่มคอลัมน์อื่น ๆ ตามต้องการ

                // กำหนดความหนาของตัวหนังสือในทุกคอลัมน์
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
