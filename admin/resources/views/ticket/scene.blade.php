@extends('shared.core.base')
@section('title', __('Preview ticket') . ' #' . $data->id)

@section('content')
    <div class="w-full items-start grid grid-rows-1 grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="flex flex-col p-6 bg-x-white rounded-x-thin shadow-x-core">
            <div class="grid grid-rows-1 grid-cols-1 gap-6">
                <div class="flex flex-col gap-1">
                    <label class="text-x-black font-x-thin text-base">
                        {{ __('Reference') }}
                    </label>
                    <neo-textbox placeholder="{{ __('Reference') }}" value="{{ $data->reference }}" disable></neo-textbox>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-x-black font-x-thin text-base">
                        {{ __('Category') }}
                    </label>
                    <neo-textbox placeholder="{{ __('Category') }}" value="{{ ucfirst(__($data->category)) }}"
                        disable></neo-textbox>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-x-black font-x-thin text-base">
                        {{ __('Status') }}
                    </label>
                    <neo-textbox placeholder="{{ __('Status') }}" value="{{ ucfirst(__($data->status)) }}"
                        disable></neo-textbox>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-x-black font-x-thin text-base">
                        {{ __('Date') }}
                    </label>
                    <neo-textbox placeholder="{{ __('Date') }}"
                        value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat(Core::setting() ? Core::formatsList(Core::setting('date_format'), 1) : 'Y-m-d' . ' H:i') }}"
                        disable></neo-textbox>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex flex-col">
                        <label class="text-x-black font-x-thin text-base">
                            {{ __('Subject') }}
                        </label>
                        <neo-textbox placeholder="{{ __('Subject') }}" value="{{ ucfirst($data->subject) }}"
                            disable></neo-textbox>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:-order-1 lg:col-span-2 flex flex-col p-6 bg-x-white rounded-x-thin shadow-x-core">
            <div class="flex flex-col gap-4">
                <ul class="flex flex-col gap-4 bg-x-light p-6 rounded-x-thin h-[400px] overflow-auto">
                    @foreach ($data->Comments as $comment)
                        <li class="flex flex-wrap">
                            <div
                                class="flex gap-2 flex-col w-max min-w-[30%] max-w-[80%] rounded-x-thin bg-x-white px-4 py-2 {{ $comment->target_type == 'App\\Models\\Admin' ? 'ms-auto' : 'me-auto' }}">
                                <p class="text-x-black text-base">
                                    {!! nl2br($comment->content) !!}
                                </p>
                                <div class="w-full h-px bg-x-light"></div>
                                <p class="text-x-black text-xs w-max ms-auto">
                                    {{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat(Core::setting() ? Core::formatsList(Core::setting('date_format'), 1) : 'Y-m-d') }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if ($data->status !== 'closed')
                    <form validate action="{{ route('actions.tickets.patch', $data->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('patch')
                        <div class="w-full grid grid-rows-1 grid-cols-1 gap-6">
                            <div class="flex flex-col gap-1">
                                <label class="text-x-black font-x-thin text-base">
                                    {{ __('Content') }} (*)
                                </label>
                                <neo-textarea rules="required"
                                    errors='{"required": "{{ __('The content field is required') }}"}'
                                    placeholder="{{ __('Content') }} (*)" name="content" value="{{ old('content') }}"
                                    rows="2" auto="false">
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
                @endif
            </div>
        </div>
    </div>
@endsection
