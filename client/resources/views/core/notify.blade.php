@extends('shared.core.base')
@section('title', __('Notifications'))

@section('content')
    <div class="w-full items-start grid grid-rows-1 grid-cols-1 gap-1">
        <ul class="w-full flex flex-col gap-1">
            @php
                $recoveries = Core::recoveries();
                $reminders = Core::reminders();

                $all = array_merge(
                    $recoveries
                        ->map(function ($recovery) {
                            return __('Reservation') .
                                ' "' .
                                $recovery->reference .
                                '" ' .
                                ($recovery->dropoff_date < now() ? __('ended at') : __('will end at')) .
                                ' "' .
                                $recovery->dropoff_date .
                                '" <a href="' .
                                route('views.recoveries.patch', $recovery->Recovery->id) .
                                '" class="w-max ms-2 text-sm font-x-thin text-x-prime underline underline-offset-2">' .
                                __('view') .
                                '</a>';
                        })
                        ->toArray(),
                    $reminders
                        ->map(function ($reminder) {
                            return '"' .
                                ucfirst(__($reminder->consumable_name)) .
                                '" ' .
                                __('on') .
                                ' "' .
                                ucfirst(__($reminder->Vehicle->brand)) .
                                ' ' .
                                ucfirst(__($reminder->Vehicle->model)) .
                                ' ' .
                                $reminder->Vehicle->year .
                                ' (' .
                                strtoupper($reminder->Vehicle->registration_number) .
                                ')" ' .
                                __('at') .
                                ' "' .
                                $reminder->view_issued_at .
                                '"';
                        })
                        ->toArray(),
                );
            @endphp
            @if (count($all))
                @foreach ($all as $single)
                    <li
                        class="bg-x-white rounded-x-thin text-x-black p-4 text-base font-x-thin shadow-x-core flex items-center">
                        {!! $single !!}
                    </li>
                @endforeach
            @else
                <li class="bg-x-white rounded-x-thin text-x-black p-6 text-center shadow-x-core">
                    {{ __('No data found') }}
                </li>
            @endif
        </ul>
    </div>
@endsection
