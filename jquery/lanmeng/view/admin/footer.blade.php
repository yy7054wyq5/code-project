</section>
<!-- JQUERY UI-->
{!!HTML::script('super/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js') !!}
<!-- BOOTSTRAP -->
{!!HTML::script('super/bootstrap-dist/js/bootstrap.min.js') !!}
<!-- DATE RANGE PICKER -->
{!!HTML::script('super/js/bootstrap-daterangepicker/moment.min.js') !!}

{!!HTML::script('super/js/bootstrap-daterangepicker/daterangepicker.min.js') !!}
<!-- SLIMSCROLL -->
{!!HTML::script('super/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js') !!}
{!!HTML::script('super/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js') !!}
<!-- COOKIE -->
{!!HTML::script('super/js/jQuery-Cookie/jquery.cookie.min.js') !!}
<!-- CUSTOM SCRIPT -->
{!!HTML::script('super/js/script.js') !!}
{!!HTML::script('super/layer/layer.js') !!}
<script>
	jQuery(document).ready(function() {		
		App.setPage("fixed_header_sidebar");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>