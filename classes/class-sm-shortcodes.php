<?php

defined( 'ABSPATH' ) || exit;

class SM_ShortCodes {
    private string $no_horses_found_message = "Brak koni do wyświetlenia";
    private string $sort_parameter_name = 'sort';

    public function __construct() {
        add_shortcode( 'lista_koni', array( $this, 'horse_list_shortcode' ) );
        add_shortcode( 'lista_linkow_koni', array( $this, 'horse_links_list_shortcode' ) );
        add_shortcode( 'lista_koni_zdjecia', array( $this,'horse_images_list_shortcode' ) );
        add_shortcode( 'lista_koni_zdjecia_linki', array( $this, 'horse_images_and_links_list_shortcode' ) );
    }

    public function horse_list_shortcode( array $atts ): string {
        $atts = shortcode_atts(
            array(
                'rasa' => '',
                $this->sort_parameter_name => 'imie',
            ),
        $atts );

        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );

        if ( $atts[ $this->sort_parameter_name ] == 'imie' ) {
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
        } elseif ( $atts[ $this->sort_parameter_name ] == 'data' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        }
    
        $query = new WP_Query( $args );
        $output = "";
        if ( $query->have_posts() ) {
            $output .= '<ul>';
            while ( $query->have_posts() ) {
                $query->the_post();
                $output .= '<li>' . get_the_title() . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output = "<p>$this->no_horses_found_message</p>";
        }
        wp_reset_postdata();
        return $output;
    }

    public function horse_links_list_shortcode(): string {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query( $args );
        $output = '<ul>';
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
        } else {
            $output .= "<li>$this->no_horses_found_message</li>";
        }
        $output .= '</ul>';
        wp_reset_postdata();
        return $output;
    }

    public function horse_images_list_shortcode(): string {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query( $args );
        $output = '<div class="lista-koni-zdjecia">';
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $output .= '<div class="kon-zdjecie">';
                if ( has_post_thumbnail() ) {
                    $output .= get_the_post_thumbnail( null, 'medium' ); // Możesz zmienić rozmiar zdjęcia
                }
                $output .= '<h3>' . get_the_title() . '</h3>';
                $output .= '</div>';
            }
        } else {
            $output .= "<p>$this->no_horses_found_message</p>";
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    }
    
    public function horse_images_and_links_list_shortcode(): string {
        $args = array(
            'post_type' => SM_CPT_HORSE,
            'posts_per_page' => -1,
        );
        $query = new WP_Query( $args );
        $output = '<div class="lista-koni-zdjecia-linki">';
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $output .= '<div class="kon-zdjecie-link">';
                $output .= '<a href="' . get_permalink() . '">';
                if ( has_post_thumbnail() ) {
                    $output .= get_the_post_thumbnail( null, 'medium' );
                }
                $output .= '<h3>' . get_the_title() . '</h3>';
                $output .= '</a>';
                $output .= '</div>';
            }
        } else {
            $output .= "<p>$this->no_horses_found_message</p>";
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    }
}
