<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="poll p-10">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Question: {{$question->title}}
                    </h2>

                    <form action="{{route('submissions.store', $question->id)}}" method="POST">
                        @csrf
                        @foreach($question->answers as $answer)

                            <div class="form-control">
                                <label for="answer_{{$answer->id}}" class="label-text hover:cursor-pointer my-3">
                                    <input type="radio" name="answer" class="radio" id="answer_{{$answer->id}}" value="{{$answer->id}}">

                                    {{$answer->description}}
                                </label>
                            </div>
                        @endforeach
                        <div class="form-control">
                            <input type="submit" value="save" class="btn btn-success mt-5">
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
