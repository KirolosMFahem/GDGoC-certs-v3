<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $page->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex">
                    <!-- Left Column: Navigation -->
                    <div class="w-1/4 border-r border-gray-200 p-6">
                        <h3 class="font-semibold text-lg mb-4">Documentation</h3>
                        <nav class="space-y-2">
                            @foreach($pages as $navPage)
                                <a href="{{ route('dashboard.documentation.show', $navPage->slug) }}" class="block px-3 py-2 text-sm {{ $navPage->id === $page->id ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} rounded-md">
                                    {{ $navPage->title }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <!-- Right Column: Content -->
                    <div class="w-3/4 p-6">
                        <div class="documentation-content prose max-w-none">
                            @php
                                $converter = new \League\CommonMark\CommonMarkConverter([
                                    'html_input' => 'escape',
                                    'allow_unsafe_links' => false,
                                ]);
                                echo $converter->convert($page->content);
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
