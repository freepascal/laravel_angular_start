<?php

// https://laracasts.com/discuss/channels/general-discussion/l5-form-errors-better-way-to-do-it
$errors = session()->has('errors')? session('errors'): $errors;
?>

@extends('layout')
@section('content')
    <div class="container-fluid">
        {!!
            Form::model($member, array(
                'action'    => array('MemberController@update',$member->id),
                'method'    => 'PATCH',
                'files'     => true,
                'class' => 'form col-sm-8 col-sm-offset-2',
            ))
        !!}
        <div class="form-group">
            {!!
                Form::text('name', $member->name, array(
                    'class'         => 'form-control',
                ))
            !!}
            @if ($errors->has('name'))
                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::text('address', $member->address, array(
                    'class'         => 'form-control',
                ))
            !!}
            @if ($errors->has('address'))
                <div class="alert alert-danger">{{ $errors->first('address') }}</div>
            @endif
        </div>

        <div class="form-group">
            {!!
                Form::text('age', $member->age, array(
                    'class'         => 'form-control',
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
                Form::submit('Save', array(
                    'class' => 'form-control btn btn-primary'
                ))
            !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop()
