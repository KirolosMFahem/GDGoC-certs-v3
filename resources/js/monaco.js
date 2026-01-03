import * as monaco from 'monaco-editor';
import editorWorker from 'monaco-editor/esm/vs/editor/editor.worker?worker';
import jsonWorker from 'monaco-editor/esm/vs/language/json/json.worker?worker';
import cssWorker from 'monaco-editor/esm/vs/language/css/css.worker?worker';
import htmlWorker from 'monaco-editor/esm/vs/language/html/html.worker?worker';
import tsWorker from 'monaco-editor/esm/vs/language/typescript/ts.worker?worker';

self.MonacoEnvironment = {
    getWorker(_, label) {
        if (label === 'json') {
            return new jsonWorker();
        }
        if (label === 'css' || label === 'scss' || label === 'less') {
            return new cssWorker();
        }
        if (label === 'html' || label === 'handlebars' || label === 'razor') {
            return new htmlWorker();
        }
        if (label === 'typescript' || label === 'javascript') {
            return new tsWorker();
        }
        return new editorWorker();
    }
};

window.initMonacoEditor = function(containerId, inputId, language = 'html', initialValue = '') {
    const container = document.getElementById(containerId);
    if (!container) return;

    const editor = monaco.editor.create(container, {
        value: initialValue,
        language: language,
        theme: 'vs-light', // or 'vs-dark'
        automaticLayout: true,
        minimap: { enabled: false }
    });

    const input = document.getElementById(inputId);

    // Update hidden input on change
    editor.onDidChangeModelContent(() => {
        input.value = editor.getValue();
        // Trigger input event for Alpine binding
        input.dispatchEvent(new Event('input'));
    });

    // Allow external updates (e.g., from drag-and-drop visual editor)
    // We expose the editor instance on the container element
    container._monaco = editor;
};
