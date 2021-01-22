<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    public function __construct()
    {
        // 认证通过．．．
        if (Auth::check()){
//            return redirect()->intended('dashboard');
        }else{
            return $this->unauthorizedResponse();
        }
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }


    /**
     * return Unauthorized response.
     *
     * @param $error
     * @param  int  $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorizedResponse($error = 'Forbidden', $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }

    //处理Minitab 方法
    public function doMinitabTaskAction($params = []){
        $dataName = $params['dataName'];
        $dataArr = $params['dataArr'];
        $dataName = substr($dataName,0,strlen($dataName)-1);
        $dataArr = substr($dataArr,0,strlen($dataArr)-1);
        $command = $params['command'];
        $insert_data = [
            'dataName'=>$dataName,
            'dataArr' =>$dataArr,
            'command' =>$command
        ];
        $table = 'minitab_task';
        $insertId = DB::table($table)->insertGetId($insert_data);
        if (!is_numeric($insertId)) return "系统error";
        while (true){
            //2 代表Minitab 分析完成
            $status = DB::table($table)->where('id',$insertId)->value('status');
            if ($status === '2') break;
        }

        $list = DB::table($table)->find($insertId);

        if ($list == null)return ['msg'=>"系统错误！"];
        if(strpos($list['OTTitle'],'不合格') !== false){
            if (isset($params['email']) && !empty($params['email'])){
//                SendMail($params['email'],$list['OTTitle'],$list['OTMessage']);
            }
        }

        $seconds = strtotime($list['finish_time']) - strtotime($list['create_time']);
        $saveName = $list['OTGraph'];
        $arr = [];
        if ($saveName != null){
            $arr = explode(',',rtrim($saveName,','));
            foreach ($arr as $k=> $item){
                $arr[$k] = "data:image/jpeg;base64,".$item;
            }
        }

        $list['OTGraph'] = $arr;
        $list['time'] = '耗时'.$seconds.'秒';
        $list['code'] = 200;
        $list['msg'] = 'success';
        return $list;
    }

    public function getColName($dataName){
        $dataName = substr($dataName,0,strlen($dataName)-1);
        $dataNameArr = explode(';',$dataName);
        $colName = '';
        foreach ($dataNameArr as $name){
            $colName.="'".$name."' ";
        }
        return $colName;
    }
}
