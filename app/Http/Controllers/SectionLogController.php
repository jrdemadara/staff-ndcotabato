<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SectionLogController extends Controller
{
    public function index(): View
    {
        $sections = DB::table('section')
            ->select('secserial', 'secname')
            ->where('isdelete', '=', 0)
            ->orderBy('secname', 'asc')
            ->get();

        return view('pages/section-log', [
            'layout' => 'top-menu',
            'sections' => $sections,
        ]);
    }

    public function details(Request $request): View
    {
        // Format Date
        list($startDateStr, $endDateStr) = explode(' - ', $request->daterange);
        $dateFrom = Carbon::createFromFormat('d M, Y', trim($startDateStr));
        $dateTo = Carbon::createFromFormat('d M, Y', trim($endDateStr));
        $dateFromFormatted = $dateFrom->format('Y-m-d');
        $dateToFormatted = $dateTo->format('Y-m-d');

        $section = $request->section;

        $sections = DB::table('section')
            ->select('secserial', 'secname')
            ->where('isdelete', '=', 0)
            ->orderBy('secname', 'asc')
            ->get();

        if ($section == null) {
            return view('pages/section-log', [
                'layout' => 'top-menu',
                'sections' => $sections,
            ]);
        }

        $result = DB::select('CALL spRptStudentSectionLog(?,?,?)', [$section, $dateFromFormatted, $dateToFormatted]);
        $selectedSection = DB::table('section')
            ->select('secserial', 'secname')
            ->where('secserial', '=', $section)
            ->get();

        // Initialize arrays to store categorized data
        $entranceData = [];
        $exitData = [];

        // Iterate through the items and categorize by LOGTYPE
        foreach ($result as $item) {
            // Convert LOGDATE to the desired format
            $item->LOGDATE = date('F j, Y', strtotime($item->LOGDATE));

            if ($item->LOGTYPE === 'ENTRANCE') {
                $entranceData[] = $item;
            } elseif ($item->LOGTYPE === 'EXIT') {
                $exitData[] = $item;
            }
        }

        usort($entranceData, function ($a, $b) {
            return strtotime($a->LOGDATE) - strtotime($b->LOGDATE);
        });

        usort($exitData, function ($a, $b) {
            return strtotime($a->LOGDATE) - strtotime($b->LOGDATE);
        });

        usort($entranceData, function ($a, $b) {
            return strcmp($a->{'STUDENT NAME'}, $b->{'STUDENT NAME'});
        });

        usort($exitData, function ($a, $b) {
            return strcmp($a->{'STUDENT NAME'}, $b->{'STUDENT NAME'});
        });

        return view('pages/section-log', [
            'layout' => 'top-menu',
            'entranceData' => $entranceData,
            'exitData' => $exitData,
            'selectedSection' => $selectedSection,
            'sections' => $sections,
        ]);
    }
}
