@extends('home.default1')
@section('content')
    <style>

        .content {
            /* margin: -3px; */
            margin-left: 200px;
            margin-right: 100px;
            /*border-bottom:  1px solid rgba(0,0,0,0.2);
            border-top:  1px solid rgba(0,0,0,0.2);*/
        }
        input.custom-file-label {
            opacity: 0;
            position: absolute;
            left: 39px;
            top: 0px;
            width: 150px;
            height: 100px;
            /* position: relative!important; */
            /* top: 0; */
            /* right: 0; */
            /* padding: .375rem .75rem; */
            line-height: 1.6;
            color: #495057;
        }
        .title_pic.form-inline img {
            width: 150px;
            height: 100px;
        }
        .title_pic.form-inline {
            position: relative;
        }
    </style>
    <div class="content">
    <form action="{{URL('save_article')}}" class="form-group" method="POST" enctype="multipart/form-data">
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        @csrf
        <br>
        <div class="title form-inline">
            标题:&nbsp;&nbsp;<input class="form-control" name="title" value="">
        </div>
        <br>
        <div class="title_pic form-inline">
            引导图:
            <img id="title_pic" src="{{ asset('images/code.jpg') }}"/>
                &nbsp;&nbsp;<input name="title_pic" id="upload-file"
                                   onchange="xmTanUploadImg(this,'title_pic')" type="file" accept="image/*" class="custom-file-label">
            <p class="help-block">点击图片上传文件 支持jpg、jpeg、png、gif格式，大小不超过2.0M</p>
        </div>
        <br>
        <div class= "form-inline">话题:&nbsp;&nbsp;
            <select name="category" class="form-control">
                @foreach($category as $k=>$v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            内容:<textarea id="editor" cols="5" rows="2" name="content" class="ckeditor"></textarea> <br>

        </div>

        <input style="" class="tj" type='submit' class='pure-button pure-button-default' value=" 发布 ">
    </form>
    </div>
@endsection
