<?php

namespace App\Console\Commands;

use App\Article;
use App\Comment;
use App\Dynamic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class clearOldNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear_old_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日删除老旧新闻';

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
        /*删除30天以外的数据*/
        $the_day = date('Y-m-d H:i:s',strtotime(date('Y-m-d').'-30 day'));
        /*print_r($the_day);
        exit;*/

        $articles = Article::where('created_at','<=',$the_day)->where('category','=','5');
        $num=0;
        /*要删除他的评论以及动态*/
        if(!$articles->get()->isEmpty()){

            foreach ($articles->get() as $article){
                $comments = $article->comments;

                if($comments){
                    foreach ($comments as $comment){
                        Comment::find($comment->id)->delete();
                    }
                }

                $dynamic = $article->dynamic;

                if($dynamic){
                    $num = Dynamic::find($dynamic->id)->delete();
//                    print_r($num);
//                    exit;
                }
            }

            $num = $articles->delete();
            $content = '删除'.$the_day.'之前的数据'.$num.'条';
        }


        if($num){
            Storage::disk('local')->append('/log/news_clear.txt', $content);
        }

    }
}
