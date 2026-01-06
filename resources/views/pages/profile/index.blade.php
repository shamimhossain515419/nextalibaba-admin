@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-7xl md:p-6">

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Profile Settings
            </h2>
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="p-4 mb-6 rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 dark:text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-6 rounded-lg bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 dark:text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-6 rounded-lg bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h4 class="text-red-800 dark:text-red-300 font-medium mb-1">Please fix the following errors:</h4>
                        <ul class="list-disc pl-5 text-red-700 dark:text-red-400 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('POST')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Basic Information Card --}}
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            Basic Information
                        </h3>

                        <div class="space-y-5">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Full Name
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all outline-none"
                                       placeholder="Enter your full name"
                                       required>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email Address
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all outline-none"
                                       placeholder="Enter your email address"
                                       required>
                            </div>
                        </div>
                    </div>

                    {{-- Change Password Card --}}
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            Change Password
                        </h3>

                        <div class="space-y-5">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Leave password fields blank if you don't want to change your password.
                            </p>

                            {{-- Current Password --}}
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Current Password
                                </label>
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all outline-none"
                                       placeholder="Enter current password">
                            </div>

                            {{-- New Password --}}
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    New Password
                                </label>
                                <input type="password"
                                       id="new_password"
                                       name="new_password"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all outline-none"
                                       placeholder="Enter new password">
                            </div>

                            {{-- Confirm New Password --}}
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Confirm New Password
                                </label>
                                <input type="password"
                                       id="new_password_confirmation"
                                       name="new_password_confirmation"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 transition-all outline-none"
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="lg:col-span-1">
                    {{-- Profile Picture Card --}}
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            Profile Picture
                        </h3>

                        <div class="space-y-5">
                            {{-- Avatar Preview --}}
                            <div class="flex flex-col items-center">
                                <div class="relative mb-4">
                                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white dark:border-gray-800 shadow-lg">
                                        <img id="avatarPreview"
                                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff&size=128' }}"
                                             alt="{{ $user->name }}"
                                             class="w-full h-full object-cover">
                                    </div>


                                    {{-- Avatar Remove Button --}}
                                    @if($user->avatar)
                                        <button type="button"
                                                id="removeAvatarBtn"
                                                class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>

                                {{-- Upload Button --}}
                                <div class="w-full">
                                    <label for="avatar" class="block w-full">
                                        <div class="px-4 py-3 bg-blue-50 dark:bg-blue-900/30 border-2 border-dashed border-blue-200 dark:border-blue-800 rounded-lg text-center cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                            <svg class="w-6 h-6 text-blue-500 dark:text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                Upload New Photo
                                            </span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                JPG, PNG up to 2MB
                                            </p>
                                        </div>
                                        <input type="file"
                                               id="avatar"
                                               name="avatar"
                                               accept="image/*"
                                               class="hidden"
                                               onchange="previewAvatar(event)">
                                    </label>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="mt-8 flex justify-end">
                <button type="button"
                        onclick="history.back()"
                        class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium mr-4">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-medium transition-colors shadow-md hover:shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        // Avatar preview
        function previewAvatar(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;

                    // Show remove button if hidden
                    let removeBtn = document.getElementById('removeAvatarBtn');
                    if (!removeBtn) {
                        const avatarContainer = preview.parentElement.parentElement;
                        const removeButton = document.createElement('button');
                        removeButton.id = 'removeAvatarBtn';
                        removeButton.type = 'button';
                        removeButton.className = 'absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-md';
                        removeButton.innerHTML = `
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        `;
                        removeButton.onclick = removeAvatar;
                        avatarContainer.appendChild(removeButton);
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove avatar
        async function removeAvatar() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                try {
                    const response = await fetch('{{ route("removeAvatar") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    if (response.ok) {
                        const result = await response.json();
                        if (result.success) {
                            // Reset to default avatar
                            const preview = document.getElementById('avatarPreview');
                            preview.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ $user->name }}') + '&background=random&color=fff&size=128';

                            // Remove the file input value
                            document.getElementById('avatar').value = '';

                            // Hide remove button
                            const removeBtn = document.getElementById('removeAvatarBtn');
                            if (removeBtn) {
                                removeBtn.remove();
                            }

                            // Show success message
                            showMessage('Profile picture removed successfully!', 'success');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showMessage('Failed to remove profile picture', 'error');
                }
            }
        }

        // Message display function
        function showMessage(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `p-4 mb-6 rounded-lg ${type === 'success' ? 'bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800' : 'bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800'}`;
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'} mr-3" fill="currentColor" viewBox="0 0 20 20">
                        ${type === 'success' ?
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' :
                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
            }
                    </svg>
                    <span class="${type === 'success' ? 'text-green-800 dark:text-green-300' : 'text-red-800 dark:text-red-300'}">${text}</span>
                </div>
            `;

            const container = document.querySelector('.mx-auto');
            container.insertBefore(messageDiv, container.firstChild);

            // Remove message after 5 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 5000);
        }

        // Remove avatar button click handler
        document.getElementById('removeAvatarBtn')?.addEventListener('click', removeAvatar);
    </script>
@endsection
