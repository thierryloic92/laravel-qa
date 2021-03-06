<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // \DB::enableQueryLog(); Enable Query Log
        $questions = Question::with('user')->latest()->paginate(10);

        // view('questions.index',compact('questions'))->render();
        // dd(\DB::getQueryLog()); display Query Log
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {

        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', 'Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // $question->views = $question->views + 1; $question->save();
        $question->increment('views'); // Idem que la ligne précedente
        //        dd($question->body);

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // if (\Gate::denies('update-question', $question)) {
        //     abort('403',"Access Denied");
        // }
        $this->authorize("update", $question);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        // if (\Gate::denies('update-question', $question)) {
        //     abort('403',"Access Denied");
        // }
        $this->authorize("update", $question);
        $question->update($request->only('title', 'body'));

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Your question has been updated',
                'body_html' => $question->body_html
            ]);
        }
        return redirect()->route('questions.index')->with('success', 'Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // When we use Gate to authorize
        // if (\Gate::denies('delete-question', $question)) {
        //     abort('403',"Access Denied");
        // }
        $this->authorize("delete", $question);
        $question->delete();

        if(request()->exceptsJson()) {
            return response()->json([
                'message' => 'Your question has been deleted'
            ]);
        }
        return redirect()->route('questions.index')->with('success', 'Your question has been deleted');
    }
}
