<?php
/**
 * The template for displaying film archive/portfolio page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Big_Sky_Pictures
 */

get_header();
?>

<main id="primary" class="site-main portfolio-main">

	<!-- Portfolio Header -->
	<section class="portfolio-header">
		<div class="container">
			<div class="portfolio-header-content">
				<h1 class="portfolio-title">Our Films</h1>
				<p class="portfolio-description">Explore our complete collection of cinematic storytelling</p>
			</div>
		</div>
	</section>

	<!-- Portfolio Filters & Content -->
	<section class="portfolio-content">
		<div class="container">
			
			<!-- Filter Controls -->
			<div class="portfolio-filters">
				<div class="filter-group">
					<label class="filter-label">Filter by Year:</label>
					<div class="filter-buttons">
						<button class="filter-btn active" data-year="all">All Years</button>
						<?php
						// Get all film years
						$film_years = get_terms(array(
							'taxonomy' => 'film_year',
							'hide_empty' => true,
							'orderby' => 'name',
							'order' => 'DESC'
						));
						
						if (!is_wp_error($film_years) && !empty($film_years)) :
							foreach ($film_years as $year) :
						?>
							<button class="filter-btn" data-year="<?php echo esc_attr($year->slug); ?>">
								<?php echo esc_html($year->name); ?>
							</button>
						<?php 
							endforeach;
						endif; 
						?>
					</div>
				</div>
				
				<div class="portfolio-search">
					<input type="text" id="film-search" placeholder="Search films..." />
					<button type="button" id="search-btn">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</button>
				</div>
			</div>

			<!-- Films Grid -->
			<div class="portfolio-grid" id="films-grid">
				<?php
				// Get all films
				$films_query = new WP_Query(array(
					'post_type' => 'film',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'DESC',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'featured_film',
							'value' => '1',
							'compare' => '='
						),
						array(
							'key' => 'featured_film',
							'compare' => 'NOT EXISTS'
						),
						array(
							'key' => 'featured_film',
							'value' => '1',
							'compare' => '!='
						)
					)
				));

				if ($films_query->have_posts()) :
					while ($films_query->have_posts()) : $films_query->the_post();
						
						// Get film data
						$film_id = get_the_ID();
						$duration = get_post_meta($film_id, 'duration', true);
						$vimeo_id = get_post_meta($film_id, 'vimeo_video_id', true);
						$featured_image = get_the_post_thumbnail_url($film_id, 'large');
						$fallback_image = get_post_meta($film_id, 'fallback_image', true);
						
						// Get taxonomies
						$film_year_terms = get_the_terms($film_id, 'film_year');
						$film_year = $film_year_terms && !is_wp_error($film_year_terms) ? $film_year_terms[0]->name : '';
						$film_year_slug = $film_year_terms && !is_wp_error($film_year_terms) ? $film_year_terms[0]->slug : '';
						
						$film_status_terms = get_the_terms($film_id, 'film_status');
						$is_featured = $film_status_terms && !is_wp_error($film_status_terms) && 
									  in_array('featured', wp_list_pluck($film_status_terms, 'slug'));
						
						// Use featured image or fallback
						$display_image = $featured_image ?: $fallback_image;
						
						// Get excerpt or content preview
						$film_excerpt = get_the_excerpt() ?: wp_trim_words(get_the_content(), 20, '...');
				?>
				
				<article class="portfolio-item <?php echo $is_featured ? 'featured-film' : ''; ?>" 
						 data-year="<?php echo esc_attr($film_year_slug); ?>"
						 data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>"
						 data-content="<?php echo esc_attr(strtolower($film_excerpt)); ?>">
					
					<a href="<?php the_permalink(); ?>" class="portfolio-link">
						
						<!-- Film Image/Video Preview -->
						<div class="portfolio-media">
							<?php if ($display_image) : ?>
								<img src="<?php echo esc_url($display_image); ?>" 
									 alt="<?php echo esc_attr(get_the_title()); ?>"
									 loading="lazy" />
							<?php else : ?>
								<div class="portfolio-placeholder">
									<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="80" height="80" fill="var(--color-primary)" opacity="0.1"/>
										<path d="M30 25L55 40L30 55V25Z" fill="var(--color-primary)"/>
									</svg>
								</div>
							<?php endif; ?>
							
							<!-- Overlay -->
							<div class="portfolio-overlay">
								<?php if ($vimeo_id) : ?>
									<div class="play-icon">
										<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
											<circle cx="30" cy="30" r="30" fill="rgba(255,255,255,0.9)"/>
											<path d="M25 20L40 30L25 40V20Z" fill="var(--color-primary)"/>
										</svg>
									</div>
								<?php endif; ?>
								
								<?php if ($is_featured) : ?>
									<div class="featured-badge">
										<span>Featured</span>
									</div>
								<?php endif; ?>
							</div>
						</div>
						
						<!-- Film Info -->
						<div class="portfolio-info">
							<h3 class="portfolio-film-title"><?php the_title(); ?></h3>
							
							<div class="portfolio-meta">
								<?php if ($film_year) : ?>
									<span class="portfolio-year"><?php echo esc_html($film_year); ?></span>
								<?php endif; ?>
								
								<?php if ($duration) : ?>
									<span class="portfolio-duration"><?php echo esc_html($duration); ?></span>
								<?php endif; ?>
							</div>
							
							<?php if ($film_excerpt) : ?>
								<p class="portfolio-excerpt"><?php echo esc_html($film_excerpt); ?></p>
							<?php endif; ?>
							
							<div class="portfolio-cta">
								<span class="cta-text">Watch Film</span>
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
						</div>
						
					</a>
				</article>
				
				<?php 
					endwhile;
					wp_reset_postdata();
				endif; 
				?>
			</div>
			
			<!-- No Results Message -->
			<div class="no-results" id="no-results" style="display: none;">
				<div class="no-results-content">
					<svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="60" cy="60" r="60" fill="var(--color-light-gray)"/>
						<path d="M45 40L75 60L45 80V40Z" fill="var(--color-medium-gray)"/>
					</svg>
					<h3>No films found</h3>
					<p>Try adjusting your filters or search terms</p>
					<button onclick="clearAllFilters()" class="btn btn-primary">Clear Filters</button>
				</div>
			</div>
			
			<!-- Load More Button (for future pagination) -->
			<div class="portfolio-footer">
				<div class="films-count">
					<span id="visible-count"></span> films shown
				</div>
			</div>
			
		</div>
	</section>

</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const searchInput = document.getElementById('film-search');
    const noResults = document.getElementById('no-results');
    const filmsGrid = document.getElementById('films-grid');
    const visibleCount = document.getElementById('visible-count');
    
    let currentFilter = 'all';
    let currentSearch = '';
    
    // Filter by year
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            currentFilter = this.dataset.year;
            filterFilms();
        });
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        currentSearch = this.value.toLowerCase();
        filterFilms();
    });
    
    // Filter films based on year and search
    function filterFilms() {
        let visibleItems = 0;
        
        portfolioItems.forEach(item => {
            const itemYear = item.dataset.year;
            const itemTitle = item.dataset.title;
            const itemContent = item.dataset.content;
            
            const yearMatch = currentFilter === 'all' || itemYear === currentFilter;
            const searchMatch = currentSearch === '' || 
                               itemTitle.includes(currentSearch) || 
                               itemContent.includes(currentSearch);
            
            if (yearMatch && searchMatch) {
                item.style.display = 'block';
                item.classList.add('fade-in');
                visibleItems++;
            } else {
                item.style.display = 'none';
                item.classList.remove('fade-in');
            }
        });
        
        // Update count
        if (visibleCount) {
            visibleCount.textContent = visibleItems;
        }
        
        // Show/hide no results
        if (visibleItems === 0) {
            noResults.style.display = 'flex';
            filmsGrid.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            filmsGrid.style.display = 'grid';
        }
    }
    
    // Clear all filters
    window.clearAllFilters = function() {
        // Reset filter buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        filterButtons[0].classList.add('active'); // "All Years" button
        
        // Reset search
        searchInput.value = '';
        
        // Reset variables
        currentFilter = 'all';
        currentSearch = '';
        
        // Show all films
        filterFilms();
    };
    
    // Initialize count
    filterFilms();
    
    // Animation for portfolio items
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    portfolioItems.forEach(item => {
        observer.observe(item);
    });
});
</script>

<?php
get_footer();
?>