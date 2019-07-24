@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <br>
                    <br>
                    <div>
                        <a href="{{ route('questions.index') }}" class="btn btn-outline-success btn-lg btn-block">Go To All Questions !</a href="">
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
