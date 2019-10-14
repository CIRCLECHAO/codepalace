<?php
/**
 * Created by PhpStorm.
 * User: YUAN C
 * Date: 2019/2/28
 * Time: 14:12
 */

namespace App\Admin\Extentions;
use App\Article;
use Encore\Admin\Admin;
/**
 * 审核按钮OR反审按钮！
 */
class CheckButton
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->article = Article::find($this->id);

    }

    protected function script()
    {
        $url = "../web_articles/check";
        $checked = $this->article->is_checked;
        return <<<SCRIPT
$('.check_article').on('click', function () {
     $.ajax({
        type : "POST",
        url : "$url",
        dataType : "json",
        data : {
            'id':"$this->id",
            'is_checked':"$checked",
            '_token': LA.token
        },
        success : function(test) {
        
            window.location.reload();
        },
    });
});

SCRIPT;
    }

    protected function render()
    {

        Admin::script($this->script());

        if($this->article->is_checked){
            return "<a class='btn btn-sm btn-default check_article' style='float: right;margin-right: 20px;'  data-id='{$this->id}'>
                   <i class='fa fa-times'></i>
                   <span class='hidden-xs'>反审</span>
                   </a>";
        }else{
            return "<a class='btn btn-sm btn-default check_article' style='float: right;margin-right: 20px;'  data-id='{$this->id}'>
                   <i class='fa fa-check-square'></i>
                   <span class='hidden-xs'>审核</span>
                   </a>";
        }


    }

    public function __toString()
    {
        return $this->render();
    }
}