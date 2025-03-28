<x-app-layout>

    @if (session('status'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
        {{ session('status') }}
    </div>
@endif

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
            {{ __('Tableau de Bord - Technicien') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Tickets Assignés</h2>
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Titre</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Priorité</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
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
                                <form action="{{ url('/tickets/'.$ticket->id.'/update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                            
                                    <!-- Champ pour le statut -->
                                    <select name="statut" required class="mb-2 block w-full rounded-md shadow-sm">
                                        <option value="En cours" {{ $ticket->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="Résolu" {{ $ticket->statut == 'Résolu' ? 'selected' : '' }}>Résolu</option>
                                        <option value="Fermé" {{ $ticket->statut == 'Fermé' ? 'selected' : '' }}>Fermé</option>
                                    </select>
                            
                                    <!-- Champ pour les actions effectuées -->
                                    <textarea name="actions" rows="3" placeholder="Décrivez les actions effectuées"
                                              class="block w-full rounded-md shadow-sm mb-2"></textarea>
                            
                                    <!-- Bouton de mise à jour -->
                                    <button type="submit" style="background-color: #007BFF; color: white; padding: 8px 15px; font-size: 14px; border-radius: 5px;">
                                        Mettre à jour
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
