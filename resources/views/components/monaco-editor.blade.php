@props(['name', 'id' => null, 'value' => '', 'language' => 'html', 'height' => '500px'])

@php
    $id = $id ?? $name;
    $containerId = $id . '_monaco_container';
@endphp

<div id="{{ $containerId }}" style="height: {{ $height }}; border: 1px solid #d1d5db; border-radius: 0.375rem;"></div>
<input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}">

@vite(['resources/js/monaco.js'])

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const init = () => {
            if (window.initMonacoEditor) {
                window.initMonacoEditor('{{ $containerId }}', '{{ $id }}', '{{ $language }}', @json($value));
            } else {
                setTimeout(init, 50);
            }
        };
        init();
    });
</script>
