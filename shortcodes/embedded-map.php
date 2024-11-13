<?php

function emc_sc_embedded_map($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case((array) $atts, CASE_LOWER);

    extract(shortcode_atts(
        array(
            'width' => null,
            'height' => null,
            'marker' => true,
            'lat' => 41.50281,
            'lng' => 1.81346,
            'zoom' => 14.5,
            'class' => null
        ),
        $atts,
        $tag
    ));

    $id = uniqid();

    $style = '';
    if ($height) {
        $style .= 'height: ' . $height . ';';
    }
    if ($width) {
        $style .= 'width: ' . $width . ';';
    }

    $classes = 'emc_embedded_map';
    if ($class) {
        $classes .= ' ' . $class;
    }

    $content = '<div id="' . $id . '" class="' . $classes . '" style="' . $style . '"></div>';

    if (!wp_script_is('leaflet-js')) {
        wp_enqueue_script('leaflet-js');
    }

    if (!wp_script_is('leaflet-css')) {
        wp_enqueue_style('leaflet-css');
    }

    $script = '<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = new L.map("' . $id . '")
            .setView([' . $lat . ', ' . $lng . '], ' . $zoom . ');

        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>"
        }).addTo(map);

        L.marker([' . $lat . ', ' . $lng . ']).addTo(map);
    });
    </script>';

    return $content . $script;
}

add_shortcode('embedded_map', 'emc_sc_embedded_map');
