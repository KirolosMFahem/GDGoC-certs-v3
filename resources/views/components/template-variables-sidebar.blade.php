<div x-data="{
    variables: [
        { name: 'Recipient_Name', description: 'Name of the recipient' },
        { name: 'Event_Title', description: 'Title of the event' },
        { name: 'Org_Name', description: 'Organization Name' },
        { name: 'state', description: 'State/Province' },
        { name: 'event_type', description: 'Type of event (e.g., Workshop)' },
        { name: 'issue_date', description: 'Date of issue' },
        { name: 'issuer_name', description: 'Name of the issuer' },
        { name: 'unique_id', description: 'Unique Certificate ID' }
    ]
}" class="w-1/4 pl-6 border-l border-gray-200">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Variables</h3>
    <p class="text-sm text-gray-500 mb-4">Drag and drop these variables into the editor.</p>

    <div class="space-y-2">
        <template x-for="variable in variables" :key="variable.name">
            <div
                draggable="true"
                @dragstart="
                    $event.dataTransfer.effectAllowed = 'copy';
                    $event.dataTransfer.setData('text/plain', '@{{ $' + variable.name + ' }}');
                    $event.dataTransfer.setData('application/x-certificate-variable', variable.name);
                "
                class="p-3 bg-gray-50 rounded-md border border-gray-200 cursor-move hover:bg-indigo-50 hover:border-indigo-300 transition-colors shadow-sm group"
            >
                <div class="flex items-center justify-between">
                    <span class="font-mono text-sm text-indigo-700 font-medium" x-text="'@{{ $' + variable.name + ' }}'"></span>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                    </svg>
                </div>
                <div class="text-xs text-gray-500 mt-1" x-text="variable.description"></div>
            </div>
        </template>
    </div>
</div>
