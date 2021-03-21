<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3> Your answer</h3>
                </div>
                <hr>
                <form action="{{ route('questions.answers.store',$question->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                             name="body" row="10">                        
                        </textarea>

                        @if ($errors->has('body'))
                        <div class="invalid-feedback">
                            <strong> {{ $errors->first('body') }}</strong>
                        </div>
                        @endif

                    </div>
                    {{-- <div class="form-group">
                        <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                             name="body" row="7">
                        {{ old('body',$question->body) }}
                        </textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong> {{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div> --}}
                    <div class="form-group">
                        <button class="btn btn-outline-primary btn-lg">Submit</button>
                    </div>
                    {{-- @include('questions._form',['buttonText'=>'Ask Question']) --}}
                </form>
            </div>
        </div>
    </div>
</div>