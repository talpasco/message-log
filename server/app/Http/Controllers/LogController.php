<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{

    /**
     * Get & Set the filter values.
     *
     * @param Request $request
     * @param string $field
     * @return \Illuminate\Http\Response|\Laravel\Http\ResponseFactory
     */
    public function getSetFilterValues(Request $request, $field)
    {
        if ($field == "cnt_title") {
            $table = "countries";
        } else if ($field == "usr_name") {
            $table = "users";
        } else {
            $table = "logs";
        }
        $values = DB::table($table)->select($field)->distinct()->orderBy($field, 'asc')->pluck($field);
        return $values;
    }

    /**
     * Get the data to populate the grid filtered by date range and Limit and Offset calculation.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Http\ResponseFactory
     */
    public function getData(Request $request)
    {
        Log::debug($request->input('dateFrom'));
        Log::debug($request->input('dateTo'));
        $dateFrom = $request->input('dateFrom') ? date($request->input('dateFrom')) : date('2000-01-01');
        $dateTo = $request->input('dateTo') ? date($request->input('dateTo')) : date_create('now')->format('Y-m-d');;
        //Limit and Offset calculation
        $startRow = $request->input('startRow');
        $endRow = $request->input('endRow');
        $pageSize = ($endRow - $startRow) + 1;
        $params = array($dateFrom, $dateTo, $pageSize, $startRow);
        Log::debug($params);
        $results = DB::select('call LOGS_GetList(?,?,?,?)', $params);
        // for debugging purposes - logs are saved to storage/logs/laravel.log
        Log::debug($results);

        $rowCount = $this->getRowCount($request, $results);
        $resultsForPage = $this->cutResultsToPageSize($request, $results);
        return ['rows' => $resultsForPage, 'lastRow' => $rowCount];
    }

    /**
     * Calculate row count.
     *
     * @param Request $request
     * @param array $results
     * @return \Illuminate\Http\Response|\Laravel\Http\ResponseFactory
     */
    private function getRowCount($request, $results)
    {
        if (is_null($results) || !isset($results) || sizeof($results) == 0) {
            // or return null
            return 0;
        }

        $currentLastRow = $request['startRow'] + sizeof($results);

        if ($currentLastRow <= $request['endRow']) {
            return $currentLastRow;
        } else {
            return -1;
        }
    }

    /**
     * Cut results to page size - pagination purpose.
     *
     * @param Request $request
     * @param array $results
     * @return \Illuminate\Http\Response|\Laravel\Http\ResponseFactory
     */
    private function cutResultsToPageSize($request, $results)
    {
        $pageSize = $request['endRow'] - $request['startRow'];

        if ($results && (sizeof($results) > $pageSize)) {
            return array_splice($results, 0, $pageSize);
        } else {
            return $results;
        }
    }
}
