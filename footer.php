<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bigsky-theme
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="footer-container">
			<div class="footer-content">
				
				<!-- Footer Brand -->
				<div class="footer-brand">
					<h3 class="footer-logo">
						<?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<?php bloginfo('name'); ?>
						<?php endif; ?>
					</h3>
					<p class="footer-tagline">Independent Film Production</p>
				</div>
				
				<!-- Footer Links -->
				<div class="footer-links">
					<div class="footer-column">
						<h4>Films</h4>
						<ul>
							<li><a href="/films/">All Films</a></li>
							<li><a href="/films/?filter=featured">Featured</a></li>
							<li><a href="/films/?filter=recent">Recent Work</a></li>
						</ul>
					</div>
					
					<div class="footer-column">
						<h4>Company</h4>
						<ul>
							<li><a href="#about">About Us</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					</div>
					
					<div class="footer-column">
						<h4>Connect</h4>
						<div class="social-links">
							<?php 
							$facebook_url = get_theme_mod( 'facebook_url', 'https://facebook.com/bigskypictures' );
							$instagram_url = get_theme_mod( 'instagram_url', 'https://instagram.com/bigskypictures' );
							
							if ( $facebook_url ) : ?>
								<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24V15.564H7.078V12.073H10.125V9.405C10.125 6.348 11.917 4.688 14.658 4.688C15.97 4.688 17.344 4.922 17.344 4.922V7.875H15.83C14.34 7.875 13.875 8.8 13.875 9.75V12.073H17.203L16.671 15.564H13.875V24C19.612 23.094 24 18.1 24 12.073Z" fill="currentColor"/>
									</svg>
								</a>
							<?php endif; ?>
							
							<?php if ( $instagram_url ) : ?>
								<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener" aria-label="Instagram">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 2.163C15.204 2.163 15.584 2.175 16.85 2.233C20.102 2.381 21.621 3.924 21.769 7.152C21.827 8.417 21.838 8.797 21.838 12.001C21.838 15.206 21.826 15.585 21.769 16.85C21.62 20.075 20.105 21.621 16.85 21.769C15.584 21.827 15.206 21.839 12 21.839C8.796 21.839 8.416 21.827 7.151 21.769C3.891 21.62 2.38 20.07 2.232 16.849C2.174 15.584 2.162 15.205 2.162 12C2.162 8.796 2.175 8.417 2.232 7.151C2.381 3.924 3.896 2.38 7.151 2.232C8.417 2.175 8.796 2.163 12 2.163ZM12 0C8.741 0 8.333 0.014 7.053 0.072C2.695 0.272 0.273 2.69 0.073 7.052C0.014 8.333 0 8.741 0 12C0 15.259 0.014 15.668 0.072 16.948C0.272 21.306 2.69 23.728 7.052 23.928C8.333 23.986 8.741 24 12 24C15.259 24 15.668 23.986 16.948 23.928C21.302 23.728 23.730 21.31 23.927 16.948C23.986 15.668 24 15.259 24 12C24 8.741 23.986 8.333 23.928 7.053C23.732 2.699 21.311 0.273 16.949 0.073C15.668 0.014 15.259 0 12 0ZM12 5.838C8.597 5.838 5.838 8.597 5.838 12C5.838 15.403 8.597 18.162 12 18.162C15.403 18.162 18.162 15.403 18.162 12C18.162 8.597 15.403 5.838 12 5.838ZM12 16C9.791 16 8 14.209 8 12C8 9.791 9.791 8 12 8C14.209 8 16 9.791 16 12C16 14.209 14.209 16 12 16ZM18.406 4.155C18.406 4.955 17.761 5.6 16.961 5.6C16.161 5.6 15.516 4.955 15.516 4.155C15.516 3.355 16.161 2.71 16.961 2.71C17.761 2.71 18.406 3.355 18.406 4.155Z" fill="currentColor"/>
									</svg>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				
			</div>
			
			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<div class="footer-bottom-content">
					<div class="copyright">
						<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
					</div>
					
					<div class="footer-credits">
						<span>Made with</span>
						<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M8 14.25L6.825 13.2C3.4 10.36 1.25 8.525 1.25 6.25C1.25 4.515 2.515 3.25 4.25 3.25C5.22 3.25 6.155 3.705 6.75 4.435C7.345 3.705 8.28 3.25 9.25 3.25C10.985 3.25 12.25 4.515 12.25 6.25C12.25 8.525 10.1 10.36 6.675 13.2L8 14.25Z" fill="var(--color-primary)"/>
						</svg>
						<span>in Montana</span>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
