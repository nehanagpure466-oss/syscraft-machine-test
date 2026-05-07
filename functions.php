<?php

function chi_child_enqueue_styles() {

    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );
}

add_action(
    'wp_enqueue_scripts',
    'chi_child_enqueue_styles'
);

function bd_get_cached_books_data() {

    // Check cached data first
    $cached_data = get_transient('bd_books_data');

    // Return cache if available
    if ($cached_data !== false) {

        return $cached_data;
    }

    // API request
    $response = wp_remote_get(
        'https://jsonplaceholder.typicode.com/posts'
    );

    // Handle API errors
    if (is_wp_error($response)) {

        return array();
    }

    // Get response body
    $body = wp_remote_retrieve_body($response);

    // Convert JSON into array
    $data = json_decode($body, true);

    // Store cache for 1 hour
    set_transient(
        'bd_books_data',
        $data,
        HOUR_IN_SECONDS
    );

    return $data;
}

function bd_show_cached_books() {

    $data = bd_get_cached_books_data();

    if (empty($data)) {

        return;
    }

    echo '<h2>Cached API Books</h2>';

    echo '<ul>';

    foreach (array_slice($data, 0, 5) as $item) {

        echo '<li>' .
            esc_html($item['title']) .
            '</li>';
    }

    echo '</ul>';
}

function bd_custom_excerpt_more($more) {

    return '... <a href="' .
        get_permalink() .
        '">View Details</a>';
}

add_filter(
    'excerpt_more',
    'bd_custom_excerpt_more'
);

function bd_change_read_more_text(
    $translated_text,
    $text,
    $domain
) {

    if ($translated_text === 'Read More') {

        $translated_text = 'View Details';
    }

    return $translated_text;
}

add_filter(
    'gettext',
    'bd_change_read_more_text',
    20,
    3
);