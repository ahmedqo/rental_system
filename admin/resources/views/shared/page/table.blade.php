@if ($paginator->hasPages())
    <nav class="w-full container mx-auto p-4 flex items-center justify-center gap-4">
        @if (!$paginator->onFirstPage())
            <a id="prev" slot="end" title="{{ __('Prev') }}" href="{{ $paginator->previousPageUrl() }}"
                aria-label="prev_page_link"
                class="block p-2 rounded-x-thin text-x-black outline-none !bg-opacity-10 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M452-219 190-481l262-262 64 64-199 198 199 197-64 65Zm257 0L447-481l262-262 63 64-198 198 198 197-63 65Z" />
                </svg>
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a id="next" slot="end" title="{{ __('Next') }}" href="{{ $paginator->nextPageUrl() }}"
                aria-label="next_page_link"
                class="block p-2 rounded-x-thin text-x-black outline-none !bg-opacity-10 hover:bg-x-black focus:bg-x-black focus-within:bg-x-black">
                <svg class="block w-6 h-6 pointer-events-none" fill="currentcolor" viewBox="0 -960 960 960">
                    <path
                        d="M388-481 190-679l64-64 262 262-262 262-64-65 198-197Zm257 0L447-679l63-64 262 262-262 262-63-65 198-197Z" />
                </svg>
            </a>
        @endif
    </nav>
@endif
