<?php
/**
 * Big Sky Pictures Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Big_Sky_Pictures
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function big_sky_pictures_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'big-sky-pictures' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'big_sky_pictures_setup' );

function big_sky_pictures_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'big_sky_pictures_content_width', 640 );
}
add_action( 'after_setup_theme', 'big_sky_pictures_content_width', 0 );

function big_sky_pictures_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'big-sky-pictures' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'big-sky-pictures' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'big_sky_pictures_widgets_init' );

function big_sky_pictures_scripts() {
	wp_enqueue_style( 'big-sky-pictures-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'big-sky-pictures-style', 'rtl', 'replace' );

	wp_enqueue_script( 'big-sky-pictures-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'big_sky_pictures_scripts' );

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// =============================================================================
// CUSTOM POST TYPES & FUNCTIONALITY FOR BIG SKY PICTURES
// =============================================================================

/**
 * Register Custom Post Type: Films
 */
function register_film_post_type() {
    $labels = array(
        'name'                  => _x( 'Films', 'Post Type General Name', 'big-sky-pictures' ),
        'singular_name'         => _x( 'Film', 'Post Type Singular Name', 'big-sky-pictures' ),
        'menu_name'             => __( 'Films', 'big-sky-pictures' ),
        'name_admin_bar'        => __( 'Film', 'big-sky-pictures' ),
        'archives'              => __( 'Film Archives', 'big-sky-pictures' ),
        'attributes'            => __( 'Film Attributes', 'big-sky-pictures' ),
        'parent_item_colon'     => __( 'Parent Film:', 'big-sky-pictures' ),
        'all_items'             => __( 'All Films', 'big-sky-pictures' ),
        'add_new_item'          => __( 'Add New Film', 'big-sky-pictures' ),
        'add_new'               => __( 'Add New', 'big-sky-pictures' ),
        'new_item'              => __( 'New Film', 'big-sky-pictures' ),
        'edit_item'             => __( 'Edit Film', 'big-sky-pictures' ),
        'update_item'           => __( 'Update Film', 'big-sky-pictures' ),
        'view_item'             => __( 'View Film', 'big-sky-pictures' ),
        'view_items'            => __( 'View Films', 'big-sky-pictures' ),
        'search_items'          => __( 'Search Film', 'big-sky-pictures' ),
        'not_found'             => __( 'Not found', 'big-sky-pictures' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'big-sky-pictures' ),
        'featured_image'        => __( 'Film Poster', 'big-sky-pictures' ),
        'set_featured_image'    => __( 'Set film poster', 'big-sky-pictures' ),
        'remove_featured_image' => __( 'Remove film poster', 'big-sky-pictures' ),
        'use_featured_image'    => __( 'Use as film poster', 'big-sky-pictures' ),
        'insert_into_item'      => __( 'Insert into film', 'big-sky-pictures' ),
        'uploaded_to_this_item' => __( 'Uploaded to this film', 'big-sky-pictures' ),
        'items_list'            => __( 'Films list', 'big-sky-pictures' ),
        'items_list_navigation' => __( 'Films list navigation', 'big-sky-pictures' ),
        'filter_items_list'     => __( 'Filter films list', 'big-sky-pictures' ),
    );
    
    $args = array(
        'label'                 => __( 'Film', 'big-sky-pictures' ),
        'description'           => __( 'Films produced by Big Sky Pictures', 'big-sky-pictures' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'taxonomies'            => array( 'film_year', 'film_status' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-video-alt3',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'films',
        'rewrite'               => array( 'slug' => 'film' ),
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type( 'film', $args );
}
add_action( 'init', 'register_film_post_type', 0 );

/**
 * Register Custom Taxonomy: Film Year
 */
function register_film_year_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Film Years', 'Taxonomy General Name', 'big-sky-pictures' ),
        'singular_name'              => _x( 'Film Year', 'Taxonomy Singular Name', 'big-sky-pictures' ),
        'menu_name'                  => __( 'Film Years', 'big-sky-pictures' ),
        'all_items'                  => __( 'All Years', 'big-sky-pictures' ),
        'parent_item'                => __( 'Parent Year', 'big-sky-pictures' ),
        'parent_item_colon'          => __( 'Parent Year:', 'big-sky-pictures' ),
        'new_item_name'              => __( 'New Year Name', 'big-sky-pictures' ),
        'add_new_item'               => __( 'Add New Year', 'big-sky-pictures' ),
        'edit_item'                  => __( 'Edit Year', 'big-sky-pictures' ),
        'update_item'                => __( 'Update Year', 'big-sky-pictures' ),
        'view_item'                  => __( 'View Year', 'big-sky-pictures' ),
        'separate_items_with_commas' => __( 'Separate years with commas', 'big-sky-pictures' ),
        'add_or_remove_items'        => __( 'Add or remove years', 'big-sky-pictures' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'big-sky-pictures' ),
        'popular_items'              => __( 'Popular Years', 'big-sky-pictures' ),
        'search_items'               => __( 'Search Years', 'big-sky-pictures' ),
        'not_found'                  => __( 'Not Found', 'big-sky-pictures' ),
        'no_terms'                   => __( 'No years', 'big-sky-pictures' ),
        'items_list'                 => __( 'Years list', 'big-sky-pictures' ),
        'items_list_navigation'      => __( 'Years list navigation', 'big-sky-pictures' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array( 'slug' => 'film-year' ),
        'show_in_rest'               => true,
    );
    
    register_taxonomy( 'film_year', array( 'film' ), $args );
}
add_action( 'init', 'register_film_year_taxonomy', 0 );

/**
 * Register Custom Taxonomy: Film Status
 */
function register_film_status_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Film Status', 'Taxonomy General Name', 'big-sky-pictures' ),
        'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'big-sky-pictures' ),
        'menu_name'                  => __( 'Film Status', 'big-sky-pictures' ),
        'all_items'                  => __( 'All Status', 'big-sky-pictures' ),
        'parent_item'                => __( 'Parent Status', 'big-sky-pictures' ),
        'parent_item_colon'          => __( 'Parent Status:', 'big-sky-pictures' ),
        'new_item_name'              => __( 'New Status Name', 'big-sky-pictures' ),
        'add_new_item'               => __( 'Add New Status', 'big-sky-pictures' ),
        'edit_item'                  => __( 'Edit Status', 'big-sky-pictures' ),
        'update_item'                => __( 'Update Status', 'big-sky-pictures' ),
        'view_item'                  => __( 'View Status', 'big-sky-pictures' ),
        'separate_items_with_commas' => __( 'Separate status with commas', 'big-sky-pictures' ),
        'add_or_remove_items'        => __( 'Add or remove status', 'big-sky-pictures' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'big-sky-pictures' ),
        'popular_items'              => __( 'Popular Status', 'big-sky-pictures' ),
        'search_items'               => __( 'Search Status', 'big-sky-pictures' ),
        'not_found'                  => __( 'Not Found', 'big-sky-pictures' ),
        'no_terms'                   => __( 'No status', 'big-sky-pictures' ),
        'items_list'                 => __( 'Status list', 'big-sky-pictures' ),
        'items_list_navigation'      => __( 'Status list navigation', 'big-sky-pictures' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => false,
        'rewrite'                    => array( 'slug' => 'film-status' ),
        'show_in_rest'               => true,
    );
    
    register_taxonomy( 'film_status', array( 'film' ), $args );
}
add_action( 'init', 'register_film_status_taxonomy', 0 );

/**
 * Get Featured Film for Homepage
 */
function get_featured_film() {
    $featured_films = get_posts( array(
        'post_type'      => 'film',
        'posts_per_page' => 1,
        'meta_key'       => 'featured_film',
        'meta_value'     => 1,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ) );
    
    return !empty( $featured_films ) ? $featured_films[0] : null;
}

/**
 * Extend Search to Include Film Custom Fields
 */
function extend_film_search( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'page', 'film' ) );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'extend_film_search' );

/**
 * Enqueue Google Fonts and Custom Styles
 */
function big_sky_pictures_enqueue_fonts() {
    wp_enqueue_style( 
        'big-sky-pictures-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@300;400;600&display=swap',
        array(),
        null
    );
    
    $custom_css = "
    :root {
        /* Updated Color Palette */
        --color-primary: #4F7302;      /* Deep Forest Green */
        --color-primary-light: #83A603; /* Bright Green */
        --color-accent: #D9CB04;        /* Bright Yellow */
        --color-secondary: #D9A404;     /* Golden Yellow */
        --color-deep: #BF6A1F;         /* Warm Orange */
        
        /* Additional variations */
        --color-primary-dark: #3a5502;
        --color-accent-light: #e6d635;
        --color-secondary-light: #e6b535;
        
        /* Typography */
        --font-heading: 'Inter', sans-serif;
        --font-body: 'Source Sans Pro', sans-serif;
    }
    
    body {
        font-family: var(--font-body);
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-heading);
    }
    
    .site-title a {
        color: var(--color-primary);
    }
    
    .site-title a:hover {
        color: var(--color-accent);
    }
	";
    
    wp_add_inline_style( 'big-sky-pictures-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'big_sky_pictures_enqueue_fonts' );

/**
 * Add Film Status Terms on Theme Activation
 */
function big_sky_pictures_add_default_film_status() {
    if ( ! term_exists( 'Featured', 'film_status' ) ) {
        wp_insert_term( 'Featured', 'film_status', array(
            'description' => 'Featured films for homepage display',
            'slug'        => 'featured'
        ) );
    }
    
    if ( ! term_exists( 'Archived', 'film_status' ) ) {
        wp_insert_term( 'Archived', 'film_status', array(
            'description' => 'Archived films',
            'slug'        => 'archived'
        ) );
    }
}
add_action( 'after_switch_theme', 'big_sky_pictures_add_default_film_status' );

// =============================================================================
// NATIVE WORDPRESS META BOXES FOR FILMS
// =============================================================================

/**
 * Add meta boxes for Film post type
 */
function big_sky_add_film_meta_boxes() {
    add_meta_box(
        'film-details',
        'Film Details',
        'big_sky_film_details_callback',
        'film',
        'normal',
        'high'
    );
    
    add_meta_box(
        'film-reviews',
        'Film Reviews',
        'big_sky_film_reviews_callback',
        'film',
        'normal',
        'default'
    );
    
    add_meta_box(
        'film-screenings',
        'Film Screenings',
        'big_sky_film_screenings_callback',
        'film',
        'normal',
        'default'
    );
    
    add_meta_box(
        'film-credits',
        'Film Credits',
        'big_sky_film_credits_callback',
        'film',
        'normal',
        'default'
    );
    
    add_meta_box(
        'film-awards',
        'Film Awards',
        'big_sky_film_awards_callback',
        'film',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'big_sky_add_film_meta_boxes');

/**
 * Film Details Meta Box
 */
function big_sky_film_details_callback($post) {
    wp_nonce_field('big_sky_save_film_meta', 'big_sky_film_meta_nonce');
    
    $duration = get_post_meta($post->ID, 'duration', true);
    $vimeo_id = get_post_meta($post->ID, 'vimeo_video_id', true);
    $fallback_image = get_post_meta($post->ID, 'fallback_image', true);
    $featured = get_post_meta($post->ID, 'featured_film', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="duration">Duration</label></th>';
    echo '<td><input type="text" id="duration" name="duration" value="' . esc_attr($duration) . '" placeholder="e.g., 90 minutes" style="width:100%;"/></td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="vimeo_video_id">Vimeo Video ID</label></th>';
    echo '<td>';
    echo '<input type="text" id="vimeo_video_id" name="vimeo_video_id" value="' . esc_attr($vimeo_id) . '" placeholder="123456789" style="width:100%;"/>';
    echo '<p class="description">Enter only the Vimeo video ID (numbers only, not the full URL)</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="fallback_image">Fallback Image URL</label></th>';
    echo '<td>';
    echo '<input type="url" id="fallback_image" name="fallback_image" value="' . esc_attr($fallback_image) . '" placeholder="https://..." style="width:100%;"/>';
    echo '<p class="description">Image URL to show when video cannot load</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<th><label for="featured_film">Featured Film</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="featured_film" name="featured_film" value="1"' . checked($featured, 1, false) . '/>';
    echo '<label for="featured_film"> Display this film on the homepage hero section</label>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}
/**
 * Film Reviews Meta Box
 */
function big_sky_film_reviews_callback($post) {
    $reviews = get_post_meta($post->ID, 'film_reviews', true);
    if (!is_array($reviews)) {
        $reviews = array();
    }
    
    echo '<div id="film-reviews-container">';
    echo '<button type="button" class="button button-primary" onclick="addReview()" style="margin-bottom: 15px;">Add Review</button>';
    echo '<div id="reviews-list">';
    
    if (!empty($reviews)) {
        foreach ($reviews as $index => $review) {
            echo big_sky_render_review_fields($index, $review);
        }
    }
    echo '</div>';
    echo '</div>';
    
    echo '<style>
    .review-item, .screening-item, .credit-item, .award-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px 0;
        background: #f9f9f9;
        border-radius: 5px;
    }
    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
    .item-header h4 {
        margin: 0;
        color: #333;
    }
    .remove-button {
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 12px;
    }
    .remove-button:hover {
        background: #c82333;
    }
    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }
    .field-full {
        grid-column: 1 / -1;
    }
    .field-row input, .field-row textarea, .field-row select {
        width: 100%;
        padding: 5px;
    }
    .field-row textarea {
        min-height: 80px;
        resize: vertical;
    }
    </style>';
    
    echo '<script>
    let reviewIndex = ' . count($reviews) . ';
    
    function addReview() {
        const reviewsContainer = document.getElementById("reviews-list");
        const reviewHTML = `
        <div class="review-item" id="review-${reviewIndex}">
            <div class="item-header">
                <h4>Review ${reviewIndex + 1}</h4>
                <button type="button" class="remove-button" onclick="removeReview(${reviewIndex})">Remove</button>
            </div>
            <div class="field-row">
                <textarea name="film_reviews[${reviewIndex}][quote]" placeholder="Review quote..." class="field-full"></textarea>
            </div>
            <div class="field-row">
                <input type="text" name="film_reviews[${reviewIndex}][reviewer]" placeholder="Reviewer name"/>
                <input type="text" name="film_reviews[${reviewIndex}][publication]" placeholder="Publication"/>
            </div>
            <div class="field-row">
                <input type="url" name="film_reviews[${reviewIndex}][link]" placeholder="Review URL (optional)" class="field-full"/>
            </div>
        </div>`;
        reviewsContainer.insertAdjacentHTML("beforeend", reviewHTML);
        reviewIndex++;
    }
    
    function removeReview(index) {
        document.getElementById("review-" + index).remove();
    }
    </script>';
}

function big_sky_render_review_fields($index, $review = array()) {
    $quote = isset($review['quote']) ? esc_textarea($review['quote']) : '';
    $reviewer = isset($review['reviewer']) ? esc_attr($review['reviewer']) : '';
    $publication = isset($review['publication']) ? esc_attr($review['publication']) : '';
    $link = isset($review['link']) ? esc_attr($review['link']) : '';
    
    return '<div class="review-item" id="review-' . $index . '">
        <div class="item-header">
            <h4>Review ' . ($index + 1) . '</h4>
            <button type="button" class="remove-button" onclick="removeReview(' . $index . ')">Remove</button>
        </div>
        <div class="field-row">
            <textarea name="film_reviews[' . $index . '][quote]" placeholder="Review quote..." class="field-full">' . $quote . '</textarea>
        </div>
        <div class="field-row">
            <input type="text" name="film_reviews[' . $index . '][reviewer]" placeholder="Reviewer name" value="' . $reviewer . '"/>
            <input type="text" name="film_reviews[' . $index . '][publication]" placeholder="Publication" value="' . $publication . '"/>
        </div>
        <div class="field-row">
            <input type="url" name="film_reviews[' . $index . '][link]" placeholder="Review URL (optional)" value="' . $link . '" class="field-full"/>
        </div>
    </div>';
}

/**
 * Film Screenings Meta Box
 */
function big_sky_film_screenings_callback($post) {
    $screenings = get_post_meta($post->ID, 'film_screenings', true);
    if (!is_array($screenings)) {
        $screenings = array();
    }
    
    echo '<div id="film-screenings-container">';
    echo '<button type="button" class="button button-primary" onclick="addScreening()" style="margin-bottom: 15px;">Add Screening</button>';
    echo '<div id="screenings-list">';
    
    if (!empty($screenings)) {
        foreach ($screenings as $index => $screening) {
            echo big_sky_render_screening_fields($index, $screening);
        }
    }
    echo '</div>';
    echo '</div>';
    
    echo '<script>
    let screeningIndex = ' . count($screenings) . ';
    
    function addScreening() {
        const container = document.getElementById("screenings-list");
        const html = `
        <div class="screening-item" id="screening-${screeningIndex}">
            <div class="item-header">
                <h4>Screening ${screeningIndex + 1}</h4>
                <button type="button" class="remove-button" onclick="removeScreening(${screeningIndex})">Remove</button>
            </div>
            <div class="field-row">
                <input type="date" name="film_screenings[${screeningIndex}][date]" placeholder="Date"/>
                <input type="text" name="film_screenings[${screeningIndex}][venue]" placeholder="Venue name"/>
            </div>
            <div class="field-row">
                <select name="film_screenings[${screeningIndex}][type]">
                    <option value="premiere">Premiere</option>
                    <option value="festival">Festival</option>
                    <option value="screening">Screening</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>`;
        container.insertAdjacentHTML("beforeend", html);
        screeningIndex++;
    }
    
    function removeScreening(index) {
        document.getElementById("screening-" + index).remove();
    }
    </script>';
}

function big_sky_render_screening_fields($index, $screening = array()) {
    $date = isset($screening['date']) ? esc_attr($screening['date']) : '';
    $venue = isset($screening['venue']) ? esc_attr($screening['venue']) : '';
    $type = isset($screening['type']) ? esc_attr($screening['type']) : 'screening';
    
    $types = array(
        'premiere' => 'Premiere',
        'festival' => 'Festival', 
        'screening' => 'Screening',
        'other' => 'Other'
    );
    
    $options = '';
    foreach ($types as $value => $label) {
        $selected = ($type === $value) ? ' selected' : '';
        $options .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';
    }
    
    return '<div class="screening-item" id="screening-' . $index . '">
        <div class="item-header">
            <h4>Screening ' . ($index + 1) . '</h4>
            <button type="button" class="remove-button" onclick="removeScreening(' . $index . ')">Remove</button>
        </div>
        <div class="field-row">
            <input type="date" name="film_screenings[' . $index . '][date]" value="' . $date . '"/>
            <input type="text" name="film_screenings[' . $index . '][venue]" placeholder="Venue name" value="' . $venue . '"/>
        </div>
        <div class="field-row">
            <select name="film_screenings[' . $index . '][type]">' . $options . '</select>
        </div>
    </div>';
}

/**
 * Film Credits Meta Box
 */
function big_sky_film_credits_callback($post) {
    $credits = get_post_meta($post->ID, 'film_credits', true);
    if (!is_array($credits)) {
        $credits = array();
    }
    
    echo '<div id="film-credits-container">';
    echo '<button type="button" class="button button-primary" onclick="addCredit()" style="margin-bottom: 15px;">Add Credit</button>';
    echo '<div id="credits-list">';
    
    if (!empty($credits)) {
        foreach ($credits as $index => $credit) {
            echo big_sky_render_credit_fields($index, $credit);
        }
    }
    echo '</div>';
    echo '</div>';
    
    echo '<script>
    let creditIndex = ' . count($credits) . ';
    
    function addCredit() {
        const container = document.getElementById("credits-list");
        const html = `
        <div class="credit-item" id="credit-${creditIndex}">
            <div class="item-header">
                <h4>Credit ${creditIndex + 1}</h4>
                <button type="button" class="remove-button" onclick="removeCredit(${creditIndex})">Remove</button>
            </div>
            <div class="field-row">
                <input type="text" name="film_credits[${creditIndex}][role]" placeholder="Role (e.g., Director, Producer)"/>
                <input type="text" name="film_credits[${creditIndex}][name]" placeholder="Person name"/>
            </div>
        </div>`;
        container.insertAdjacentHTML("beforeend", html);
        creditIndex++;
    }
    
    function removeCredit(index) {
        document.getElementById("credit-" + index).remove();
    }
    </script>';
}

function big_sky_render_credit_fields($index, $credit = array()) {
    $role = isset($credit['role']) ? esc_attr($credit['role']) : '';
    $name = isset($credit['name']) ? esc_attr($credit['name']) : '';
    
    return '<div class="credit-item" id="credit-' . $index . '">
        <div class="item-header">
            <h4>Credit ' . ($index + 1) . '</h4>
            <button type="button" class="remove-button" onclick="removeCredit(' . $index . ')">Remove</button>
        </div>
        <div class="field-row">
            <input type="text" name="film_credits[' . $index . '][role]" placeholder="Role (e.g., Director, Producer)" value="' . $role . '"/>
            <input type="text" name="film_credits[' . $index . '][name]" placeholder="Person name" value="' . $name . '"/>
        </div>
    </div>';
}

/**
 * Film Awards Meta Box
 */
function big_sky_film_awards_callback($post) {
    $awards = get_post_meta($post->ID, 'film_awards', true);
    if (!is_array($awards)) {
        $awards = array();
    }
    
    echo '<div id="film-awards-container">';
    echo '<button type="button" class="button button-primary" onclick="addAward()" style="margin-bottom: 15px;">Add Award</button>';
    echo '<div id="awards-list">';
    
    if (!empty($awards)) {
        foreach ($awards as $index => $award) {
            echo big_sky_render_award_fields($index, $award);
        }
    }
    echo '</div>';
    echo '</div>';
    
    echo '<script>
    let awardIndex = ' . count($awards) . ';
    
    function addAward() {
        const container = document.getElementById("awards-list");
        const html = `
        <div class="award-item" id="award-${awardIndex}">
            <div class="item-header">
                <h4>Award ${awardIndex + 1}</h4>
                <button type="button" class="remove-button" onclick="removeAward(${awardIndex})">Remove</button>
            </div>
            <div class="field-row">
                <input type="text" name="film_awards[${awardIndex}][name]" placeholder="Award name"/>
                <input type="text" name="film_awards[${awardIndex}][category]" placeholder="Category"/>
            </div>
            <div class="field-row">
                <input type="number" name="film_awards[${awardIndex}][year]" placeholder="Year" min="1900" max="2050"/>
            </div>
        </div>`;
        container.insertAdjacentHTML("beforeend", html);
        awardIndex++;
    }
    
    function removeAward(index) {
        document.getElementById("award-" + index).remove();
    }
    </script>';
}

function big_sky_render_award_fields($index, $award = array()) {
    $name = isset($award['name']) ? esc_attr($award['name']) : '';
    $category = isset($award['category']) ? esc_attr($award['category']) : '';
    $year = isset($award['year']) ? esc_attr($award['year']) : '';
    
    return '<div class="award-item" id="award-' . $index . '">
        <div class="item-header">
            <h4>Award ' . ($index + 1) . '</h4>
            <button type="button" class="remove-button" onclick="removeAward(' . $index . ')">Remove</button>
        </div>
        <div class="field-row">
            <input type="text" name="film_awards[' . $index . '][name]" placeholder="Award name" value="' . $name . '"/>
            <input type="text" name="film_awards[' . $index . '][category]" placeholder="Category" value="' . $category . '"/>
        </div>
        <div class="field-row">
            <input type="number" name="film_awards[' . $index . '][year]" placeholder="Year" min="1900" max="2050" value="' . $year . '"/>
        </div>
    </div>';
}

/**
 * Save all film meta data
 */
function big_sky_save_film_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['big_sky_film_meta_nonce']) || !wp_verify_nonce($_POST['big_sky_film_meta_nonce'], 'big_sky_save_film_meta')) {
        return;
    }
    
    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save film details
    if (isset($_POST['duration'])) {
        update_post_meta($post_id, 'duration', sanitize_text_field($_POST['duration']));
    }
    
    if (isset($_POST['vimeo_video_id'])) {
        update_post_meta($post_id, 'vimeo_video_id', sanitize_text_field($_POST['vimeo_video_id']));
    }
    
    if (isset($_POST['fallback_image'])) {
        update_post_meta($post_id, 'fallback_image', esc_url_raw($_POST['fallback_image']));
    }
    
    $featured = isset($_POST['featured_film']) ? 1 : 0;
    update_post_meta($post_id, 'featured_film', $featured);
    
    // Save reviews
    if (isset($_POST['film_reviews']) && is_array($_POST['film_reviews'])) {
        $reviews = array();
        foreach ($_POST['film_reviews'] as $review) {
            if (!empty($review['quote']) || !empty($review['reviewer'])) {
                $reviews[] = array(
                    'quote' => sanitize_textarea_field($review['quote']),
                    'reviewer' => sanitize_text_field($review['reviewer']),
                    'publication' => sanitize_text_field($review['publication']),
                    'link' => esc_url_raw($review['link'])
                );
            }
        }
        update_post_meta($post_id, 'film_reviews', $reviews);
    } else {
        delete_post_meta($post_id, 'film_reviews');
    }
    
    // Save screenings
    if (isset($_POST['film_screenings']) && is_array($_POST['film_screenings'])) {
        $screenings = array();
        foreach ($_POST['film_screenings'] as $screening) {
            if (!empty($screening['venue']) || !empty($screening['date'])) {
                $screenings[] = array(
                    'date' => sanitize_text_field($screening['date']),
                    'venue' => sanitize_text_field($screening['venue']),
                    'type' => sanitize_text_field($screening['type'])
                );
            }
        }
        update_post_meta($post_id, 'film_screenings', $screenings);
    } else {
        delete_post_meta($post_id, 'film_screenings');
    }
    
    // Save credits
    if (isset($_POST['film_credits']) && is_array($_POST['film_credits'])) {
        $credits = array();
        foreach ($_POST['film_credits'] as $credit) {
            if (!empty($credit['role']) || !empty($credit['name'])) {
                $credits[] = array(
                    'role' => sanitize_text_field($credit['role']),
                    'name' => sanitize_text_field($credit['name'])
                );
            }
        }
        update_post_meta($post_id, 'film_credits', $credits);
    } else {
        delete_post_meta($post_id, 'film_credits');
    }
    
    // Save awards
    if (isset($_POST['film_awards']) && is_array($_POST['film_awards'])) {
        $awards = array();
        foreach ($_POST['film_awards'] as $award) {
            if (!empty($award['name']) || !empty($award['category'])) {
                $awards[] = array(
                    'name' => sanitize_text_field($award['name']),
                    'category' => sanitize_text_field($award['category']),
                    'year' => intval($award['year'])
                );
            }
        }
        update_post_meta($post_id, 'film_awards', $awards);
    } else {
        delete_post_meta($post_id, 'film_awards');
    }
}
add_action('save_post', 'big_sky_save_film_meta');

?>