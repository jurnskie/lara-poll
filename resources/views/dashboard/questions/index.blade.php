<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Application's Questions</h1>
                    <div>
                        <a href="{{route('questions.create')}}" class="btn btn-success my-5">
                            New question
                        </a>
                    </div>
                    @if('questions')
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th>title</th>
                                        <th>status</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{$question->id}}</td>
                                            <td>{{$question->title}}</td>
                                            <td>{{$question->status}}</td>
                                            <td>
                                                <div class="flex justify-end">
                                                    <form action="{{route('questions.destroy', $question->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="i-heroicons-trash text-red-400 mt-4 mr-4" type="submit"></button>

                                                    </form>
                                                    <a href="{{route('questions.edit', $question->id)}}">
                                                        <div class="i-heroicons-pencil-square text-blue-400 mt-4 mr-4" ></div>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @endif
                    @if(session('message'))
                        <div class="alert w-1/2 ml-10 mx-auto alert-success shadow-lg fixed bottom-20 left-0">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{session('message')}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
