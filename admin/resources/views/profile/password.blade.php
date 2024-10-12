@extends('shared.core.base')
@section('title', __('Update password'))

@section('content')
    <form validate action="{{ route('actions.password.patch') }}" method="POST"
        class="w-full grid grid-rows-1 grid-cols-1 p-6 bg-x-white rounded-x-thin shadow-x-core gap-6">
        @csrf
        @method('patch')
        <div class="flex flex-col gap-1">
            <label class="text-x-black font-x-thin text-base">
                {{ __('Old password') }} (*)
            </label>
            <neo-password rules="required" errors='{"required": "{{ __('The old password field is required') }}"}'
                placeholder="{{ __('Old password') }} (*)" name="old_password"
                value="{{ old('old_password') }}"></neo-password>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-x-black font-x-thin text-base">
                {{ __('New password') }} (*)
            </label>
            <neo-password rules="required" errors='{"required": "{{ __('The new password field is required') }}"}'
                placeholder="{{ __('New password') }} (*)" name="new_password"
                value="{{ old('new_password') }}"></neo-password>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-x-black font-x-thin text-base">
                {{ __('Confirm password') }} (*)
            </label>
            <neo-password rules="required|match:new_password" rules="required"
                errors='{"required": "{{ __('The confirm password field is required') }}", "match": "{{ __('The confirm password field must match the new password field') }}"}'
                placeholder="{{ __('Confirm password') }} (*)" name="confirm_password"
                value="{{ old('confirm_password') }}"></neo-password>
        </div>
        <div class="w-full flex">
            <neo-button
                class="w-max px-6 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                <span>{{ __('Save') }}</span>
            </neo-button>
        </div>
    </form>
@endsection
