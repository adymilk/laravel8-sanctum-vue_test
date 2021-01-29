<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MinitabTask;

class MinitabAnalysis extends Controller
{
    //处理Minitab 方法
    public function doMinitabTask($params = []){
        $dataName = $params['dataName'];
        $dataArr = $params['dataArr'];
        $dataName = substr($dataName,0,strlen($dataName)-1);
        $dataArr = substr($dataArr,0,strlen($dataArr)-1);
        $command = $params['command'];
        $insert_data = [
            'dataName'=>$dataName,
            'dataArr' =>$dataArr,
            'command' =>$command,
        ];
        $insertId = MinitabTask::insertGetId($insert_data);
        if (!is_numeric($insertId)) return "系统error";

        while (true){
            $status = MinitabTask::where('id',$insertId)->value('status');
            //2 代表Minitab 分析完成
            if ($status === 2) break;
        }
        $list = MinitabTask::find($insertId);
        if ($list == null)return ['msg'=>"系统错误！"];
        if (strpos($list['OTTitle'],'不合格') !== false){
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
