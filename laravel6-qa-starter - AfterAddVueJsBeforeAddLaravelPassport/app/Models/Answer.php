<?php

namespace App\Models;

use App\User;
use App\Models\Question;
use App\Components\VotableTrait;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;
    protected $fillable = ['body','user_id'];
    protected $appends = ['created_date','body_html','is_best'];
    
    public function question (){
        return $this->belongsTo(Question::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }
    
    
    public function getBodyHtmlAttribute() {
        return clean(\Parsedown::instance()->text($this->body));
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }
    
    public function getStatusAttribute() {
        return $this->isBest() ? 'vote-accepted' : '';
    }
    
    public function getIsBestAttribute () {
        return $this->isBest();
    }
    
    public function isBest() {
        return $this->id === $this->question->best_answer_id; 
    }
    
    // public function votes() {
    //     return $this->morphToMany(User::class,'votable');
    // }
    // public function upVotes() {
    //     return $this->votes()->wherePivot('vote',1);
    // }
    // public function downVotes() {
    //     return $this->votes()->wherePivot('vote',-1);
    // }

    


    public static function boot () {
        parent::boot();
        static::created(function ($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
            // $question = $answer->question;
            // $question->decrement('answers_count');
            // if ($question->best_answer_id === $answer->id) {
            //     // var_dump($question->best_answer_id);
            //     $question->best_answer_id = NULL;
            //     // dd($question->best_answer_id);
            //     $answer->question->save();
            // }
        });

        // static::saved(function($answer){
        //     echo "Answer saved\n";
        // });
    }
}
