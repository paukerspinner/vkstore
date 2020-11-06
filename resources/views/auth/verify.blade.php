@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Nhập mã xác thực được gửi tới số điện thoại.') }}

                    <form method="POST" action="{{ route('verify.create') }}">
                        @csrf
                        <input id="code" type="text" class="form-inline" name="code">
                        <div class="form-inline">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                    {{-- 
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>.
                    </form>
                    --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
