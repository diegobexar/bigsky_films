<?php
/**
 * The template for displaying individual film pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Big_Sky_Pictures
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();
		
		// Get film meta data
		$film_id = get_the_ID();
		$duration = get_post_meta($film_id, 'duration', true);
		$vimeo_id = get_post_meta($film_id, 'vimeo_video_id', true);
		$youtube_id = get_post_meta($film_id, 'youtube_video_id', true);
		$fallback_image = get_post_meta($film_id, 'fallback_image', true);
		$featured_image = get_the_post_thumbnail_url($film_id, 'full');
		
		// Get taxonomies
		$film_year_terms = get_the_terms($film_id, 'film_year');
		$film_year = $film_year_terms && !is_wp_error($film_year_terms) ? $film_year_terms[0]->name : '';
		$film_status_terms = get_the_terms($film_id, 'film_status');
		
		// Get tabbed content
		$reviews = get_post_meta($film_id, 'film_reviews', true) ?: array();
		$screenings = get_post_meta($film_id, 'film_screenings', true) ?: array();
		$credits = get_post_meta($film_id, 'film_credits', true) ?: array();
		$awards = get_post_meta($film_id, 'film_awards', true) ?: array();
		
		// Use fallback image if no featured image
		$hero_image = $featured_image ?: $fallback_image;
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('film-single'); ?>>
		
		<!-- Film Hero Section -->
		<section class="film-hero">
			<div class="film-hero-container">
				
				<!-- Video/Image Container -->
				<div class="film-media">
					<?php if (film_has_video($film_id)) : ?>
						<div class="film-video-container">
							<?php if ($vimeo_id) : ?>
								<iframe 
									src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_id); ?>?color=6B9B0F&title=0&byline=0&portrait=0" 
									frameborder="0" 
									allow="autoplay; fullscreen; picture-in-picture" 
									allowfullscreen
									class="film-video vimeo-video">
								</iframe>
							<?php elseif ($youtube_id) : ?>
								<iframe 
									src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?color=white&rel=0&showinfo=0" 
									frameborder="0" 
									allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
									allowfullscreen
									class="film-video youtube-video">
								</iframe>
							<?php endif; ?>
							
							<?php if ($hero_image) : ?>
								<div class="film-video-poster" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
									<button class="film-play-button" onclick="playFilmVideo()" aria-label="Play film">
										<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
											<circle cx="50" cy="50" r="50" fill="rgba(255,255,255,0.9)"/>
											<path d="M40 30L70 50L40 70V30Z" fill="var(--color-primary)"/>
										</svg>
									</button>
								</div>
							<?php endif; ?>
							
							<!-- Video Platform Indicator -->
							<div class="video-platform-indicator">
								<?php if ($vimeo_id) : ?>
									<span class="platform-badge vimeo-badge">Vimeo</span>
								<?php elseif ($youtube_id) : ?>
									<span class="platform-badge youtube-badge">YouTube</span>
								<?php endif; ?>
							</div>
						</div>
					<?php elseif ($hero_image) : ?>
						<div class="film-image" style="background-image: url('<?php echo esc_url($hero_image); ?>');"></div>
					<?php endif; ?>
				</div>
				
				<!-- Film Info Overlay -->
				<div class="film-info-overlay">
					<div class="container">
						<div class="film-header">
							<h1 class="film-title"><?php the_title(); ?></h1>
							
							<div class="film-meta">
								<?php if ($film_year) : ?>
									<span class="film-year"><?php echo esc_html($film_year); ?></span>
								<?php endif; ?>
								
								<?php if ($duration) : ?>
									<span class="film-duration"><?php echo esc_html($duration); ?></span>
								<?php endif; ?>
								
								<?php if ($film_status_terms && !is_wp_error($film_status_terms)) : ?>
									<span class="film-status"><?php echo esc_html($film_status_terms[0]->name); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Film Content Section -->
		<section class="film-content">
			<div class="container">
				
				<!-- Film Synopsis -->
				<?php if (get_the_content()) : ?>
					<div class="film-synopsis">
						<h2>Synopsis</h2>
						<div class="synopsis-content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endif; ?>
				
				<!-- Tabbed Content -->
				<div class="film-tabs-container">
					
					<!-- Tab Navigation -->
					<nav class="film-tabs-nav">
						<?php if (!empty($reviews)) : ?>
							<button class="tab-button active" data-tab="reviews">Reviews</button>
						<?php endif; ?>
						
						<?php if (!empty($screenings)) : ?>
							<button class="tab-button <?php echo empty($reviews) ? 'active' : ''; ?>" data-tab="screenings">Screenings</button>
						<?php endif; ?>
						
						<?php if (!empty($credits)) : ?>
							<button class="tab-button <?php echo empty($reviews) && empty($screenings) ? 'active' : ''; ?>" data-tab="credits">Credits</button>
						<?php endif; ?>
						
						<?php if (!empty($awards)) : ?>
							<button class="tab-button <?php echo empty($reviews) && empty($screenings) && empty($credits) ? 'active' : ''; ?>" data-tab="awards">Awards</button>
						<?php endif; ?>
					</nav>
					
					<!-- Tab Content -->
					<div class="film-tabs-content">
						
						<!-- Reviews Tab -->
						<?php if (!empty($reviews)) : ?>
							<div class="tab-content active" id="reviews">
								<div class="reviews-grid">
									<?php foreach ($reviews as $review) : ?>
										<?php if (!empty($review['quote'])) : ?>
											<div class="review-item">
												<blockquote class="review-quote">
													"<?php echo esc_html($review['quote']); ?>"
												</blockquote>
												
												<div class="review-attribution">
													<?php if (!empty($review['reviewer'])) : ?>
														<cite class="reviewer-name"><?php echo esc_html($review['reviewer']); ?></cite>
													<?php endif; ?>
													
													<?php if (!empty($review['publication'])) : ?>
														<span class="publication-name"><?php echo esc_html($review['publication']); ?></span>
													<?php endif; ?>
													
													<?php if (!empty($review['link'])) : ?>
														<a href="<?php echo esc_url($review['link']); ?>" class="review-link" target="_blank" rel="noopener">
															Read Full Review →
														</a>
													<?php endif; ?>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Screenings Tab -->
						<?php if (!empty($screenings)) : ?>
							<div class="tab-content <?php echo empty($reviews) ? 'active' : ''; ?>" id="screenings">
								<div class="screenings-list">
									<?php foreach ($screenings as $screening) : ?>
										<?php if (!empty($screening['venue']) || !empty($screening['date'])) : ?>
											<div class="screening-item">
												<div class="screening-main">
													<?php if (!empty($screening['date'])) : ?>
														<div class="screening-date">
															<?php echo esc_html($screening['date']); ?>
														</div>
													<?php endif; ?>
													
													<div class="screening-details">
														<?php if (!empty($screening['venue'])) : ?>
															<h4 class="venue-name"><?php echo esc_html($screening['venue']); ?></h4>
														<?php endif; ?>
														
														<?php if (!empty($screening['type'])) : ?>
															<span class="screening-type screening-type-<?php echo esc_attr($screening['type']); ?>">
																<?php echo ucfirst(esc_html($screening['type'])); ?>
															</span>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Credits Tab -->
						<?php if (!empty($credits)) : ?>
							<div class="tab-content <?php echo empty($reviews) && empty($screenings) ? 'active' : ''; ?>" id="credits">
								<div class="credits-grid">
									<?php foreach ($credits as $credit) : ?>
										<?php if (!empty($credit['role']) || !empty($credit['name'])) : ?>
											<div class="credit-item">
												<?php if (!empty($credit['role'])) : ?>
													<div class="credit-role"><?php echo esc_html($credit['role']); ?></div>
												<?php endif; ?>
												
												<?php if (!empty($credit['name'])) : ?>
													<div class="credit-name"><?php echo esc_html($credit['name']); ?></div>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Awards Tab -->
						<?php if (!empty($awards)) : ?>
							<div class="tab-content <?php echo empty($reviews) && empty($screenings) && empty($credits) ? 'active' : ''; ?>" id="awards">
								<div class="awards-list">
									<?php foreach ($awards as $award) : ?>
										<?php if (!empty($award['name']) || !empty($award['category'])) : ?>
											<div class="award-item">
												<div class="award-icon">
													<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
														<circle cx="20" cy="20" r="18" fill="var(--color-accent)" opacity="0.2"/>
														<path d="M20 8L22.5 15.5L30 15.5L24.5 20L27 27.5L20 23L13 27.5L15.5 20L10 15.5L17.5 15.5L20 8Z" fill="var(--color-secondary)"/>
													</svg>
												</div>
												
												<div class="award-details">
													<?php if (!empty($award['name'])) : ?>
														<h4 class="award-name"><?php echo esc_html($award['name']); ?></h4>
													<?php endif; ?>
													
													<div class="award-meta">
														<?php if (!empty($award['category'])) : ?>
															<span class="award-category"><?php echo esc_html($award['category']); ?></span>
														<?php endif; ?>
														
														<?php if (!empty($award['year'])) : ?>
															<span class="award-year"><?php echo esc_html($award['year']); ?></span>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- No Content Fallback -->
						<?php if (empty($reviews) && empty($screenings) && empty($credits) && empty($awards)) : ?>
							<div class="no-additional-content">
								<p>Additional film information coming soon...</p>
							</div>
						<?php endif; ?>
						
					</div>
				</div>
				
			</div>
		</section>
		
		<!-- Related Films Section -->
		<section class="related-films">
			<div class="container">
				<h2>More Films</h2>
				
				<div class="related-films-grid">
					<?php
					$related_films = get_posts(array(
						'post_type' => 'film',
						'posts_per_page' => 3,
						'post__not_in' => array($film_id),
						'orderby' => 'rand'
					));
					
					if ($related_films) :
						foreach ($related_films as $related_film) :
							$related_year_terms = get_the_terms($related_film->ID, 'film_year');
							$related_year = $related_year_terms && !is_wp_error($related_year_terms) ? $related_year_terms[0]->name : '';
					?>
					
					<article class="related-film-card">
						<a href="<?php echo get_permalink($related_film->ID); ?>" class="related-film-link">
							<div class="related-film-image">
								<?php 
								$thumbnail = get_the_post_thumbnail($related_film->ID, 'medium');
								if ($thumbnail) :
									echo $thumbnail;
								else :
								?>
									<div class="related-film-placeholder">
										<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
											<rect width="80" height="80" fill="var(--color-primary)" opacity="0.1"/>
											<path d="M30 25L55 40L30 55V25Z" fill="var(--color-primary)"/>
										</svg>
									</div>
								<?php endif; ?>
								
								<div class="related-film-overlay">
									<span class="related-play-icon">▶</span>
								</div>
							</div>
							
							<div class="related-film-info">
								<h3 class="related-film-title"><?php echo get_the_title($related_film->ID); ?></h3>
								<?php if ($related_year) : ?>
									<span class="related-film-year"><?php echo esc_html($related_year); ?></span>
								<?php endif; ?>
							</div>
						</a>
					</article>
					
					<?php 
						endforeach;
					endif; 
					?>
				</div>
				
				<div class="related-films-footer">
					<a href="/films/" class="btn btn-secondary">View All Films</a>
				</div>
			</div>
		</section>

	</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; // End of the loop. ?>

</main><!-- #main -->

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.dataset.tab;
            
            // Remove active class from all tabs
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            button.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
});

// Film video functionality
let filmVideoLoaded = false;

function playFilmVideo() {
    if (!filmVideoLoaded) {
        const poster = document.querySelector('.film-video-poster');
        const video = document.querySelector('.film-video');
        
        if (poster && video) {
            poster.style.opacity = '0';
            setTimeout(() => {
                poster.style.display = 'none';
            }, 300);
            filmVideoLoaded = true;
        }
    }
}
</script>

<?php
get_footer();
?>