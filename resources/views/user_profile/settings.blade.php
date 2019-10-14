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
            left: 55px;
            top: 0px;
            width: 100px;
            height: 100px;
            /* position: relative!important; */
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
        .card_background_image.form-inline img {
            width: 100px;
            height: 100px;
        }
        .avatar.form-inline {
             position: relative;
        }
        .card_background_image.form-inline {
            position: relative;
        }
    </style>
    <script type="text/javascript">
        //判断浏览器是否支持FileReader接口
        if (typeof FileReader == 'undefined') {
            document.getElementById("upload-file").InnerHTML = "<h1>当前浏览器不支持FileReader接口</h1>";
            //使选择控件不可操作
            document.getElementById("upload-file").setAttribute("disabled", "disabled");
        }


    </script>
    <div class="content">
        <br>
    <form action="{{URL('user/save_settings')}}" class="form-group" method="POST" enctype="multipart/form-data">
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        @csrf
        <div class="avatar form-inline">
            头&nbsp;&nbsp;&nbsp;&nbsp;像:&nbsp;&nbsp;
            <img id="up-avatar" src="{{$user_info->avatar}}"/>
            &nbsp;&nbsp;<input name="avatar" id="upload-file"
                               onchange="xmTanUploadImg(this,'up-avatar')" type="file" accept="image/*" class="custom-file-label">
            <p class="help-block">点击图片上传文件 支持jpg、jpeg、png、gif格式，大小不超过2.0M</p>
        </div>

        <br>


        <div class="card_background_image form-inline">
            名片背景:&nbsp;&nbsp;
            <img id="up-card_background_image" src="{{$user_info->card_background_image}}"/>
            &nbsp;&nbsp;<input name="card_background_image" id="upload-file"
                               onchange="xmTanUploadImg(this,'up-card_background_image')" type="file" accept="image/*" class="custom-file-label">
            <p class="help-block">点击图片上传文件 支持jpg、jpeg、png、gif格式，大小不超过2.0M</p>
        </div>

        <br>

        <div class="name form-inline">
            用户名:&nbsp;&nbsp;<input class="form-control" name="name" value="{{$user_info->name}}">
        </div>
        <br>

        <div class="sex form-inline">性&nbsp;&nbsp;&nbsp;&nbsp;别:&nbsp;&nbsp;
            <select name="sex" class="form-control">
                @if ($user_info->sex==0)
                    <option value="0" selected="selected">保密</option>
                @else
                    <option value="0">保密</option>

                @endif
                    @if ($user_info->sex==1)
                        <option value="1" selected="selected">男</option>
                    @else
                        <option value="1">男</option>

                    @endif
                    @if ($user_info->sex==2)
                        <option value="2" selected="selected">女</option>
                    @else
                        <option value="2">女</option>

                    @endif
            </select>
        </div>
        <br>
        <div class="birthday form-inline">
            生&nbsp;&nbsp;&nbsp;日:&nbsp;&nbsp;&nbsp;<input class="form-control" id="datepicker" type="date" name="birthday" value="{{$user_info->birthday}}">
        </div>
        <br>
        <div class="form-inline">E-MAIL:&nbsp; <input class="form-control" name="email" value="{{$user_info->email}}"></div>
        <br>

        <div class="location form-inline">
            区&nbsp;&nbsp;&nbsp;域:&nbsp;&nbsp;&nbsp;
            <select name="country" onchange="get_province(this,1)" class="form-control">
                @if ($user_info->country==0)
                    <option value="0" selected="selected">选择国家</option>
                    <option value="1">中国</option>
                @else
                    <option value="0" >选择国家</option>
                    <option value="1" selected="selected">中国</option>
                @endif
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <select name="province" onchange="get_province(this,2)" class=" province form-control">
                <option value="0" >选择省份</option>
            @if($provinces??null)
             @foreach($provinces as $v)
                @if ($user_info->province==$v->province_id)
                            <option value="{{ $v['province_id'] }}" selected="selected">{{ $v->province_name }}</option>
                @else
                            <option value="{{ $v['province_id'] }}" >{{ $v->province_name }}</option>
                @endif
             @endforeach
                    @endif
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <select name="city" onchange="get_province(this,3)" class="city form-control">
                <option value="0" >选择城市</option>

            @if($cities??null)

                @foreach($cities as $v)
                    @if ($user_info->city==$v->city_id)
                            <option value="{{ $v['city_id'] }}" selected="selected">{{ $v->city_name }}</option>
                    @else
                            <option value="{{ $v['city_id'] }}" >{{ $v->city_name }}</option>
                    @endif
                @endforeach
                    @endif
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <select name="area" class="area form-control">
                <option value="0" >选择区/县</option>

            @if($areas??null)

                @foreach($areas as $v)
                    @if ($user_info->area==$v->area_id)
                            <option value="{{ $v['area_id'] }}" selected="selected">{{ $v->area_name }}</option>
                    @else
                            <option value="{{ $v['area_id'] }}" >{{ $v->area_name }}</option>
                    @endif
                @endforeach
                    @endif
            </select>
        </div>
        <br>

        <div class="address form-inline">
            地&nbsp;&nbsp;&nbsp;址:&nbsp;&nbsp;<input class="form-control col-5" name="address" value="{{$user_info->address}}">
        </div>
        <br>
        <div class="description form-inline">
            个性签名:&nbsp;<input class="form-control col-5" maxlength="15" name="description" value="{{$user_info->description}}">
            {{--<textarea id="editor" cols="5" rows="2" name="description" class="ckeditor">{{$user_info->description}}</textarea>--}} <br>

        </div>
        <input style="" class="tj" type='submit' class='pure-button pure-button-default' value=" 保存 ">
    </form>
    </div>
    <script>
        function get_province(con,type) {
            id = con.value;
            post_data = null;
            if(type==1){
                if(id==1){
                   post_data = {'_token':'{{csrf_token()}}','type':type};
                   op_obj = 'province';
                }
                $('.province').empty();
                $('.city').empty();
                $('.area').empty();
            }else if(type==2){
                op_obj = 'city';
                post_data = {'_token':'{{csrf_token()}}','type':type,'pid':id};
                $('.city').empty();
                $('.area').empty();
            }else if(type==3){
                op_obj = 'area';
                post_data = {'_token':'{{csrf_token()}}','type':type,'pid':id};
                $('.area').empty();

            }
            if(post_data){
                $.post('/get_geography_info',post_data,function(data)
                {
                    //console.log(data);
                    $('.'+op_obj).append('<option value="0">--请选择--</option>');
                    for(i=0;i<data.length;i++){
                        $('.'+op_obj).append('<option value="'+data[i].code+'">'+data[i].name+'</option>')
                    }
                });
            }



        }

    </script>
@endsection
