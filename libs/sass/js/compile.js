Sass.preloadFiles('libs/sass/css', '', ['stylesheet.scss'], function() {
	Sass.compile('@import "stylesheet";', { style: Sass.style.expanded }, function(result) {
		var file = 'css/stylesheet.css';
		jQuery.post('libs/sass/create.php', { file: '../../' + file, text: result.text }, function(response) {
		    jQuery('head').append('<link rel="stylesheet" href="' + file + '" type="text/css" />');
		});
	});
});
