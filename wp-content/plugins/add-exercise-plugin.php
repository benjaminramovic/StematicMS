<?php
/*
Plugin Name: Exercise Submission Plugin
Description: Allows users to submit exercises via a frontend form
Version: 1.0
Author: StematicMS
*/

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

function exercise_submission_form_shortcode() {
    if ( !is_user_logged_in() ) {
        return '<p>Morate biti prijavljeni da biste dodali vežbu.</p>';
    }

    ob_start(); ?>

    <form id="exercise-submission-form" method="post">

        <label for="exercise-description">Opis vežbe:</label>
        <textarea id="exercise-description" name="exercise-description" required></textarea>

        <label for="exercise-video-link">Video link (opciono):</label>
        <input type="url" id="exercise-video-link" name="exercise-video-link">

        <label for="exercise-goals">Razvojni ciljevi:</label>
        <textarea id="exercise-goals" name="exercise-goals" required></textarea>

        <label for="exercise-material">Materijal:</label>
        <textarea id="exercise-material" name="exercise-material" required></textarea>

        <label for="exercise-tasks-children">Zadaci za decu:</label>
        <textarea id="exercise-tasks-children" name="exercise-tasks-children" required></textarea>

        <label for="exercise-tasks-teacher">Zadaci za vaspitača:</label>
        <textarea id="exercise-tasks-teacher" name="exercise-tasks-teacher" required></textarea>

        <label for="exercise-game-link">Link ka edukativnoj igri:</label>
        <input type="url" id="exercise-game-link" name="exercise-game-link" required>

        <label for="exercise-stats-game">Link ka statistici igre:</label>
        <input type="url" id="exercise-stats-game" name="exercise-stats-game" required>

        <label for="exercise-stats-access">Link ka statistici pristupa:</label>
        <input type="url" id="exercise-stats-access" name="exercise-stats-access" required>

        <label for="exercise-kategorija">Kategorija:</label>
        <?php
        $categories = get_terms(array(
            'taxonomy' => 'kategorija-vezbe',
            'hide_empty' => false,
        ));
        if (!empty($categories)) {
            echo '<select id="exercise-kategorija" name="exercise-kategorija">';
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<p>Nema dostupnih vežbi.</p>';
        }
        ?>

        <?php wp_nonce_field( 'exercise_submission', 'exercise_submission_nonce' ); ?>

        <button type="submit" name="submit-exercise">Dodaj vežbu</button>
    </form>
    <?php 
    if (isset($_GET['exercise_status']) && $_GET['exercise_status'] === 'success') {
        ?>
        <div>
            Vežba je uspešno dodata i čeka odobrenje!
        </div>
        <?php
    }
    ?>
    <?php
    return ob_get_clean();
}
add_shortcode( 'exercise_submission_form', 'exercise_submission_form_shortcode' );

function handle_exercise_submission() {
    if ( isset( $_POST['submit-exercise'] ) ) {
        if ( !isset( $_POST['exercise_submission_nonce'] ) || !wp_verify_nonce( $_POST['exercise_submission_nonce'], 'exercise_submission' ) ) {
            return;
        }

        if ( !is_user_logged_in() ) {
            return;
        }

        $description = sanitize_textarea_field( $_POST['exercise-description'] );
        $video_link = esc_url_raw( $_POST['exercise-video-link'] );
        $goals = sanitize_textarea_field( $_POST['exercise-goals'] );
        $material = sanitize_textarea_field( $_POST['exercise-material'] );
        $tasks_children = sanitize_textarea_field( $_POST['exercise-tasks-children'] );
        $tasks_teacher = sanitize_textarea_field( $_POST['exercise-tasks-teacher'] );
        $game_link = esc_url_raw( $_POST['exercise-game-link'] );
        $stats_game = esc_url_raw( $_POST['exercise-stats-game'] );
        $stats_access = esc_url_raw( $_POST['exercise-stats-access'] );
        $kategorija = intval($_POST['exercise-kategorija']);

        $post_id = wp_insert_post( array(
            'post_content' => $description,
            'post_type'    => 'exercise',
            'post_status'  => 'draft',
            'post_author'  => get_current_user_id(),
            'tax_input'    => array(
                'kategorija-vezbe' => array($kategorija),
            ),
        ) );

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_exercise_description', $description);
            update_post_meta($post_id, '_exercise_video_link', $video_link);
            update_post_meta($post_id, '_exercise_goals', $goals);
            update_post_meta($post_id, '_exercise_material', $material);
            update_post_meta($post_id, '_exercise_tasks_children', $tasks_children);
            update_post_meta($post_id, '_exercise_tasks_teacher', $tasks_teacher);
            update_post_meta($post_id, '_exercise_game_link', $game_link);
            update_post_meta($post_id, '_exercise_stats_game', $stats_game);
            update_post_meta($post_id, '_exercise_stats_access', $stats_access);

            wp_redirect( add_query_arg( 'exercise_status', 'success', get_permalink() ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'handle_exercise_submission' );
?>