@extends('layouts.loginlayout')

@section('content')

                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}" style="z-index: 1">

                            <input type="email" placeholder="username" value="{{ old('email') }}" name="email" required autofocus><br>

                                @if ($errors->has('email'))
                                    <span class="help-block" style="color: indianred;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="{{ $errors->has('password') ? ' has-error' : '' }}" style="z-index: 1;color: indianred;"        >

                            <input type="password" placeholder="password" name="password" required><br>

                                @if ($errors->has('password'))
                                    <span>
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                            <div class="col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>


                                <input type="submit" value="Login">
                        <div class="col-md-offset-8">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                    </form>

@endsection
