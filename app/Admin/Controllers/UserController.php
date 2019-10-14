<?php

namespace App\Admin\Controllers;

use App\{User,Province,City,Area};
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('用户管理')
            ->description('前台-用户管理')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('前台用户资料')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('前台用户资料')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('前台用户')
            ->description('新建')
            ->body($this->form());
    }


    /**
     * Save interface.
     *
     * @param Content $content
     * @return Content
     */
    public function save(Request $request,$id)
    {

        $param_arr = $request->toArray();
        unset($param_arr['_token']);
        unset($param_arr['_method']);
        unset($param_arr['_previous_']);

      //  $re = $form->update($id,$form);

//
        $param_arr = $request->toArray();

        $user = User::FindOrFail($id);
        if($user){
            unset($param_arr['_token']);
            unset($param_arr['_method']);
            unset($param_arr['_previous_']);
            foreach ($param_arr as $k=>$v){
                $user->$k=$v;
            }
          $re =   $user->save();

        }
        admin_toastr('更新成功','success');


        return Redirect::back();

        /*echo '<pre>';
        print_r($re??0);
        echo '<pre>';

        exit;*/
    }


    /**
     * delete interface.
     *
     * @param Content $content
     * @return Content
     */
    public function delete(Request $request,$id)
    {

        $form = new Form(new User);
        $param_arr = $request->toArray();
        unset($param_arr['_token']);
        unset($param_arr['_method']);
        unset($param_arr['_previous_']);

        //  $re = $form->update($id,$form);

//
        $param_arr = $request->toArray();

        $user = User::FindOrFail($id);

            $re =   $user->delete();


       // admin_toastr('删除成功','success');

      return  response()->json([
          'status'  => true,
          'message' => '删除成功',
      ]);

        /*echo '<pre>';
        print_r($re??0);
        echo '<pre>';

        exit;*/
    }



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('Id');
        $grid->name('名字');

// 设置尺寸
        $grid->column('avatar', '头像')->image("https://www.codepalace.xyz",50,50);
        //$grid->avatar('Avatar');
        $grid->sex('性别')->display(function ($sex){
           if($sex==1){
               return '男';
           }elseif ($sex==2){
               return '女';
           }else{
               return '保密';
           }
        });

     /*   $grid->column('性别')->display(function (){
            if($this->sex==1){
               return '男';
           }elseif ($this->sex==2){
               return '女';
           }else{
               return '保密';
           }
        });*/

       // $grid->description('个性签名');

        $grid->email('Email');

        $grid->birthday('生日');


        $grid->column('年龄')->display(function (){
            $birthday = strtotime($this->birthday);//int strtotime ( string $time [, int $now ] )
            $year = date('Y', $birthday);
            if(($month = (date('m') - date('m', $birthday))) < 0){
                $year++;
            }else if ($month == 0 && date('d') - date('d', $birthday) < 0){
                $year++;
            }
            return date('Y') - $year;
        });

       // $grid->email_verified_at('Email verified at');
        //$grid->password('Password');
        //$grid->remember_token('Remember token');
        $grid->created_at('注册时间')->sortable();
        //$grid->updated_at('Updated at');
        $grid->province('所在省')->display(function ($province){
            if($province){
                return Province::select('province_name')
                               ->where('province_id','=',$province)
                               ->first()['province_name'];
            }else{
                return '保密';
            }
        });
       // $grid->country('Country');
        $grid->city('所在市')->display(function ($city){
            if($city){
                return City::select('city_name')
                    ->where('city_id','=',$city)
                    ->first()['city_name'];
            }else{
                return '保密';
            }
        });
        //$grid->citycode('Citycode');
        $grid->qq_name('QQ昵称')->display(function ($qq_name){
            if(!$qq_name){
                return '无';
            }else{
                return $qq_name;
            }
        });
        $grid->level('等级');
        $grid->experience('经验');
        $grid->is_close('是否封号')->display(function ($is_close){
            if(!$is_close){
                return '否';
            }else{
                return '是';
            }
        });
        // $grid->close_start('封号开始时间');
        // $grid->close_days('封号时长');
        // $grid->is_expert('是否专家');
        // $grid->is_fantastic('是否牛人');
        // $grid->qq_token('Qq token');
        //$grid->area('Area');
        //  $grid->address('联系地址');
        //$grid->focus_ids('Focus ids');
        // $grid->fans_ids('Fans ids');
        //$grid->focus_num('关注数');
        //$grid->fans_num('粉丝数');
        //$grid->job('职业');
        //$grid->edu('教育背景');
        //  $grid->donotsee_ids('Donotsee ids');
        // $grid->card_background_image('Card background image');

        $grid->last_ip('最后登录的IP');




        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        //$show->id('Id');
        $show->name('名字');
        $show->avatar('头像')->unescape()->as(function ($avatar){
            return "<img src='{$avatar}' style='width: 200px;height: 200px;' />";
        });
        $show->sex('性别')->as(function ($sex){
            if($sex==1){
                return '男';
            }elseif ($sex==2){
                return '女';
            }else{
                return '保密';
            }
        });
        $show->description('个性签名');
        $show->email('Email');

       // $show->email_verified_at('Email verified at');
       // $show->password('Password');
       // $show->remember_token('Remember token');
        //$show->created_at('Created at');
        //$show->updated_at('Updated at');

        $show->age('年龄')->as(function (){
            $birthday = strtotime($this->birthday);//int strtotime ( string $time [, int $now ] )
            $year = date('Y', $birthday);
            if(($month = (date('m') - date('m', $birthday))) < 0){
                $year++;
            }else if ($month == 0 && date('d') - date('d', $birthday) < 0){
                $year++;
            }
            return date('Y') - $year;
        });
        $show->birthday('生日');
        $show->province('所在省')->as(function ($province){
            if($province){
                return Province::select('province_name')
                    ->where('province_id','=',$province)
                    ->first()['province_name'];
            }else{
                return '保密';
            }
        });
        //$show->country('Country');
        $show->city('所在市')->as(function ($city){
            if($city){
                return City::select('city_name')
                    ->where('city_id','=',$city)
                    ->first()['city_name'];
            }else{
                return '保密';
            }
        });
        $show->area('所在区')->as(function ($area){
            if($area){
                return Area::select('area_name')
                    ->where('area_id','=',$area)
                    ->first()['city_name'];
            }else{
                return '保密';
            }
        });
        $show->address('联系地址');
       // $show->citycode('Citycode');
        $show->qq_name('QQ昵称');
        $show->is_close('是否封号')->as(function ($is_close){
            if(!$is_close){
                return '否';
            }else{
                return '是';
            }
        });
        if(User::find($id)->is_close){
            $show->close_start('封号开始时间');
            $show->close_days('封号时长(天)');
        }


        $show->level('等级');
        $show->experience('经验');
        $show->is_expert('是否专家号')->as(function ($is_expert){
            return $is_expert==1?'是':'否';
        });
        $show->is_fantastic('是否牛人号')->as(function ($is_fantastic){
            return $is_fantastic==1?'是':'否';
        });
       // $show->qq_token('Qq token');

        //$show->focus_ids('Focus ids');
        //$show->fans_ids('Fans ids');
        //$show->focus_num('Focus num');
        $show->fans_num('粉丝数');
        $show->job('职业');
        $show->edu('教育背景');
        //$show->donotsee_ids('Donotsee ids');
       // $show->card_background_image('Card background image');
        $show->last_ip('最后登录ip');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->display('id', 'ID');
        //$form->text('name', 'Name');
        //$form->image('avatar', 'Avatar');
        //$form->number('sex', 'Sex');
        //$form->textarea('description', 'Description');
        //$form->email('email', 'Email');
        //$form->datetime('email_verified_at', 'Email verified at')->default(date('Y-m-d H:i:s'));
        //$form->password('password', 'Password');
       // $form->text('remember_token', 'Remember token');
        //$form->number('age', 'Age');
        //$form->date('birthday', 'Birthday')->default(date('Y-m-d'));
        //$form->text('province', 'Province');
        //$form->text('country', 'Country');
       // $form->text('city', 'City');
        //$form->text('citycode', 'Citycode');
        //$form->text('qq_name', 'Qq name');

        $is_close = ['1'=>'是','0'=>'否'];

        $form->select('is_close', '是否封号')->options($is_close);
        $form->datetime('close_start', '封号开始时间');
        $form->number('close_days', '封号时长（天）');
        $form->number('level', '等级');
        $form->number('experience', '经验');
        $form->select('is_expert', '是否专家号')->options($is_close);
        $form->select('is_fantastic', '是否牛人号')->options($is_close);
        //$form->text('qq_token', 'Qq token');
       // $form->text('area', 'Area');
       // $form->text('address', 'Address');
        //$form->textarea('focus_ids', 'Focus ids');
        //$form->textarea('fans_ids', 'Fans ids');
       // $form->number('focus_num', 'Focus num');
        //$form->number('fans_num', 'Fans num');
        //$form->text('job', 'Job');
       // $form->text('edu', 'Edu');
        //$form->textarea('donotsee_ids', 'Donotsee ids');
        //$form->text('card_background_image', 'Card background image');
        //$form->text('last_ip', 'Last ip');·
      //  $form->setAction('/auth/web_users/'.$id.'/save');
        return $form;
    }
}
