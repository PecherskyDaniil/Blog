<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Comments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @foreach ($comments as $comment)
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom:20px;">
                <form class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700" style="margin:10px;" action="{{ route('get-post', ['id' => $comment->publication_id]) }}">
                    <input type="submit" style="color:white;font-size:20px" value="To post" />
                </form>
                <div class="p-6 text-gray-900 dark:text-gray-100" >
                <div style="border:2px solid white;border-radius:10px 10px;padding:10px">{{$comment->text}}</div>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
