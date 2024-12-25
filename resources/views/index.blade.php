<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Logs</title>
    <script src="{{ request_logs_asset('assets/js/tailwindcss.3.4.16.js') }}"></script>
    <script>
        tailwind.config = {
            darkMode: 'media'
        };
    </script>
    <style>
        /* Custom scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1f2937; /* dark:bg-gray-800 */
        }

        ::-webkit-scrollbar-thumb {
            background: #4b5563; /* dark:bg-gray-600 */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6b7280; /* dark:bg-gray-500 */
        }

        /* For Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1f2937;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Slide down animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Scale animation */
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Apply animations to elements */
        .page-header {
            animation: slideDown 0.5s ease-out;
        }

        .filter-section {
            animation: fadeIn 0.5s ease-out 0.2s both;
        }

        .logs-table {
            animation: fadeIn 0.5s ease-out 0.4s both;
        }

        .pagination-section {
            animation: fadeIn 0.5s ease-out 0.6s both;
        }

        /* Advanced filters animation */
        #advancedFilters {
            transition: all 0.3s ease-in-out;
            opacity: 0;
            transform: translateY(-10px);
            max-height: 0;
            overflow: hidden;
        }

        #advancedFilters.show {
            opacity: 1;
            transform: translateY(0);
            max-height: 500px; /* Adjust based on content */
        }

        /* Button hover effects */
        .btn-hover-effect {
            transition: all 0.2s ease;
        }

        .btn-hover-effect:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        /* Table row hover effect */
        .table-row-hover {
            transition: background-color 0.2s ease;
        }

        .table-row-hover:hover {
            background-color: rgba(55, 65, 81, 0.5);
        }

        /* Notification animation */
        [data-notification] {
            animation: slideDown 0.5s ease-out;
        }

        /* Loading animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Shimmer effect for loading state */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .loading-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 50;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.show {
            opacity: 1;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #3b82f6;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Button click effect */
        .btn-click-effect {
            transform: scale(0.97);
            opacity: 0.9;
        }

        /* Shimmer loading effect */
        .shimmer {
            background: linear-gradient(90deg, 
                rgba(255,255,255,0.1) 0%, 
                rgba(255,255,255,0.2) 50%, 
                rgba(255,255,255,0.1) 100%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }

        /* Table row delete animation */
        .row-delete {
            animation: fadeOut 0.5s ease-out forwards;
        }

        /* Success checkmark animation */
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .checkmark {
            animation: checkmark 0.5s ease-out forwards;
        }

        /* Ripple effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            top: 0;
            left: 0;
        }

        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
@if(session('success'))
    <div class="fixed top-4 right-4 z-50" data-notification>
        <div class="flex items-center p-4 gap-3 bg-gray-800 rounded-lg shadow-lg border border-green-500/20">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium text-gray-100">
                {{ session('success') }}
            </div>
            <div class="flex-shrink-0">
                <button class="inline-flex text-gray-400 hover:text-gray-300 focus:outline-none">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50" data-notification>
        <div class="flex items-center p-4 gap-3 bg-gray-800 rounded-lg shadow-lg border border-red-500/20">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium text-gray-100">
                {{ session('error') }}
            </div>
            <div class="flex-shrink-0">
                <button class="inline-flex text-gray-400 hover:text-gray-300 focus:outline-none">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
<div class="mx-auto my-10 px-4">
    <h1 class="page-header text-blue-500 text-3xl mb-8 font-semibold text-center dark:text-blue-400">Request Logs</h1>
    <div class="filter-section mb-6 bg-gray-800 p-4 rounded-lg">
        <form action="{{ route('request.logs') }}" method="GET" class="space-y-4" id="filterForm">
            <!-- Basic Search -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 lg:col-span-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Search</label>
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search in URL, IP, User Agent..."
                            class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            oninput="checkFilters()">
                            </div>
                    </div>
                
                <!-- Method Filter -->
                <div class="col-span-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Method</label>
                        <select name="method" 
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                onchange="checkFilters()">
                            <option value="">All Methods</option>
                            @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $method)
                                <option value="{{ $method }}" {{ request('method') == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-span-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                        <select name="status" 
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                onchange="checkFilters()">
                            <option value="">All Status</option>
                            @foreach([200, 201, 301, 302, 400, 401, 403, 404, 419, 422, 429, 500, 503] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">From</label>
                        <input type="date"
                            name="date_from"
                            value="{{ request('date_from') }}"
                            class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="From"
                            onchange="checkFilters()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">To</label>
                        <input type="date"
                            name="date_to"
                            value="{{ request('date_to') }}"
                            class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="To"
                            onchange="checkFilters()">
                    </div>
                </div>
            </div>

            <!-- Advanced Filters Toggle -->
            <div class="space-y-4">
                <button type="button" 
                        id="toggleAdvanced"
                        class="text-sm text-blue-500 hover:text-blue-400 flex items-center gap-1">
                    <span id="toggleText">Show Advanced Filters</span>
                    <svg class="w-4 h-4" id="toggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Advanced Filters -->
                <div id="advancedFilters" class="grid grid-cols-1 sm:grid-cols-2 gap-4 hidden">
                    <!-- IP Address Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">IP Address</label>
                        <input type="text"
                               name="ip"
                               value="{{ request('ip') }}"
                               placeholder="Filter by IP..."
                               class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               onchange="checkFilters()">
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">User</label>
                        <input type="text"
                               name="user"
                               value="{{ request('user') }}"
                               placeholder="Filter by user..."
                               class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               onchange="checkFilters()">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-2">
                <button type="submit"
                        id="applyFilters"
                        disabled
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Apply Filters
                </button>
                @if(request()->hasAny(['search', 'method', 'status', 'date_from', 'date_to', 'ip', 'user']))
                    <a href="{{ route('request.logs') }}"
                       class="px-4 py-2 text-sm bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="logs-table relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Method</th>
                <th scope="col" class="px-6 py-3">URL</th>
                <th scope="col" class="px-6 py-3">IP Address</th>
                <th scope="col" class="px-6 py-3">User Agent</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Timestamp</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr class="table-row-hover bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration }}</th>
                    <td class="px-6 py-4">{{ $log->user ? getUserTitle($log->user) : 'Guest' }}</td>
                    <td class="px-6 py-4">{{ $log->method }}</td>
                    <td class="px-6 py-4">
                        <div class="relative">
                            <div class="flex items-center space-x-2">
                                <span class="cursor-pointer hover:text-blue-400 transition"
                                      onclick="showUrlModal('{{ $log->url }}')">
                                    {{ Str::limit($log->url, 40) }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $log->ip_address }}</td>
                    <td class="px-6 py-4">{{ $log->user_agent }}</td>
                    <td class="px-6 py-4">{{ $log->response_status }}</td>
                    <td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($log->created_at)->format('D, M j, Y H:i:s') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2 relative z-10">
                            <!-- Body Button -->
                            <button onclick="showBodyModal({{ json_encode($log->body) }})"
                                    class="relative z-20 text-yellow-600 transition dark:text-yellow-500 hover:text-yellow-700 dark:hover:text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <line x1="10" y1="9" x2="8" y2="9"/>
                                    </svg>
                            </button>

                            <!-- Headers Button -->
                            <button onclick="showHeadersModal({{ json_encode($log->headers) }})"
                                    class="relative z-20 text-blue-600 transition dark:text-blue-500 hover:text-blue-700 dark:hover:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                        <path d="M4 12h8"/>
                                        <path d="M4 18h8"/>
                                        <path d="M4 6h16"/>
                                        <path d="M16 12h4"/>
                                        <path d="M16 18h4"/>
                                    </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-section mt-4">
        @if ($logs->hasPages())
            <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
                 class="flex items-center justify-between">
                <div class="flex justify-between flex-1 sm:hidden">
                    {{-- Previous Page Link --}}
                    @if ($logs->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}"
                           class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                            {!! __('pagination.previous') !!}
                        </a>
                    @endif

                    <div
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $logs->currentPage() }} / {{ $logs->lastPage() }}
                    </div>

                    @if ($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}"
                           class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                            {!! __('pagination.next') !!}
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 leading-5 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $logs->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $logs->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $logs->total() }}</span>
                            results
                        </p>
                    </div>

                    <div>
                        <span class="relative z-0 inline-flex rounded-md shadow-sm">
                            {{-- Previous Page Link --}}
                            @if ($logs->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $logs->currentPage() === 2 ? $logs->path() : $logs->previousPageUrl() }}"
                                   rel="prev"
                                   class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Numbers --}}
                            @php
                                $window = 2;
                                $start = $logs->currentPage() - $window;
                                $end = $logs->currentPage() + $window;
                                if($start < 1) {
                                    $start = 1;
                                    $end = min($logs->lastPage(), 5);
                                }
                                if($end > $logs->lastPage()) {
                                    $end = $logs->lastPage();
                                    $start = max(1, $end - 4);
                                }
                            @endphp

                            {{-- First Page --}}
                            @if($start > 1)
                                <a href="{{ $logs->url(1) === $logs->path() . '?page=1' ? $logs->path() : $logs->url(1) }}"
                                   class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                    1
                                </a>
                                @if($start > 2)
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">...</span>
                                @endif
                            @endif

                            {{-- Page Numbers --}}
                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $logs->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-default leading-5 dark:bg-blue-700">{{ $i }}</span>
                                        </span>
                                @else
                                    <a href="{{ $i === 1 ? $logs->path() : $logs->url($i) }}"
                                       class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                        {{ $i }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if($end < $logs->lastPage())
                                @if($end < $logs->lastPage() - 1)
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">...</span>
                                @endif
                                <a href="{{ $logs->url($logs->lastPage()) }}"
                                   class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                    {{ $logs->lastPage() }}
                                </a>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" rel="next"
                                   class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @endif
                        </span>
                    </div>
                </div>
            </nav>
        @endif
    </div>
</div>

<div id="loadingOverlay" class="loading-overlay">
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <div class="text-white text-sm animate-pulse">Loading...</div>
        </div>
    </div>
</div>

<script>
    // Handle notifications auto-hide
    document.addEventListener('DOMContentLoaded', function () {
        const notifications = document.querySelectorAll('[data-notification]');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        });
    });

    // Format JSON function with different handling for headers
    function formatJSON(jsonString, isHeaders = false) {
        try {
            let obj;
            if (isHeaders) {
                // Headers are typically double-encoded, so we need to parse twice
                const firstParse = JSON.parse(jsonString);
                // If it's still a string and looks like JSON, parse again
                if (typeof firstParse === 'string' && (firstParse.includes('{') || firstParse.includes('['))) {
                    obj = JSON.parse(firstParse);
                } else {
                    obj = firstParse;
                }
            } else {
                // For body, just parse once
                obj = JSON.parse(jsonString);
            }
            return JSON.stringify(obj, null, 2);
        } catch (e) {
            console.error('JSON parsing error:', e);
            return jsonString;
        }
    }

    // Create modal function update
    function createModal(content, title) {
        // Format content based on whether it's headers or body
        const isHeaders = title.includes('Headers');
        const isUrl = title.includes('URL');
        let formattedContent = content;
        if (typeof content === 'string' && (content.includes('{') || content.includes('[')) && !isUrl) {
            formattedContent = formatJSON(content, isHeaders);
        }

        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-50 overflow-y-auto';
        modal.innerHTML = `
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-gray-800 text-white rounded-lg shadow-xl max-w-3xl w-full mx-auto">
                    <button onclick="this.closest('.fixed').remove()"
                            class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold ${isHeaders ? 'text-blue-400' : 'text-yellow-400'} mb-4">${title}</h3>
                        <div class="bg-gray-900 rounded p-4 max-h-[70vh] overflow-y-auto">
                            <div class="flex items-center justify-between space-x-4">
                                <pre class="whitespace-pre text-sm font-mono text-gray-300 overflow-x-auto">${formattedContent}</pre>
                                ${isUrl ? `
                                    <button onclick="copyToClipboard(this, '${formattedContent.replace(/'/g, "\\'")}')"
                                            class="flex-shrink-0 text-blue-500 hover:text-blue-400 transition-colors duration-200"
                                            title="Copy to clipboard">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                        </svg>
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });

        document.body.appendChild(modal);
    }

    // Copy to clipboard function
    function copyToClipboard(button, text) {
        navigator.clipboard.writeText(text).then(() => {
            const originalTitle = button.getAttribute('title');
            button.setAttribute('title', 'Copied!');
            setTimeout(() => {
                button.setAttribute('title', originalTitle);
            }, 2000);
        });
    }

    // Show URL modal
    function showUrlModal(url) {
        createModal(url, 'Full URL');
    }

    // Show Body modal
    function showBodyModal(body) {
        createModal(body || 'No body data available', 'Request Body');
    }

    // Show Headers modal with special handling
    function showHeadersModal(headers) {
        createModal(headers || 'No headers available', 'Request Headers');
    }

    // Handle advanced filters toggle
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleAdvanced');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');
        const advancedFilters = document.getElementById('advancedFilters');
        let isAdvancedVisible = false;

        // Show advanced filters if any advanced filter is active
        if ("{{ request('ip') }}" || "{{ request('user') }}") {
            isAdvancedVisible = true;
            advancedFilters.classList.remove('hidden');
            advancedFilters.classList.add('show');
            toggleText.textContent = 'Hide Advanced Filters';
            toggleIcon.classList.add('rotate-180');
        }

        toggleBtn.addEventListener('click', function() {
            isAdvancedVisible = !isAdvancedVisible;
            
            if (isAdvancedVisible) {
                advancedFilters.classList.remove('hidden');
                // Use setTimeout to ensure the display:none is removed before adding show class
                setTimeout(() => {
                    advancedFilters.classList.add('show');
                }, 10);
                toggleText.textContent = 'Hide Advanced Filters';
                toggleIcon.classList.add('rotate-180');
            } else {
                advancedFilters.classList.remove('show');
                // Wait for animation to complete before hiding
                setTimeout(() => {
                    advancedFilters.classList.add('hidden');
                }, 300);
                toggleText.textContent = 'Show Advanced Filters';
                toggleIcon.classList.remove('rotate-180');
            }
        });

        // Add hover effect class to buttons
        document.querySelectorAll('button, a').forEach(button => {
            if (!button.classList.contains('btn-hover-effect')) {
                button.classList.add('btn-hover-effect');
            }
        });
    });

    // Auto-hide notifications after 3 seconds
    document.querySelectorAll('[data-notification]').forEach(notification => {
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Show loading on form submit
        document.querySelector('form').addEventListener('submit', function() {
            showLoading();
        });

        // Show loading on pagination clicks
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function() {
                showLoading();
            });
        });

        // Button click effects
        document.querySelectorAll('button, .btn-hover-effect').forEach(button => {
            button.addEventListener('mousedown', function() {
                this.classList.add('btn-click-effect');
            });

            button.addEventListener('mouseup', function() {
                this.classList.remove('btn-click-effect');
            });

            button.addEventListener('mouseleave', function() {
                this.classList.remove('btn-click-effect');
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('button, .btn-hover-effect').forEach(button => {
            button.classList.add('ripple');
            button.addEventListener('click', createRipple);
        });
    });

    // Loading functions
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        overlay.style.display = 'block';
        setTimeout(() => overlay.classList.add('show'), 0);
    }

    function hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        overlay.classList.remove('show');
        setTimeout(() => overlay.style.display = 'none', 300);
    }

    // Ripple effect function
    function createRipple(event) {
        const button = event.currentTarget;
        button.classList.remove('ripple');
        void button.offsetWidth; // Trigger reflow
        button.classList.add('ripple');
    }

    // Delete row animation
    function animateDelete(row) {
        row.classList.add('row-delete');
        return new Promise(resolve => {
            setTimeout(resolve, 500);
        });
    }

    // Success checkmark animation
    function showSuccess(element) {
        const checkmark = document.createElement('div');
        checkmark.innerHTML = `
            <svg class="checkmark w-6 h-6 text-green-500" viewBox="0 0 24 24">
                <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
            </svg>
        `;
        checkmark.classList.add('checkmark');
        element.appendChild(checkmark);
        setTimeout(() => checkmark.remove(), 2000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initial check for filters
        checkFilters();

        // Handle form submission
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Remove empty values
            const formData = new FormData(this);
            const params = new URLSearchParams();
            
            for (const [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value.trim());
                }
            }

            // Build the URL with non-empty parameters
            const url = `${this.action}${params.toString() ? '?' + params.toString() : ''}`;
            
            // Show loading and redirect
            showLoading();
            window.location.href = url;
        });
    });

    function checkFilters() {
        const form = document.getElementById('filterForm');
        const submitButton = document.getElementById('applyFilters');
        let hasValue = false;

        // Check all inputs and selects
        const elements = form.querySelectorAll('input, select');
        elements.forEach(element => {
            if (element.type === 'date') {
                if (element.value !== '') hasValue = true;
            } else {
                if (element.value.trim() !== '') hasValue = true;
            }
        });

        // Enable/disable submit button
        submitButton.disabled = !hasValue;

        // Update button appearance
        if (hasValue) {
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
</script>
</body>
</html>
