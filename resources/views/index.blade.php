<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.7/dist/cdn.min.js"></script>
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
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
@if(session('success'))
    <div class="fixed top-4 right-4 z-50"
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 3000)">
        <div class="flex items-center p-4 gap-3 bg-gray-800 rounded-lg shadow-lg border border-green-500/20">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium text-gray-100">
                {{ session('success') }}
            </div>
            <div class="flex-shrink-0">
                <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-300 focus:outline-none">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50"
         x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 3000)">
        <div class="flex items-center p-4 gap-3 bg-gray-800 rounded-lg shadow-lg border border-red-500/20">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium text-gray-100">
                {{ session('error') }}
            </div>
            <div class="flex-shrink-0">
                <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-300 focus:outline-none">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
<div class="mx-auto my-10 px-4">
    <h1 class="text-blue-500 text-3xl mb-8 font-semibold text-center dark:text-blue-400">Request Logs</h1>
    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
        <div class="p-4">
            <!-- Search and Actions Bar -->
            <div class="mb-4 flex justify-between items-center">
                <form action="{{ route('request.logs') }}" method="GET" class="flex gap-2">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search logs..."
                               class="px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-8">
                        @if(request('search'))
                            <a href="{{ url()->current() }}" 
                               class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <button type="submit"
                            onclick="if(!this.form.search.value) this.form.search.disabled = true"
                            class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Search
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration }}</th>
                            <td class="px-6 py-4">{{ $log->user ? getUserTitle($log->user) : 'Guest' }}</td>
                            <td class="px-6 py-4">{{ $log->method }}</td>
                            <td class="px-6 py-4" x-data="{ showFullUrl: false }">
                                <div class="relative">
                                    <!-- Truncated URL with hover/click functionality -->
                                    <div class="flex items-center space-x-2">
                                            <span class="cursor-pointer hover:text-blue-400 transition"
                                                  @click="showFullUrl = !showFullUrl">
                                                {{ Str::limit($log->url, 40) }}
                                            </span>
                                    </div>

                                    <!-- Full URL Modal -->
                                    <template x-teleport="body">
                                        <div x-show="showFullUrl"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="fixed inset-0 z-50 overflow-y-auto"
                                             @click.self="showFullUrl = false">
                                            <!-- Backdrop with blur -->
                                            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

                                            <div class="relative flex items-center justify-center min-h-screen p-4">
                                                <!-- Modal Content -->
                                                <div x-show="showFullUrl"
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                     class="relative bg-gray-800 text-white rounded-lg shadow-xl max-w-3xl w-full mx-auto">
                                                    <!-- Close button -->
                                                    <button @click="showFullUrl = false"
                                                            class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors duration-200">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>

                                                    <div class="p-6">
                                                        <h3 class="text-xl font-semibold text-blue-400 mb-4">Full
                                                            URL</h3>
                                                        <div class="bg-gray-900 rounded p-4">
                                                            <div
                                                                class="flex items-center justify-between space-x-4">
                                                                    <pre
                                                                        class="whitespace-pre-wrap break-all">{{ $log->url }}</pre>
                                                                <button
                                                                    @click="navigator.clipboard.writeText('{{ $log->url }}')"
                                                                    class="text-blue-500 hover:text-blue-400 transition-colors duration-200"
                                                                    title="Copy to clipboard">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         class="h-5 w-5"
                                                                         fill="none"
                                                                         viewBox="0 0 24 24"
                                                                         stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                              stroke-linejoin="round"
                                                                              stroke-width="2"
                                                                              d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $log->ip_address }}</td>
                            <td class="px-6 py-4">{{ $log->user_agent }}</td>
                            <td class="px-6 py-4">{{ $log->response_status }}</td>
                            <td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($log->created_at)->format('D, M j, Y H:i:s') }}</td>
                            <td class="px-6 py-4" x-data="{ showBody: false, showHeaders: false }">
                                <div class="flex space-x-2 relative z-10">
                                    <!-- Body Button -->
                                    <button @click.prevent="showBody = true"
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
                                    <button @click.prevent="showHeaders = true"
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

                                <!-- Body Popover -->
                                <template x-teleport="body">
                                    <div x-show="showBody"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 z-50 overflow-y-auto"
                                         @click.self="showBody = false">
                                        <!-- Backdrop with blur -->
                                        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

                                        <div class="relative flex items-center justify-center min-h-screen p-4">
                                            <!-- Modal Content -->
                                            <div x-show="showBody"
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave="transition ease-in duration-200"
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                 class="relative bg-gray-800 text-white rounded-lg shadow-xl max-w-3xl w-full mx-auto transform">
                                                <!-- Close button -->
                                                <button @click="showBody = false"
                                                        class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors duration-200">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>

                                                <div class="p-6">
                                                    <h3 class="text-xl font-semibold text-yellow-400 mb-4">Request
                                                        Body</h3>
                                                    <div class="bg-gray-900 rounded p-4 overflow-x-auto">
                                                        @php
                                                            $body = $log->body ? json_decode($log->body, true) : null;
                                                        @endphp

                                                        @if($body)
                                                            <pre
                                                                class="whitespace-pre-wrap">{{ json_encode($body, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            <p class="text-gray-400">No body data available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Headers Modal -->
                                <template x-teleport="body">
                                    <div x-show="showHeaders"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 z-50 overflow-y-auto"
                                         @click.self="showHeaders = false">
                                        <!-- Backdrop with blur -->
                                        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

                                        <div class="relative flex items-center justify-center min-h-screen p-4">
                                            <!-- Modal Content -->
                                            <div x-show="showHeaders"
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave="transition ease-in duration-200"
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                 class="relative bg-gray-800 text-white rounded-lg shadow-xl max-w-3xl w-full mx-auto transform">
                                                <!-- Close button -->
                                                <button @click="showHeaders = false"
                                                        class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors duration-200">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>

                                                <div class="p-6">
                                                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Request
                                                        Headers</h3>
                                                    <div class="bg-gray-900 rounded p-4 overflow-x-auto">
                                                        @php
                                                            $headers = $log->headers ? json_decode($log->headers, true) : null;
                                                        @endphp

                                                        @if($headers)
                                                            <pre
                                                                class="whitespace-pre-wrap">{{ json_encode($headers, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            <p class="text-gray-400">No headers available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                @if ($logs->hasPages())
                    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            {{-- Previous Page Link --}}
                            @if ($logs->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                    {!! __('pagination.previous') !!}
                                </span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                    {!! __('pagination.previous') !!}
                                </a>
                            @endif

                            <div class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $logs->currentPage() }} / {{ $logs->lastPage() }}
                            </div>

                            @if ($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                    {!! __('pagination.next') !!}
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
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
                                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $logs->currentPage() === 2 ? $logs->path() : $logs->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
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
                                        <a href="{{ $logs->url(1) === $logs->path() . '?page=1' ? $logs->path() : $logs->url(1) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                            1
                                        </a>
                                        @if($start > 2)
                                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">...</span>
                                        @endif
                                    @endif

                                    {{-- Page Numbers --}}
                                    @for ($i = $start; $i <= $end; $i++)
                                        @if ($i == $logs->currentPage())
                                            <span aria-current="page">
                                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-blue-600 border border-blue-600 cursor-default leading-5 dark:bg-blue-700">{{ $i }}</span>
                                            </span>
                                        @else
                                            <a href="{{ $i === 1 ? $logs->path() : $logs->url($i) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                                {{ $i }}
                                            </a>
                                        @endif
                                    @endfor

                                    {{-- Last Page --}}
                                    @if($end < $logs->lastPage())
                                        @if($end < $logs->lastPage() - 1)
                                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">...</span>
                                        @endif
                                        <a href="{{ $logs->url($logs->lastPage()) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-white">
                                            {{ $logs->lastPage() }}
                                        </a>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($logs->hasMorePages())
                                        <a href="{{ $logs->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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
    </div>
</div>
</body>
</html>
