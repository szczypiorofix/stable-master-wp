<?php

defined( 'ABSPATH' ) || exit;

class SM_ShortCodes {
    private $noHorsesMessage = "Brak koni do wyświetlenia";
    private $sortParameterName = 'sort';

    public function __construct() {
        add_shortcode('lista_koni', array($this, 'horseListShortCode'));
        add_shortcode('lista_linkow_koni', array($this, 'horseLinksListShortCode'));
        add_shortcode('lista_koni_zdjecia', array($this,'lista_koni_zdjecia_shortcode'));
        add_shortcode('lista_koni_zdjecia_linki', array($this, 'lista_koni_zdjecia_linki_shortcode'));
    }

    public function horseListShortCode($atts) {
        $atts = shortcode_atts(array(
            'rasa' => '',
            $this->sortParameterName => 'imie',
        ), $atts);

        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );

        if ($atts[$this->sortParameterName] == 'imie') {
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
        } elseif ($atts[$this->sortParameterName] == 'data') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        }
    
        $query = new WP_Query($args);
        $output = "";
        if ($query->have_posts()) {
            $output .= '<ul>';
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li>' . get_the_title() . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output = '<p>Brak koni do wyświetlenia.</p>';
        }
        wp_reset_postdata();
        return $output;
    }

    public function horseLinksListShortCode() {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        $output = '<ul>';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
        } else {
            $output .= "<li>$this->noHorsesMessage</li>";
        }
        $output .= '</ul>';
        wp_reset_postdata();
        return $output;
    }

    public function lista_koni_zdjecia_shortcode() {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        $output = '<div class="lista-koni-zdjecia">';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<div class="kon-zdjecie">';
                if (has_post_thumbnail()) {
                    $output .= get_the_post_thumbnail(null, 'medium'); // Możesz zmienić rozmiar zdjęcia
                }
                $output .= '<h3>' . get_the_title() . '</h3>';
                $output .= '</div>';
            }
        } else {
            $output .= "<p>$this->noHorsesMessage</p>";
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    }
    
    public function lista_koni_zdjecia_linki_shortcode() {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        $output = '<div class="lista-koni-zdjecia-linki">';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<div class="kon-zdjecie-link">';
                $output .= '<a href="' . get_permalink() . '">';
                if (has_post_thumbnail()) {
                    $output .= get_the_post_thumbnail(null, 'medium');
                }
                $output .= '<h3>' . get_the_title() . '</h3>';
                $output .= '</a>';
                $output .= '</div>';
            }
        } else {
            $output .= "<p>$this->noHorsesMessage</p>";
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    }
}
