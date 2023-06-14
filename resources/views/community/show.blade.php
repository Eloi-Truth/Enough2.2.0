<x-app-layout>
    <x-slot name="header">
        <h2>
            <a href="{{ route('community.index') }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __(' ⇦') }}
            </a>
            <h1 class="text-2xl font-bold">{{ $community->title }}</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gray-200 p-4 mb-4">
                    <div class="flex justify-between items-center">
                        <div class="text-left">
                            <h1 class="text-2xl font-bold">{{ $community->title }}</h1>
                            <p class="text-gray-600">{{ $community->about }}</p>
                            <p class="text-gray-600">Criador: {{ optional($community->user)->name }}</p>
                        </div>
                        <div class="text-center">
                            <form action="{{ route('posts.store') }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex items-center justify-center">
                                    <div class="w-2/3">
                                        <x-input-label for="body" :value="__('Body')" class="text-xl" />
                                        <x-text-input id="body" class="block mt-1 w-full" type="text" name="body" required />
                                    </div>
                                    <input type="hidden" id="community_id" name="community_id" value="{{ $community->id }}" />
                                    <x-primary-button class="ml-4 bg-rose-600">Add</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($community->posts as $post)
                            <div class="bg-white dark:bg-gray-700 p-4 shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-md font-bold">{{ $post->user->name }}</h4>
                                    <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                                </div>
                                <p class="text-gray-800">{{ $post->body }}</p>

                                <div class="mt-4">
                                    <h4 class="text-md font-semibold mb-2 cursor-pointer" onclick="toggleComments(this)">Comentários</h4>

                                    <div class="comments hidden">
                                        @foreach ($post->comments as $comment)
                                            <div class="flex items-center mb-2">
                                                <span class="font-semibold">{{ $comment->user->name }}:</span>
                                                <p class="ml-2">{{ $comment->content }}</p>
                                                @if (auth()->user()->id == $community->user_id || auth()->user()->id == $comment->user_id)
                                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500">Excluir</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach

                                        <form action="{{ route('comment.store') }}" method="POST" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                                            <div class="mb-4">
                                                <x-input-label for="comment_content" :value="__('Novo Comentário')" class="text-xl" />
                                                <x-text-input id="comment_content" class="block mt-1 w-full" type="text" name="content" required />
                                            </div>

                                            <x-primary-button class="w-full bg-blue-500">Adicionar Comentário</x-primary-button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Condição para exibir botões de exclusão e edição para o dono da comunidade ou o dono do post -->
                                @if (auth()->user()->id == $community->user_id || auth()->user()->id == $post->user_id)
                                    <div class="mt-4">
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">Excluir Post</button>
                                        </form>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500">Editar Post</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($community->posts->isEmpty())
                        <p class="text-gray-600">Nenhum post encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

   
</x-app-layout>

<script>
    function toggleComments(element) {
        const commentsDiv = element.nextElementSibling;
        commentsDiv.classList.toggle('hidden');
    }
</script>
