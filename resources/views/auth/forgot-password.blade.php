<x-guest-layout>
    <x-authentication-card>
    <x-slot name="logo">
        <div class="flex flex-col items-center">
            <img src="{{ asset('budget.png') }}" alt="Finansų logotipas" class="w-20 h-20 rounded-full shadow-md mb-2">
            <h1 class="text-xl font-bold text-gray-800">Asmeninių finansų sistema</h1>
        </div>
    </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Pamiršai slaptažodį? Jokių problemų. Tiesiog įvesk savo el. pašto adresą ir mes atsiųsime slaptažodžio atkūrimo nuorodą, kuri leis tau pasirinkti naują slaptažodį.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('El. Paštas') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Atstatyti slaptažodį') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
