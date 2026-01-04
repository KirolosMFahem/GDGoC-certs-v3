@props(['name', 'value' => ''])

@php
    $variables = [
        [ 'name' => 'Recipient_Name', 'label' => 'Recipient Name', 'type' => 'text' ],
        [ 'name' => 'Event_Title', 'label' => 'Event Title', 'type' => 'text' ],
        [ 'name' => 'Org_Name', 'label' => 'Org Name', 'type' => 'text' ],
        [ 'name' => 'Org_Logo', 'label' => 'Org Logo', 'type' => 'image' ],
        [ 'name' => 'state', 'label' => 'State', 'type' => 'text' ],
        [ 'name' => 'event_type', 'label' => 'Event Type', 'type' => 'text' ],
        [ 'name' => 'issue_date', 'label' => 'Issue Date', 'type' => 'text' ],
        [ 'name' => 'issuer_name', 'label' => 'Issuer Name', 'type' => 'text' ],
        [ 'name' => 'Issuer_Signature', 'label' => 'Signature', 'type' => 'image' ],
        [ 'name' => 'unique_id', 'label' => 'Unique ID', 'type' => 'text' ]
    ];

    if (auth()->check() && auth()->user()->role === 'superadmin') {
        $variables[] = [
            'name' => 'password_reset_url',
            'label' => 'Password Reset URL',
            'type' => 'text'
        ];
    }
@endphp

<div class="email-editor-container flex h-[700px] border border-gray-300 rounded-md overflow-hidden">
    <!-- Blocks Sidebar -->
    <div class="w-1/5 bg-gray-100 border-r border-gray-300 p-2 overflow-y-auto">
        <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase">Blocks</h3>
        <div id="blocks"></div>
    </div>

    <!-- GrapesJS Canvas -->
    <div class="flex-1 bg-gray-50">
        <div id="gjs" style="height: 100%; overflow: hidden;"></div>
    </div>
</div>

<input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}">

@vite(['resources/js/grapes.js'])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ensure the function is available (it's attached to window in grapes.js)
        if (window.initGrapesEditor) {
            window.initGrapesEditor('#gjs', '#{{ $name }}', @json($value), @json($variables));
        } else {
            // Wait for module load if needed, or simple polling
            const interval = setInterval(() => {
                if (window.initGrapesEditor) {
                    clearInterval(interval);
                    window.initGrapesEditor('#gjs', '#{{ $name }}', @json($value), @json($variables));
                }
            }, 100);
        }
    });
</script>
