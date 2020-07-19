@extends('layouts.front_page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h4 class="head5 font-weight-bold mt-4 pt-2">Connecting People Amidst Corona </h4>

            <img src="{{ asset('img/main.png') }}" class="img-fluid" alt="Responsive image">
        </div>
        <div class="col-5 rightbodytext">
            <h1>Create an account</h1>
            <p class="lead">It's quick and easy.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="fname" placeholder="First name" name="fname" required autocomplete="given-name" autofocus>
                    </div>
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="lname" placeholder="Last name" name="lname" required autocomplete="family-name">
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">

                    <input type="email" class="form-control @if($errors->has('email') && !old('loginform')) is-invalid @endif" id="email" name="email" placeholder="Email address" @if($errors->has('email') && !old('loginform')) value="{{ old('email') }} @endif" required autocomplete="email">
                    @if($errors->has('email') && !old('loginform'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email')  }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">

                    <input type="password" class="form-control @if($errors->has('password') && !old('loginform')) is-invalid @endif" id="password" placeholder="New password" required autocomplete="new-password" name="password">
                    @if($errors->has('password') && !old('loginform'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password')  }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">

                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Re-enter password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="inputAddress2" class="font-weight-bold text-muted">Birthday</label>
                    <div class="row">
                        <div class="col-3">
                            <select class="custom-select" id="day" name="day" autocomplete="bday-day">
                                <option selected>Day</option>
                                @for ($i = 1; $i <= 31; $i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="custom-select" id="month" name="month" autocomplete="bday-month">
                                <option selected>Month</option>
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="custom-select" id="year" name="year" autocomplete="bday-year">
                                <option selected>Year</option>
                                <?php $last = date('Y') - 120; ?>
                                <?php $now = date('Y'); ?>
                                {{$now." ".$last}}
                                @for ($i = $now; $i >= $last; $i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress2" class="font-weight-bold text-muted">Gender</label>
                    <div class="row ml-2">
                        <div class="col-3">
                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="Male" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Male
                            </label>
                        </div>
                        <div class="col-3">
                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="Female">
                            <label class="form-check-label" for="exampleRadios2">
                                Female
                            </label>
                        </div>
                        <div class="col-3">
                            <input class="form-check-input" type="radio" name="gender" id="exampleRadios3" value="Others">
                            <label class="form-check-label" for="exampleRadios3">
                                Others
                            </label>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <small>
                        <div class="text-muted">By clicking Sign Up, you agree to our Terms, Data Policy and Cookie Policy. You may receive SMS notifications from us and can opt out at any time.</div>
                    </small>
                </div>
                <button type="submit" class="btn sign-up">Sign Up</button>
            </form>

        </div>
    </div>
</div>
@endsection