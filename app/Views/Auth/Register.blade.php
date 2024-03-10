@extends('layouts.app')
@section('jsx')

    <div className='formContainer registerForm'>
        <RegisterForm 
            redirect="{{config->auth['GUARD_LOGIN']}}"
            formTitle="{{config->app_name}}">
        </RegisterForm>
    </div>

@endsection