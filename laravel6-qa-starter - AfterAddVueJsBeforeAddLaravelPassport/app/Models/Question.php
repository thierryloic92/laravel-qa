<?php

namespace App\Models;

use App\User;
use App\Models\Answer;
use Illuminate\Support\Str;
use App\Components\VotableTrait;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;
    protected $fillable = ['title','body'];

    protected $appends = ['created_date' ,'favorites_count','is_favorited','body_html'];
    

    public function setTitleAttribute ($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);

    }

    public function getUrlAttribute() {
        return route ("questions.show",$this->slug);
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute () {
        return $this->answers_count > 0 
        ?  ( $this->best_answer_id ? 'answered-accepted' : 'answered') 
        : 'unanswered';
    }

    public function getBodyHtmlAttribute() {
        return clean(\Parsedown::instance()->text($this->body));
    }

    public function getIsFavoritedAttribute() {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute () {
        return $this->favorites->count();
    }

    public function getExcerptAttribute() {
        return $this->excerpt(250);
        
    }

    public function excerpt($length) {
        return Str::limit(strip_tags($this->body_html, $length)) ; // Avec méthode la version originale n'est pas stockée dans la BDD par contre avec Purifier toute la question entière y est stockée
    }

    //Relationship between models
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers () {
        return $this->hasMany(Answer::class,'question_id')->orderBy('votes_count','DESC');
    }

    public function acceptBestAnswer (Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites () {
        return $this->belongsToMany(User::class,'favorites')->withTimestamps(); // ,'question_id','user_id'
    }

    public function isFavorited () {
        return $this->favorites()->where('user_id',\Auth::id())->count() > 0;
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

}
