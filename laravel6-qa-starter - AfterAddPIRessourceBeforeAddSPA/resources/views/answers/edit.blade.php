@extends('layouts.app')
@section('content')
<div class="container">
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h1> Editing answer for question {{ $question->title }}</h1>
                </div>
                <hr>
                <form action="{{ route('questions.answers.update',[$question->id,$answer->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                             name="body" row="10"> 
                             {{ old('body',$answer->body) }}                       
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
                        <button class="btn btn-outline-primary btn-lg">Update</button>
                    </div>
                    {{-- @include('questions._form',['buttonText'=>'Ask Question']) --}}
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection