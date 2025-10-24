@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm rounded-lg border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-900 flex items-center">
            <i class="fas fa-envelope mr-3 text-gray-600"></i>
            {{ __('pages.email_test.title') }}
        </h2>
        <p class="text-gray-600 mt-1">{{ __('pages.email_test.description') }}</p>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('email.test.send') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.email_test.company') }}</label>
                        <select name="company_id" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">{{ __('pages.email_test.company_help') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.email_test.email_type') }}</label>
                        <select name="email_type" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                            @foreach($types as $type)
                                <option value="{{ $type->key }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">{{ __('pages.email_test.email_type_help') }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('pages.email_test.language') }}</label>
                        <select name="language" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                            @foreach($languages as $language)
                                <option value="{{ $language->code }}" {{ $language->is_default ? 'selected' : '' }}>
                                    {{ $language->name }} {{ $language->is_default ? '(Default)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">{{ __('pages.email_test.language_help') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipient</label>
                        <select name="recipient_user_id" required id="recipient_user_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-gray-500 focus:ring-1 focus:ring-gray-500">
                            <option value="">Select a recipient...</option>
                            @foreach($companies as $company)
                                @foreach($company->users as $user)
                                    <option value="{{ $user->id }}" data-company="{{ $company->id }}" class="company-{{ $company->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Select who will receive the email</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 p-4 rounded-md">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-gray-500 mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">{{ __('pages.email_test.fallback_info.title') }}</h4>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p class="{{ session('email_data.fallback_level') == 1 ? 'text-blue-600 font-semibold' : '' }}">
                                <strong>{{ __('pages.email_test.fallback_info.level1') }}</strong>
                            </p>
                            <p class="{{ session('email_data.fallback_level') == 2 ? 'text-blue-600 font-semibold' : '' }}">
                                <strong>{{ __('pages.email_test.fallback_info.level2') }}</strong>
                            </p>
                            <p class="{{ session('email_data.fallback_level') == 3 ? 'text-blue-600 font-semibold' : '' }}">
                                <strong>{{ __('pages.email_test.fallback_info.level3') }}</strong>
                            </p>
                            <p class="{{ session('email_data.fallback_level') == 4 ? 'text-blue-600 font-semibold' : '' }}">
                                <strong>{{ __('pages.email_test.fallback_info.level4') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-6 rounded-md transition-colors duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    {{ __('pages.email_test.preview_button') }}
                </button>
            </div>
        </form>

        @if(session('email_preview'))
            <div class="mt-8 bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-envelope-open mr-3 text-gray-600"></i>
                        {{ __('pages.email_test.preview_title') }}
                    </h3>
                    @if(session('email_data'))
                        <div class="mt-2 text-sm text-gray-600">
                            <p><strong>Sender:</strong> {{ session('email_data.sender_name') }} &lt;{{ session('email_data.sender_email') }}&gt;</p>
                            <p><strong>Recipient:</strong> {{ session('email_data.recipient_name') }} &lt;{{ session('email_data.recipient_email') }}&gt;</p>
                            <p><strong>{{ __('pages.email_test.company') }}:</strong> {{ session('email_data.company') }}</p>
                            <p><strong>{{ __('pages.email_test.email_type') }}:</strong> {{ session('email_data.email_type') }}</p>
                            <p><strong>{{ __('pages.email_test.language') }}:</strong> {{ session('email_data.language') }}</p>
                            <p><strong>{{ __('pages.email_test.template_source') }}:</strong> {{ session('email_data.template_source') }}</p>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="prose max-w-none">
                            {!! session('email_preview') !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const companySelect = document.querySelector('select[name="company_id"]');
    const recipientSelect = document.getElementById('recipient_user_id');

    function filterUsers(selectElement, companyId) {
        const options = selectElement.querySelectorAll('option');
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
                return;
            }

            const userCompanyId = option.getAttribute('data-company');
            if (userCompanyId === companyId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Reset selection if current selection is not from the selected company
        const selectedOption = selectElement.querySelector('option:checked');
        if (selectedOption && selectedOption.getAttribute('data-company') !== companyId) {
            selectElement.value = '';
        }
    }

    companySelect.addEventListener('change', function() {
        const companyId = this.value;
        filterUsers(recipientSelect, companyId);
    });

    // Initialize with first company selected
    if (companySelect.value) {
        filterUsers(recipientSelect, companySelect.value);
    }
});
</script>
@endsection
