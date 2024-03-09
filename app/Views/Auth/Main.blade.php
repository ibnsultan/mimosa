@extends('layouts.app')

@section('jsx')

    <div className='formContainer loginForm'>
        <LoginForm
            redirect='{{config->home}}'
            formTitle="{{config->app_name}}" >
        </LoginForm>
    </div>

@endsection