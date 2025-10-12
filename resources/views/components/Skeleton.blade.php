@props([
    'type' => 'default', // Pwedeng 'default', 'card', 'list', 'table', 'profile'
    'count' => 1,        // Ilang skeleton items ang ipapakita
    'height' => null,    // Custom height (optional)
    'width' => null,     // Custom width (optional)
    'class' => '',       // Additional classes
])

@for ($i = 0; $i < $count; $i++)
    <div class="skeleton-container animate-pulse {{ $class }}">
        @switch($type)
            @case('card')
                <div class="h-32 w-full bg-gray-700 mb-2 rounded"></div>
                <div class="h-4 w-3/4 bg-gray-700 mb-2 rounded"></div>
                <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
                @break

            @case('list')
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 rounded-full bg-gray-700 mr-3"></div>
                    <div class="flex-1">
                        <div class="h-4 w-3/4 bg-gray-700 mb-2 rounded"></div>
                        <div class="h-3 w-1/2 bg-gray-700 rounded"></div>
                    </div>
                </div>
                @break

            @case('table')
                <div class="flex justify-between mb-2">
                    <div class="h-4 w-1/6 bg-gray-700 rounded"></div>
                    <div class="h-4 w-1/6 bg-gray-700 rounded"></div>
                    <div class="h-4 w-1/6 bg-gray-700 rounded"></div>
                    <div class="h-4 w-1/6 bg-gray-700 rounded"></div>
                </div>
                @break

            @case('profile')
                <div class="flex flex-col items-center">
                    <div class="h-16 w-16 rounded-full bg-gray-700 mb-4"></div>
                    <div class="h-4 w-3/4 bg-gray-700 mb-2 rounded"></div>
                    <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
                </div>
                @break

            @default
                <div class="h-12 w-12 rounded-full bg-gray-700 mb-4"></div>
                <div class="h-4 w-3/4 bg-gray-700 mb-2 rounded"></div>
                <div class="h-4 w-1/2 bg-gray-700 rounded"></div>
                <div class="h-32 w-full bg-gray-700 mt-4 rounded"></div>
        @endswitch

        @if ($height || $width)
            <div class="{{ $height ?? 'h-32' }} {{ $width ?? 'w-full' }} bg-gray-700 mt-4 rounded"></div>
        @endif
    </div>
@endfor

<style>
    .skeleton-container .bg-gray-700 {
        background: #333;
    }

    .animate-pulse {
        position: relative;
        overflow: hidden;
    }

    .animate-pulse::after {
        content: "";
        position: absolute;
        top: 0;
        left: -150px;
        height: 100%;
        width: 150px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        100% {
            left: 100%;
        }
    }
</style>