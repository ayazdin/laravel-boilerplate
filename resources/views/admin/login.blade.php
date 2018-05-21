@extends('admin.layouts.login-app')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="{{url('/images/yalamart-logo.jpg')}}" alt="Nepal Auto" width="100%" /><!--<b>YalaMart</b>--></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    @if (session('err') == "invalid")
    <script type="text/javascript">setTimeout(function(){$(".loginAlert").slideUp(500,function(e){$(".loginAlert").remove();});}, 6000);</script>
    <p class="loginAlert">Email or password is incorrect</p>
    @endif
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="/login" method="post">
      {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input id="email" type="email" name="email" value="" required="required" autofocus="autofocus" class="form-control">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" type="password" name="password" required="required" class="form-control">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!--<div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>-->
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <!--<a href="register.html" class="text-center">Register a new membership</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
