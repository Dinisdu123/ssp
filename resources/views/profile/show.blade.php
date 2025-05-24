<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-cinzel">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-10">
        <!-- Profile Information -->
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="bg-white p-6 rounded-md shadow-md">
                @livewire('profile.update-profile-information-form')
            </div>
            <x-section-border />
        @endif

        <!-- Order History -->
        <div class="bg-white p-6 rounded-md shadow-md">
            <h3 class="text-lg font-semibold text-black font-cinzel uppercase tracking-wider mb-4">Order History</h3>
            @if ($orders->isEmpty())
                <p class="text-gray-600 font-lora">You have no orders yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Order ID</th>
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Date</th>
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Total</th>
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Status</th>
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Address</th>
                                <th class="py-2 text-left font-cinzel text-sm text-black uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-b">
                                    <td class="py-3 font-lora text-sm">{{ $order->_id }}</td>
                                    <td class="py-3 font-lora text-sm">{{ $order->ordered_date->format('Y-m-d') }}</td>
                                    <td class="py-3 font-lora text-sm">LKR {{ number_format($order->total_price, 2) }}</td>
                                    <td class="py-3 font-lora text-sm">{{ ucfirst($order->order_status) }}</td>
                                    <td class="py-3 font-lora text-sm">{{ $order->delivery_address }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('order.confirmation', $order->_id) }}" class="text-blue-600 hover:underline font-lora text-sm">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <x-section-border />

        <!-- Update Password -->
        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="bg-white p-6 rounded-md shadow-md">
                @livewire('profile.update-password-form')
            </div>
            <x-section-border />
        @endif

        <!-- Two-Factor Authentication -->
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="bg-white p-6 rounded-md shadow-md">
                @livewire('profile.two-factor-authentication-form')
            </div>
            <x-section-border />
        @endif

        <!-- Logout Other Sessions -->
        <div class="bg-white p-6 rounded-md shadow-md">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        <!-- Account Deletion -->
        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-section-border />
            <div class="bg-white p-6 rounded-md shadow-md">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>

    <style>
        .font-cinzel {
            font-family: 'Cinzel', serif;
            font-weight: 900;
        }
        .font-lora {
            font-family: 'Lora', serif;
        }
        .button-pulse {
            background-color: #D4AF37;
            color: #000000;
            transition: all 0.4s ease;
        }
        .button-pulse:hover {
            background-color: #b8972e;
            transform: scale(1.03);
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.25);
        }
    </style>
</x-app-layout>