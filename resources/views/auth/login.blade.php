<x-guest-layout>
    <x-authentication-card>

        <!-- Logo -->
        <x-slot name="logo">
            <div class="w-40">
                <a href="/">
                    <x-authentication-card-logo />
                </a>
            </div>
        </x-slot>

        @if (session('status'))
            <div class="py-4 font-medium text-sm text-green-600 bg-green-50">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('メールアドレス') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('パスワード') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('パスワードを保存する') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れたとき') }}
                    </a>
                @endif

                <x-button class="tx-s ml-4">
                    {{ __('ログイン') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
