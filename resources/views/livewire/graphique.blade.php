@php
    $stats = [
        ['title' => 'Revenu Total', 'value' => 45231, 'trend' => 12.5, 'icon' => 'dollar', 'color' => 'blue'],
        ['title' => 'Utilisateurs', 'value' => 8429, 'trend' => 8.2, 'icon' => 'users', 'color' => 'green'],
        ['title' => 'Ventes', 'value' => 1253, 'trend' => 3.8, 'icon' => 'shopping-cart', 'color' => 'orange'],
        ['title' => 'Conversion', 'value' => 3.24, 'trend' => 1.2, 'icon' => 'percent', 'color' => 'purple'],
        ['title' => 'Vues de page', 'value' => 23847, 'trend' => 7.4, 'icon' => 'eye', 'color' => 'cyan'],
        ['title' => 'Taux de clics', 'value' => 4.87, 'trend' => -5.3, 'icon' => 'cursor', 'color' => 'pink'],
    ];
    $colors = [
        'blue' => 'from-blue-500 to-blue-600',
        'purple' => 'from-purple-500 to-purple-600',
        'green' => 'from-green-500 to-green-600',
        'orange' => 'from-orange-500 to-orange-600',
        'pink' => 'from-pink-500 to-pink-600',
        'cyan' => 'from-cyan-500 to-cyan-600',
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach ($stats as $stat)
        @php
            $gradientColor = $colors[$stat['color']] ?? $colors['blue'];
            $isPositive = $stat['trend'] >= 0;
        @endphp
        <div
            class="relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div
                class="absolute -top-24 -right-24 w-48 h-48 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500 bg-gradient-to-br {{ $gradientColor }}">
            </div>
            <div class="relative p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-3 rounded-xl bg-gradient-to-br {{ $gradientColor }} shadow-lg">
                        <!-- Ici utilise une icône SVG différente selon $stat['icon'] -->
                        {{-- Inclure l’icône correspondante ici --}}
                        <svg class="w-6 h-6 text-white" ...><!-- ... --></svg>
                    </div>
                    <div
                        class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {{ $isPositive ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if ($isPositive)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            @endif
                        </svg>
                        <span>{{ abs($stat['trend']) }}%</span>
                    </div>
                </div>
                <h3 class="text-sm font-medium text-gray-600 mb-2">{{ $stat['title'] }}</h3>
                <p class="text-3xl font-bold text-gray-900">
                    {{ number_format($stat['value']) }}{{ isset($stat['slot']) ? $stat['slot'] : '' }}</p>
            </div>
        </div>
    @endforeach
</div>
