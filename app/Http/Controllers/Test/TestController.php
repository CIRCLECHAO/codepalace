<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Xl_MQ\MQServer;
class TestController extends Controller
{
    public function test()
    {
        //检测变量是否设置
//        $this->self_log(isset($a));
//        //检测是否为空
//        $this->self_log(empty($a));
//        //
//        if(empty($a)){
//            $this->self_log('a 为空');
//        }
//        if($a??empty($a)){
//            $this->self_log('a 为空');
//        }

//        $str='0';
//        if(!$str){
//            $this->self_log('字符串0用if判断为false');
//        }
//        if(empty($str)){
//            $this->self_log('字符串0用empty判断为true');
//        }
//
//        $num=0;
//        if(!$num){
//            $this->self_log('数字0用if判断为false');
//        }
//        if(empty($num)){
//            $this->self_log('数字0用empty判断为true');
//        }
//
//
//        $str='';
//        if(!$str){
//            $this->self_log('字符串“”用if判断为false');
//        }
//        if(empty($str)){
//            $this->self_log('字符串“”用empty判断为true');
//        }
//
//        $str='null';
//        if($str){
//            $this->self_log('字符串null用if判断为true');
//        }
//        if(!empty($str)){
//            $this->self_log('字符串null用empty判断为false');
//        }
//
//        $str=array();
//        if(!$str){
//            $this->self_log('空数组用if判断为false');
//        }
//        if(empty($str)){
//            $this->self_log('空数组用empty判断为true');
//        }
//
//
//        $str=(object)array();
//        if($str){
//            $this->self_log('空数组强转对象用if判断为true');
//        }
//        if(!empty($str)){
//            $this->self_log('空数组强转对象用empty判断为false');
//        }

        /*
         * string(0) 用if->false 和 empty->true 数字0也是
         * 字符串"0.0"、字符串"00"、包括一个空格字符的字符串" "、字符串"false" 、整型 -1 都不为 false
         * */

//            $a= [1];
//            $a1=(object)$a;
//            $a2=(object)[];
//            $a2->name='sisi';
//            $file = fopen('../public/favicon.ico','r');
        // $b ='1,2,3,4';
//            echo $b,substr($b,1,3);
//            print $b;
//            print_r($a);
//            print_r($a1);
//            var_dump($a);
//            var_dump($a1);
//            var_dump($a2);
//            print_r($file);
//            var_dump($file);


        /*
         * print_r 打印 对象 stdClass Object   var_dump 打印 对象object(stdClass)#522
         *         打印 文件 Resource id #286                 resource(286) of type (stream)
         * */

//    session_start();
//    $_SESSION['user']='asdasd'.time();
//        $this->self_log($_SESSION['user']);
//    $re = session_destroy();
//        $this->self_log($re);
//        session_start();
//        $this->self_log($_SESSION) ;

//        setcookie('cookie1','YUANCCHAO',time()+50,'/','localhost',0,0);
//        $cookie = $_COOKIE;
//        $this->print_arr($cookie);

        //获取某个日期的前一天前一个小时
//          $yesterday  = date('Y、m、d H:i:s',strtotime('-1 day -1 hour',strtotime('1931-01-01 00:00:00')));
//
//          print_r($yesterday);
//        $str1 = null;
//        $str2 = false;
//        echo $str1==$str2 ? '相等' : '不相等';
//
//        $str3 = '';
//        $str4 = 0;
//        echo $str3==$str4 ? '相等' : '不相等';
//
//        $str5 = 0;
//        $str6 = '0';
//        echo $str5===$str6 ? '相等' : '不相等';
//        $a1 = null;
//        $a2 = false;
//        $a3 = 0;
//        $a4 = '';
//        $a5 = '0';
//        $a6 = 'null';
//        $a7 = array();
//        $a8 = array(array());
//
//        echo empty($a1) ? 'true' : 'false';
//        echo empty($a2) ? 'true' : 'false';
//        echo empty($a3) ? 'true' : 'false';
//        echo empty($a4) ? 'true' : 'false';
//        echo empty($a5) ? 'true' : 'false';
//        echo empty($a6) ? 'true' : 'false';
//        echo empty($a7) ? 'true' : 'false';
//        echo empty($a8) ? 'true' : 'false';
//        $test = 'aaaaaa';
//        $abc = &$test;
//        $abc= 'bbb';
//        echo $test;
//
//        unset($test);
//
//        echo $abc;
//
//        $str = 'qwertyuiop';
//        $rev_str = strrev($str);
//        print_r($rev_str);

//          $bd = fopen('http://www.baidu.com','r');
//          $contents = stream_get_contents($bd);
//          fclose($bd);
//          echo $contents;

//            $fc = file_get_contents('http://www.baidu.com');
//            echo $fc;
//            @ $a = 0/0;
//            $a=0/0;

//        function scan_dir($dir)
//        {
//            $files = [];
//            if (is_dir($dir)) {
//                if ($handler = opendir($dir)) {
//                    while (($file = readdir($handler)) !== false) {
//                        /*否则会执行超时*/
//                        if($file!='..'&&$file!='.'){
//                            if (is_dir($file)) {
//                                $files[$file] = scan_dir($file);
//                            } else {
//                                $files[] = $file;
//                            }
//                        }
//
//                    }
//                }
//
//            }
//            closedir($handler);
//            return $files;
//        }
//
//        $this->print_arr(scan_dir("../public/css"));


//        $this->print_arr(scandir('../public'));


        MQServer::run();
    }

}
