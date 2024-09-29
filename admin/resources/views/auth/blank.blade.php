@extends('shared.auth.base')
@section('title', __('Forgot password'))

@section('content')
    <div class="w-full flex justify-center items-center p-4 lg:w-1/2">
        <div class="w-full lg:w-2/3 flex flex-col gap-4">
            <a href="{{ route('views.login.index') }}" class="block w-36 mx-auto" aria-label="login_page_link">
                <img src="{{ asset('img/logo.webp') }}?v={{ env('APP_VERSION') }}" alt="{{ env('APP_NAME') }} logo image"
                    class="block w-full" width="916" height="516" loading="lazy" />
            </a>
            <form validate action="{{ route('actions.blank.index') }}" method="POST"
                class="w-full flex flex-col gap-6 p-6 bg-x-white rounded-x-thin shadow-x-core">
                <p class="text-base text-x-black">
                    {{ __('Forgot your password? No problem. Just tell us your email, and we will send you a link that will allow you to choose a new password') }}
                </p>
                @csrf
                <div class="flex flex-col gap-1">
                    <label class="text-x-black font-x-thin text-base">
                        {{ __('Email') }} (*)
                    </label>
                    <neo-textbox rules="required|email"
                        errors='{"required": "{{ __('The email field is required') }}", "email": "{{ __('The email field must be a valid email') }}"}'
                        type="email" placeholder="{{ __('Email') }} (*)" name="email"
                        value="{{ old('email') }}"></neo-textbox>
                </div>
                <neo-button
                    class="w-full text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                    <span>{{ __('Send') }}</span>
                </neo-button>
            </form>
        </div>
    </div>
    <div style="background-image: url({{ asset('img/bg-blank.webp') }}?v={{ env('APP_VERSION') }})"
        alt="{{ env('APP_NAME') }} blank background image"
        class="block bg-center bg-cover bg-no-repeat fixed w-full h-[100dvh] inset-0 z-[-1] lg:w-1/2 lg:relative">
        <div class="absolute inset-0 w-full h-full bg-x-black bg-opacity-30 backdrop-blur-sm"></div>
    </div>
@endsection
