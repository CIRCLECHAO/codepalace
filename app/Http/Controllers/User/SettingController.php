<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\Dynamic;
use App\Jobs\record;
use App\Province, App\City, App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User, App\Article, App\Suggestion;
use DB;
use Illuminate\Support\Facades\Redirect, Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function get_settings()
    {
        if (Auth::guest()) {
            return Redirect("/")->withInput()->withErrors("请登录后操作！");
        }
        $id = Auth::id();
        $user_info = User::find($id);

        /*必然有省份选择
        如果有省份 需要有城市
        如果有城市 需要有区县*/
        $provinces = Province::all();

        if ($user_info->province) {
            $cities = Province::where('province_id', $user_info->province)->get()[0]->cities;
        }
        if ($user_info->city) {
            $areas = City::where('city_id', $user_info->city)->get()[0]->areas;
        }

        $data = ['user_info' => $user_info,
            'provinces' => $provinces,
            'cities' => $cities ?? null,
            'areas' => $areas ?? null,
            'html_title' => '个人信息-代码殿堂'];
        // return $user_info;
        return view('user_profile.settings', $data);
    }

    public function save_settings(Request $request)
    {
        //return $request;
        $file_character = $request->file('avatar');
        if ($file_character && $file_character->isValid()) {
            $avatar = $file_character->store('/public/' . date('Y-m-d') . '/avatars');
            //上传的头像字段avatar是文件类型
            $avatar = Storage::url($avatar);//就是很简单的一个步骤
        }
        if (trim(strip_tags($request->input('name'))) == '管理员' && Auth::id() != 1) {
            return Redirect::back()->withInput()->withErrors("禁止使用的用户名！");
        }


        $file_character = $request->file('card_background_image');
        if ($file_character && $file_character->isValid()) {
            $card_background_image = $file_character->store('/public/' . date('Y-m-d') . '/card_background_images');
            //上传的头像字段avatar是文件类型
            $card_background_image = Storage::url($card_background_image);//就是很简单的一个步骤
        }
        if (trim(strip_tags($request->input('name'))) == '管理员' && Auth::id() != 1) {
            return Redirect::back()->withInput()->withErrors("禁止使用的用户名！");
        }

        $user = [
            'name' => $request->input('name'),
            'sex' => $request->input('sex'),
            'email' => $request->input('email'),
            'description' => $request->input('description'),
            'birthday' => $request->input('birthday'),
            'country' => $request->input('country'),
            'province' => $request->input('province'),
            'city' => $request->input('city'),
            'area' => $request->input('area'),
            'address' => $request->input('address'),
        ];
        if ($avatar ?? null) {
            $user['avatar'] = $avatar;
        }
        if ($card_background_image ?? null) {
            $user['card_background_image'] = $card_background_image;
        }

        User::where('id', '=', Auth::id())
            ->update($user);
        return Redirect::back();


    }

    public function show_info($id = "", $type = "")
    {
        /*$articles=Article::whereHas('comments')->get();
        return $articles;*/
        //$articles = User::find($id)->articles;

        $articles_comments = Comment::where(['article_user_id' => $id,])
            ->select('id', 'user_id', 'article_id', 'article_user_id', 'content', 'zan', 'cai', 'created_at')
            ->paginate(5);

        $be_commented_num = $articles_comments->count();

        $user_list = $this->get_user_list();


        $comments_num = User::find($id)->comments->count();
        $articles_num = User::find($id)->articles->count();
        $collects_num = Dynamic::where(['op_type' => 4, 'op_user_id' => $id])->count();
        $zan_num = Dynamic::where(['op_type' => 3, 'op_user_id' => $id])->count();
        //return $articles_comments;
        /* if(!$articles){
             $be_commented_num=0;
         }else{
             $articles_arr=[];
             $be_commented_num=0;
             foreach ($articles as $article){
                 $c_count= $article->comments->count();
                 if($c_count){
                     $be_commented_num++;
                     $articles_arr[]=$article['id'];
                 }
             }
         }*/
        if (Auth::id()) {
            $user_data_arr = $this->get_user_data_arr();
        } else {
            $user_data_arr = [];
        }

        $user_info = $this->get_user_info($id);


        $user_info->be_commented_num = $be_commented_num;
        $user_info->comments_num = $comments_num;
        $user_info->articles_num = $articles_num;
        $user_info->collects_num = $collects_num;
        $user_info->zan_num = $zan_num;


        /*$articles = $user_info->articles;
        $comments = $user_info->comments;
        foreach ($comments as $comment){
            $comment_obj = Comment::find($comment['id']);

            $c_article = $comment_obj->article;

            $comment['article_title']=$c_article->title;
            $comment['article_content']=$c_article->content;

            $a_user = User::find($comment['article_user_id']);

            $comment['article_user_avatar']= $a_user['avatar'];
            $comment['article_user_name']= $a_user['name'];
            $comment['article_user_description']= strip_tags($a_user['description']);
        }
        $suggestions =$user_info
            ->suggestions()
            ->where('type','=',1)
            ->orderBy('created_at','desc')
            ->get();*/
        /*获取动态*/
        if (!$type || $type == 4 || $type == 5) {
            if ($type) {
                $dynamics = Dynamic::where('op_user_id', '=', $id)
                    ->where('op_type', '=', $type != 5 ? 4 : 3)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);
            } else {
                $dynamics = Dynamic::where('op_user_id', '=', $id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);
            }

            if ($dynamics) {
                foreach ($dynamics as &$dynamic) {
                    $op_type = $dynamic['op_type'];
                    /*发布帖子*/
                    if ($op_type == 1) {
                        $dynamic['user'] = User::where('id', $id)->first(['id', 'name', 'avatar', 'description', 'fans_num', 'card_background_image']);
                        $dynamic['user']['comment_num'] = Comment::select('id')
                            ->where('user_id', '=', $id)
                            ->count();
                        //User::find($id)->comments->count();
                        $dynamic['user']['article_num'] = Article::select('id')
                            ->where('user_id', '=', $id)
                            ->count();
                        //User::find($id)->articles->count();

                        /*发布的文章*/
                        $dynamic['content'] = Article::find($dynamic['op_user_article_id']);
                        $dynamic['content']['comment_num'] = Comment::select('id')
                            ->where('article_id', '=', $dynamic['op_user_article_id'])
                            ->count();
                        //$dynamic['content']->comments->count();
                    } elseif ($op_type == 2 || $op_type == 3 || $op_type == 4) {
                        /*评论文章*/
                        /*发布的文章*/
                        $dynamic['content'] = Article::find($dynamic['article_id']);
//                        $this->print_arr($dynamic);
//                        exit;

                        $d_content = $dynamic['content'];
                        $d_content['comment_num'] = Comment::select('id')
                            ->where('article_id', '=', $dynamic['article_id'])
                            ->count();

//                        if(!is_object($dynamic['content'])){
//                            $this->print_arr($dynamic['content']);
//                            exit;
//                        }
                        if($dynamic['content'] && is_object($dynamic['content'])){

                            $dynamic['user'] = User::where('id', $dynamic['content']->user_id)
                                ->first(['id', 'name', 'avatar', 'description', 'fans_num', 'card_background_image']);


                            $dynamic['user']['comment_num'] = Comment::select('id')
                                ->where('user_id', '=', $dynamic['content']->user_id)
                                ->count();

                            //User::find($dynamic['content']->user_id)->comments->count();
                            $dynamic['user']['article_num'] = Article::select('id')
                                ->where('user_id', '=', $dynamic['content']->user_id)
                                ->count();
                        }
                        $dynamic['content'] = $d_content;
                       /* $dynamic['content']['comment_num'] = Comment::select('id')
                            ->where('article_id', '=', $dynamic['article_id'])
                            ->count();*/
                        //$dynamic['content']->comments->count();



                        //User::find($dynamic['content']->user_id)->articles->count();
                    } elseif ($op_type == 5) {
                        //TODO

                    } elseif ($op_type == 6) {
                        //TODO
                    }
                }
            } else {
                $dynamics = [];
            }
        } elseif ($type == 1) {
            if ($be_commented_num == 0) {
                $dynamics = [];
            } else {
                // $dynamic=new \stdClass();
                foreach ($articles_comments as &$articles_comment) {
                    $articles_comment->op_type = 0;
                    $articles_comment->article_title = Article::where('id', '=', $articles_comment['article_id'])
                        ->select(['title'])
                        ->first()['title'];
                    $articles_comment->user = User::where('id', $articles_comment->user_id)->first(['id', 'name', 'avatar', 'description', 'fans_num', 'card_background_image']);
                    $articles_comment->user->comment_num = User::find($id)->comments->count();
                    $articles_comment->user->article_num = User::find($id)->articles->count();
                }
                $dynamics = $articles_comments;
            }


        } elseif ($type == 2) {
            /*回复*/
            if ($comments_num == 0) {
                $dynamics = [];
            } else {

                $comments = User::find($id)->comments()->paginate(5);
                foreach ($comments as &$comment) {
                    $comment->op_type = 0;
                    $comment->article_title = Article::where('id', '=', $comment['article_id'])
                        ->select(['title'])
                        ->first()['title'];
                    $comment->user = User::where('id', $comment->user_id)->first(['id', 'name', 'avatar', 'description', 'fans_num', 'card_background_image']);
                    $comment->user->comment_num = User::find($id)->comments->count();
                    $comment->user->article_num = User::find($id)->articles->count();
                }
                $dynamics = $comments;
            }

            /*2019年8月26日15:52:05 不显示数据*/
        } elseif ($type == 3) {
            if ($articles_num == 0) {
                $dynamics = [];
            } else {
                $dynamics = User::find($id)->articles()->select('id', 'title', 'content', 'created_at')->paginate(5);
            }
//            echo '<pre>';
//            print_r($articles_num);
//            print_r($dynamics);
//            exit;
        }
        //return $dynamics;
        $data = ['user_info' => $user_info,
            'dynamics' => $dynamics,
            'type' => $type,
            'user_list' => $user_list,
            'user_focus_arr' => $user_data_arr['user_focus_arr'] ?? [],
            'user_comment_arr' => $user_data_arr['user_comment_arr'] ?? [],
            'user_zan_arr' => $user_data_arr['user_zan_arr'] ?? [],
            'user_collect_arr' => $user_data_arr['user_collect_arr'] ?? [],
            'html_title' => $user_info->name . '的个人主页'

            //'articles'=>$articles,
            //'suggestions'=>$suggestions,
            //'comments'=>$comments
        ];
        /*插入消息队列*/
        $post_arr = ['profile_read_num' => 1];

        record::dispatch($post_arr);
        return view('user_profile.profile', $data);
    }

    public function show_faf($id = "", $type = "")
    {

        if (Auth::id()) {
            $user_data_arr = $this->get_user_data_arr();
        } else {
            $user_data_arr = [];
        }

        $user_list = $this->get_user_list();
        $user_info = $this->get_user_info($id);
        $user_f_arr = [];
        if ($type == 1) {
            $ob_name = 'focus';
        } elseif ($type == 2) {
            $ob_name = 'fans';
        }
        $user_f_list = [];
        $num = $ob_name . '_num';
        $ids = $ob_name . '_ids';
        if ($user_info->$num > 0) {
            $user_f_arr = explode('丨', $user_info->$ids);

            $user_f_list = User::whereIn('id', $user_f_arr)
                ->select('id', 'name', 'avatar', 'card_background_image',
                    'description', 'fans_num', 'focus_num')
                ->paginate(5);
            foreach ($user_f_list as &$user) {
                $user->article_num = $user->articles()->count();
                $user->comment_num = $user->comments()->count();
            }
        }
        //return $user_info->$num;
        $data = [
            'user_info' => $user_info,
            'type' => $type,
            'user_list' => $user_list,
            'user_f_list' => $user_f_list,
            'user_focus_arr' => $user_data_arr['user_focus_arr'] ?? [],
            'html_title' => $user_info->name . '的个人主页'
        ];
        return view('user_profile.profile_faf', $data);
    }

    public function change_focus(Request $request)
    {
        if (Auth::guest()) {
            return "no_login";
        }
        $user_id = Auth::id();

        $type = $request->type;
        $id = $request->id;
        if ($user_id == $id) {
            return 'cant_focus_self';
        }
        $me = User::find($user_id);
        $who = User::find($id);
        $fids = $me->focus_ids;

        /*关注*/
        if ($type == 1) {
            if (strpos($fids, '丨')) {
                $me_focus_arr = explode('丨', $fids);
            } else {
                $me_focus_arr[] = $fids;
            }
            if (in_array($id, $me_focus_arr)) {
                return 'already_have';
            }
            //1 在我的focus加一个 数量加1
            if (!$me->focus_num) {
                $me->focus_num = 1;
                $me->focus_ids = $id;
            } else {
                $me->focus_num += 1;
                $me->focus_ids .= '丨' . $id;
            }
            //在对方的粉丝加1
            if (!$who->fans_num) {
                $who->fans_num = 1;
                $who->fans_ids = $user_id;
            } else {
                $who->fans_num += 1;
                $who->fans_ids .= '丨' . $user_id;
            }


            /*取关*/
        } else {

            if ($me->focus_num < 1 || $me->focus_ids == '' || $who->fans_num < 1 || $who->fans_ids == "") {
                //return Redirect("/")->withInput()->withErrors("并未关注，请刷新页面！");
                return "not_attention";
            } else {
                $me->focus_num -= 1;
                $who->fans_num -= 1;

                /*去除关注的人*/
                $me_focus = explode('丨', $me->focus_ids);
                $me_focus_str = '';
                $me_focus_arr = [];
                foreach ($me_focus as $ids) {
                    if ($ids != $id) {
                        $me_focus_arr[] = $ids;
                    }
                }
                if (count($me_focus_arr) > 0) {
                    $me_focus_str = implode('丨', $me_focus_arr);
                }
                $me->focus_ids = $me_focus_str;

                $who_fans = explode('丨', $who->fans_ids);
                $who_fans_str = '';
                $who_fans_arr = [];
                foreach ($who_fans as $ids) {
                    if ($ids != $user_id) {
                        $who_fans_arr[] = $ids;
                    }
                }
                if (count($who_fans_arr) > 0) {
                    $who_fans_str = implode("丨", $who_fans_arr);
                }
                $who->fans_ids = $who_fans_str;
            }

        }

        $me->save();

        $re = $who->save();

        return $re ? 1 : 0;
    }

}
