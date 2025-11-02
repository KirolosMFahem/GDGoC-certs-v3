{{--
    Certificate Show/Details View
    
    Expected variables:
    @var \App\Models\Certificate $certificate - The certificate to display
--}}
<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            @if($certificate->status === 'revoked')
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                    <div class="flex items-center mb-2">
                        <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h2 class="text-xl font-bold">Certificate Revoked</h2>
                    </div>
                    <p class="mb-2">
                        This certificate (ID: <span class="font-mono">{{ $certificate->unique_id }}</span>) was revoked on 
                        <strong>{{ $certificate->revoked_at ? $certificate->revoked_at->format('F d, Y') : 'Unknown' }}</strong>.
                    </p>
                    <p class="text-sm">
                        <strong>Reason:</strong> {{ $certificate->revocation_reason ?? 'No reason provided' }}
                    </p>
                </div>
            @else
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-bold">Certificate Valid</h2>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <div class="border-b pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Recipient Name</h3>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $certificate->recipient_name }}</p>
                </div>

                <div class="border-b pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Event</h3>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $certificate->event_title }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ ucfirst($certificate->event_type) }} - {{ ucfirst($certificate->state) }}
                    </p>
                </div>

                <div class="border-b pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Issued By</h3>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $certificate->org_name }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        Issuer: {{ $certificate->issuer_name }}
                    </p>
                </div>

                <div class="border-b pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Issue Date</h3>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $certificate->issue_date->format('F d, Y') }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Certificate ID</h3>
                    <p class="text-sm font-mono text-gray-900 mt-1 break-all">{{ $certificate->unique_id }}</p>
                </div>
            </div>

            @if($certificate->status === 'issued')
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('public.certificate.download', ['unique_id' => $certificate->unique_id]) }}" 
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF Certificate
                    </a>
                </div>
            @endif

            <div class="mt-6 text-center">
                <a href="{{ route('public.validate.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                    ← Validate Another Certificate
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
