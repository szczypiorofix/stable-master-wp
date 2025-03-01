<?php

defined( 'ABSPATH' ) || exit;

class Sm_Cpt_Horse extends Sm_Cpt {
    
    
    public function __construct(string $postTypeSlug) {
        parent::__construct($postTypeSlug);

        $this->addField(
            'horseDescription',
            new Sm_Cpt_Field(
                "_horseDescription",
                'Opis konia',
                'horseDescription_nonce',
                'customMetaBox'
            )
        );

        add_filter('enter_title_here', array($this, 'changePostTitlePlaceholder'));

        add_action('init', array($this, 'addCustomHorseCategory'));
        add_action('init', array($this, 'addCustomHorseTags'));

        add_action('admin_init', array($this, 'addCustomColumnnForPostList'));
    }


    public function addCustomColumnnForPostList() {
        add_filter("manage_{$this->postTypeSlug}_posts_columns", array($this, 'addHorseImageColumn'));
        add_filter("manage_{$this->postTypeSlug}_posts_custom_column", array($this, 'addDisplayHorseImageColumn'), 10, 2);
    }

    public function changePostTitlePlaceholder($title){
        $screen = get_current_screen();
        if  ('sm_horse' == $screen->post_type) {
            $title = 'Imię konia';
        }
        return $title;
    }

    public function addHorseImageColumn($columns): array {
        $new_columns = array();
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key == 'title') {
                $new_columns['post_image'] = __('Zdjęcie konia', SM_DOMAIN);
            }
        }
        return $new_columns;
    }

    public function addDisplayHorseImageColumn($column_name, $post_id = "default") {
        if ($column_name === 'post_image') {
            if (has_post_thumbnail($post_id)) {
                $image = get_the_post_thumbnail($post_id, array(60, 60));
                echo $image;
            } else {
                echo __('No Image', SM_DOMAIN);
            }
        }
    }
    
    public function registerPostTypeCallback(): void {
        $labels = array(
            'name'                  => __('Koń', SM_DOMAIN ),
            'singular_name'         => __('Koń', SM_DOMAIN),
            'menu_name'             => __('Konie', SM_DOMAIN),
            'name_admin_bar'        => __('Koń', SM_DOMAIN),
            'add_new'               => __('Dodaj nowego', SM_DOMAIN),
            'add_new_item'          => __('Dodaj nowego konia', SM_DOMAIN),
            'new_item'              => __('Nowy koń', SM_DOMAIN),
            'edit_item'             => __('Edytuj konia', SM_DOMAIN),
            'view_item'             => __('Zobacz konia', SM_DOMAIN),
            'all_items'             => __('Wszystkie konie', SM_DOMAIN),
            'search_items'          => __('Szukaj koni', SM_DOMAIN),
            'parent_item_colon'     => __('Nadrzędny koń', SM_DOMAIN),
            'not_found'             => __('Nie znaleziono koni', SM_DOMAIN),
            'not_found_in_trash'    => __('Nie znaleziono koni w koszu', SM_DOMAIN),
            'featured_image'        => __('Obraz konia', SM_DOMAIN),
            'set_featured_image'    => __('Ustaw obraz konia', SM_DOMAIN),
            'remove_featured_image' => __('Usuń obaz konia', SM_DOMAIN),
            'use_featured_image'    => __('Użyj jako obrazu konia', SM_DOMAIN),
            'archives'              => __('Archiwum koni', SM_DOMAIN),
            'insert_into_item'      => __('Wstaw do konia', SM_DOMAIN),
            'uploaded_to_this_item' => __('Załadowano do konia', SM_DOMAIN),
            'filter_items_list'     => __('Filtruj listę koni', SM_DOMAIN),
            'items_list_navigation' => __('Nawigacja po koniach', SM_DOMAIN),
            'items_list'            => __('Lista koni', SM_DOMAIN)
        );
        $postTypeArgs = array(
            'hierarchical'      => false,
            'public'            => true,
            'labels'            => $labels,
            'description'       => __('Podstawowa strona koni', SM_DOMAIN),
            'has_archive'       => true,
            'menu_icon'         => 'dashicons-admin-page',
            'show_in_menu'      => true,
            'capability_type'   => 'post',
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'show_in_rest'      => true,
            'menu_position'     => 31,
            'supports'          => array('title', 'editor', 'thumbnail')
        );

        register_post_type( $this->postTypeSlug, $postTypeArgs );
    }

    public function addCustomMetaBoxCallback(): void {
        add_meta_box( 
            $this->getField('horseDescription')->metaBoxId,
            __($this->getField('horseDescription')->title, SM_DOMAIN),
            array($this, 'horseDescriptionCustomFields'),
            $this->postTypeSlug,
            'normal',
            'default'
        );
    }

    public function savePostCallback(int $post_id): void {

    }

    public function addCustomHorseCategory(): void {
        $labels = array(
            'name'              => _x('Kategorie koni', 'taxonomy general name', SM_DOMAIN),
            'singular_name'     => _x('Kategoria koni', 'taxonomy singular name', SM_DOMAIN),
            'search_items'      => __('Szukaj kategorii koni', SM_DOMAIN),
            'all_items'         => __('Wszystkie kateorie koni', SM_DOMAIN),
            'parent_item'       => __('Kategoria rodzima', SM_DOMAIN),
            'parent_item_colon' => __('Kategoria rodzima:', SM_DOMAIN),
            'edit_item'         => __('Edytuj kategorię koni', SM_DOMAIN),
            'update_item'       => __('Aktualizuj kategorię', SM_DOMAIN),
            'add_new_item'      => __('Dodaj nową kategorię', SM_DOMAIN),
            'new_item_name'     => __('Nazwa nowej kategorii', SM_DOMAIN),
            'menu_name'         => __('Kategorie koni', SM_DOMAIN),
        );
    
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'horse_category'),
        );
    
        register_taxonomy('horse_category', array($this->postTypeSlug), $args);
    }

    public function addCustomHorseTags(): void {
        $labels = array(
            'name' => _x( 'Cechy koni', 'taxonomy general name' ),
            'singular_name' => _x( 'Cecha konia', 'taxonomy singular name' ),
            'search_items' =>  __( 'Szukaj cech koni' ),
            'popular_items' => __( 'Popularne cechy koni' ),
            'all_items' => __( 'Wszystkie cechy koni' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edytuj cechy' ), 
            'update_item' => __( 'Aktualizuj cechy' ),
            'add_new_item' => __( 'Dodaj nowe cechy' ),
            'new_item_name' => __( 'Nazwa nowej cechy' ),
            'separate_items_with_commas' => __( 'Rodziej cechy przecinkiem' ),
            'add_or_remove_items' => __( 'Dodaj lub usuń cechy' ),
            'choose_from_most_used' => __( 'Najczęściej używane cechy' ),
            'menu_name' => __( 'Cechy' ),
          ); 
        
          register_taxonomy('horse_tag', array($this->postTypeSlug), array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'tag'),
          ));
    }

    public function horseDescriptionCustomFields(): void {
        wp_nonce_field(plugin_basename(__FILE__), 'horseDescription_nonce');

        ?>
        <p>Opis konia:</p>
        <textarea cols="48" rows="6" style="width: 100%;"></textarea>
        <?php
    }
}
