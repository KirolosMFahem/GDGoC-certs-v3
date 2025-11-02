<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Help & Documentation') }}
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
                            @forelse($pages as $page)
                                <a href="{{ route('dashboard.documentation.show', $page->slug) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    {{ $page->title }}
                                </a>
                            @empty
                                <p class="text-sm text-gray-500">No documentation available.</p>
                            @endforelse
                        </nav>
                    </div>

                    <!-- Right Column: Content -->
                    <div class="w-3/4 p-6">
                        <div class="prose max-w-none">
                            <h2>Welcome to the Help Center</h2>
                            <p>Select a topic from the left sidebar to view documentation and guides.</p>
                            <p>These resources will help you get started with the GDGoC Certificate Generation Platform and learn how to make the most of its features.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
