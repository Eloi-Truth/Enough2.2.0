<x-app-layout>
    <x-slot name="header">

    <a href="{{ route('community.show', $community -> id) }}" class="font-semibold text-xl text-black-800  leading-tight">
                {{ __(' ⇦') }}
               
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Usuários Inscritos na Comunidade
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Comunidade: {{ $community->title }}</h3>
                    
                    @if ($users->isEmpty())
                        <p>Nenhum usuário inscrito nesta comunidade.</p>
                    @else
                        <ul>
                            @foreach ($users as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>