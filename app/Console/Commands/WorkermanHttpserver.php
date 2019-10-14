<?php

namespace App\Console\Commands;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;
use Illuminate\Console\Command;

class WorkermanHttpserver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workman {action} {d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开启 WORKERMAN 服务器';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
        $action = $this->argument('action');

        $argv[0]='wk';
        $argv[1]=$action;

        $argv[2]=$this->argument('d')?'-d':'';
       // print_r($argv);

        $this->start();
    }

    /*2018年12月25日16:55:52*/
    private function start(){
        $this->startGateWay();

        $this->startBusinessWorker();

        $this->startRegister();

        Worker::runAll();
    }

    private function startBusinessWorker(){
        $worker = new BusinessWorker();

        $worker->name = 'BusniessWorker';
        $worker->count=1;
        $worker->registerAddress="127.0.0.1:1236";
        $worker->eventHandler=\App\Http\Controllers\Workerman\EventsController::class;
    }

    private function startGateWay(){
        $gateway = new Gateway("websocket://127.0.0.1:2346");
        $gateway->name = 'Gateway';
        $gateway->count =1;
        $gateway->lanIp = '127.0.0.1';
        $gateway->startPort=2300;
        $gateway->pingInterval=30;
        $gateway->pingNotResponseLimit=0;
        $gateway->pingData= '{"type":"heart"}';
        $gateway->registerAddress="127.0.0.1:1236";
    }

    private function startRegister(){
        new Register('text://127.0.0.1:1236');
    }
}
