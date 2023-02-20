<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $order = count($question->answers);

        Answer::create([
            'question_id' => $question->id,
            'description' => $request->description,
            'order' => ($order + 1)
        ]);

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
