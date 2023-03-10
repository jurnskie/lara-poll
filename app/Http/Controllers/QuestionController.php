<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $questions = Question::paginate(12)->sortByDesc('order');

        return \response()->view('dashboard.questions.index', compact('questions'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('dashboard.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {

        $data = $request->validated();

        Question::create($data);

        return \response()->redirectTo(route('questions.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question): Response
    {
        return \response()->view('dashboard.questions.create', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question): Response
    {
        $question->load('answers');
        $statuses = collect(['draft','published']);
        return \response()->view('dashboard.questions.edit', compact('question','statuses'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question): RedirectResponse
    {
    }

    public function updateOrder(Request $request, Question $question){
        $answer = $request->get('answers');
        $order = $answer['order'];
        DB::table('answers')
            ->where('id', $answer['answer_id'])
            ->update(['order' => $answer['order']]);

        // Reorder the rest of the rows
        $rowsToUpdate = DB::table('answers')
            ->where(function ($query) use ($order) {
                $query->where('order', '>=', $order)
                    ->orWhereNull('order');
            })
            ->where('id', '!=', $answer['answer_id'])
            ->orderBy('order', 'asc')
            ->get();

        $nextValue = $order + 1;
        foreach ($rowsToUpdate as $rowToUpdate) {
            DB::table('answers')
                ->where('id', $rowToUpdate->id)
                ->update(['order' => $nextValue]);
            $nextValue++;
        }

        return redirect()->route('questions.edit', $question->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question): RedirectResponse
    {
        try {

            $question->delete();

            request()->session()->flash('message', 'Task was successful!');

            return \response()->redirectTo(route('questions.index'));

        }catch (\Exception $exception){
            return $exception;
        }
    }
}
