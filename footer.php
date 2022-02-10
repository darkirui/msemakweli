	<div class="footersection">
		<div class="contentwrap">
			&copy; KCCB - KARP
		</div>
	</div>
	<script type="text/javascript" src="theme/js/jquery.min.js"></script>	
	<script src="theme/js/jquery.form.min.js"></script>
	<script src="theme/js/jquery-ui.js"></script>
	<script src="theme/js/bootstrap.min.js"></script>
	<script src="theme/js/bootstrap-select.min.js"></script>
	<!---<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>-->
	<script src="theme/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="theme/js/tinymce/tinymce.min.js"></script>
	<script src="theme/chartjs/dist/Chart.min.js"></script>
	<script src="theme/chartjs/dist/utils.js"></script>
	<script type="text/javascript" charset="utf8" src="theme/js/jquery.dataTables.js"></script>
    <script src="theme/light/js/lightslider.js"></script> 
	<!-- <script src="theme/js/custom.js"></script>
	<script src="theme/js/loaddataaftepageload.js"></script> -->
	<script src="theme/summernote/summernote.min.js"></script>
	<script src="theme/js/codemirror/codemirror.js"></script>
	
	<script src="theme/js/codemirror/javascript-hint.js"></script>
	<script src="theme/js/codemirror/javascript.js"></script>
	<script src="theme/js/codemirror/markdown.js"></script>
	<script src="theme/js/codemirror/markdown.js"></script>
	<script src="theme/js/codemirror/matchbrackets.js"></script>
	<script src="theme/js/codemirror/sql.js"></script>
	<script src="theme/js/codemirror/show-hint.js"></script>
	<script src="theme/js/codemirror/sql-hint.js"></script>
	<script src="theme/js/paginga.jquery.js"></script>
	<script src="theme/js/pagination.min.js"></script>
	<script src="theme/js/d3.v4.min.js"></script> 
	<script src="theme/js/d3-instant-charts.js"></script> 
	<script src="theme/js/popPyramid.js"></script>
	<script src="theme/js/main.js"></script>
	<script src="theme/js/jquery.uploadfile.min.js"></script>
	<script src="theme/js/react.production.min.js"></script>
	<script src="theme/js/react-dom.production.min.js"></script>
	<script src="theme/js/prop-types.min.js"></script>
	<script src="theme/js/browser.min.js"></script>
	<script src="theme/js/apexcharts.js"></script>
	<script src="theme/js/react-apexcharts.iife.min.js"></script>
		<script type="text/javascript">

		//var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
		  $('#summernote').summernote({
		  		minHeight: 300,
		  		hint: {
				    words: ['apple', 'orange', 'watermelon', 'lemon','apple3','apple4'],
				    match: /\b(\w{1,})$/,
				    search: function (keyword, callback) {
				      callback($.grep(this.words, function (item) {
				        return item.indexOf(keyword) === 0;
				      }));
				    }
				}
		  });
		});
	</script>

	<script>
window.onload = function() {
  var mime = 'text/x-mariadb';
  // get mime type
  if (window.location.href.indexOf('mime=') > -1) {
    mime = window.location.href.substr(window.location.href.indexOf('mime=') + 5);
  }
  window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    mode: mime,
    indentWithTabs: true,
    smartIndent: true,
    lineNumbers: true,
    matchBrackets : true,
    autofocus: true,
    extraKeys: {"Ctrl-Space": "autocomplete"},
    hintOptions: {tables: {
      users: ["name", "score", "birthDate"],
      countries: ["name", "population", "size"]
    }}
  });
};
</script>
</body>
</html>