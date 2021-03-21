@can('accept',$model)
<a href="" class=" {{ $model->status }} mt-2" 
title="Mark this answer as best answer" 
onclick="event.preventDefault(); 
document.getElementById('accept-answer-{{ $model->id }}').submit();">
    <i class="fas fa-check fa-2x"></i>
</a>
<form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept',$model->id)}}" method="POST" style="display : none;">
     @csrf
</form>
@else
@if($model->is_best)
<a href="" class=" {{ $model->status }} mt-2" 
    title="The question owner accepted  this answer as best answer" 
>
        <i class="fas fa-check fa-2x"></i>
    </a>
@endif
@endcan