    <p class="page-top"><a class="page-top__link" href="#">TOP</a></p>
    <footer class="footer">
        <div class="footer__site-name "><a href="<?php echo home_url(); ?>">Portfolio.</a></div>
        <div class="footer__menu">
				<?php echo get_footer_menu(); ?>
			</div>
    </footer>
<script>
<?php echo jq_on_screen('.entry__container'); ?>
<?php echo jq_page_top(); ?>
<?php echo jq_hamburger_menu(); ?>
</script>
</body>
</html>