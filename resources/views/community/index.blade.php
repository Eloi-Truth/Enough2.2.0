<x-app-layout>
    <x-slot name="header">
        <h2>
            <a href="{{ route('community.create') }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Make Your Own Community') }}<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach (App\Models\Community::all() as $community)
                    <div class="bg-gradient-to-r from-black to-gray-900 text-white p-4 mb-4">
                        <div class="mt-4">
                            <a href="{{ route('community.show', $community->id) }}" class="font-semibold text-xl text-white-800 dark:text-gray-200 leading-tight">
                                <div>title: {{ $community->title }}</div>
                            </a>
                        </div>
                        <div class="mt-2 text-gray-400">
                            Criador: {{ $community->user->name }}
                        </div>
                        <div class="mt-4">
                            <x-input-label for="about" :value="__('About:')" class="text-xl text-white" />
                            <p class="text-white-600">{{ $community->about }}</p>
                        </div>
                        <div class="mt-4">
                            @if ($community->user_id === auth()->id())
                            <form action="{{ route('community.destroy', $community->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 underline">Delete</button>
                            </form>
                            <a href="{{ route('community.edit', $community) }}" class="text-blue-600 underline">Edit</a>
                            @endif
                        </div>

                        @auth
                        <div class="mt-4">
                            <form action="{{ route('communities.subscribe',  ['community' => $community->id, 'user_id' => auth()->id()]) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-600 underline">Inscrever-se</button>
                            </form>
                        </div>
                        @endauth

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>