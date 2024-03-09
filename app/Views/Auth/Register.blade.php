@extends('layouts.app')
@section('jsx')

    <div className='formContainer registerForm'>
        <RegisterForm 
            redirect='{{config->login_url}}'
            formTitle='{{config->app_name}}'>
        </RegisterForm>
    </div>

@endsection