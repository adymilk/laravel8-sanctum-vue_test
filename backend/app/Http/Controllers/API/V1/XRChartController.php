<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class XRChartController extends BaseController
{
    public function index(Request $request)
    {

        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
            $groupSize =  $_POST['groupSize'];
            $Test =  $_POST['Test'];
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }

        $params_only['command'] = "XRChart $colName $groupSize;Test $Test.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
