@if ($answerCount > 0)
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ $answerCount . ' ' . Str::plural('Answer', $answerCount) }}
                    </h2>
                </div>
                <hr>
                @include('layouts._message')
                @foreach ($answers as $answer)
                    @include('answers._answer',[
                        'answer'=>$answer
                    ])
                    
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
