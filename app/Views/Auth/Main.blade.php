@extends('layouts.app')

@section('jsx')

    <div className='formContainer loginForm'>
        <LoginForm
            redirect="{{config->auth['GUARD_HOME']}}"
            formTitle="{{config->app_name}}" >
        </LoginForm>
    </div>

@endsection