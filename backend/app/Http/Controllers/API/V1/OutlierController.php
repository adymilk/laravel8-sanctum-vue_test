<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class OutlierController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }
        $params_only['command'] = "Outlier $colName;Grubbs;Alpha 0.05;Alternative 0;NoDefault;TMethod;TTest;TOutlier;GOutlierplot.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
