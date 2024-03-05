@extends('layouts.app')
@section('jsx')

    <Header></Header>
    
    <SampleComponent
        title='{{$title}}'
        description='{{$description}}' />

@endsection