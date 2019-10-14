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
            position: relative!important;
            /* top: 0; */
            /* right: 0; */
            /* padding: .375rem .75rem; */
            line-height: 1.6;
            color: #495057;
        }
        .avatar.form-inline img {
            width: 100px;
            height: 100px;
        }
    </style>
    <div class="content">
        <form action="{{URL('save_suggestion')}}" class="form-group" method="POST" >
            <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
            @csrf
            <br>
            <div class="title form-inline">
                标题:&nbsp;&nbsp;<input class="form-control" name="title" value="">
            </div>
            <br>
            <div class= "form-inline">类别:&nbsp;&nbsp;
                <select name="variety" class="form-control">
                        <option value="1">建议</option>
                        <option value="2">反馈</option>
                </select>
            </div>
            <br>
            <div>
                内容:<textarea id="editor" cols="5" rows="2" name="content" class="ckeditor"></textarea> <br>

            </div>

            <input style="float: left" class="tj" type='submit' class='pure-button pure-button-default' value=" 提交 ">
        </form>
    </div>
@endsection
