<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class NormTestController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $title =  $_POST['title'];
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }
        $params_only['command'] = "NormTest $colName;Title '$title'.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
