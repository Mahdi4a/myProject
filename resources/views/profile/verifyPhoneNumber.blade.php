@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        active phone number
                    </div>
                    <div class="card-body">
                        <form action="{{ route('verify.phone') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control @error('code') 'is-invalid' @enderror" name="code">
                            </div>
                            {!! $errors->first('code', '<p class="help-block" style="color:red">:message</p>') !!}

                            <div class="form-group">
                                <button class="btn btn-primary">Validate Code</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
