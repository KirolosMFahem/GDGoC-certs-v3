<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Certificate Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row gap-6"
                         x-data="{
                            type: '{{ old('type', $certificateTemplate->type) }}',
                            tab: 'code',
                            svgContent: '',

                            init() {
                                // Watch for changes in the textarea to update svgContent
                                $watch('svgContent', value => {
                                    document.getElementById('content').value = value;
                                });

                                // Initial sync if needed, though svgContent is initialized with blade output
                                // But blade output is string literal, so newlines might break it.
                                // Safer to read from textarea on mount.
                                this.svgContent = document.getElementById('content').value;
                            },

                            syncFromTextarea() {
                                this.svgContent = document.getElementById('content').value;
                            },

                            handleDrop(event) {
                                event.preventDefault();
                                const variableName = event.dataTransfer.getData('application/x-certificate-variable');
                                if (!variableName) return;

                                const svgContainer = this.$refs.visualPreview;
                                const svgEl = svgContainer.querySelector('svg');

                                if (!svgEl) {
                                    alert('Invalid SVG content. Please ensure valid SVG code is present.');
                                    return;
                                }

                                try {
                                    const pt = svgEl.createSVGPoint();
                                    pt.x = event.clientX;
                                    pt.y = event.clientY;

                                    // Transform to SVG coordinates
                                    const svgP = pt.matrixTransform(svgEl.getScreenCTM().inverse());

                                    // Create new text element
                                    const newText = `<text x=\x22${Math.round(svgP.x)}\x22 y=\x22${Math.round(svgP.y)}\x22 font-family=\x22Arial\x22 font-size=\x2224\x22 fill=\x22black\x22>@{{ $${variableName} }}</text>`;

                                    // Insert before closing svg tag
                                    const closeTagIndex = this.svgContent.lastIndexOf('</svg>');
                                    if (closeTagIndex !== -1) {
                                        this.svgContent = this.svgContent.substring(0, closeTagIndex) + '\n    ' + newText + '\n' + this.svgContent.substring(closeTagIndex);
                                    } else {
                                        alert('Could not find closing </svg> tag.');
                                    }
                                } catch (e) {
                                    console.error(e);
                                    alert('Error placing variable. Ensure the SVG is valid.');
                                }
                            }
                         }"
                    >
                        <div class="flex-1">
                            <form method="POST" action="{{ route('admin.templates.certificates.update', $certificateTemplate) }}">
                                @csrf
                                @method('PUT')

                                <!-- Name -->
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Template Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $certificateTemplate->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Type -->
                                <div class="mb-4">
                                    <x-input-label for="type" :value="__('Type')" />
                                    <select id="type" name="type" x-model="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="svg">SVG</option>
                                        <option value="blade">Blade</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <!-- Content Editor -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <x-input-label for="content" :value="__('Template Content')" />

                                        <!-- View Toggles (Only for SVG) -->
                                        <div x-show="type === 'svg'" class="flex bg-gray-100 rounded-lg p-1 text-sm">
                                            <button type="button"
                                                    @click="tab = 'code'"
                                                    :class="{'bg-white shadow': tab === 'code', 'text-gray-500': tab !== 'code'}"
                                                    class="px-3 py-1 rounded-md transition-all">
                                                Code
                                            </button>
                                            <button type="button"
                                                    @click="tab = 'visual'; syncFromTextarea()"
                                                    :class="{'bg-white shadow': tab === 'visual', 'text-gray-500': tab !== 'visual'}"
                                                    class="px-3 py-1 rounded-md transition-all">
                                                Visual Editor
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Code Editor -->
                                    <div x-show="tab === 'code' || type !== 'svg'">
                                        <textarea id="content"
                                                  name="content"
                                                  rows="15"
                                                  class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-mono text-sm"
                                                  required
                                                  @input="svgContent = $event.target.value"
                                        >{{ old('content', $certificateTemplate->content) }}</textarea>
                                    </div>

                                    <!-- Visual Editor (SVG Only) -->
                                    <div x-show="type === 'svg' && tab === 'visual'" class="mt-1 border border-gray-300 rounded-md p-4 bg-gray-50 overflow-auto min-h-[400px]"
                                         @dragover.prevent
                                         @drop="handleDrop($event)">
                                        <div x-ref="visualPreview" x-html="svgContent" class="pointer-events-none [&>svg]:pointer-events-auto [&>svg]:w-full [&>svg]:h-auto [&>svg]:bg-white [&>svg]:shadow-sm"></div>
                                        <p class="text-xs text-gray-500 mt-2 text-center">Drag variables from the sidebar onto the certificate preview above.</p>
                                    </div>

                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                    <p class="text-sm text-gray-600 mt-1">Enter your template content (SVG or Blade template)</p>
                                </div>

                                <!-- Is Global -->
                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_global" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_global', $certificateTemplate->is_global) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Make this a global template (accessible to all Leaders)</span>
                                    </label>
                                    <x-input-error :messages="$errors->get('is_global')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="button" id="preview-btn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                        {{ __('Preview') }}
                                    </button>

                                    <a href="{{ route('admin.templates.certificates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                        Cancel
                                    </a>

                                    <x-primary-button>
                                        {{ __('Update Template') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>

                        <x-template-variables-sidebar />
                    </div>

                    <x-template-preview-modal :route="route('admin.templates.certificates.preview')" type="certificate" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
