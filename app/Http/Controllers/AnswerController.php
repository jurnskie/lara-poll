<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Question $question): RedirectResponse
    {
        $order = DB::table('answers')->where('question_id', $question->id)
            ->orderBy('order','desc')
            ->limit(1)
            ->get()
            ->all();

        $order = $order[0]->order;

        $newOrder = $order + 1;
        $answer = Answer::create([
            'question_id' => $question->id,
            'description' => $request->description,
            'order' => $newOrder
        ]);

        // Reorder the rest of the rows
        $rowsToUpdate = DB::table('answers')
            ->where(function ($query) use ($newOrder) {
                $query->where('order', '>=', $newOrder)
                    ->orWhereNull('order');
            })
            ->where('id', '!=', $answer->id)
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
     * Display the specified resource.
     */
    public function show(Answer $answer): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question, Answer $answer): RedirectResponse
    {

        try {
            $answer->delete();

        }catch (\Exception $exception){
            return redirect('questions.edit', $question->id)->withErrors($exception);

        }

        return redirect()->route('questions.edit', $question->id);
    }
}
