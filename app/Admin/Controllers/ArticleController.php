<?php

namespace App\Admin\Controllers;

use App\Admin\Extentions\CheckButton;
use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends Controller
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
            ->header('文章管理')
            ->description('前台-文章管理')
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
            ->header('文章详情')
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * check interface.
     *
     * @param Request $request
     *
     * @return re
     */
    public function check(Request $request){
        $id = $request->id;
        $is_checked = $request->is_checked;
        $article = Article::find($id);
        $article->is_checked = $is_checked==1?0:1;
        $message =  '反审成功';
        if($article->is_checked){
            $message =  '审核成功';

            $article->checked_uid=Auth::id();
            $article->checked_time = date('Y-m-d H:i:s');
        }
        $re  = $article->save();

        admin_toastr($message,'success');

        return  response()->json([
            'status'  => true,
            'message' => $message,
        ]);


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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $grid->filter(function ($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();


        });



        $grid->id('Id');
        $grid->user_id('作者')->display(function ($user_id){
            $u=User::find($user_id);
            if($u){
                $name=$u->name;
            }else{
                $name = '佚名';
            }
            return $name;
        });

        $grid->title('标题');

        //$grid->content('内容');

        $grid->category('类别')->display(function (){
            $c = Category::find($this->category);
          //  return $this->category;
            if($c){
                $name=$c->name;
            }else{
                $name = '未知';
            }
            return $name;
        });
        $grid->created_at('创建时间')->sortable();
      //  $grid->updated_at('更新时间');
        $grid->click('点击')->sortable();
        $grid->zan('获赞')->sortable();
        $grid->cai('获踩')->sortable();

        $grid->collect_num('收藏')->sortable();
        //$grid->title_pic('引导图');
        $grid->is_top('置顶')->display(function ($is_top){
            if($is_top){
                $v='是';
            }else{
                $v='否';
            }
            return $v;
        });
        $grid->is_checked('审核通过')->display(function ($is_checked){
            if($is_checked){
                $v='是';
            }else{
                $v='否';
            }
            return $v;
        });
        //$grid->checked_time('审核时间');
        $grid->checked_uid('审核人')->display(function ($checked_uid){
            if($user = User::find($checked_uid)){
                $v=$user->name;
            }else{
                $v= '系统审核';
            }
            return $v;
        });


        /*将编辑去掉*/
        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableDelete();
        });

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
        $show = new Show(Article::findOrFail($id));

        $show->id('Id');
        $show->user_id('作者')->as(function ($user_id){
            $u=User::find($user_id);
            if($u){
                $name=$u->name;
            }else{
                $name = '佚名';
            }
            return $name;
        });;
        $show->title('标题');
        $show->title_pic('引导图')->file();

        $show->content('内容')->unescape()->as(function ($content){
            return "
                  <textarea 
                  style='margin: 10%'
                  id='ck_content'  
                  cols='16' 
                  disabled='disabled'  
                  name='ck_content' 
                  class='ck_content'>".$content."</textarea>
                 
                  <script src='../../../js/ckeditor/ckeditor.js'></script>
                      <script src='../../../js/jquery.lazyload.js'></script>

                  <script>
                  CKEDITOR.replace( 'ck_content',
                  { 
                    toolbarCanCollapse: true, 
                    toolbarStartupExpanded: false, 
	                format_tags: 'p;h1;h2;h3;pre',
	                skin: 'moonocolor_v1.1',
                    extraPlugins: 'floatpanel,panelbutton,colorbutton,codesnippet',
                    width: '870px' ,
                    height: '1000px'
                  });        
                   window.onload=function () {
                    jQuery('#cke_contents img').lazyload({effect: 'fadeIn'});
        };
                  </script>";
        });

        $show->category('类别')->as(function (){
            $c = Category::find($this->category);
            //  return $this->category;
            if($c){
                $name=$c->name;
            }else{
                $name = '未知';
            }
            return $name;
        });
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->click('点击量');
        $show->zan('获赞数');
        $show->cai('获踩数');
        $show->is_top('是否置顶')->as(function ($is_top){
            if($is_top){
                $v='是';
            }else{
                $v='否';
            }
            return $v;
        });
        $show->collect_num('收藏数');
        $show->is_checked('审核通过')->as(function ($is_checked){
            if($is_checked){
                $v='是';
            }else{
                $v='否';
            }
            return $v;
        });
        $show->checked_time('审核时间');
        $show->checked_uid('审核人')->as(function ($checked_uid){
            if($user = User::find($checked_uid)){
                $v=$user->name;
            }else{
                $v= '系统审核';
            }
            return $v;
        });

        $show->panel()
            ->tools(function ($tools)use ($id) {
                $tools->disableEdit();
                $tools->disableDelete();
                $tools->append(new CheckButton($id));
               // $tools->prepend('<a class="btn btn-sm btn-default form-history-bac" style="float: right;margin-right: 20px;" href="#" onClick="javascript :history.back(-1);"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>');

            });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);

        $form->text('user_id', '作者');
        $form->text('title', '标题');
        $form->textarea('content', '内容');
        $form->number('category', '类别');
        $form->number('click', '点击量');
        $form->number('zan', '获赞数');
        $form->number('cai', '获踩数');
        $form->number('is_top', '是否置顶');
        $form->number('collect_num', '收藏数');
        $form->text('title_pic', '引导图');
        $form->number('is_checked', '审核通过');
        $form->datetime('checked_time', '审核时间')->default(date('Y-m-d H:i:s'));
        $form->number('checked_uid', '审核人');

        return $form;
    }
}
