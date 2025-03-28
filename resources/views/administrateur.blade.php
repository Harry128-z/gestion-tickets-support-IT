<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de Bord - Administrateur') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold mb-4">Statistiques des Tickets</h2>
        <ul>
            <li>Total tickets : {{ $statistiques['total_tickets'] }}</li>
            <li>Tickets ouverts : {{ $statistiques['tickets_ouverts'] }}</li>
            <li>Tickets résolus : {{ $statistiques['tickets_resolus'] }}</li>
            <li>Tickets critiques : {{ $statistiques['tickets_critiques'] }}</li>
            <li>Temps moyen de résolution : {{ $statistiques['temps_moyen_resolution'] }} heures</li>
        </ul>
    </div>
    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <!-- Gestion des Tickets -->
            <h2 class="text-lg font-semibold mb-4">Gestion des Tickets</h2>
            
            @if($tickets->isEmpty())
                <p>Aucun ticket trouvé.</p>
            @else
                <table class="w-full table-auto border-collapse border border-gray-300 mb-6">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Titre</th>
                            <th class="border border-gray-300 px-4 py-2">Description</th>
                            <th class="border border-gray-300 px-4 py-2">Priorité</th>
                            <th class="border border-gray-300 px-4 py-2">Statut</th>
                            <th class="border border-gray-300 px-4 py-2">Technicien</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->titre }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->description }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->priorité }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->statut }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $ticket->id_technicien ? $ticket->technicien->nom : 'Non assigné' }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <!-- Assigner un technicien -->
                                    <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                                        @csrf
                                        <select name="id_technicien" required>
                                            <option value="" disabled selected>Assigner un technicien</option>
                                            @foreach ($techniciens as $technicien)
                                                <option value="{{ $technicien->id }}">{{ $technicien->nom }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" style="background-color: #28a745; color: white; padding: 8px 15px; font-size: 14px; border-radius: 5px;">
                                            Assigner
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <h3 class="text-md font-semibold mb-4">Ajouter un Utilisateur</h3>
            <form action="{{ route('users.create') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 dark:text-gray-300">Nom :</label>
                    <input type="text" id="nom" name="nom" class="block mt-1 w-full rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300">Email :</label>
                    <input type="email" id="email" name="email" class="block mt-1 w-full rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 dark:text-gray-300">Rôle :</label>
                    <select id="role" name="role" class="block mt-1 w-full rounded-md shadow-sm" required>
                        <option value="technicien">Technicien</option>
                        <option value="employe">Employé</option>
                    </select>
                </div>
                <button type="submit" style="background-color: #007BFF; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px;">
                    Ajouter
                </button>
            </form>

            <!-- Gestion des Utilisateurs -->
            <h2 class="text-lg font-semibold mb-4">Gestion des Utilisateurs</h2>
            @if($users->isEmpty())
                <p>Aucun utilisateur trouvé.</p>
            @else
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Nom</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->nom }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->role }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #dc3545; color: white; padding: 8px 15px; font-size: 14px; border-radius: 5px;">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
