@extends('user::profile.layout')
@section('profile','')
@section('twoFactor','active')
@section('main')
    <h4>two factor authentication</h4>
    <hr>
    <form action="{{route('two.factor.auth')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="type">type</label>
            <select name="type" id="type" class="form-control">
                @foreach(config('twoFactor.type') as $key => $name)
                    <option
                        value="{{$key}}" {{auth()->user()->two_factor_type === $key || old('type') === $key ? "selected":""}}>{{$name}}</option>
                @endforeach
            </select>
        </div>
        {!! $errors->first('type', '<p class="help-block" style="color:red">:message</p>') !!}

        <div class="form-group">
            <label for="phone">phone</label>
            <input type="text" name="phone" id="phone" value="{{old('phone') ?? auth()->user()->phone_number}}"
                   class="form-control">
        </div>
        {!! $errors->first('phone', '<p class="help-block" style="color:red">:message</p>') !!}
        <div class="form-group">
            <button class="btn btn-primary">
                update
            </button>
        </div>
    </form>
@endsection
