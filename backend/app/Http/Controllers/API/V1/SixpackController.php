<?php


namespace App\Http\Controllers\API\V1;



use Illuminate\Http\Request;

class SixpackController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {

            $colName = $this->minitabAnalysis->getColName($params_only['dataName']);
            $groupSize =  $_POST['groupSize'];
            $Lspec =  $_POST['Lspec'];
            $Uspec =  $_POST['Uspec'];
            $Test =  $_POST['Test'];
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }

        $params_only['command'] = "Sixpack ".$colName. $groupSize . "; Lspec " . $Lspec . "; Uspec " .$Uspec. "; Pooled; AMR; CCRbar; CCSbar; CCAMR; UnBiased; OBiased; Breakout 25;Toler 6; CStat;test " .$Test. ".";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
