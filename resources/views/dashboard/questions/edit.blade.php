<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Question: {{$question->title}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('questions.update',$question->id) }}">
                        <div class="form-control">
                            <label for="title" class="mb-2">Title</label>
                            <input type="text" name="title" value="{{$question->title}}" class=" mb-5 input input-bordered w-full max-w-xs" />
                        </div>
                        <div class="form-control">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="select w-full max-w-xs mb-2 input-bordered">
                                @foreach($statuses as $status)
                                    @if($status == $question->status)
                                        <option value="{{$question->status}}" selected>
                                            {{$question->status}}
                                        </option>
                                    @else
                                        <option value="{{$status}}" selected>
                                            {{$status}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" value="Save" class="btn btn-success mt-5">
                    </form>

                    <h4 class="text-2xl mt-5">Question Answers</h4>
                    @if($question->answers && count($question->answers))
                            @csrf

                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th>#desc</th>
                                        <th>#order</th>
                                        <th>#actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($question->answers as $answer)
                                        <tr>
                                            <td>
                                                {{$answer->id}}
                                            </td>
                                            <td>{{$answer->excerpt()}}</td>
                                            <td>
                                                <form action="{{route('questions.order.answers',$question->id)}}" method="post">
                                                    @csrf
                                                    <input type="number" name="answers[order]" class="input w-full max-w-xs" value="{{$answer->order}}">
                                                    <input type="hidden" name="answers[answer_id]" class="input w-full max-w-xs" value="{{$answer->id}}">
                                                    <input type="hidden" name="answers[description]" class="input w-full max-w-xs" value="{{$answer->description}}">
                                                    <input type="hidden" name="answers[question_id]" class="input w-full max-w-xs" value="{{$question->id}}">
                                                    <input type="submit" class="btn btn-success mt-5" value="Update answers">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{route('questions.answers.destroy', [$question->id,$answer->id])}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="submit" class="btn btn-error mr-2" value="Verwijderen">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                    @endif


                    <h3 class="text-xl my-5">Add answer</h3>
                    <form action="{{route('questions.answers.store', $question->id)}}" method="POST">
                        @csrf
                        <div class="form-control">
                            <label for="description">
                                Desc
                            </label>
                            <input type="text" name="description" value="" class=" mb-5 input input-bordered w-full max-w-xs" />
                        </div>
                        <input type="submit" class="btn btn-success mt-5" value="Toevoegen">
                    </form>

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
