<?php


namespace App\Http\Controllers\API\V1;



use Illuminate\Http\Request;

class BoxplotController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $y =  trim($_POST['y']);
            $x =  trim($_POST['x']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'',406);
        }

        $params_only['command'] = "Boxplot ( '$y') * '$x';IQRBox;Outlier.";
        $result = $this->minitabAnalysis->doMinitabTask($params_only);
        return $this->sendResponse($result,'分析完成');
    }
}
