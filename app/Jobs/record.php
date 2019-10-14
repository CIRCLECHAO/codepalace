<?php

namespace App\Jobs;

use Exception;
use App\Operation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class record implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable,SerializesModels;

    protected $arr;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr=[])
    {
        //
        $this->arr = $arr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arr = $this->arr;
        //print_r(1);
        $date = date('Y-m-d');
        $old_op = Operation::where('op_date','=',$date)
            ->first();
//        print_r($old_op->toArray());
//        exit;
        if($old_op&&$old_op->id){
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
         //print_r($operation->toArray());

       // print_r($operation->toArray());
            $re = $operation->save();
        //print_r($re);
        return;
    }

    /**
     * 执行失败的任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        print_r($exception);
    }
}
