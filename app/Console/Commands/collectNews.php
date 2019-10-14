<?php

namespace App\Console\Commands;

use App\Dynamic;
use App\Jobs\record;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use QL\QueryList;
use App\Article;
class collectNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日新闻采集';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
//        $this->aid_web = 'https://www.toutiao.com/ch/';
//        $this->variety_arr= ['news_tech/','news_entertainment/','news_game/','news_sports/','news_finance/'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*由新闻机器人发布文章*/
        Auth::loginUsingId(9);

//        $today = date('Y-m-d');
//        /*1根据当前锁 判定是否正在爬取*/
//        $lock_all = Cache::get($today.'collect_news_all');
//        if($lock_all){
//            return;
//        }
//        $lock = Cache::get($today.'collect_news');
//        if($lock){
//            return;
//        }
//
//        $arr_position = Cache::get($today.'collect_position');
//        if(!$arr_position){
//            //初始为0
//            $arr_position=0;
//        }

        /*突破验证 进行加锁*/
//        Cache::forever($today.'collect_news',1);


        $url = 'https://it.ithome.com/ityejie/';
            // 元数据采集规则
        $rules = [
            // 采集文章标题
            'title' => ['h2>a','text'],
            // 采集链接
            'link' => ['h2>a','href'],
            // 采集缩略图
            'title_pic' => ['.list_thumbnail>img','data-original'],
        ];
// 切片选择器
        $range = '.ulcl li';
        $rt = QueryList::get($url)->rules($rules)
            ->range($range)
            ->query()
            ->getData();
        $data = $rt->all();
     //   Storage::disk('local')->append('/test/file.txt', json_encode($data));
        //exit;
        /*分析页面 在每个页面分别获取详细数据 获取数据*/
        foreach ($data as $article){
            if($article['link']){
                $new_article = new Article;
                $new_article->title=$article['title'];
                $new_article->user_id=Auth::user()->id;
                $new_article->Category=5;
                $new_article->link=$article['link'];
                $new_article->title_pic=$article['title_pic'];
                $new_article->is_checked=1;
                $new_article->checked_time=date('Y-m-d H:i:s');
                $new_article->checked_uid=1;

                /*如果已经有相同标题和链接的文章 就跳过*/
                $is_repeat = Article::where(['title'=>$article['title'],'title_pic'=>$article['title_pic']])
                                        ->first();
                if($is_repeat){
                    continue;
                }

                /*采集单文章*/
                $url = $article['link'];
                $this->record( '采集详情页：'.$url);
                $ql = QueryList::get($url);

                $content= $ql->find('.post_content')->html();
                //Storage::disk('local')->append('/test/file.txt', ($content));
               // exit;
                /*****/
                $say_from= '<p>来自IT之家，原网页<a href="'.$new_article->link.'">'.$new_article->title.'</a></p>';

                $new_article->content=$say_from.$content;
                /*保存数据*/
                unset($new_article->link);
                $saved =  $new_article->save();
              //  Storage::disk('local')->append('/test/file.txt', json_encode($new_article));
                if($saved){
                    $post_arr=['article_write_num'=>1];
                    record::dispatch($post_arr);
                    $this->record($new_article->title.'保存成功：'.$saved);
                    $dynamic = new Dynamic();
                    /*发帖*/
                    $article_id = $new_article->id;
                    $dynamic->op_user_article_id = $article_id;
                    $dynamic->op_type=1;
                    $dynamic->op_user_id=Auth::id();
                    $dynamic->save();
                }
            }
        }
    }


    public function record($content){

        Storage::disk('local')->append('/log/news.txt', date('Y-m-d'));
        Storage::disk('local')->append('/log/news.txt', $content);

    }
}
