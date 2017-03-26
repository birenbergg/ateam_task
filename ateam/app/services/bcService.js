(function(){

	var app = angular.module("bookCatalogueApp");

	app.service("bcService", function ($http) {

		this.getData = function() {
			return $http.get("/data/books.json");
		};
	});
	
}());