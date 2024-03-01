@extends('layouts.app')

@section('components')

    function addClassesToBody(classes) {
        var body = document.querySelector('body');
        body.classList.add(...classes.split(' '));
    }

    addClassesToBody("flex center-all h-screen");

    const Cards = () => {
        return (
            <div className="flex card mt-3">
                
                @foreach($descriptions as $description)

                    <p> {{ $description }} </p>

                @endforeach

                <p>, &nbsp;
                    <a href="https://framework-x.org/docs/getting-started/quickstart" target="_blank" className="btn btn-primary">View Documentation</a>
                </p>

            </div>
        );
    }
    
    
@endsection

@section('content')

    <div className="mt-3">
        <div className="flex center-start">
            <span>🌿 &nbsp;</span>
            <h4> {{$title}} </h4>
        </div>

        <Cards />
    </div>
    
@endsection