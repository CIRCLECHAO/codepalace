/*写评论判断有无登录*/
// $('.cke_editable').click(function () {
//     if($('.drop-down-list .menu').children('.login').length>0){
//         $('.login').click();
//     }
// })
/*获取自己的ckeditor*/
$(document).ready(function(){
    // $('#editor').ckeditor(ckeditor_config);
    CKEDITOR.instances.editor.on('focus',function () {
        if($('.drop-down-list .menu').children('.login').length>0){
            $('.login').click();
        }
    });
});
/**/
