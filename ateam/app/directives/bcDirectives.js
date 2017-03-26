(function(){

	var app = angular.module("bookCatalogueApp");

    app.directive('fallbackSrc', function () {
        return {
            link: function postLink(scope, iElement, iAttrs) {
                iElement.bind('error', function() {
                    angular.element(this).attr("src", iAttrs.fallbackSrc);
                });
            }
        }
    });
	
}());