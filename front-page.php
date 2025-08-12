<?php
/**
 * The front page template file
 *
 * This is the most generic template file in a WordPress theme
 * and displays the homepage with featured film hero section.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Big_Sky_Pictures
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php
    // Get the featured film
    $featured_film = get_featured_film();
    
    if ($featured_film) :
        // Get film data
        $film_id = $featured_film->ID;
        $film_title = get_the_title($film_id);
        $film_synopsis = get_the_excerpt($film_id) ?: get_the_content(null, false, $film_id);
        $film_year_terms = get_the_terms($film_id, 'film_year');
        $film_year = $film_year_terms && !is_wp_error($film_year_terms) ? $film_year_terms[0]->name : '';
        $duration = get_post_meta($film_id, 'duration', true);
        $vimeo_id = get_post_meta($film_id, 'vimeo_video_id', true);
        $youtube_id = get_post_meta($film_id, 'youtube_video_id', true);
        $fallback_image = get_post_meta($film_id, 'fallback_image', true);
        $featured_image = get_the_post_thumbnail_url($film_id, 'full');
        
        // Use fallback image if no featured image
        $hero_image = $featured_image ?: $fallback_image;
    ?>
    
    <!-- Hero Section with Featured Film -->
    <section class="hero-section" id="hero">
        <div class="hero-container">
            
            <!-- Video/Image Container -->
            <div class="hero-media">
                <?php if (film_has_video($film_id)) : ?>
                    <div class="video-container" id="video-container">
                        <?php if ($vimeo_id) : ?>
                            <iframe 
                                src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_id); ?>?autoplay=1&muted=1&loop=1&background=1&controls=0&color=6B9B0F" 
                                frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" 
                                allowfullscreen
                                class="hero-video vimeo-video">
                            </iframe>
                        <?php elseif ($youtube_id) : ?>
                            <iframe 
                                src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($youtube_id); ?>&controls=0&showinfo=0&rel=0&modestbranding=1" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="hero-video youtube-video">
                            </iframe>
                        <?php endif; ?>
                        
                        <?php if ($hero_image) : ?>
                            <div class="video-fallback" id="video-fallback" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
                                <button class="play-button" onclick="loadVideo()" aria-label="Play video">
                                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="40" cy="40" r="40" fill="rgba(255,255,255,0.9)"/>
                                        <path d="M32 25L55 40L32 55V25Z" fill="var(--color-primary)"/>
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
                    <div class="hero-image" style="background-image: url('<?php echo esc_url($hero_image); ?>');"></div>
                <?php endif; ?>
                
                <!-- Hero Content Overlay -->
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title"><?php echo esc_html($film_title); ?></h1>
                        
                        <div class="hero-meta">
                            <?php if ($film_year) : ?>
                                <span class="hero-year"><?php echo esc_html($film_year); ?></span>
                            <?php endif; ?>
                            
                            <?php if ($duration) : ?>
                                <span class="hero-duration"><?php echo esc_html($duration); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($film_synopsis) : ?>
                            <p class="hero-synopsis"><?php echo wp_trim_words($film_synopsis, 30, '...'); ?></p>
                        <?php endif; ?>
                        
                        <div class="hero-actions">
                            <a href="<?php echo get_permalink($film_id); ?>" class="btn btn-primary">
                                Learn More
                            </a>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="scroll-indicator">
            <a href="#about" aria-label="Scroll to about section">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 10L12 15L17 10H7Z" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </section>
    
    <?php else : ?>
    
    <!-- Default Hero Section (No Featured Film) -->
    <section class="hero-section hero-default">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title"><?php bloginfo('name'); ?></h1>
                    <p class="hero-tagline"><?php bloginfo('description') ?: 'Independent Film Production'; ?></p>
                    <div class="hero-actions">
                        <a href="/films/" class="btn btn-primary">View Our Films</a>
                        <a href="#about" class="btn btn-secondary">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php endif; ?>
    
    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Big Sky Pictures</h2>
                    
                    <p class="lead">Doug Hawes-Davis and Dru Carr co-founded High Plains Films in 1992 and have collaborated on dozens of independent documentaries, branded content, PSA's, and other media for more than three decades.  Their most recent feature film, ALL THE LABOR premiered at the SXSW Film Festival in 2013.  In 2012, their feature documentary FACING THE STORM: STORY OF THE AMERICAN BISON, a co-production of ITVS and Montana Public Television, was broadcast on the national PBS series, Independent Lens. In 2007, their film, LIBBY, MONTANA was broadcast nationally on the acclaimed PBS Series, POV: The American Documentary, and was nominated for a National Emmy Award the following year. </p>

                    <p>Challenging in form and content, much of their work is intended to provide insight into the relationship between human society and the natural world.</p>

<p>Carr and Hawes-Davis have also worked extensively as free-lance camera operators, producers, directors, and editors, assisting with documentaries, television, web video, and non-profit/corporate video production.</p>

<p>Hawes-Davis is the founder of the annual Big Sky Documentary Film Festival, an Academy-qualifying event for short-form documentary.  The festival is consistently recognized as one of the world's finest documentary cinema events.</p>

<p>Additionally, Hawes-Davis has taught filmmaking at the University of Montana and in the Colorado College Film & Media Studies Program.  Dru Carr has taught media production at the MAPS Media Institute in the Hamilton, Montana public school system as well as for Missoula Community Access Television (MCAT). </p>

<p>High Plains Films also produces THE MONTANA EXPERIENCE: STORIES FROM BIG SKY COUNTRY, a youtube channel dedicated to all things concerning the great State of Montana.</p>
                    <!--<div class="about-stats">
                        <div class="stat">
                            <span class="stat-number"><?php //echo wp_count_posts('film')->publish; ?></span>
                            <span class="stat-label">Films Produced</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">5+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">25+</span>
                            <span class="stat-label">Awards Won</span>
                        </div>
                    </div>-->
                </div>
                
                <div class="about-image">
                    <!-- You can add an about image here -->
                    <div class="about-placeholder">
                        <svg width="400" height="300" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="var(--color-primary-light)" opacity="0.1"/>
                            <path d="M200 100L250 150L200 200L150 150L200 100Z" fill="var(--color-accent)" opacity="0.3"/>
                            <circle cx="200" cy="150" r="30" fill="var(--color-primary)" opacity="0.2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Portfolio Preview Section -->
    <section class="portfolio-preview-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Latest Films</h2>
            </div>
            
            <div class="films-grid" style="display: none;">
                <?php 
                $recent_films = get_posts(array(
                    'post_type' => 'film',
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($recent_films) :
                    foreach ($recent_films as $film) :
                        $film_year_terms = get_the_terms($film->ID, 'film_year');
                        $film_year = $film_year_terms && !is_wp_error($film_year_terms) ? $film_year_terms[0]->name : '';
                ?>
                
                <article class="film-card">
                    <a href="<?php echo get_permalink($film->ID); ?>" class="film-link">
                        <div class="film-image">
                            <?php 
                            $thumbnail = get_the_post_thumbnail($film->ID, 'medium');
                            if ($thumbnail) :
                                echo $thumbnail;
                            else :
                            ?>
                                <div class="film-placeholder">
                                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100" height="100" fill="var(--color-primary)" opacity="0.1"/>
                                        <path d="M30 35L50 50L30 65V35Z" fill="var(--color-primary)"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="film-overlay">
                                <span class="play-icon">▶</span>
                            </div>
                        </div>
                        
                        <div class="film-info">
                            <h3 class="film-title"><?php echo get_the_title($film->ID); ?></h3>
                            <?php if ($film_year) : ?>
                                <span class="film-year"><?php echo esc_html($film_year); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </article>
                
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
            
            <div class="section-footer">
                <a href="/films/" class="btn btn-primary">View All Films</a>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Contact Big Sky Pictures</h2>
                    <p class="lead">Contact us about collaborating on your next film project.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <strong>Email</strong>
                            <span>yak@highplainsfilms.org</span>
                        </div>
                        <!--<div class="contact-method">
                            <strong>Phone</strong>
                            <span>(555) 123-4567</span>
                        </div>-->
                        <div class="contact-method">
                            <strong>Location</strong>
                            <span>Missoula, MT</span>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <!-- Contact Form 7 shortcode will go here -->
                    [contact-form-7 id="ae6a4f8" title="Contact Big Sky Pictures"]
                    
                </div>
            </div>
        </div>
    </section>

</main><!-- #main -->

<script>
// Video loading functionality
let videoLoaded = false;

function loadVideo() {
    if (!videoLoaded) {
        const fallback = document.getElementById('video-fallback');
        const container = document.getElementById('video-container');
        
        if (fallback && container) {
            fallback.style.display = 'none';
            videoLoaded = true;
        }
    }
}

// Auto-hide video fallback on load (for autoplay)
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('.hero-video');
    const fallback = document.getElementById('video-fallback');
    
    if (video && fallback) {
        // Hide fallback after a short delay to allow video to load
        setTimeout(() => {
            if (videoLoaded === false) {
                fallback.style.display = 'none';
                videoLoaded = true;
            }
        }, 3000);
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<?php
get_footer();
?>