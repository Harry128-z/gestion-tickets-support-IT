<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de Bord - Administrateur') }}
        </h2>
    </x-slot>

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
                                    <form action="{{ url('/tickets/'.$ticket->id.'/assign') }}" method="POST">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
