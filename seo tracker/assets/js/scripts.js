jQuery(document).ready(function ($) {
    // Función para actualizar las métricas de SEO (ejemplo: llamada AJAX para obtener datos)
    function updateSeoMetrics() {
        $.ajax({
            url: ajaxurl, // WordPress AJAX handler
            method: 'GET',
            data: { action: 'get_seo_metrics' },
            success: function (response) {
                // Aquí procesamos la respuesta
                console.log('SEO Metrics:', response);
                // Puedes agregar más lógica para mostrar las métricas en el dashboard
            },
            error: function () {
                console.log('Error al obtener las métricas de SEO');
            }
        });
    }

    // Llamar a la función de actualización cuando se carga la página
    updateSeoMetrics();
});
