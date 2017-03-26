(function(){

	var app = angular.module("bookCatalogueApp", ["ngRoute"]);

	app.config(function($routeProvider) {
	
		$routeProvider
		.when("/", {
			templateUrl : "/app/templates/thumbnails.html"
		})
		.when("/table", {
			templateUrl : "/app/templates/table.html"
		});
	});

}());