<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom:20px">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                
                <div style="width:100%;height:fit-content;">
                    <div style="width:fit-content;height:fit-content;font-size:15px;margin-left:auto;margin-right:10px;margin-top:10px;margin-bottom:10px;">Created: {{$post->created_at}}</div>
                    <div style="border:2px solid white;border-radius:10px 10px;padding:10px">{{$post->text}}</div>
                    @if (!is_null($post->imagename))
                    <img style="border:1px solid white;border-radius:10px 10px;width:100%;px;margin-left:auto;margin-right:auto" src="{{ url('storage/'.$post->imagename) }}" alt="" title="">
                    @endif
                    <div style="width:fit-content;margin-left:auto;margin-right:10px;margin-top:10px;margin-bottom:10px;">
                        <div style="display:inline-block;width:fit-content;padding:5px;border:2px solid white;border-radius:10px 10px; font-size:20px;">
                            @if ($post->publicated==0)
                                <form method="POST" action="{{ route('publish-post') }}" >
                                    @csrf
                                    <button name="publish" value="{{$post->id}}">publish<button>
                                </form>
                            @else
                            <form method="POST" action="{{ route('unpublish-post') }}" >
                                @csrf
                                    <button name="unpublish" value="{{$post->id}}">unpublish<button>
                            </form>
                            @endif
                        </div>
                        <div style="display:inline-block;width:fit-content;padding:5px;border:2px solid white;border-radius:10px 10px; font-size:20px;">
                            <form method="GET" action="{{ route('get-edit-post') }}" >
                                    @csrf
                                    <button name="edit" value="{{$post->id}}">edit<button>
                            </form>
                        </div>
                        <div style="display:inline-block;width:fit-content;padding:5px;border:2px solid white;border-radius:10px 10px; font-size:20px; background-color:#f7684f">
                            <form method="POST" action="{{ route('delete-post') }}" >
                                    @csrf
                                    <button name="delete" value="{{$post->id}}">delete<button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
