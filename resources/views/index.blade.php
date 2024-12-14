<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $log->id }}</th>
                        <td class="px-6 py-4">{{ $log->user ? getUserTitle($log->user) : 'Guest' }}</td>
                        <td class="px-6 py-4">{{ $log->method }}</td>
                        <td class="px-6 py-4">{{ $log->url }}</td>
                        <td class="px-6 py-4">{{ $log->ip_address }}</td>
                        <td class="px-6 py-4">{{ $log->user_agent }}</td>
                        <td class="px-6 py-4">{{ $log->response_status }}</td>
                        <td class="px-6 py-4">{{ $log->created_at }}</td>
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
