@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link @yield('profile')" href="{{ route('profile') }}">profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('twoFactor')" href="{{ route('two.factor.auth') }}">two factor
                                    authentication</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @yield('orders')" href="{{ route('get.orders') }}">orders</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @yield('main')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
