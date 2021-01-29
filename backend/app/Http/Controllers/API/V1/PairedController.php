<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class PairedController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }
        $params_only['command'] = "Paired $colName;Confidence 95.0;Test 0.0;Alternative 0.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
