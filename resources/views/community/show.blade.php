<x-app-layout>
    <x-slot name="header">
        <h2>
            <a href="{{ route('community.index') }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight absolute left-0 mt-4 ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-bold">{{ $community->title }}</h1>
            <p class="text-gray-600">Criador: {{ optional($community->user)->name }}</p>
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
                                <!-- Botão de Like -->
                                    <div class="flex justify-end items-center p-4">
                                        <button class="text-gray-500 hover:text-red-500" @click="like.store({{ $post->id }}, {{ auth()->user()->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                                <path d="M19.84 5.68a5.5 5.5 0 0 1 0 7.77l-7.07 7.07a1.5 1.5 0 0 1-2.12 0L4.16 13.47a5.5 5.5 0 0 1 0-7.77 5.5 5.5 0 0 1 7.77 0L12 6.23l.47.47.47-.47a5.5 5.5 0 0 1 7.77 0zM12 21.5l-1.34-1.34a2 2 0 0 1-2.83 0L5.5 16" />
                                            </svg>
                                        </button>
                                        <span class="text-sm ml-2">Likes: <span class="like-count" x-text="likesCount"></span></span>
                                    </div>
                            </div>

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
            <script>
                function toggleComments(element) {
                    const commentsDiv = element.nextElementSibling;
                    commentsDiv.classList.toggle('hidden');
                }


                const like = {
                    store: function(post_id, user_id) {
                        axios.post('/likes', {
                                post_id: post_id
                            })
                            .then(function(response) {
                                // Atualizar o contador de likes na interface
                                const likeCountElement = document.querySelector('.like-count');
                                likeCountElement.textContent = response.data.likesCount;
                            })
                            .catch(function(error) {
                                if (error.response.status === 409) {
                                    // O usuário já curtiu o post, exibir uma mensagem de erro
                                    alert('Você já curtiu esse post.');
                                } else {
                                    // Outro erro ocorreu, exibir uma mensagem genérica de erro
                                    alert('Ocorreu um erro ao processar a solicitação.');
                                }
                            });
                    }
                };
            </script>
        </div>

    </div>


</x-app-layout>