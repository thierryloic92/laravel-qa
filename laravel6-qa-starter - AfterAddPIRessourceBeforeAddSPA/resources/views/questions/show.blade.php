@extends('layouts.app')

@section('content')
    <div class="container">
        <question-page :question="{{ $question }}"></question-page>
        {{-- <answers :answers="{{ $question->answers }}" :count="{{ $question->answers_count }}"></answers> --}}

        {{-- @include('answers._create') --}}
    </div>
@endsection
