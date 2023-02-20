<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="poll p-10">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Question: {{$question->title}} results are:
                    </h2>
                    <table class="table max-w-5xl">
                        <thead>
                            <tr>
                                <th>#id</th>
                                <th>desc</th>
                                <th>amount of votes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $row)
                                <tr >
                                    <td @if($row->selected) class="bg-green-500 text-black" @endif>{{$row->answer_id}}</td>
                                    <td @if($row->selected) class="bg-green-500 text-black" @endif>{{\Illuminate\Support\Str::limit($row->description,40)}}</td>
                                    <td @if($row->selected) class="bg-green-500 text-black" @endif>{{$row->answer_count}} antwoord(en) gegeven</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
