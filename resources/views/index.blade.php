<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Logs</title>
    @if(config('tracking.theme') === 'bootstrap')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    @elseif(config('tracking.theme') === 'tailwind')
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="@if(config('tracking.theme') === 'tailwind') bg-gray-100 @endif">
<div class="container mt-5">
    <h1 class="text-center mb-4 @if(config('tracking.theme') === 'bootstrap') text-primary @elseif(config('tracking.theme') === 'tailwind') text-blue-500 @endif">Request Logs</h1>
    <table class="@if(config('tracking.theme') === 'bootstrap') table table-striped table-bordered @elseif(config('tracking.theme') === 'tailwind') min-w-full bg-white divide-y divide-gray-200 @endif">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Method</th>
            <th>URL</th>
            <th>IP Address</th>
            <th>User Agent</th>
            <th>Status</th>
            <th>Headers</th>
            <th>Body</th>
            <th>Response Content</th>
            <th>Timestamp</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->user ? $log->user->name : 'Guest' }}</td>
                <td>{{ $log->method }}</td>
                <td>{{ $log->url }}</td>
                <td>{{ $log->ip_address }}</td>
                <td>{{ $log->user_agent }}</td>
                <td>{{ $log->response_status }}</td>
                <td>{{ $log->headers }}</td>
                <td>{{ $log->body }}</td>
                <td>{{ $log->response_content }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="@if(config('tracking.theme') === 'bootstrap') d-flex justify-content-center @elseif(config('tracking.theme') === 'tailwind') flex justify-center @endif">
        {{ $logs->links() }}
    </div>
</div>
</body>
</html>