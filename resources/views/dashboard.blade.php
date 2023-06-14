<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-black dark:text-gray-200 leading-tight">
            {{ __('Posts:') }}
        </h2> -->
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                
                    <!-- POSTS -->
                    @foreach (App\Models\Post::all() as $post)
                    <div class="flex flex-col border-b mb-4" x-data="{ showComments: false, likesCount: {{ $post->likes }} }">
                        <a href="{{ route('community.show', $post->community->id) }}" class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight bg-gray-700 px-3 py-2 rounded-lg mb-2">
                            <div>{{ $post->community->title }}</div>
                        </a>
                        <div class="flex justify-between items-center hover:bg-gray-300 py-2 px-4">
                            <div class="font-bold">
                                <p class="text-black-600">{{ $post->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-start p-4">
                            <div class="flex-grow">{{ $post->body }}</div>
                        </div>

                        <!-- Botão de Like -->
                        <div class="flex justify-end items-center p-4">
                            <button class="text-gray-500 hover:text-red-500" @click="likePost({{ $post->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M19.84 5.68a5.5 5.5 0 0 1 0 7.77l-7.07 7.07a1.5 1.5 0 0 1-2.12 0L4.16 13.47a5.5 5.5 0 0 1 0-7.77 5.5 5.5 0 0 1 7.77 0L12 6.23l.47.47.47-.47a5.5 5.5 0 0 1 7.77 0zM12 21.5l-1.34-1.34a2 2 0 0 1-2.83 0L5.5 16" />
                                </svg>
                            </button>
                            <span class="text-sm ml-2">Likes: <span class="like-count" x-text="likesCount"></span></span>
                        </div>

                        <!-- COMMENTS -->
                        <div class="bg-gray-900 bg-opacity-75 px-4 py-2">
                            <h3 class="font-bold text-lg cursor-pointer flex items-center" @click="showComments = !showComments">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5 w-5">
                                    <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Comentários
                            </h3>

                            <div x-show="showComments">
                                @foreach ($post->comments as $comment)
                                <div class="flex justify-between items-center bg-white my-2 p-2 border border-gray-200">
                                    <div class="font-bold text-black">{{ $comment->user->name }}</div>
                                    <div class="text-black">{{ $comment->content }}</div>
                                    @if (auth()->user()->id == $post->community->user_id || auth()->user()->id == $comment->user_id)
                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Excluir Comentário</button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach

                                <!-- Formulário para adicionar comentários -->
                                <form action="{{ route('comment.store') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                                    <div class="mb-4">
                                        <label for="content" class="font-bold text-black">Novo comentário:</label>
                                        <textarea name="content" id="content" rows="3" class="form-textarea mt-1 block w-full" placeholder="Digite seu comentário..." required></textarea>
                                    </div>

                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">Adicionar comentário</button>
                                </form>
                            </div>
                        </div>

                        <!-- Excluir post -->
                        @if (auth()->user()->id == $post->user_id || auth()->user()->id == $post->community->user_id)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Excluir Post</button>
                        </form>
                        @endif
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
