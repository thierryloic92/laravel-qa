<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoteQuestionController extends Controller
{

    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        $votesCount = auth()->user()->voteQuestion($question, $vote);


        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Thanks for the feedback',
                'votesCount' => $votesCount
            ]);
        }
    }
}
