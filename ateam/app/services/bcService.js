(function(){

	var app = angular.module("bookCatalogueApp");

	app.service("bcService", function ($http, $q) {

		var deferred = $q.defer();

		this.getData = function() {
			return $http.get("/data/books.json")
			.then(function (response) {
                deferred.resolve(response.data);
                return deferred.promise;
            }, function (response) {
                deferred.reject(response);
                return deferred.promise;
            });
		};
	});
	
}());