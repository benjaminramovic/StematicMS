<?php 

function enqueue_jquery_bootstrap() {
    // Dodavanje Bootstrap CSS-a
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');

    // Učitavanje jQuery-a (već dolazi sa WordPressom)
    wp_enqueue_script('jquery');

    // Dodavanje Bootstrap JS-a (zavisi od jQuery-a)
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_jquery_bootstrap');

error_reporting(E_ALL);
ini_set('display_errors', 1);


function load_stylesheets(){
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), 1, 'all');
    wp_enqueue_style('bootstrap');

    wp_register_style('pogoslider', get_template_directory_uri() . '/css/pogo-slider.min.css', array(), 1, 'all');
    wp_enqueue_style('pogoslider');

    wp_register_style('style', get_template_directory_uri() . '/css/style.css', array(), 1, 'all');
    wp_enqueue_style('style');

    wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css', array(), 1, 'all');
    wp_enqueue_style('responsive');

    wp_register_style('custom', get_template_directory_uri() . '/css/custom.css', array(), 1, 'all');
    wp_enqueue_style('custom');
}

function exercise_theme_setup() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'exercise' ),
        'footer'  => __( 'Footer Menu', 'exercise' ),
        'mobile'  => __( 'Mobile Menu', 'exercise' ),
        'secondary' => __( 'Secondary Menu', 'exercise' ),
    ) );

    add_theme_support( 'post-thumbnails' );
}
add_action( 'init', 'exercise_theme_setup' );

function exercise_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'exercise' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Social Widgets', 'exercise' ),
        'id'            => 'footer-social',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'exercise_widgets_init' );

function exercise_customize_register_footer( $wp_customize ) {
    $wp_customize->add_section( 'footer_section' , array(
        'title'      => __( 'Footer Settings', 'exercise' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'footer_copyright_text', array(
        'default'   => 'Exercise',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'footer_copyright_text_control', array(
        'label'    => __( 'Footer Copyright Text', 'exercise' ),
        'section'  => 'footer_section',
        'settings' => 'footer_copyright_text',
        'type'     => 'text',
    ));

    $wp_customize->add_setting( 'footer_year', array(
        'default'   => date('Y'),
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control( 'footer_year_control', array(
        'label'    => __( 'Footer Year', 'exercise' ),
        'section'  => 'footer_section',
        'settings' => 'footer_year',
        'type'     => 'number',
    ));

    $wp_customize->add_setting( 'footer_background_color' , array(
        'default'   => '#333',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color_control', array(
        'label'      => __( 'Footer Background Color', 'exercise' ),
        'section'    => 'footer_section',
        'settings'   => 'footer_background_color',
    ) ) );

    $wp_customize->add_setting( 'footer_text_color' , array(
        'default'   => '#fff',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color_control', array(
        'label'      => __( 'Footer Text Color', 'exercise' ),
        'section'    => 'footer_section',
        'settings'   => 'footer_text_color',
    ) ) );
}
add_action( 'customize_register', 'exercise_customize_register_footer' );

function exercise_register_property_post_type() {
    $labels = array(
        'name'               => __( 'Vežbe', 'exercise' ),
        'singular_name'      => __( 'Vežba', 'exercise' ),
        'menu_name'          => __( 'Vežbe', 'exercise' ),
        'name_admin_bar'     => __( 'Vežba', 'exercise' ),
        'add_new'            => __( 'Dodaj novu', 'exercise' ),
        'add_new_item'       => __( 'Dodaj novu vežbu', 'exercise' ),
        'new_item'           => __( 'Nova vežba', 'exercise' ),
        'edit_item'          => __( 'Izmeni vežbu', 'exercise' ),
        'view_item'          => __( 'Pogledaj vežbu', 'exercise' ),
        'all_items'          => __( 'Sve vežbe', 'exercise' ),
        'search_items'       => __( 'Pretraga vežbi', 'exercise' ),
        'not_found'          => __( 'Nema pronađenih vežbi.', 'exercise' ),
        'not_found_in_trash' => __( 'Nema pronađenih vežbi u otpadu.', 'exercise' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_rest'       => false,
        'show_in_nav_menus'  => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'vezbe' ),
        'capability_type'    => 'exercise', // ako zelimo potpunu kontrolu nad vezbama i da ih odvojimo od drugih postova u sistemu, inace je 'post'
        'map_meta_cap'       => true,       // automatsko mapiranje prava
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_icon'          => 'dashicons-admin-home',
    );

    register_post_type( 'vezba', $args );
}
add_action( 'init', 'exercise_register_property_post_type' );

function exercise_property_meta_box() {
    add_meta_box(
        'exercise_details',
        __( 'Detalji o vežbi', 'exercise' ),
        'exercise_property_meta_box_callback',
        'exercise',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'exercise_property_meta_box' );

function exercise_property_meta_box_callback( $post ) {
    wp_nonce_field( 'save_property_details', 'property_details_nonce' );

    $fields = [
        '_exercise_description' => [ 'label' => __( 'Opis vežbe (text):', 'exercise' ), 'type' => 'textarea' ],
        '_exercise_video_link' => [ 'label' => __( 'Video link (opciono):', 'exercise' ), 'type' => 'url' ],
        '_exercise_goals' => [ 'label' => __( 'Razvojni ciljevi (text):', 'exercise' ), 'type' => 'textarea' ],
        '_exercise_material' => [ 'label' => __( 'Materijal (text):', 'exercise' ), 'type' => 'textarea' ],
        '_exercise_tasks_children' => [ 'label' => __( 'Zadaci za decu (text):', 'exercise' ), 'type' => 'textarea' ],
        '_exercise_tasks_teacher' => [ 'label' => __( 'Zadaci za vaspitača (text):', 'exercise' ), 'type' => 'textarea' ],
        '_exercise_game_link' => [ 'label' => __( 'Link ka edukativnoj igri:', 'exercise' ), 'type' => 'url' ],
        '_exercise_stats_game' => [ 'label' => __( 'Link ka statistici igre:', 'exercise' ), 'type' => 'url' ],
        '_exercise_stats_access' => [ 'label' => __( 'Link ka statistici pristupa:', 'exercise' ), 'type' => 'url' ]
    ];

    foreach ( $fields as $key => $field ) {
        $value = get_post_meta( $post->ID, $key, true );

        echo '<p>';
        echo '<label for="' . esc_attr( $key ) . '">' . $field['label'] . '</label><br>';

        if ( $field['type'] === 'textarea' ) {
            echo '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" rows="4" style="width:100%;">' . esc_textarea( $value ) . '</textarea>';
        } elseif ( $field['type'] === 'url' ) {
            echo '<input type="url" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;">';
        }
        echo '</p>';
    }
}

function exercise_save_property_details( $post_id ) {
    if ( ! isset( $_POST['property_details_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['property_details_nonce'], 'save_property_details' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [
        '_exercise_description',
        '_exercise_video_link',
        '_exercise_goals',
        '_exercise_material',
        '_exercise_tasks_children',
        '_exercise_tasks_teacher',
        '_exercise_game_link',
        '_exercise_stats_game',
        '_exercise_stats_access'
    ];

    foreach ( $fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            if ( strpos( $field, '_link' ) !== false || strpos( $field, '_stats' ) !== false || $field === '_exercise_video_link' ) {
                $url = esc_url_raw( $_POST[ $field ] );
                if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
                    update_post_meta( $post_id, $field, $url );
                } else {
                    delete_post_meta( $post_id, $field );
                }
            } else {
                update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
            }
        }
    }
}
add_action( 'save_post', 'exercise_save_property_details' );

function exercise_register_property_taxonomy() {
    $labels = array(
        'name'              => __( 'Kategorije vežbi', 'exercise' ),
        'singular_name'     => __( 'Kategorija vežbe', 'exercise' ),
        'search_items'      => __( 'Pretraga kategorija', 'exercise' ),
        'all_items'         => __( 'Sve kategorije', 'exercise' ),
        'parent_item'       => __( 'Roditeljska kategorija', 'exercise' ),
        'parent_item_colon' => __( 'Roditeljska kategorija:', 'exercise' ),
        'edit_item'         => __( 'Izmeni kategoriju', 'exercise' ),
        'update_item'       => __( 'Ažuriraj kategoriju', 'exercise' ),
        'add_new_item'      => __( 'Dodaj novu kategoriju', 'exercise' ),
        'new_item_name'     => __( 'Naziv nove kategorije', 'exercise' ),
        'menu_name'         => __( 'Kategorije vežbi', 'exercise' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'kategorija-vezbe' ),
    );

    register_taxonomy( 'kategorija_vezbe', array( 'vezba' ), $args );
}
add_action( 'init', 'exercise_register_property_taxonomy' );

function exercise_customize_register_header( $wp_customize ) {
    $wp_customize->add_section( 'header_section' , array(
        'title'      => __( 'Header Settings', 'exercise' ),
        'priority'   => 30,
    ) );

    $wp_customize->add_setting( 'header_logo' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo', array(
        'label'    => __( 'Logo', 'exercise' ),
        'section'  => 'header_section',
        'settings' => 'header_logo',
    ) ) );

    $wp_customize->add_setting( 'header_background_color' , array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color_control', array(
        'label'      => __( 'Header Background Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'header_background_color',
    ) ) );

    $wp_customize->add_setting( 'menu_link_color' , array(
        'default'   => '#333333',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_link_color_control', array(
        'label'      => __( 'Menu Link Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'menu_link_color',
    ) ) );

    $wp_customize->add_setting( 'menu_hover_background_color' , array(
        'default'   => '#004d40',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_hover_background_color_control', array(
        'label'      => __( 'Menu Hover Background Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'menu_hover_background_color',
    ) ) );

    $wp_customize->add_setting( 'menu_hover_text_color' , array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_hover_text_color_control', array(
        'label'      => __( 'Menu Hover Text Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'menu_hover_text_color',
    ) ) );

    $wp_customize->add_setting( 'menu_active_background_color' , array(
        'default'   => '#004d40',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_active_background_color_control', array(
        'label'      => __( 'Menu Active Background Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'menu_active_background_color',
    ) ) );

    $wp_customize->add_setting( 'menu_active_text_color' , array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_active_text_color_control', array(
        'label'      => __( 'Menu Active Text Color', 'exercise' ),
        'section'    => 'header_section',
        'settings'   => 'menu_active_text_color',
    ) ) );
}
add_action( 'customize_register', 'exercise_customize_register_header' );

add_action('wp_enqueue_scripts','load_stylesheets');

add_filter('show_admin_bar', '__return_false');

function create_custom_roles() {
    // Teacher uloga
    add_role(
        'teacher',
        __( 'Teacher', 'exercise' ),
        array(
            'read'                => true,
            'edit_exercises'      => true,
            'read_exercises'      => true,
            'delete_exercises'    => true,
            'edit_others_exercises' => false,
        )
    );

    // Child uloga
    add_role(
        'child',
        __( 'Child', 'exercise' ),
        array(
            'read' => true,
        )
    );
}
add_action( 'init', 'create_custom_roles' );

// dodavanje prava
function add_exercise_capabilities() {
    $roles = array( 'administrator', 'teacher' );

    foreach ( $roles as $role_name ) {
        $role = get_role( $role_name );
        if ( $role ) {
            $role->add_cap( 'edit_exercises' );
            $role->add_cap( 'read_exercises' );
            $role->add_cap( 'delete_exercises' );
            $role->add_cap( 'edit_others_exercises' );
            $role->add_cap( 'delete_others_exercises' );
        }
    }
}
add_action( 'init', 'add_exercise_capabilities' );

// pristupi
function restrict_dashboard_menu() {
    if ( current_user_can( 'teacher' ) ) {
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'users.php' );
    }

    if ( current_user_can( 'child' ) ) {
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'admin_menu', 'restrict_dashboard_menu', 999 );

function redirect_users_on_login($redirect_to, $request, $user) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'teacher', $user->roles ) ) {
            return admin_url( 'edit.php?post_type=exercise' );
        } elseif ( in_array( 'child', $user->roles ) ) {
            return home_url();
        }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'redirect_users_on_login', 10, 3 );

function hide_admin_bar_for_child() {
    if ( current_user_can( 'child' ) ) {
        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'hide_admin_bar_for_child' );


?>