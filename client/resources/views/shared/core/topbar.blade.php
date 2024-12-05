<neo-topbar transparent align="space-between"
    class="main-topbar bg-x-prime md:bg-transparent shadow-x-core md:shadow-none md:py-4">
    <div class="lg:flex-1 min-w-max flex flex-wrap gap-4 items-center">
        <button id="trigger" onclick="sidebar.toggle()" aria-label="sidebar_trigger"
            class="flex w-8 h-8 items-center justify-center text-x-white md:text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
            <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                <path
                    d="M129-215q-20.75 0-33.375-12.675Q83-240.351 83-261.175 83-280 95.625-293T129-306h458q19.75 0 32.375 13.175 12.625 13.176 12.625 32Q632-240 619.375-227.5 606.75-215 587-215H129Zm0-221q-20.75 0-33.375-13.175Q83-462.351 83-482.175 83-502 95.625-514.5 108.25-527 129-527h339q18.75 0 31.875 12.675Q513-501.649 513-481.825 513-462 499.875-449 486.75-436 468-436H129Zm0-218q-20.75 0-33.375-13.175Q83-680.351 83-700.175 83-720 95.625-733 108.25-746 129-746h458q19.75 0 32.375 13.175 12.625 13.176 12.625 33Q632-680 619.375-667 606.75-654 587-654H129Zm605 173 114 113q13 14 12.5 33T847-304q-15 14-33.5 14T782-304L637-450q-14-13-14-31t14-32l145-146q13-13 31.5-13t33.5 13q13 14 12.5 33T847-594L734-481Z" />
            </svg>
        </button>
    </div>
    <h1
        class="lg:flex-[3] me-auto md:me-0 lg:text-center text-x-white md:text-x-black font-x-thin text-base md:text-2xl">
        @yield('title')
    </h1>
    <div class="lg:flex-1 min-w-max items-center justify-end flex flex-wrap gap-1">
        <neo-dropdown id="notify" label="{{ __('Notifications') }}"
            position="{{ Core::lang('ar') ? 'start' : 'end' }}">
            <button id="notify_trigger" slot="trigger" aria-label="notifications_trigger"
                class="flex w-8 h-8 items-center justify-center text-x-white md:text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M139-179v-91h71v-278q0-91.69 51.5-166.35Q313-789 405-810v-17q0-30.58 21.84-53.29T479.88-903q31.2 0 53.16 22.71Q555-857.58 555-827v17q91 19 144 94.39T752-548v278h71v91H139ZM480.46-51q-36.94 0-62.2-25.85Q393-102.7 393-139h175q0 37-25.95 62.5T480.46-51Z" />
                </svg>
            </button>
            <ul class="w-full flex flex-col lg:w-[400px]">
                <li>
                    <ul id="notify_content" class="w-full flex flex-col"></ul>
                </li>
                <li
                    class="w-full px-4 py-2 bg-x-white flex justify-center items-center sticky left-0 right-0 bottom-0 border-t border-x-shade">
                    <a href="{{ route('views.core.notify') }}"
                        class="w-max text-sm font-x-thin text-x-prime underline underline-offset-2">
                        {{ __('view notifications') }}
                    </a>
                </li>
            </ul>
        </neo-dropdown>
        <neo-dropdown label="{{ __('System') }}" position="{{ Core::lang('ar') ? 'start' : 'end' }}">
            <button slot="trigger" aria-label="setting_trigger"
                class="flex w-8 h-8 items-center justify-center text-x-white md:text-x-black outline-none rounded-x-thin !bg-opacity-5 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M408-59q-18 0-31-10.5T363-98l-15-94q-14-4-31-14t-28-19l-86 41q-15 6-32.5 1.5T144-204L72-332q-10-16-5-32.5T85-391l80-59q-1-5-1-14.5v-30q0-8.5 1-15.5l-81-58q-13-11-17.5-27.5T72-628l72-127q9-16 26.5-21t32.5 0l88 41q10-7 27-17t30-14l15-98q1-16 14.5-27t31.5-11h143q17 0 30.5 11t15.5 27l14 97q15 4 31.5 14t27.5 18l86-41q15-5 32.5 0t26.5 21l73 126q9 16 5 33t-19 28l-81 55q1 8 2.5 17t1.5 16q0 7-1.5 15.5T794-449l81 58q13 10 18.5 26.5T890-332l-74 128q-10 17-27 21.5t-32-1.5l-86-41q-11 9-28.5 19.5T613-192l-15 94q-2 18-15 28.5T552-59H408Zm71-294q53 0 90-37t37-90q0-52-37-89.5T479-607q-54 0-90.5 37.5T352-480q0 53 36.5 90t90.5 37Z" />
                </svg>
            </button>
            <ul class="sys-colors w-full lg:w-[170px] flex flex-col">
                <li class="w-full">
                    <a href="{{ route('views.profile.patch') }}"
                        class="w-full flex flex-wrap gap-2 px-4 py-2 text-start items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ request()->routeIs('views.profile.patch') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M310-279h340v-23q0-45.622-44.534-69.811Q560.931-396 479.966-396 399-396 354.5-371.811T310-302v23Zm170.044-184q33.431 0 55.693-22.975Q558-508.95 558-542.212q0-33.263-22.343-55.525Q513.314-620 479.832-620t-55.657 22.431Q402-575.139 402-542t22.307 56.069Q446.613-463 480.044-463ZM150-99q-37.175 0-64.088-26.594Q59-152.188 59-190v-495q0-36.588 26.912-64.294Q112.825-777 150-777h133l55-65q12.136-16 30.508-24 18.373-8 38.492-8h148q18.125 0 36.562 8Q610-858 623-842l55 65h132q37.225 0 64.613 27.706Q902-721.588 902-685v495q0 37.812-27.387 64.406Q847.225-99 810-99H150Z" />
                        </svg>
                        <span class="block flex-1 text-base text-start">{{ __('Profile') }}</span>
                    </a>
                </li>
                <li class="w-full">
                    <a href="{{ route('views.password.patch') }}"
                        class="w-full flex flex-wrap gap-2 px-4 py-2 text-start items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ request()->routeIs('views.password.patch') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="M229-62q-36.775 0-63.888-27.112Q138-116.225 138-153v-415q0-38.588 27.112-65.294Q192.225-660 229-660h53v-74q0-83.965 57.921-142.483Q397.843-935 479.731-935q81.889 0 140.079 58.517Q678-817.965 678-734v74h53q37.188 0 64.594 26.706Q823-606.588 823-568v415q0 36.775-27.406 63.888Q768.188-62 731-62H229Zm251.248-223Q512-285 533.5-306.615q21.5-21.616 21.5-51.969Q555-388 533.252-412q-21.748-24-53.5-24T426.5-412.064Q405-388.128 405-358.42q0 30.12 21.748 51.77 21.748 21.65 53.5 21.65ZM373-660h214v-73.769q0-47.731-30.973-78.481Q525.054-843 480.235-843q-44.818 0-76.027 30.75Q373-781.5 373-733.769V-660Z" />
                        </svg>
                        <span class="block flex-1 text-base text-start">{{ __('Password') }}</span>
                    </a>
                </li>
                <li class="w-full">
                    <a href="{{ route('views.settings.patch') }}"
                        class="w-full flex flex-wrap gap-2 px-4 py-2 text-start items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ request()->routeIs('views.settings.patch') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                        <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                            <path
                                d="m185-501-14-71q-7.45-4.06-14.73-8.03Q149-584 142-589l-69 21-56-98 54-47v-31l-54-47 56-99 69 22q7-5 14.27-8.97 7.28-3.97 14.73-8.03l14-71h116l15 71q7.45 4.06 14.73 8.03Q338-873 344-868l69-22 57 99-55 47q1 8.25 1 15.5t-1 15.5l55 47-57 98-69-21q-6 5-13.27 8.97-7.28 3.97-14.73 8.03l-15 71H185Zm58.21-156Q273-657 294-677.92t21-51q0-30.08-20.92-50.58t-51-20.5q-30.08 0-50.58 20.71t-20.5 50.5Q172-699 192.71-678t50.5 21ZM590 6l-19-93q-22-6-42.5-17.5T492-133l-87 31-63-107 71-63q-5-22-5-45t5-45l-71-63 63-107 87 31q16-17 36.5-28.5T571-547l19-93h126l19 93q22 6 42 17.5t35 28.5l88-31 63 107-71 63q5 22 5 45t-5 45l71 63-63 107-88-31q-15 17-35 28.5T735-87L716 6H590Zm63-214q45 0 76.5-32t31.5-77q0-45-31.71-77T653-426q-46 0-77.5 31.5T544-317q0 46 31.5 77.5T653-208Z" />
                        </svg>
                        <span class="block flex-1 text-base text-start">{{ __('Settings') }}</span>
                    </a>
                </li>
                <li class="w-full">
                    <form action="{{ route('actions.close.index') }}" method="POST">
                        @csrf
                        <button type="submit" aria-label="logout_trigger"
                            class="w-full flex flex-wrap gap-2 px-4 py-2 text-start items-center outline-none hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent">
                            <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                                <path
                                    d="M635-306q-13-15-13.5-33.125T635-371l64-63H409q-19.775 0-32.388-13.36Q364-460.719 364-479.86q0-20.14 12.612-32.64Q389.225-525 409-525h288l-66-67q-13-12.267-12.5-30.081t14.714-31.866Q644.661-666 664.705-665.5 684.75-665 699-653l141 142q4.909 6.327 8.955 15.008Q853-487.311 853-478.676q0 8.636-4.045 17.106Q844.909-453.1 840-448L699.006-305.089Q686-292 668-293t-33-13ZM181-97q-38.1 0-65.05-26.975Q89-150.95 89-188v-584q0-37.463 26.95-64.731Q142.9-864 181-864h251q20.2 0 33.1 13.763 12.9 13.763 12.9 32.816 0 20.053-12.9 32.737Q452.2-772 432-772H181v584h251q20.2 0 33.1 12.675 12.9 12.676 12.9 32.816 0 19.141-12.9 32.325Q452.2-97 432-97H181Z" />
                            </svg>
                            <span class="block flex-1 text-base text-start">{{ __('Logout') }}</span>
                        </button>
                    </form>
                </li>
            </ul>
        </neo-dropdown>
    </div>
</neo-topbar>
