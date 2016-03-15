<?php

// https://laracasts.com/discuss/channels/general-discussion/l5-form-errors-better-way-to-do-it
$errors = session()->has('errors')? session('errors'): $errors;
?>

@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        {!!
            Form::open(array(
                'action'=> 'MemberController@store',
                'files' => true,
                'class' => 'form col-sm-8 col-sm-offset-2',
                'method'=> 'POST'
            ))
        !!}
        <div class="form-group">
            {!!
                Form::text('name', '', array(
                    'class'         => 'form-control',
                    'placeholder'   => 'Name'
                ))
            !!}
            @if ($errors->has('name'))
                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::text('address', '', array(
                    'class'         => 'form-control',
                    'placeholder'   => 'Address'
                ))
            !!}
            @if ($errors->has('address'))
                <div class="alert alert-danger">{{ $errors->first('address') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::text('age', null, array(
                    'class'         => 'form-control',
                    'placeholder'   => 'Age'
                ))
            !!}
            @if ($errors->has('age'))
                <div class="alert alert-danger">{{ $errors->first('age') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::file('photo', null);
            !!}
            @if ($errors->has('photo'))
                <div class="alert alert-danger">{{ $errors->first('photo') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::submit('Create', array(
                    'class' => 'form-control btn btn-primary'
                ))
            !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop
