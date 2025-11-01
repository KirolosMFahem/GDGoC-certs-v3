<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>Login Logs - {{ config('app.name') }}</title>
        <link>{{ route('admin.logs.index') }}</link>
        <description>Recent login attempts and authentication activity</description>
        <language>en-us</language>
        <pubDate>{{ now()->toRssString() }}</pubDate>
        
        @foreach($logs as $log)
        <item>
            <title>{{ $log->success ? 'Successful' : 'Failed' }} login attempt for {{ $log->email }}</title>
            <description>
                {{ $log->success ? 'Successful' : 'Failed' }} login attempt
                - Email: {{ $log->email }}
                - IP Address: {{ $log->ip_address }}
                - Time: {{ $log->created_at->format('Y-m-d H:i:s') }}
            </description>
            <pubDate>{{ $log->created_at->toRssString() }}</pubDate>
            <guid>{{ route('admin.logs.index') }}#log-{{ $log->id }}</guid>
        </item>
        @endforeach
    </channel>
</rss>
