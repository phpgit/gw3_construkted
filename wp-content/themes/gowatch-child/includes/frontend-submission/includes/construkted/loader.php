<?php

define( 'CONSTRUKTED_ROOT', get_stylesheet_directory() . '/includes/frontend-submission' );

class CONSTRUKTED_Loader {

    public function __construct() {

        $this->includes();

        add_action( 'tszf_render_pro_file_upload',           array( $this, 'tszf_render_pro_file_upload_runner' ), 10, 7 );
    }

    public function includes() {
        require_once CONSTRUKTED_ROOT . '/includes/construkted/render-form.php';
    }

    public function tszf_render_pro_file_upload_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        CONSTRUKTED_render_form_element::file_upload( $form_field, $post_id, $type, $form_id, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }

}

new CONSTRUKTED_Loader();