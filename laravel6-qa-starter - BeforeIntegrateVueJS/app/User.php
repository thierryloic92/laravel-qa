<?php

namespace App;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUrlAttribute()
    {
        // return route ("questions.show",$this->id);
        return '#';
    }
    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;
        return  "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) ."?&s=" . $size;
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id');
    }

    public function favorites () {
        return $this->belongsToMany(Question::class,'favorites')->withTimestamps(); //,'user_id','question_id'
    }

    public function voteQuestions() {
        return $this->morphedByMany(Question::class,'votable')->withTimestamps();;
    }

    public function voteAnswers() {
        return $this->morphedByMany(Answer::class,'votable')->withTimestamps();;
    }

    public function voteQuestion(Question $question,$vote) {
        $voteQuestions = $this->voteQuestions();
        $this->_vote($voteQuestions,$question,$vote);
        // if($voteQuestions->where('votable_id',$question->id)->exists()) {
        //     $this->voteQuestions()->updateExistingPivot($question,['vote'=>$vote]);
        // } else {
        //     $this->voteQuestions()->attach($question, ['vote'=>$vote]);
        // }

        // $question->load('votes');

        // $downVotes = (int) $question->downVotes()->sum('vote');
        // $upVotes = (int) $question->upVotes()->sum('vote');
        // // $downVotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
        // // $upVotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');

        // $question->votes_count= $upVotes + $downVotes;
        // $question->save();

    }
    public function voteAnswer(Answer $answer,$vote) {
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers,$answer,$vote);
        // if($voteAnswers->where('votable_id',$answer->id)->exists()) {
        //     $voteAnswers->updateExistingPivot($answer,['vote'=>$vote]);
        //     // $this->voteAnswers()->updateExistingPivot($answer,['vote'=>$vote]);
        // } else {
        //     // $this->voteAnswers()->attach($answer, ['vote'=>$vote]);
        //     $voteAnswers->attach($answer, ['vote'=>$vote]);
        // }

        // $answer->load('votes');

        // $downVotes = (int) $answer->downVotes()->sum('vote');
        // $upVotes = (int) $answer->upVotes()->sum('vote');
        // // $downVotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
        // // $upVotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');

        // $answer->votes_count= $upVotes + $downVotes;
        // $answer->save();

    }

    private function _vote($relationship,$model,$vote) {

        if($relationship->where('votable_id',$model->id)->exists()) {
            $relationship->updateExistingPivot($model,['vote'=>$vote]);
        } else {
            $relationship->attach($model, ['vote'=>$vote]);
        }

        $model->load('votes');

        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');
        // $downVotes = (int) $question->votes()->wherePivot('vote',-1)->sum('vote');
        // $upVotes = (int) $question->votes()->wherePivot('vote',1)->sum('vote');

        $model->votes_count= $upVotes + $downVotes;
        $model->save();

    }
}
