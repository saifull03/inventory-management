<x-app-layout>
    <!-- Custom styling to override layout background to Snipe-IT dark theme -->
    <style>
        body, main, .bg-gray-100 {
            background-color: #1e282c !important;
        }
        header.bg-white {
            background-color: #222d32 !important;
            border-bottom: 1px solid #1a2226;
        }
        header.bg-white h2 {
            color: #ffffff !important;
        }
    </style>

    <div class="py-6 text-gray-200">
        <div class="mx-auto max-w-8xl space-y-6 px-4 sm:px-6 lg:px-8">
            
            <!-- DEMO MODE Alert Bar -->
            <div class="rounded bg-neutral-800 text-neutral-300 px-4 py-3 shadow-sm flex items-center justify-between text-sm font-medium border-l-4 border-neutral-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>DEMO MODE: Some features are disabled for this installation.</span>
                </div>
            </div>

            <!-- Snipe-IT 6-Color Stats Cards (Black and White Theme) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                <!-- Assets -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #343a40;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['assets']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">Assets</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M2 4h2v16H2V4zm4 0h1v16H6V4zm3 0h3v16H9V4zm5 0h2v16h-2V4zm3 0h1v16h-1V4zm2 0h3v16h-3V4z"/>
                    </svg>
                    <a href="{{ route('products.index') }}" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>

                <!-- Licenses -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #3e444a;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['licenses']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">Licenses</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                    </svg>
                    <a href="{{ route('products.index') }}?search=License" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>

                <!-- Accessories -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #495057;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['accessories']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">Accessories</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M20 5H4c-1.1 0-1.99.9-1.99 2L2 17c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm-9 3h2v2h-2V8zm0 3h2v2h-2v-2zM8 8h2v2H8V8zm0 3h2v2H8v-2zm-3 0h2v2H5v-2zm0-3h2v2H5V8zm3 6h8v2H8v-2zm6-3h2v2h-2v-2zm0-3h2v2h-2V8zm3 3h2v2h-2v-2zm0-3h2v2h-2V8z"/>
                    </svg>
                    <a href="{{ route('products.index') }}?search=Accessory" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>

                <!-- Consumables -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #343a40;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['consumables']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">Consumables</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                    </svg>
                    <a href="{{ route('products.index') }}?search=Consumable" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>

                <!-- Components -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #3e444a;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['components']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">Components</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm1-3h-2v-2h2v2z"/>
                    </svg>
                    <a href="{{ route('products.index') }}?search=Component" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>

                <!-- People -->
                <div class="relative overflow-hidden rounded shadow-sm text-white flex flex-col justify-between h-32 group" style="background-color: #495057;">
                    <div class="p-4 z-10">
                        <span class="block text-3xl font-bold tracking-tight">{{ number_format($totals['people']) }}</span>
                        <span class="text-sm font-medium opacity-90 block mt-1">People</span>
                    </div>
                    <!-- Icon Watermark -->
                    <svg class="absolute right-2 -bottom-2 text-white pointer-events-none group-hover:scale-110 transition duration-305" style="width: 80px; height: 80px; opacity: 0.1; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 5.34 5 7s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    <a href="{{ route('employees.index') }}" class="bg-black/15 hover:bg-black/25 text-xs text-center py-1.5 font-medium transition flex items-center justify-center gap-1 z-10">
                        <span>view all</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 9l3 3m0 0l-3 3m3-3H8"/></svg>
                    </a>
                </div>
            </div>

            <!-- Lower Layout: Recent Activity & Assets by Status Chart -->
            <div class="grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
                <!-- Recent Activity Table -->
                <div class="rounded bg-[#2a363b] shadow-sm border border-neutral-700 overflow-hidden">
                    <div class="bg-[#20292d] px-4 py-3 border-b border-neutral-700 flex items-center justify-between">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300">Recent Activity</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-700 text-sm">
                            <thead class="bg-[#1f282c]">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-400">Date</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-400">Created By</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-400">Action</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-400">Item</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-400">Target</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-700 bg-[#283238]">
                                @forelse ($recentActivity as $activity)
                                    @php
                                        if ($activity->employee_id) {
                                            $action = 'checkout';
                                            $target = $activity->employee->name;
                                            $targetClass = 'text-neutral-300';
                                        } else {
                                            $action = ($activity->created_at == $activity->updated_at) ? 'create new' : 'update details';
                                            $target = 'Available / In Warehouse';
                                            $targetClass = 'text-neutral-400';
                                        }
                                    @endphp
                                    <tr class="hover:bg-neutral-700/30 transition">
                                        <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">
                                            {{ $activity->updated_at->format('D M d, Y g:iA') }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-300">
                                            {{ $activity->creator?->name ?? 'Admin User' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wide
                                                bg-neutral-800 text-neutral-300">
                                                {{ $action }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-200">
                                            <a href="{{ route('products.show', $activity) }}" class="hover:underline text-neutral-300 font-medium">
                                                {{ $activity->name }}
                                            </a>
                                            <span class="text-xs text-gray-400 block font-mono">{{ $activity->product_code }}</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium {{ $targetClass }}">
                                            {{ $target }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                            No recent inventory activity recorded.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Assets by Status Chart Card -->
                <div class="rounded bg-[#2a363b] shadow-sm border border-neutral-700 overflow-hidden flex flex-col justify-between">
                    <div class="bg-[#20292d] px-4 py-3 border-b border-neutral-700">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300">Assets by Status</h3>
                    </div>

                    <div class="p-6 flex flex-col items-center justify-center flex-grow space-y-6">
                        @php
                            $totalStatusCount = $statusBreakdown->sum('count');
                            
                            $statusColors = [
                                'Available' => '#f3f4f6',   // White/Light gray
                                'Assigned' => '#9ca3af',    // Cool gray
                                'Maintenance' => '#4b5563', // Medium gray
                                'Damaged' => '#1f2937',     // Dark charcoal
                                'Disposed' => '#6b7280',    // Gray
                                'In Stock' => '#d1d5db',    // Light gray
                                'Reserved' => '#374151',    // Dark gray
                            ];
                        @endphp

                        @if ($totalStatusCount > 0)
                            <!-- SVG Donut Chart -->
                            <div class="relative w-48 h-48">
                                <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                    <!-- Base Circle -->
                                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#374151" stroke-width="4.2"></circle>
                                    
                                    @php
                                        $cumulativePercent = 0;
                                    @endphp
                                    @foreach ($statusBreakdown as $status)
                                        @php
                                            $percent = ($status->count / $totalStatusCount) * 100;
                                            $dashArray = "$percent " . (100 - $percent);
                                            $dashOffset = 100 - $cumulativePercent;
                                            $cumulativePercent += $percent;
                                            $color = $statusColors[$status->status] ?? '#9ca3af';
                                        @endphp
                                        @if ($percent > 0)
                                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="{{ $color }}" stroke-width="4.3" stroke-dasharray="{{ $dashArray }}" stroke-dashoffset="{{ $dashOffset }}" class="transition-all duration-300 hover:stroke-[5] cursor-pointer"></circle>
                                        @endif
                                    @endforeach
                                </svg>
                                <!-- Inner Donut Text -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                    <span class="text-3xl font-extrabold text-white">{{ $totalStatusCount }}</span>
                                    <span class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Total Assets</span>
                                </div>
                            </div>

                            <!-- Legend List -->
                            <div class="w-full space-y-2.5">
                                @foreach ($statusBreakdown as $status)
                                    @php
                                        $percent = ($status->count / $totalStatusCount) * 100;
                                        $color = $statusColors[$status->status] ?? '#9ca3af';
                                    @endphp
                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $color }};"></span>
                                            <span class="text-gray-300 font-medium">{{ $status->status }}</span>
                                        </div>
                                        <div class="text-gray-400 font-mono">
                                            {{ $status->count }} ({{ number_format($percent, 1) }}%)
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-neutral-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                                <span>No status data available.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
