<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoritesController extends Controller
{

    
    public function store(Question $question) {
        $question->favorites()->attach(\Auth::id());
        return response()->json(null,204);
    }

    public function destroy(Question $question) {
        $question->favorites()->detach(\Auth::id());
        return response()->json(null,204);
    }
}
