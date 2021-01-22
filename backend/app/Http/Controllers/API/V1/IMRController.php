<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Http\Request;

class IMRController extends BaseController
{
    public function index(Request $request){
        $params_only = $request->only(['dataName','dataArr']);
        try {
            $colName = $this->getColName($params_only['dataName']);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(),'参数错误！');
        }

        $params_only['command'] = "IMRChart $colName.";
        return $this->sendResponse($this->doMinitabTaskAction($params_only),'success!');
    }
}
