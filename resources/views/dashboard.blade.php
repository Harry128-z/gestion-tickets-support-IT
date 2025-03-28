<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour Modifier le Profil -->
    <div class="max-w-7xl mx-auto mt-6">
        @if (Route::currentRouteName() === 'profile.edit')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Modifier votre Profil</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300">Nom :</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" 
                               class="block mt-1 w-full rounded-md shadow-sm" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-300">Email :</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                               class="block mt-1 w-full rounded-md shadow-sm" required>
                    </div>

                    <!-- Bouton Soumettre -->
                    <button type="submit" 
                            class="bg-blue-500 text-blue px-4 py-2 rounded-md hover:bg-blue-600">
                        Mettre à jour
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Section pour Créer un Ticket -->
    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Créer un Nouveau Ticket</h2>
            <form action="{{ url('/tickets') }}" method="POST">
                @csrf
                <!-- Titre du Ticket -->
                <div class="mb-4">
                    <label for="titre" class="block text-gray-700 dark:text-gray-300">Titre :</label>
                    <input type="text" id="titre" name="titre" 
                           class="block mt-1 w-full rounded-md shadow-sm" required>
                </div>

                <!-- Description du Ticket -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description :</label>
                    <textarea id="description" name="description" rows="4" 
                              class="block mt-1 w-full rounded-md shadow-sm" required></textarea>
                </div>

                <!-- Bouton Soumettre -->
                <button type="submit" style="background-color: #007BFF; color: white; padding: 12px 20px; font-size: 16px; border-radius: 5px; display: block; margin-top: 10px;">
                    Créer le Ticket
                </button>
                
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Liste des Tickets Créés</h2>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Titre</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->titre }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->description }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $ticket->statut }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</x-app-layout>
