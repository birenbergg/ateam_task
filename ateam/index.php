<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Books Catalogue</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon-precomposed" href="/images/icons/iphone.png" />
		<link rel="icon" type="image/png" href="/images/icons/favicon.png" />

		<link rel="stylesheet" href="/css/style.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/modal-overrides.css">
	</head>
	<body>
		<header class="text-center">
			<h1>Books Catalogue</h1>
		</header>
		<main class="container-fluid" ng-app="booksCatalogueApp" ng-controller="booksController">
			<div class="text-right display-mode">
				<label>Display as: </label>
				<span ng-click="displayMode = 'thumbnails'" class="glyphicon glyphicon-th display-mode-button" ng-class="{selected: displayMode == 'thumbnails'}"></span>
				<span ng-click="displayMode = 'table'" class="glyphicon glyphicon-list-alt display-mode-button" ng-class="{selected: displayMode == 'table'}"></span>
			</div>
			<div id="bc-container">

				<!-- Thumbnails -->
				<div class="row" ng-show="displayMode == 'thumbnails'">
					<div ng-repeat="book in books | orderBy: 'date'" class="bc-thumbnail col-lg-3 col-md-4 col-sm-6 col-xs-12">
						<img fallback-src="/images/book_covers/nocover.jpg" ng-src="/images/book_covers/{{ book.slug }}.jpg" alt="{{ book.title | capitalize | alphaSpace }}" ng-click="showModal(book.id); $event.stopPropagation();" />
						<div class="text-center">
							<label>{{ book.title | capitalize | alphaSpace }}</label>
						</div>
						<div class="text-center">
							<span ng-show="book.authors.length > 4">
								<small ng-repeat="author in book.authors | limitTo:3">{{ $first ? '' : ', ' }}{{ author.name }}</small><small> and {{ book.authors.length - 3 }} others</small>
							</span>
							<small ng-show="book.authors.length <= 4" ng-repeat="author in book.authors">{{ $first ? '' : $last ? ' and ' : ', ' }}{{ author.name }}</small>
						</div>
					</div>
				</div>

				<!-- Table -->
				<table ng-show="displayMode == 'table'" class="table table-hover table-responsive">
					<thead>
						<tr>
							<th ng-click="sortProp = 'title'; sortDirection = !sortDirection">
								Title
								<span ng-show="sortProp == 'title' && sortDirection">&#9662</span>
								<span ng-show="sortProp == 'title' && !sortDirection">&#9652</span>
							</th>
							<th ng-click="sortProp = 'authors[0].name'; sortDirection = !sortDirection">
								Author(s)
								<span ng-show="sortProp == 'authors[0].name' && sortDirection">&#9662</span>
								<span ng-show="sortProp == 'authors[0].name' && !sortDirection">&#9652</span>
							</th>
							<th ng-click="sortProp = 'date'; sortDirection = !sortDirection">
								Date
								<span ng-show="sortProp == 'date' && sortDirection">&#9662</span>
								<span ng-show="sortProp == 'date' && !sortDirection">&#9652</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="book in books | orderBy:sortProp:sortDirection" ng-click="showModal(book.id); $event.stopPropagation();">
							<td>{{ book.title | capitalize | alphaSpace }}</td>
							<td>
								<span ng-show="book.authors.length > 4">
									<span ng-repeat="author in book.authors | limitTo:3">{{ $first ? '' : ', ' }}{{ author.name }}</span><span> and {{ book.authors.length - 3 }} others</span>
								</span>
								<span ng-show="book.authors.length <= 4" ng-repeat="author in book.authors">{{ $first ? '' : $last ? ' and ' : ', ' }}{{ author.name }}</span>
							</td>
							<td style="white-space: nowrap">{{ book.date | date }}</td>
						</tr>
					</tbody>
				</table>

				<!-- Modal -->
				<div id="modal" class="modal-wrapper">
					<div class="my-modal">
						<div class="my-modal-content" ng-click="$event.stopPropagation();">
							<div class="modal-header text-center">
								<h1>{{ selectedItem.title | capitalize | alphaSpace }}</h1>
							</div>
							<div class="my-modal-body" ng-hide="editMode">
								<img ng-src="/images/book_covers/{{ selectedItem.slug }}.jpg" alt="{{ selectedItem.title | capitalize | alphaSpace }}" />
								<div style="font-size: 16px">
									<p>
										<label>By:</label> <span ng-repeat="author in selectedItem.authors">{{ $first ? '' : $last ? ' and ' : ', ' }}{{ author.name }}</span>
									</p>
									<p>
										<label>Released:</label> {{ selectedItem.date | date }}
									</p>
								</div>
							</div>
							<div class="my-modal-body" ng-show="editMode">
								<form name="forms.bookForm">
									<div class="form-group">
										<label for="title">Title:</label>
										<input type="text" class="form-control input-lg" name="title" id="title" ng-model="selectedItem.title" required ng-class="forms.bookForm.title.$invalid ? 'invalid' : (forms.bookForm.title.$dirty ? 'valid' : '')" />
									</div>
									<div class="form-group">
										<label for="author">Author{{ selectedItem.authors.length > 1 ? 's' : '' }}:</label>
										<input ng-repeat="author in selectedItem.authors" type="text" name="author" class="form-control input-lg" id="author-{{$index}}" ng-model="author.name" required ng-class="forms.bookForm.author.$invalid ? 'invalid' : (forms.bookForm.author.$dirty ? 'valid' : '')" />
									</div>
									<div class="form-group">
										<label for="date">Date:</label>
										<input type="date" name="date" class="form-control input-lg" id="date" ng-model="selectedItem.date" value="{{ selectedItem.date | date: 'yyyy-MM-dd' }}" placeholder="yyyy-MM-dd" required ng-class="forms.bookForm.date.$invalid ? 'invalid' : (forms.bookForm.date.$dirty ? 'valid' : '')" />
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<div class="text-center">
									<button ng-hide="editMode" class="btn btn-primary" ng-click="editMode = true">Edit</button>
									<button ng-show="editMode" class="btn btn-primary" type="submit" ng-show="editMode" ng-click="save()" ng-enabled="forms.bookForm.title.$valid" ng-class="{disabled: forms.bookForm.$invalid}" ng-disabled="forms.bookForm.$invalid">Save</button>
									<button class="btn btn-danger" ng-click="delete()">Delete</button>
									<button class="btn" ng-click="hideModal()">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

		<!-- JavaScript for Bootstrap -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
		<!-- AngularJS -->
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js"></script>

		<script src="/app/booksCatalogueApp.js"></script>

		<!-- Services -->
		<script src="/app/services/booksService.js"></script>

		<!-- Controllers -->
		<script src="/app/controllers/booksController.js"></script>

		<!-- Directives -->
		<script src="/app/directives/booksDirectives.js"></script>
		
		<!-- Filters -->
		<script src="/app/filters/booksFilters.js"></script>

		<script type="text/javascript">
			$('img').on("error", function() {
				$(this).attr('src', '/images/book_covers/nocover.jpg');
			});
		</script>
	</body>
</html>