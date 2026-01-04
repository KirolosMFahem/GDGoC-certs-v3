import grapesjs from 'grapesjs';
import 'grapesjs/dist/css/grapes.min.css';
import newsletterPlugin from 'grapesjs-preset-newsletter';

window.initGrapesEditor = function (containerSelector, inputSelector, initialContent, customVariables = []) {
    const editor = grapesjs.init({
        container: containerSelector,
        height: '700px',
        width: 'auto',
        storageManager: false, // We use the form to save
        plugins: [newsletterPlugin],
        pluginsOpts: {
            [newsletterPlugin]: {
                // Newsletter options
            }
        },
        blockManager: {
            appendTo: '#blocks',
        },
        deviceManager: {
            devices: [{
                name: 'Desktop',
                width: '', // default size
            }, {
                name: 'Mobile',
                width: '320px', // this will be used on second breakpoint
                widthMedia: '480px', // this will be used in CSS @media
            }]
        },
        panels: {
            defaults: [
                // ... default panels
            ]
        }
    });

    // Add Custom Variable Blocks
    const blockManager = editor.BlockManager;

    // Default variables if none provided
    const variables = customVariables.length > 0 ? customVariables : [
        { name: 'Recipient_Name', label: 'Recipient Name' },
        { name: 'Event_Title', label: 'Event Title' },
        { name: 'Org_Name', label: 'Org Name' },
        { name: 'Org_Logo', label: 'Org Logo', type: 'image' },
        { name: 'state', label: 'State' },
        { name: 'event_type', label: 'Event Type' },
        { name: 'issue_date', label: 'Issue Date' },
        { name: 'issuer_name', label: 'Issuer Name' },
        { name: 'Issuer_Signature', label: 'Signature', type: 'image' },
        { name: 'unique_id', label: 'Unique ID' }
    ];

    variables.forEach(v => {
        let content = '';
        if (v.type === 'image') {
            content = `<img src="{{ $${v.name} }}" alt="${v.label}" style="max-width: 100%;" />`;
        } else {
            content = `<span>{{ $${v.name} }}</span>`;
        }

        blockManager.add(v.name, {
            label: v.label,
            content: content,
            category: 'Variables',
            attributes: {
                class: 'gjs-fonts gjs-f-b1' // Simple icon
            }
        });
    });

    // Load initial content
    if (initialContent) {
        editor.setComponents(initialContent);
    }

    // Sync with hidden input on change
    editor.on('change:changesCount', () => {
        const html = editor.runCommand('gjs-get-inlined-html');
        document.querySelector(inputSelector).value = html;
    });
};
