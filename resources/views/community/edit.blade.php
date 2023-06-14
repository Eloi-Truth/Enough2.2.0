<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Comunidade
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('community.update', $community->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                Título:
                            </label>
                            <input type="text" name="title" id="title" value="{{ $community->title }}" class="border border-gray-300 rounded-md p-2 w-full">
                        </div>

                        <div class="mb-4">
                            <label for="about" class="block text-gray-700 text-sm font-bold mb-2">
                                Sobre:
                            </label>
                            <textarea name="about" id="about" class="border border-gray-300 rounded-md p-2 w-full">{{ $community->about }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
