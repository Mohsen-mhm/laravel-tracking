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
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
<div class="mx-auto my-10 px-4">
    <h1 class="text-blue-500 text-3xl mb-8 font-semibold text-center dark:text-blue-400">Request Logs</h1>
    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $log->id }}</th>
                        <td class="px-6 py-4">{{ $log->user ? getUserTitle($log->user) : 'Guest' }}</td>
                        <td class="px-6 py-4">{{ $log->method }}</td>
                        <td class="px-6 py-4" x-data="{ showFullUrl: false }">
                            <div class="relative">
                                <!-- Truncated URL with hover/click functionality -->
                                <div class="flex items-center space-x-2">
            <span class="cursor-pointer hover:text-blue-400" @click="showFullUrl = !showFullUrl">
                {{ Str::limit($log->url, 40) }}
            </span>
                                    @if(strlen($log->url) > 40)
                                        <button @click="showFullUrl = !showFullUrl"
                                                class="text-xs text-blue-500 hover:text-blue-400">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    @endif
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
                                                    <h3 class="text-xl font-semibold text-blue-400 mb-4">Full URL</h3>
                                                    <div class="bg-gray-900 rounded p-4">
                                                        <div class="flex items-center justify-between space-x-4">
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
                        <td class="px-6 py-4">{{ $log->created_at }}</td>
                        <td class="px-6 py-4" x-data="{ showBody: false, showHeaders: false }">
                            <div class="flex space-x-2 relative z-10">
                                <!-- Body Button -->
                                <button @click.prevent="showBody = true"
                                        class="relative z-20 text-yellow-600 dark:text-yellow-500 hover:text-yellow-700 dark:hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
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
                                        class="relative z-20 text-blue-600 dark:text-blue-500 hover:text-blue-700 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
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
                                                <h3 class="text-xl font-semibold text-yellow-400 mb-4">Request Body</h3>
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
        <div class="flex flex-col justify-center mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
</body>
</html>
