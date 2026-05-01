@props([
    'tier' => [],
    'size' => 'md',
    'showLabel' => false,
])

@php
    $key = $tier['key'] ?? 'warrior';
    $name = $tier['name'] ?? 'Warrior';
    $stars = (int) ($tier['stars'] ?? 1);
    $primary = $tier['primary'] ?? '#94a3b8';
    $secondary = $tier['secondary'] ?? '#64748b';
    $accent = $tier['accent'] ?? '#44403c';
    $gradientId = 'tier-gradient-' . uniqid();

    $sizeClass = match ($size) {
        'sm' => 'w-12 h-12',
        'lg' => 'w-24 h-24',
        'xl' => 'w-36 h-36',
        default => 'w-16 h-16',
    };
@endphp

<div {{ $attributes->merge(['class' => 'tier-emblem inline-flex items-center gap-3']) }}>
    <div class="relative {{ $sizeClass }} shrink-0">
        <span class="absolute inset-0 rounded-full blur-xl opacity-60" style="background: {{ $primary }}"></span>
        <svg class="relative h-full w-full drop-shadow-[0_16px_32px_rgba(0,0,0,0.45)]" viewBox="0 0 120 120" role="img" aria-label="{{ $name }}">
            <defs>
                <linearGradient id="{{ $gradientId }}" x1="16" y1="12" x2="104" y2="110" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="{{ $primary }}"/>
                    <stop offset="0.52" stop-color="{{ $secondary }}"/>
                    <stop offset="1" stop-color="{{ $accent }}"/>
                </linearGradient>
                <filter id="{{ $gradientId }}-glow" x="-30%" y="-30%" width="160%" height="160%">
                    <feGaussianBlur stdDeviation="3" result="blur"/>
                    <feMerge>
                        <feMergeNode in="blur"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>

            <circle cx="60" cy="60" r="54" fill="#020617" stroke="{{ $primary }}" stroke-width="2" opacity="0.94"/>
            <circle cx="60" cy="60" r="46" fill="url(#{{ $gradientId }})" opacity="0.22"/>

            @if($key === 'mythical_glory')
                <path d="M60 11 73 36l28 4-20 20 5 28-26-13-26 13 5-28-20-20 28-4 13-25Z" fill="url(#{{ $gradientId }})" stroke="#fde68a" stroke-width="3" filter="url(#{{ $gradientId }}-glow)"/>
                <path d="M36 78 60 25l24 53-24-13-24 13Z" fill="#f8fafc" opacity="0.24"/>
                <path d="M31 35h58l-12 17H43L31 35Z" fill="#fde68a"/>
            @elseif($key === 'mythic')
                <path d="M17 68c15-7 25-21 31-42 8 12 12 23 12 34 0-11 4-22 12-34 6 21 16 35 31 42-14 5-25 4-34-2l-9 27-9-27c-9 6-20 7-34 2Z" fill="url(#{{ $gradientId }})" stroke="#e9d5ff" stroke-width="3" filter="url(#{{ $gradientId }}-glow)"/>
                <path d="M60 35 74 59 60 83 46 59 60 35Z" fill="#f8fafc" opacity="0.26"/>
            @elseif($key === 'legend')
                <path d="M27 84 33 45l18 16 9-29 9 29 18-16 6 39H27Z" fill="url(#{{ $gradientId }})" stroke="#fef3c7" stroke-width="3" filter="url(#{{ $gradientId }}-glow)"/>
                <path d="M35 88h50v10H35z" fill="#fef3c7"/>
                <circle cx="60" cy="32" r="6" fill="#fef3c7"/>
            @elseif($key === 'epic')
                <path d="M60 17 93 36v48L60 103 27 84V36l33-19Z" fill="url(#{{ $gradientId }})" stroke="#cffafe" stroke-width="3" filter="url(#{{ $gradientId }}-glow)"/>
                <path d="M60 28 80 43 72 76 60 90 48 76 40 43 60 28Z" fill="#f8fafc" opacity="0.24"/>
                <path d="M42 44h36L60 86 42 44Z" fill="#ecfeff" opacity="0.18"/>
            @else
                <path d="M60 18 91 31v25c0 23-12 39-31 48-19-9-31-25-31-48V31l31-13Z" fill="url(#{{ $gradientId }})" stroke="#e2e8f0" stroke-width="3" filter="url(#{{ $gradientId }}-glow)"/>
                <path d="M42 52h36M47 66h26" stroke="#f8fafc" stroke-width="7" stroke-linecap="round" opacity="0.5"/>
            @endif

            <g transform="translate({{ 60 - (($stars - 1) * 10) }}, 101)">
                @for($i = 0; $i < $stars; $i++)
                    <path transform="translate({{ $i * 20 }}, 0)" d="M0-8 2.4-2.4 8-2 3.7 1.7 5 7 0 4.1-5 7-3.7 1.7-8-2-2.4-2.4Z" fill="#fef08a" stroke="#92400e" stroke-width="0.9"/>
                @endfor
            </g>
        </svg>
    </div>

    @if($showLabel)
        <div class="leading-tight">
            <p class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-500">Tier Saat Ini</p>
            <p class="mt-1 text-lg font-black uppercase text-white">{{ $name }} <span class="text-cyan-300">{{ str_repeat('*', $stars) }}</span></p>
        </div>
    @endif
</div>
