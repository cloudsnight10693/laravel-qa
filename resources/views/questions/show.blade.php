@extends('layouts.app')

@section('content')

    @include ('layouts._messages')

<question-page :question="{{ $question }}"></question-page>
@endsection
