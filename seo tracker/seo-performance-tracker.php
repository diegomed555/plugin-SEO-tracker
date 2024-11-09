<?php
/*
Plugin Name: SEO Performance Tracker
Description: Plugin para rastrear el rendimiento SEO de tu sitio y mostrar métricas clave.
Version: 1.3
Author: Diego Medina
*/

// Activar el plugin y crear tablas necesarias
register_activation_hook(__FILE__, 'seo_performance_tracker_activate');
function seo_performance_tracker_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'seo_metrics';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        keyword VARCHAR(255) NOT NULL,
        position INT NOT NULL,
        page_url VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Cargar archivos CSS y JS
function seo_performance_tracker_enqueue_assets() {
    wp_enqueue_style('seo-tracker-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('seo-tracker-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'seo_performance_tracker_enqueue_assets');

// Incluir lógica de rastreo SEO
require_once(plugin_dir_path(__FILE__) . 'includes/seo-tracking.php');

// Mostrar métricas en el dashboard
function seo_performance_tracker_dashboard_widget() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'seo_metrics';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    
    echo '<h3>Métricas de SEO</h3>';
    echo '<table>';
    echo '<tr><th>Keyword</th><th>Posición</th><th>URL</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . esc_html($row->keyword) . '</td>';
        echo '<td>' . esc_html($row->position) . '</td>';
        echo '<td>' . esc_html($row->page_url) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('seo_performance_tracker_widget', 'SEO Performance', 'seo_performance_tracker_dashboard_widget');
});
