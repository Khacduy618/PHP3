<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    {{-- Use Bootstrap danger button --}}
    <button type="button" class="btn btn-danger" x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</button>

    {{-- Keep modal component, but style inner form with Bootstrap --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4"> {{-- Adjusted padding --}}
            @csrf
            @method('delete')

            <h2 class="h5 mb-3"> {{-- Use Bootstrap heading class --}}
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-muted mb-3"> {{-- Use Bootstrap text class --}}
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            {{-- Password Input with Bootstrap classes --}}
            <div class="mb-3">
                <label for="delete_user_password" class="form-label visually-hidden">{{ __('Password') }}</label>
                <input id="delete_user_password" {{-- Changed ID slightly --}} name="password" type="password"
                    class="form-control @error('password', 'userDeletion') is-invalid @enderror" {{-- Use Bootstrap
                    classes --}} placeholder="{{ __('Password') }}" />
                @error('password', 'userDeletion') {{-- Specify error bag --}}
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Modal Footer Buttons with Bootstrap classes --}}
            <div class="mt-4 d-flex justify-content-end">
                {{-- Use standard button with Alpine directive for closing --}}
                <button type="button" class="btn btn-secondary me-2" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                {{-- Use standard danger button for submission --}}
                <button type="submit" class="btn btn-danger">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>