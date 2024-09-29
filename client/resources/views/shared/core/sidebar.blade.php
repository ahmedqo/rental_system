<neo-sidebar id="sidebar">
    <neo-topbar transparent class="lg:h-[5.5rem]">
        <img src="{{ Core::company() ? Core::company('Image')->Link : asset('img/logo.png') }}?v={{ env('APP_VERSION') }}"
            alt="{{ env('APP_NAME') }} logo image" class="block w-24 m-auto pointer-events-auto" width="916"
            height="516" loading="lazy" />
    </neo-topbar>
    <ul class="nav-colors w-full flex flex-col flex-1 mt-6 lg:mt-0">
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.core.index') }}" aria-label="dashboard_page_link"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('dashboard') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M99-425v-356q0-32.025 24.194-56.512Q147.387-862 179-862h277v437H99Zm405-437h277q32.025 0 56.512 24.488Q862-813.025 862-781v197H504v-278Zm0 763v-436h358v356q0 31.613-24.488 55.806Q813.025-99 781-99H504ZM99-376h357v277H179q-31.613 0-55.806-24.194Q99-147.387 99-179v-197Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li class="my-1.5"></li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.reservations.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('reservations') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M482.77-98Q434-135 378-160q-56-25-117.59-25Q221-185 184-174t-71 29q-37 19-71.5-1T7-206v-480q0-26.06 11-48.33Q29-756.61 52-769q47.63-22 99.32-32.5Q203-812 257.24-812q60.26 0 116.51 15Q430-782 480-748.53V-229q51-31 106-50t114-19q36 0 71 7t69 20v-524q17.52 6 34.52 13 17 7 35.48 13 23 10.39 33 33.67 10 23.27 10 49.33v496q0 35-34.5 49.5T847-145q-34-18-71-29t-76.41-11q-60.59 0-114.82 25-54.23 25-102 62ZM560-332v-417l200-208v437L560-332Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Reservations') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.recoveries.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('recoveries') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="m481-296 78-79-51-50h158v-113H508l51-51-78-79-186 186 186 186ZM210-76q-56.98 0-96.49-40.01T74-212v-540q0-55.97 39.51-95.99Q153.02-888 210-888h125q24-38 62-59.5t83-21.5q45 0 83 21.5t62 59.5h125q56.97 0 96.49 40.01Q886-807.97 886-752v540q0 55.98-39.51 95.99Q806.97-76 750-76H210Zm270-712q16.47 0 27.23-10.77Q518-809.53 518-826t-10.77-27.23Q496.47-864 480-864t-27.23 10.77Q442-842.47 442-826t10.77 27.23Q463.53-788 480-788Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Recoveries') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.payments.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('payments') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M130-119q-55.97 0-95.99-40.01Q-6-199.02-6-255v-437h136v437h683v136H130Zm193-192q-55.98 0-95.99-39.31Q187-389.63 187-447v-291q0-55.97 40.01-95.99Q267.02-874 323-874h507q55.97 0 95.99 40.01Q966-793.97 966-738v291q0 57.37-40.01 96.69Q885.97-311 830-311H323Zm70-121q0-34.65-24.97-59.33Q343.06-516 308-516v84h85Zm367 0h85v-84q-36 0-60.5 24.67Q760-466.65 760-432Zm-183.79-41q49.79 0 84.29-35 34.5-35 34.5-85t-34.71-85q-34.71-35-84.29-35-50.42 0-85.71 35Q455-643 455-593t35.71 85q35.7 35 85.5 35ZM308-669q35.06 0 60.03-24.97T393-754h-85v85Zm537 0v-85h-85q0 35 24.53 60 24.52 25 60.47 25Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Payments') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.charges.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('charges') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M417-205h111v-40h40q23.25 0 39.13-16.38Q623-277.75 623-301v-139q0-23.25-15.87-39.13Q591.25-495 568-495H448v-29h175v-111h-80v-40H432v40h-40q-23.25 0-39.12 16.37Q337-602.25 337-579v139q0 23.25 15.88 39.12Q368.75-385 392-385h120v29H337v111h80v40ZM250-34q-55.73 0-95.86-39.64Q114-113.28 114-170v-620q0-56.72 40.14-96.36Q194.27-926 250-926h329l267 267v489q0 56.72-40.14 96.36T710-34H250Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Charges') }}</span>
            </a>
        </li>
        <li class="my-1.5"></li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.restrictions.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('restrictions') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M480.15-32Q321-70 217.5-209.06 114-348.11 114-516.16v-274.82L480-928l366 137.02v274.38Q846-348 742.65-209 639.3-70 480.15-32ZM425-315h110q29 0 48.5-20.2T603-383v-98.63Q603-498 591.5-510T563-522v-40q0-34.35-24.33-58.17Q514.34-644 480.17-644t-58.67 23.83Q397-596.35 397-562v40q-17 0-28.5 12T357-482v99q0 27.6 19.5 47.8Q396-315 425-315Zm15-207v-40q0-16 11.5-28t28.5-12q17 0 28.5 12t11.5 28v40h-80Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Restrictions') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.agencies.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('agencies') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M150-99q-37.17 0-64.09-26.91Q59-152.82 59-190v-193h336v58h173v-58h334v193q0 37.18-27.21 64.09Q847.59-99 810-99H150Zm302-283v-59h59v59h-59ZM59-440v-200q0-37.59 26.91-64.79Q112.83-732 150-732h150v-100q0-36.13 26.91-63.56Q353.83-923 391-923h178q37.17 0 64.09 27.44Q660-868.13 660-832v100h150q37.59 0 64.79 27.21Q902-677.59 902-640v200H568v-58H395v58H59Zm332-292h178v-100H391v100Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Agencies') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.clients.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('clients') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M13-116v-176q0-35.6 25.65-60.3Q64.3-377 98-377h146q20.21 0 34.11 7Q292-363 300-352q32 44 79.5 69.5T480.04-257q51.96 0 100.46-25.5Q629-308 663-352q6-11 19.59-18 13.6-7 34.41-7h146q35.6 0 60.8 24.7Q949-327.6 949-292v176H658v-128q-38 30-83 46.5T480.14-181q-47.8 0-93.97-16T304-243v127H13Zm466.88-214q-32.88 0-61.38-14.5T372-387q-22-29-48-43t-60-18q36-31 99.08-48T480-513q55.84 0 117.92 17T698-448q-34 4-61 18t-46 43q-19 27-48.58 42t-62.54 15ZM160-473q-47.67 0-81.33-34.25Q45-541.5 45-590.28 45-637 78.75-671t81.53-34Q209-705 243-670.8t34 80.8q0 48.67-34.2 82.83Q208.6-473 160-473Zm640 0q-47.67 0-81.33-34.25Q685-541.5 685-590.28 685-637 718.75-671t81.53-34Q849-705 883-670.8t34 80.8q0 48.67-34.2 82.83Q848.6-473 800-473ZM480-609q-47.67 0-81.33-34.25Q365-677.5 365-725.28q0-48.72 33.75-82.22t81.53-33.5Q529-841 563-807.3t34 82.3q0 47.67-34.2 81.83Q528.6-609 480-609Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Clients') }}</span>
            </a>
        </li>
        <li class="my-1.5"></li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.reminders.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('reminders') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M480-35q-83 0-157-32t-129.5-87Q138-209 106-283T74-441q0-84 32-157.5t87.5-129Q249-783 323-815t157-32q84 0 158 32t129 87.5q55 55.5 87 129T886-441q0 84-32 158t-87 129q-55 55-129 87T480-35Zm102-225 76-76-125-124v-182H427v228l155 154ZM204-922l75 74L73-641l-74-75 205-206Zm552 0 206 206-74 75-207-207 75-74Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Reminders') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.vehicles.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('vehicles') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M244-161v8q0 30.6-22.5 51.3Q199-81 166.7-81h-10.89Q125-81 102.5-103.29 80-125.58 80-156v-331.43L167-735q9.64-28.8 34.86-46.4Q227.08-799 258-799h444q30.92 0 56.14 17.6T793-735l87 247.57V-156q0 30.42-22.5 52.71T804.19-81H793.3q-32.3 0-54.8-20.7T716-153v-8H244Zm1-404h470l-36-105H281l-36 105Zm60 241q26 0 44-18.38t18-43.5q0-25.12-18-43.62-18-18.5-43.5-18.5T262-429.62q-18 18.38-18 43.5t18.13 43.62Q280.25-324 305-324Zm349.5 0q25.5 0 43.5-18.38t18-43.5q0-25.12-18.12-43.62Q679.75-448 655-448q-26 0-44 18.38t-18 43.5q0 25.12 18 43.62 18 18.5 43.5 18.5Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Vehicles') }}</span>
            </a>
        </li>
        <li class="my-1.5"></li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.companies.patch') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('company') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M94-95v-613h243v-67l143-142 145 142v229h243v451H94Zm91-91h106v-105H185v105Zm0-162h106v-106H185v106Zm0-163h106v-105H185v105Zm243 325h105v-105H428v105Zm0-162h105v-106H428v106Zm0-163h105v-105H428v105Zm0-162h105v-105H428v105Zm242 487h106v-105H670v105Zm0-162h106v-106H670v106Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Company') }}</span>
            </a>
        </li>
        <li class="w-full mib-w-[240px] overflow-hidden">
            <a href="{{ route('views.users.index') }}"
                class="w-full flex flex-wrap gap-2 px-3 py-2 text-start items-center outline-none lg:rounded-e-full hover:text-x-white hover:bg-x-acent focus:text-x-white focus:bg-x-acent focus-within:text-x-white focus-within:bg-x-acent {{ Core::matchRoute('users') ? 'bg-x-prime text-x-white' : 'text-x-black' }}">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M68-130q-20.1 0-33.05-12.45Q22-154.9 22-174.708V-246q0-42.011 21.188-75.36 21.187-33.348 59.856-50.662Q178-404 238.469-419 298.938-434 363-434q66.062 0 126.031 15Q549-404 624-372q38.812 16.018 60.406 49.452Q706-289.113 706-246v71.708Q706-155 693.275-142.5T660-130H68Zm679 0q11-5 20.5-17.5T777-177v-67q0-65-32.5-108T659-432q60 10 113 24.5t88.88 31.939q34.958 18.329 56.539 52.945Q939-288 939-241v66.787q0 19.505-13.225 31.859Q912.55-130 893-130H747ZM364-494q-71.55 0-115.275-43.725Q205-581.45 205-652.5q0-71.05 43.725-115.275Q292.45-812 363.5-812q70.05 0 115.275 44.113Q524-723.775 524-653q0 71.55-45.112 115.275Q433.775-494 364-494Zm386-159q0 70.55-44.602 114.775Q660.796-494 591.035-494 578-494 567.5-495.5T543-502q26-27.412 38.5-65.107 12.5-37.696 12.5-85.599 0-46.903-12.5-83.598Q569-773 543-804q10.75-3.75 23.5-5.875T591-812q69.775 0 114.387 44.613Q750-722.775 750-653Z" />
                </svg>
                <span class="block flex-1 text-base">{{ __('Users') }}</span>
            </a>
        </li>
    </ul>
</neo-sidebar>
