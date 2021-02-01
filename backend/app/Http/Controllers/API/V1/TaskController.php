<?php

namespace App\Http\Controllers\API\V1;

use App\Models\MinitabTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends BaseController
{

    public function index(Request $request)
    {
        return MinitabTask::where('status',0)->orderBy('create_time','desc')->first();
    }


    public function update(Request $request)
    {
        $data = [
            'status'=>$request->status,
            'OTGraph'=>$request->OTGraph,
            'OTTable'=>$request->OTTable,
            'OTTitle'=>$request->OTTitle,
            'OTMessage'=>$request->OTMessage,
            'OTFormula'=>$request->OTFormula,
            'hint'=>$request->hint,
        ];
        $rows =  MinitabTask::where('id',$request->id)->update($data);
        return $rows == 1 ? $this->sendResponse('1 rows','success!') : $this->sendError('');
    }
}
