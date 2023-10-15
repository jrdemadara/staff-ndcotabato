<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SMSLogController extends Controller
{
    public function index(): View
    {
        $name = DB::select('CALL spSearchSE()');

        usort($name, function ($a, $b) {
            return strcmp($a->FULLNAME, $b->FULLNAME);
        });

        return view('pages/sms-log', [
            'layout' => 'top-menu',
            'names' => $name,
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

        $name = $request->name;

        $names = DB::select('CALL spSearchSE()');

        if ($name == null) {
            return view('pages/sms-log', [
                'layout' => 'top-menu',
                'names' => $names,
            ]);
        }

        $result = DB::select('CALL spRptSMSSend(?,?,?)', [$name, $dateFromFormatted, $dateToFormatted]);

        // Initialize arrays to store categorized data
        $entranceData = [];
        $exitData = [];

        // Iterate through the items and categorize by LOGTYPE
        foreach ($result as $item) {
            if ($item->logype === 'ENTRANCE') {
                $entranceData[] = $item;
            } elseif ($item->logype === 'EXIT') {
                $exitData[] = $item;
            }
        }

        usort($entranceData, function ($a, $b) {
            return strtotime($a->datetimesend) - strtotime($b->datetimesend);
        });

        usort($exitData, function ($a, $b) {
            return strtotime($a->datetimesend) - strtotime($b->datetimesend);
        });

        usort($entranceData, function ($a, $b) {
            return strcmp($a->FULLNAME, $b->FULLNAME);
        });

        usort($exitData, function ($a, $b) {
            return strcmp($a->FULLNAME, $b->FULLNAME);
        });

        return view('pages/sms-log', [
            'layout' => 'top-menu',
            'entranceData' => $entranceData,
            'exitData' => $exitData,
            'selectedName' => $name,
            'names' => $names,
        ]);
    }
}
