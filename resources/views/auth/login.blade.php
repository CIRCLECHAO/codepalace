@extends('home.default_dcom')

@section('content')
    <style>
        body.dcom{
            overflow: hidden;
        }
        .container {
            padding-left: 0;
            padding-right: 0;
            /*margin-left: 12%;*/
        }

    </style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
         {{--       <div class="card-header">{{ __('auth.Login') }}</div>--}}

                <div class="card-body">
                    {{--2018年11月19日08:40:18 将form改成ajax--}}
                    <form method="" action="{{--{{ route('login') }}--}}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('auth.Remember Me') }}&nbsp;&nbsp;&nbsp;
                                    </label>
                                    第三方登录：<a href="{{URL('/qq')}}"><img style="width: 30px;height: 27px;" src="qq_login.png"></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary btn_login">
                                    {{ __('auth.Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('auth.Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{asset('plugins/layer/layer.js')}}"></script>
    <script src="{{asset('js/login.js')}}"></script>

@endsection
