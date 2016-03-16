@extends('layout')
@section('content')
    <div ng-app="app" ng-controller="MemberController" class="container-fluid">
        <div class="panel panel-default col-sm-8 col-sm-offset-2">
            <div class="panel panel-heading">
                <h4>Edit member with specified ID [[ mem_to_edit.id ]]</h4>
            </div>
            <div class="panel panel-body">
                <div class="form-group">
                    <input type="text" ng-model="var_name" placeholder="[[ mem_to_edit.name ]]" class="form-control">
                    <div ng-repeat="e in error_name">
                        <div class="alert alert-danger">[[ e ]]</div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" ng-model="var_address" placeholder="[[ mem_to_edit.address ]]" class="form-control">
                    <div ng-repeat="e in error_address">
                        <div class="alert alert-danger">[[ e ]]</div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" ng-model="var_age" placeholder="[[ mem_to_edit.age ]]" class="form-control">
                    <div ng-repeat="e in error_age">
                        <div class="alert alert-danger">[[ e ]]</div>
                    </div>
                </div>
                <!--
                <div class="form-control">
                    <input type="file" file-model="myFile" ng-model="var_photo"/>
                </div>
                -->
            </div>
            <div class="panel panel-footer">
                <button type="button" class="btn btn-primary" ng-click="onSave(mem_to_edit)">Save</button>
            </div>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <a href="{{ route('member_create') }}" class="btn btn-primary lg">Add member</a>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li><a href="" ng-click="orderByField='id';reverseSort= !reverseSort">ID</a></li>
                    <li><a href="" ng-click="orderByField='name';reverseSort= !reverseSort">Name</a></li>
                    <li><a href="" ng-click="orderByField='address';reverseSort= !reverseSort">Address</a></li>
                    <li><a href="" ng-click="orderByField='age';reverseSort= !reverseSort">Age</a></li>
                </ul>
            </div>
        </div>

        <!-- show members table -->
        <!-- |orderBy:sort.orderByField:reverseSort -->
        <div ng-repeat="m in members |orderBy:orderByField:reverseSort">
            <div class="media col-sm-6" >
                <a class="pull-left" href="">
                    <img width="200px" height="200px" ng-src="[[m.photo]]">
                </a>
                <div class="media-body panel panel-default">
                    <div class="panel panel-body list-group">
                        <div class="list-group-item"><b>ID</b>: [[ m.id ]]</div>
                        <div class="list-group-item"><b>Name</b>: [[ m.name]]</div>
                        <div class="list-group-item"><b>Address</b>: [[ m.address]]</div>
                        <div class="list-group-item"><b>Age</b>: [[ m.age ]]</div>
                    <div>
                    <div class="panel panel-footer">
                        <button type="button" class="btn btn-primary" ng-click="onSelect(m)">Edit partials</button>
                        <button type="button" class="btn btn-primary" ng-click="onReconstruct(m)">Edit</button>
                        <button type="button" class="btn btn-warning" ng-click="onDelete(m.id,m)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
