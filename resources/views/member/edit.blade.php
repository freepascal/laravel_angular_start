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
        </div>

        <div class="form-group">
            {!!
                Form::text('address', $member->address, array(
                    'class'         => 'form-control',
                ))
            !!}
        </div>

        <div class="form-group">
            {!!
                Form::text('age', $member->age, array(
                    'class'         => 'form-control',
                ))
            !!}
        </div>

        <div class="form-group">
            {!!
                Form::file('photo', null);
            !!}
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
