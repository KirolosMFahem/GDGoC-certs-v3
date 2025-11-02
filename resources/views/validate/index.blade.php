{{--
    Certificate Validation Index View
--}}
<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Validate Certificate
            </h2>

            <p class="text-sm text-gray-600 mb-6 text-center">
                Enter the unique certificate ID to validate and view certificate details.
            </p>

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET" action="{{ route('public.validate.query') }}">
                <div class="mb-4">
                    <x-input-label for="unique_id" :value="__('Certificate ID')" />
                    <x-text-input 
                        id="unique_id" 
                        class="block mt-1 w-full" 
                        type="text" 
                        name="unique_id" 
                        :value="old('unique_id')" 
                        required 
                        autofocus
                        placeholder="Enter certificate unique ID" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Validate Certificate') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
