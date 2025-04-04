<x-app-layout>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de Bord - Employé') }}
        </h2>
    </x-slot>
    
    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Créer un Nouveau Ticket</h2>
            <form action="{{ route('tickets.store') }}" method="POST">
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

                 <!-- Statut du Ticket -->
            <div class="mb-4">
                <label for="statut" class="block text-gray-700 dark:text-gray-300">Statut :</label>
                <select id="statut" name="statut" class="block mt-1 w-full rounded-md shadow-sm" required>
                    <option value="Ouvert">Ouvert</option>
                    <option value="En cours">En cours</option>
                    <option value="Résolu">Résolu</option>
                    <option value="Fermé">Fermé</option>
                </select>
            </div>

                 <!-- Priorité du Ticket -->
            <div class="mb-4">
                <label for="priorité" class="block text-gray-700 dark:text-gray-300">Priorité :</label>
                <select id="priorité" name="priorité" class="block mt-1 w-full rounded-md shadow-sm" required>
                    <option value="Faible">Faible</option>
                    <option value="Moyenne">Moyenne</option>
                    <option value="Élevée">Élevée</option>
                    <option value="Critique">Critique</option>
                </select>
            </div>
            <input type="hidden" name="id_employe" value="{{ auth()->user()->id }}">
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
                            <td class="border border-gray-300 px-4 py-2">{{ $ticket->statut }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

