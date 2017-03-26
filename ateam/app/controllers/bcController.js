(function(){

	var app = angular.module("bookCatalogueApp");

	app.controller("bcController", ['$scope', '$filter', 'bcService', function ($scope, $filter, bcService) {

		bcService.getData().then(
            function (result) {
                $scope.books = result;

				for (i = 0; i < $scope.books.length; i++) {
					$scope.books[i].date = processDate($scope.books[i].date);
				}
            },
            function (error) {
                console.log(error.statusText);
            }
        );

		$scope.forms = {};

		var processDate = function(dateStr) {
			return new Date(parseInt(dateStr.substr(0,4)), parseInt(dateStr.substr(6,2)), parseInt(dateStr.substr(9,2)));
		}
		
		$scope.editMode = false; 

		$scope.sortProp = 'title';
		$scope.sortDirection = false;

		$(document).click(function(event) {
			$scope.hideModal();
		});

		$(document).keypress(function(event) {
			if (event.keyCode === 27) {
				$scope.hideModal();
			}
		});

		$(document).keydown(function(event) {
			if (event.keyCode === 27) {
				$scope.hideModal();
			}
		});

		$scope.showModal = function(id) {

			$scope.selectedItem = angular.copy($scope.books.find(function (book) {
				return book.id == id;
			}));

			document.getElementById('modal').classList.add('my-modal-open');
		}

		$scope.hideModal = function() {
			$scope.editMode = false;
			document.getElementById('modal').classList.remove('my-modal-open');
			$scope.forms.bookForm.$setPristine();
		}

		$scope.save = function() {

			for (i = 0; i < $scope.books.length; i++) {
				if ($scope.books[i].id == $scope.selectedItem.id) {
					$scope.books[i] = $scope.selectedItem;
				}
			}

			$scope.forms.bookForm.$setPristine();
			$scope.editMode = false;
		}

		$scope.delete = function() {
			if(confirm("Are you sure you want to delete " + $scope.selectedItem.title + "?")) {

				for (i = 0; i < $scope.books.length; i++) {
					if ($scope.books[i].id == $scope.selectedItem.id) {
						$scope.books.splice(i, 1);
					}
				}

				$scope.selectedItem = null;
				$scope.hideModal();
			};
		}

	}]);

}());