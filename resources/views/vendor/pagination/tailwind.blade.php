@if ($paginator->hasPages())
    <nav
        role="navigation"
        aria-label="{{ __("Pagination Navigation") }}"
        class="flex items-center justify-between w-full"
    >
        {{-- Mobile Pagination --}}
        <div class="flex justify-between flex-1 sm:hidden">
            <span>
                @if ($paginator->onFirstPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-muted-foreground cursor-default leading-5 rounded-lg"
                    >
                        {!! __("pagination.previous") !!}
                    </span>
                @else
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-accent-foreground rounded-lg leading-5 hover:bg-accent focus:outline-none focus:border-ring focus:ring ring-ring active:bg-accent transition-colors touch-target"
                    >
                        {!! __("pagination.previous") !!}
                    </a>
                @endif
            </span>

            <span>
                @if ($paginator->hasMorePages())
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-accent-foreground rounded-lg leading-5 hover:bg-accent focus:outline-none focus:border-ring focus:ring ring-ring active:bg-accent transition-colors touch-target"
                    >
                        {!! __("pagination.next") !!}
                    </a>
                @else
                    <span
                        class="relative inline-flex items-center px-3.5 py-2 ml-3 text-sm font-medium text-muted-foreground cursor-default leading-5 rounded-lg"
                    >
                        {!! __("pagination.next") !!}
                    </span>
                @endif
            </span>
        </div>

        {{-- Desktop Pagination --}}
        <div
            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm text-muted-foreground leading-5">
                    <span>{!! __("Showing") !!}</span>

                    @if ($paginator->firstItem())
                        <span class="font-medium">
                            {{ $paginator->firstItem() }}
                        </span>
                        <span>{!! __("to") !!}</span>
                        <span class="font-medium">
                            {{ $paginator->lastItem() }}
                        </span>
                    @else
                        <span class="font-medium">
                            {{ $paginator->count() }}
                        </span>
                    @endif
                    <span>{!! __("of") !!}</span>
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    <span>{!! __("results") !!}</span>
                </p>
            </div>

            <div>
                <span
                    class="relative z-0 inline-flex gap-1 rtl:flex-row-reverse rounded-md shadow-sm"
                >
                    {{-- Previous Page Link --}}
                    <span>
                        @if ($paginator->onFirstPage())
                            <span
                                aria-disabled="true"
                                aria-label="{{ __("pagination.previous") }}"
                            >
                                <span
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-muted-foreground cursor-default rounded-lg leading-5"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </span>
                        @else
                            <a
                                href="{{ $paginator->previousPageUrl() }}"
                                rel="prev"
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-accent-foreground rounded-lg leading-5 hover:bg-accent focus:z-10 focus:outline-none focus:border-ring focus:ring ring-ring active:bg-accent transition-colors touch-target"
                                aria-label="{{ __("pagination.previous") }}"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </a>
                        @endif
                    </span>

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-3.5 py-2 text-sm font-medium text-muted-foreground cursor-default leading-5"
                                >
                                    {{ $element }}
                                </span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-3.5 py-2 rounded-lg text-sm font-medium leading-5 text-accent-foreground bg-secondary border border-ring/50 cursor-default"
                                        >
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <a
                                        href="{{ $url }}"
                                        class="relative inline-flex items-center px-3.5 py-2 rounded-lg text-sm font-medium leading-5 text-accent-foreground bg-accent/0 border border-border/0 hover:bg-accent focus:z-10 focus:outline-none focus:border-ring focus:ring ring-ring active:bg-accent active:border-border transition-colors touch-target"
                                        aria-label="{{ __("Go to page :page", ["page" => $page]) }}"
                                    >
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <span>
                        @if ($paginator->hasMorePages())
                            <a
                                href="{{ $paginator->nextPageUrl() }}"
                                rel="next"
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-accent-foreground bg-accent/0 rounded-lg leading-5 hover:bg-accent focus:z-10 focus:outline-none focus:border-ring focus:ring ring-ring active:bg-accent transition-colors touch-target"
                                aria-label="{{ __("pagination.next") }}"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </a>
                        @else
                            <span
                                aria-disabled="true"
                                aria-label="{{ __("pagination.next") }}"
                            >
                                <span
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-muted-foreground cursor-default rounded-lg leading-5"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </span>
                        @endif
                    </span>
                </span>
            </div>
        </div>
    </nav>
@endif
