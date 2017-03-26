(function(){

	var app = angular.module("bookCatalogueApp");

	app.filter("capitalize", function() {
		return function(title) {
			if (title) {
				var words = title.split(" ");

				for (var i = 0; i < words.length; i++) {
					words[i] = words[i].charAt(0).toUpperCase() + words[i].substr(1).toLowerCase();
				};

				return words.join(" ");
			} else {
				return "";
			}
		}
	});

	app.filter("alphaSpace", function() {
		return function(title) {
			if (title) {
				return title.replace(/[^a-zA-Z\s]/g, '');
			} else {
				return "";
			}
		}
	});
	
}());