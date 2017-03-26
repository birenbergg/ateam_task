(function(){

	var app = angular.module("booksCatalogueApp");

	app.service("booksService", function ($http) {

		var getData = function() {
			return $http.get("/data/books.json");
		};

		return {
			getData: getData
		};
	});
	
}());