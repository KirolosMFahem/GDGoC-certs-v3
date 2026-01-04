@php
    $variables = [
        [
            'name' => 'Recipient_Name',
            'label' => 'Recipient Name',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'></path></svg>"
        ],
        [
            'name' => 'Event_Title',
            'label' => 'Event Title',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'></path></svg>"
        ],
        [
            'name' => 'Org_Name',
            'label' => 'Organization',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'></path></svg>"
        ],
        [
            'name' => 'Org_Logo',
            'label' => 'Org Logo',
            'type' => 'image',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'></path></svg>"
        ],
        [
            'name' => 'state',
            'label' => 'State',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'></path></svg>"
        ],
        [
            'name' => 'event_type',
            'label' => 'Event Type',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'></path></svg>"
        ],
        [
            'name' => 'issue_date',
            'label' => 'Issue Date',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'></path></svg>"
        ],
        [
            'name' => 'issuer_name',
            'label' => 'Issuer Name',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'></path></svg>"
        ],
        [
            'name' => 'Issuer_Signature',
            'label' => 'Signature',
            'type' => 'image',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z'></path></svg>"
        ],
        [
            'name' => 'unique_id',
            'label' => 'Unique ID',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'></path></svg>"
        ]
    ];

    if (auth()->check() && auth()->user()->role === 'superadmin') {
        $variables[] = [
            'name' => 'password_reset_url',
            'label' => 'Password Reset URL',
            'type' => 'text',
            'icon' => "<svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'></path></svg>"
        ];
    }
@endphp

<div x-data="{
    variables: @json($variables)
}" class="w-1/3 pl-6 border-l border-gray-200">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Content Blocks</h3>
    <p class="text-sm text-gray-500 mb-4">Drag blocks to add content.</p>

    <div class="grid grid-cols-2 gap-3">
        <template x-for="variable in variables" :key="variable.name">
            <div
                draggable="true"
                @dragstart="
                    $event.dataTransfer.effectAllowed = 'copy';
                    // For Textareas: Pass the Blade syntax directly
                    // We use @{{ }} to ensure Blade outputs the braces literals for JS
                    const textContent = variable.type === 'image'
                        ? '<img src=\x22@{{ $' + variable.name + ' }}\x22 alt=\x22' + variable.label + '\x22 />'
                        : '@{{ $' + variable.name + ' }}';

                    $event.dataTransfer.setData('text/plain', textContent);

                    // For Visual Editor: Pass metadata
                    $event.dataTransfer.setData('application/x-certificate-variable', variable.name);
                    $event.dataTransfer.setData('application/x-certificate-variable-type', variable.type);
                "
                class="flex flex-col items-center justify-center p-4 bg-white rounded-lg border border-gray-200 cursor-move hover:bg-indigo-50 hover:border-indigo-500 hover:shadow-md transition-all duration-200 group text-center h-24"
            >
                <div class="text-gray-400 group-hover:text-indigo-600 mb-2" x-html="variable.icon"></div>
                <span class="text-xs font-medium text-gray-700 group-hover:text-indigo-700" x-text="variable.label"></span>
            </div>
        </template>
    </div>
</div>
