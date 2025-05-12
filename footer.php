    <p class="page-top"><a href="#">TOP</a></p>
    <footer class="footer">
        <div class="ft-item-name"><a href="<?php echo home_url(); ?>">Portfolio.</a></div>
        <div class="ft-item-menu">
				<?php echo get_footer_menu(); ?>
			</div>
    </footer>
<script>
function splash(param) {
	var time = param;
	setTimeout(function() {
		$('.splash').fadeOut(500);
	}, time);
}
<?php echo jq_masonry('.container', '.card', get_thumbnail_width()); ?>
<?php echo jq_on_screen('.card'); ?>
<?php echo jq_page_top(); ?>
<?php echo jq_hamburger_menu(); ?>
</script>
</body>
</html>