<x-app-layout>
    <x-slot name="header">
        <h2>
        <a href="{{ route('community.index') }}" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __(' ⇦') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('community.store')}}" method="POST">
                        @csrf
                      
                        <div class="mt-4">
                            <x-input-label for="title" :value="__('title')" class="text-xl" />
                            <x-text-input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="title" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="about" :value="__('about')" class="text-xl" />
                            <x-text-input id="about" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="about" required />
                        </div>

                       

                        <br>

                        <x-primary-button class="w-full bg-rose-600">
                            Add
                        </x-primary-button>
                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>