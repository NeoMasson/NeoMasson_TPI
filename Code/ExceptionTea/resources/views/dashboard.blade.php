@extends('layouts.app')

@section('header', 'Tous les Thés')

@section('content')
<div class="overflow-x-auto">
    <div class="bg-[#967259] text-white px-4 py-2 mb-4 flex justify-between items-center">
        <h2>Tous les Thés</h2>
        <div class="flex items-center gap-4">
            <span>🍵</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white hover:text-gray-200">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
    <table class="w-full border-collapse">
        <thead class="bg-[#967259] text-white">
            <tr>
                <th class="px-4 py-2 text-left border border-[#967259]">Nom</th>
                <th class="px-4 py-2 text-left border border-[#967259]">Type</th>
                <th class="px-4 py-2 text-left border border-[#967259]">Provenance</th>
                <th class="px-4 py-2 text-center border border-[#967259]">Détails</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les données des thés seront injectées ici dynamiquement -->
        </tbody>
    </table>
</div>
@endsection
