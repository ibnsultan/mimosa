@extends('layouts.app')
@section('jsx')

    <div className="mt-3">
        <div className="flex center-start">
            <span>🌿 &nbsp;</span>
            <h4> {{$title}} </h4>
        </div>

        <Cards />

    </div>

@endsection