@extends('layouts.app', [
    'class' => 'login-page',
    'backgroundImagePath' => 'img/bg/fabio-mangione.jpg'
])

@section('content')


    <div class="content" style="margin: 0 auto ">
        <div class="container" style="margin-top: 0;">
            <div class="col-lg-5 col-md-7 ml-auto mr-auto">
                <img src="{{ asset('paper') }}/img/cdhu.png" data-aos="fade-in" data-aos-delay="300" style="margin-bottom: 10px; text-align:center">
                <form class="form" method="POST" action="{{ route('login') }}" data-aos="fade-up" data-aos-delay="0">
                    @csrf
                    <div class="card card-login" style="border-radius: 12px; box-shadow: 5px 6px 10px -4px rgb(0 0 0 / 55%);">
                        <div class="card-header ">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Entrar') }}</h3>
                            </div>
                        </div>
                        <div class="card-body" style="margin-top: -40px;">                    
                            

                            <div class="md-form">
                                <i class="nc-icon nc-single-02 prefix"></i>
                                <input type="email" name="email" id="form8" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
                                <label for="form8" data-error="wrong" data-success="right">Email</label>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="md-form" style=" margin-top: 50px">
                                <i class="nc-icon nc-lock-circle-open prefix"></i>
                                <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required>
                                <label for="password" data-error="wrong" data-success="right">Senha</label>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            

                            

                            <div class="form-group" style="margin-top: 50px;">
                                <!-- <div class="form-check">
                                     <label class="form-check-label">
                                        <input class="form-check-input" name="remember" type="checkbox" value="" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="form-check-sign"></span>
                                        {{ __('Lembrar') }}
                                    </label>
                                </div> -->
                                   
                            </div>
                        </div>

                        <div class="card-footer" style="margin-top: -20px;">
                            <div class="text-center">
                                <button type="button" data-toggle="modal" data-target="#myModal_video" class="btn btn-outline-success btn-sm btn-rounded waves-effect " style="background: #FFF;"><i class="fas fa-video" style="margin-right: 10px;"></i>EXPLICANDO AS MUDANÇAS</button>  <br/><br/>
                                <button type="submit" class="     btn btn-outline-info btn-round btn-rounded waves-effect"> <i class="nc-icon nc-tap-01"></i> Entrar</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- <a href="{{ route('password.request') }}" class="btn btn-link">
                    {{ __('Forgot password') }}
                </a>
                <a href="{{ route('register') }}" class="btn btn-link float-right">
                    {{ __('Create Account') }}
                </a> -->

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush