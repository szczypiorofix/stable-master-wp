<?php

defined( 'ABSPATH' ) || exit;

class Sm_Cpt_Horse extends Sm_Cpt {
    public function __construct(string $postTypeSlug) {
        parent::__construct($postTypeSlug);

        add_filter('enter_title_here', array($this, 'sm_horse_change_title'));

        $this->addField(
            'horseDescription',
            new Sm_Cpt_Field(
                "_horseDescription",
                'Opis konia',
                'horseDescription_nonce',
                'customMetaBox'
            )
        );
    }

    public function sm_horse_change_title($title){
        $screen = get_current_screen();
        if  ('sm_horse' == $screen->post_type) {
            $title = 'Imię konia';
        }
        return $title;
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
            'supports'          => array('title', 'editor', 'thumbnail') // 'author'
        );

        register_post_type( $this->postTypeSlug, $postTypeArgs );
    }

    public function getCustomMetaBox(): void {
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

    public function horseDescriptionCustomFields() {

        ?>
        <p>Opis konia:</p>
        <textarea cols="48" rows="6" style="width: 100%;"></textarea>
        <?php
    }
}
