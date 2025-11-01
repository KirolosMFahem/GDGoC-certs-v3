<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('OIDC Configuration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.oidc.update') }}">
                        @csrf

                        <!-- Client ID -->
                        <div class="mb-4">
                            <x-input-label for="client_id" :value="__('Client ID')" />
                            <x-text-input id="client_id" class="block mt-1 w-full" type="text" name="client_id" :value="old('client_id', $settings->client_id)" />
                            <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
                        </div>

                        <!-- Client Secret -->
                        <div class="mb-4">
                            <x-input-label for="client_secret" :value="__('Client Secret')" />
                            <x-text-input id="client_secret" class="block mt-1 w-full" type="password" name="client_secret" :value="old('client_secret', $settings->client_secret)" />
                            <x-input-error :messages="$errors->get('client_secret')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">Stored encrypted in the database</p>
                        </div>

                        <!-- Scope -->
                        <div class="mb-4">
                            <x-input-label for="scope" :value="__('Scope')" />
                            <x-text-input id="scope" class="block mt-1 w-full" type="text" name="scope" :value="old('scope', $settings->scope)" />
                            <x-input-error :messages="$errors->get('scope')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">E.g., openid profile email</p>
                        </div>

                        <!-- Login Endpoint URL -->
                        <div class="mb-4">
                            <x-input-label for="login_endpoint_url" :value="__('Login Endpoint URL')" />
                            <x-text-input id="login_endpoint_url" class="block mt-1 w-full" type="url" name="login_endpoint_url" :value="old('login_endpoint_url', $settings->login_endpoint_url)" />
                            <x-input-error :messages="$errors->get('login_endpoint_url')" class="mt-2" />
                        </div>

                        <!-- Userinfo Endpoint URL -->
                        <div class="mb-4">
                            <x-input-label for="userinfo_endpoint_url" :value="__('Userinfo Endpoint URL')" />
                            <x-text-input id="userinfo_endpoint_url" class="block mt-1 w-full" type="url" name="userinfo_endpoint_url" :value="old('userinfo_endpoint_url', $settings->userinfo_endpoint_url)" />
                            <x-input-error :messages="$errors->get('userinfo_endpoint_url')" class="mt-2" />
                        </div>

                        <!-- Token Validation Endpoint URL -->
                        <div class="mb-4">
                            <x-input-label for="token_validation_endpoint_url" :value="__('Token Validation Endpoint URL')" />
                            <x-text-input id="token_validation_endpoint_url" class="block mt-1 w-full" type="url" name="token_validation_endpoint_url" :value="old('token_validation_endpoint_url', $settings->token_validation_endpoint_url)" />
                            <x-input-error :messages="$errors->get('token_validation_endpoint_url')" class="mt-2" />
                        </div>

                        <!-- End Session Endpoint URL -->
                        <div class="mb-4">
                            <x-input-label for="end_session_endpoint_url" :value="__('End Session Endpoint URL')" />
                            <x-text-input id="end_session_endpoint_url" class="block mt-1 w-full" type="url" name="end_session_endpoint_url" :value="old('end_session_endpoint_url', $settings->end_session_endpoint_url)" />
                            <x-input-error :messages="$errors->get('end_session_endpoint_url')" class="mt-2" />
                        </div>

                        <!-- Identity Key -->
                        <div class="mb-4">
                            <x-input-label for="identity_key" :value="__('Identity Key')" />
                            <x-text-input id="identity_key" class="block mt-1 w-full" type="text" name="identity_key" :value="old('identity_key', $settings->identity_key)" />
                            <x-input-error :messages="$errors->get('identity_key')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">The claim name used to identify the user (e.g., sub, email)</p>
                        </div>

                        <!-- Checkboxes -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="link_existing_users" value="1" {{ old('link_existing_users', $settings->link_existing_users) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Link Existing Users</span>
                            </label>
                            <p class="text-sm text-gray-500 ml-6">Allow linking OIDC accounts to existing email addresses</p>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="create_new_users" value="1" {{ old('create_new_users', $settings->create_new_users) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Create New Users</span>
                            </label>
                            <p class="text-sm text-gray-500 ml-6">Automatically create new users on first OIDC login</p>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="redirect_on_expiry" value="1" {{ old('redirect_on_expiry', $settings->redirect_on_expiry) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Redirect on Expiry</span>
                            </label>
                            <p class="text-sm text-gray-500 ml-6">Redirect to OIDC provider when session expires</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
