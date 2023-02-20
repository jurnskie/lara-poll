<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
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
    public function store(SubmissionRequest $request, Question $question): RedirectResponse
    {

        Submission::create([
            'question_id' => $question->id,
            'answer_id' => $request->validated()['answer'],
            'user_id' => auth()->user()->id
        ]);

        return \redirect()->route('polls.show', $question->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question): Response
    {
        $results = DB::table('submissions')
            ->where('question_id', $question->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        //if user already made a submission show poll results
        if( count($results) ){

//
//            $submissions = DB::table('answers')
//                ->leftJoin('submissions', function($join) use ($question) {
//                    $join->on('answers.id', '=', 'submissions.answer_id')
//                        ->where('submissions.question_id', '=', $question->id);
//                })
//                ->join('questions', 'questions.id', '=', 'answers.question_id')
//                ->where('questions.id', $question->id)
//                ->select('answers.id as answer_id', 'answers.description', DB::raw('count(submissions.answer_id) as answer_count'))
//                ->groupBy('answers.id', 'answers.description')
//                ->get();
            $user_id = auth()->user()->id;
            $submissions = DB::table('answers')
                ->leftJoin('submissions', function($join) use ($question, $user_id) {
                    $join->on('answers.id', '=', 'submissions.answer_id')
                        ->where('submissions.question_id', '=', $question->id)
                        ->where('submissions.user_id', '=', $user_id);
                })
                ->join('questions', 'questions.id', '=', 'answers.question_id')
                ->where('questions.id', $question->id)
                ->select('answers.id as answer_id', 'answers.description', DB::raw('count(submissions.answer_id) as answer_count'), DB::raw('(CASE WHEN submissions.user_id = ' . $user_id . ' THEN 1 ELSE 0 END) as selected'))
                ->groupBy('answers.id', 'answers.description', 'selected')
                ->get();

            return \response()->view('submissions.show', [
                'question' => $question,
                'results' => $submissions
            ]);
        } else{
            $question->load('answers');
            return \response()->view('polls.show', ['question' => $question]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $answerSubmission): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $answerSubmission): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $answerSubmission): RedirectResponse
    {
        //
    }
}
