var app = angular.module("app", [
    'ngCookies'
]);

// http://stackoverflow.com/questions/22996760/use-of-undefined-constant-assumed-id
app.config( function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

/*
A common issue with adding PATCH to AngularJS is that it doesn't have a default Content-Type header
for that HTTP method (which is application/json;charset=utf-8 for PUT, POST and DELETE).
And these are my configuration of the $httpProvider to add patch support:
*/
app.config(['$httpProvider', '$cookiesProvider', function($httpProvider, $cookiesProvider) {
    $httpProvider.defaults.headers.patch = {
        'Content-Type': 'application/json;charset=utf-8',
    }
//    $http.defaults.headers.patch['X-XSRF-TOKEN']= $cookies.get('XSRF-TOKEN');
}]);

app.directive('fileUpload', function() {

});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

// https://uncorkedstudios.com/blog/multipartformdata-file-upload-with-angularjs
app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(){
        })
        .error(function(){
        });
    }
}]);

app.controller("MemberController", ['$scope', '$http', 'fileUpload', function($scope, $http, fileUpload) {
    $scope.mem_to_edit = {};

    $scope.onInitializeOrRefreshPage = function() {
        $http.get("/api/v1/member")
            .success(function(data, status, headers, config) {
                $scope.members = angular.fromJson(data);
                for(var i = 0; i < $scope.members.length; ++i) {
                    $scope.members[i].id = parseInt($scope.members[i].id);
                    $scope.members[i].age = parseInt($scope.members[i].age);
                }
            })
            .error(function(data, status, headers, config) {
                alert("An error occurs while retrieving all members")
            });
    };

    $scope.onInitializeOrRefreshPage();

    $scope.onDelete = function(id, mem) {
        if (confirm("Sure to delete member with ID = " + id + "?")) {
            $http.delete("/api/v1/member/" + id, mem)
                .success(function(data, status, headers, config) {
                    // refresh page
                    $scope.onInitializeOrRefreshPage();
                    console.log("onDelete(" + id + ")");
                    console.log("Data: " + JSON.stringify(data, 4, 2));
                    console.log("Status: " + status);
                    console.log("Headers: " + headers);
                    console.log("Config: " + config);
                })
                .error(function(data, status, headers, config) {
                    alert("Failed to delete");
                    console.log("onDelete(" + id + ")");
                    onAppDebug(data, status, headers, config);
                });
        }
    }

    // on selecting member to edit
    $scope.onSelect = function(mem) {
        $scope.mem_to_edit = mem;
        // init
        $scope.var_name = mem.name;
        $scope.var_address = mem.address;
        $scope.var_age = mem.age;
    }

    $scope.error_name = [];
    $scope.error_address = [];
    $scope.error_age = [];
    $scope.onSave = function(mem) {
        var p = {
            method: 'PUT',
            url: '/api/v1/member/' + mem.id,
            data: angular.toJson({
                name:       $scope.var_name,
                address:    $scope.var_address,
                age:        $scope.var_age
            })
        };
        $http(p)
        .success(function (data) {
            $scope.onInitializeOrRefreshPage();
            alert("Save successfully");
            onAppDebug(data, status, headers, config);
        })
        .error(function (data, status, headers, config) {
            onAppDebug(data, status, headers, config);
            $scope.error_name = data.name;
            $scope.error_address = data.address;
            $scope.error_age = data.age;
        });
    }

    var onAppDebug = function(data, status, headers, config) {
        console.log("Data: " + JSON.stringify(data, 4, 2));
        console.log("Status: " + status);
        console.log("Headers: " + headers);
        console.log("Config: " + config);
    }

    $scope.uploadFile = function(){
        var file = $scope.myFile;
        console.log('file is ' );
        console.dir(file);
        var uploadUrl = "/up/";
        fileUpload.uploadFileToUrl(file, uploadUrl);
    };
}]);
