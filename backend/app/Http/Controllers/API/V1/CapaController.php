<?php

namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;

class CapaController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
            $groupSize =  $_POST['groupSize'];
            $Lspec =  $_POST['Lspec'];
            $Uspec =  $_POST['Uspec'];
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }

        $params_only['command'] = "Capa $colName " .$groupSize. ";Lspec " .$Lspec. ";Uspec " .$Uspec. ";Pooled;AMR;UnBiased;OBiased;Toler 6;Within;Overall;NoCI;PPM;CStat.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
