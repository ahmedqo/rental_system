@extends('shared.core.base')
@section('title', __('New ticket'))

@section('content')
    <form validate action="{{ route('actions.tickets.store') }}" method="POST"
        class="w-full p-6 bg-x-white rounded-x-thin shadow-x-core">
        @csrf
        <div class="w-full grid grid-rows-1 grid-cols-1 gap-6">
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Subject') }} (*)
                </label>
                <neo-textbox rules="required" errors='{"required": "{{ __('The subject field is required') }}"}'
                    placeholder="{{ __('Subject') }} (*)" name="subject" value="{{ old('subject') }}">
                </neo-textbox>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Category') }} (*)
                </label>
                <neo-select rules="required" errors='{"required": "{{ __('The category field is required') }}"}' search
                    placeholder="{{ __('Category') }} (*)" name="category">
                    @foreach (Core::categoriesList() as $category)
                        <neo-select-item value="{{ $category }}" {{ $category == old('category') ? 'active' : '' }}>
                            {{ ucfirst(__($category)) }}
                        </neo-select-item>
                    @endforeach
                </neo-select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-x-black font-x-thin text-base">
                    {{ __('Content') }} (*)
                </label>
                <neo-textarea rules="required" errors='{"required": "{{ __('The content field is required') }}"}'
                    placeholder="{{ __('Content') }} (*)" name="content" value="{{ old('content') }}" rows="5">
                </neo-textarea>
            </div>
            <div class="w-full flex flex-wrap gap-6">
                <neo-button id="save"
                    class="w-max px-10 ms-auto text-base lg:text-lg font-x-huge text-x-white bg-x-prime hover:bg-x-acent focus:bg-x-acent focus-within:bg-x-acent">
                    <span>{{ __('Save') }}</span>
                </neo-button>
            </div>
        </div>
    </form>
@endsection
