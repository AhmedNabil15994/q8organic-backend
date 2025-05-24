<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Requests\Dashboard\GetExcelHeaderRowRequest;
use Modules\Apps\Imports\GetFirstRowImport;
use Modules\Core\Traits\Dashboard\ControllerResponse;

class DashboardController extends Controller
{
    use ControllerResponse;

    public function index()
    {
        return view('apps::dashboard.index');
    }

    public function getExcelHeaderRow(GetExcelHeaderRowRequest $request)
    {
        try {

            $rows = Excel::toArray(new GetFirstRowImport, $request->file('excel_file'));
            $excel_cols = $rows[0][0];
            $selectors = view(strtolower($request->module).'::dashboard.' . $request->view_path , compact('excel_cols'))->render();
            return response()->json([true,'ignore_success' => true , 'selectors' => $selectors]);

        } catch (\PDOException $e) {

            return $this->createError(null, [false, $e->errorInfo[2]]);
        }
    }
}
