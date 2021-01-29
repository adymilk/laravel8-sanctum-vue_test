<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class TwoVariancesController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }
        $params_only['command'] = "TwoVariances $colName;Confidence 95.0;STest 1;Alternative 0;GInterval;NoDefault;TMethod;TStatistics;TConfidence;TTest.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
