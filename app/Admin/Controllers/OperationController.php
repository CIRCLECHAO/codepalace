<?php

namespace App\Admin\Controllers;

use App\Jobs\record;
use App\Operation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    use HasResourceActions;


    /**储存一个任务到队列
    * @param Request
     * @return null
    */
    public function store(array $arr){
        $date = date('Y-m-d');
        $old_op = Operation::where('op_date','=',$date)
            ->first();
//        print_r($old_op->toArray());
//        exit;
        if($old_op->toArray()&&$old_op->id){
            /*更新*/
            foreach ($arr as $k=>$v){
                $old_op->$k += $v;
            }
            $operation = $old_op;
        }else{
            /*添加*/
            $operation = new Operation();
            foreach ($arr as $k=>$v){
                $operation->$k = $v;
            }
            $operation->op_date = $date;
        }
       /* print_r($operation->toArray());
        exit;*/

        record::dispatch($operation);
    }
}
