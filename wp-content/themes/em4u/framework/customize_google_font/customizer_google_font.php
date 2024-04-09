<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control{

    private $fonts = false;
    


    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->fonts = $this->em4u_get_fonts();
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content(){

        if(!empty($this->fonts))
        {
            ?>
                <label style="margin-bottom: 10px; margin-top: 10px; display:block;">

                    <span style="padding-bottom: 5px; display:block;" class="customize-category-select-control"><strong><?php echo esc_html( $this->label ); ?></strong></span>
                    <i style="padding-bottom: 5px; display:block;"><?php echo esc_html( $this->description ); ?></i>
                    
                    <select <?php $this->link(); ?>>
                        <?php 
                            if( get_theme_mod('em4u_custom_font','') != '' ){
                                $cus_fonts = explode(',', get_theme_mod('em4u_custom_font',''));
                                foreach ($cus_fonts as $key => $value) {
                                    printf('<option value="ovatheme_%s">%s</option>', trim($value), $value) ;
                                }
                            }
                        ?>  

                        <?php
                            foreach ( $this->fonts as $k => $v )
                            {
                                printf('<option value="%s" %s> %s </option>', $v->family, selected($this->value(), $k, false), $v->family);
                            }
                        ?>
                    </select>
                </label>
            <?php
        }
    }

    /**
     * Get the google fonts from the API or in the cache
     *
     * @param  integer $amount
     *
     * @return String
     */
    public function em4u_get_fonts( $amount = '1000' ){

        $fontFile = EM4U_URI.'/framework/customize_google_font/cache/google-web-fonts.txt';
        $url = $fontFile;
        $request =   wp_remote_get($url);
        // Get the body of the response
        $response = wp_remote_retrieve_body( $request );
        // Decode the json
        $content = json_decode( $response ); 


        return $content->items;
    }

 }
?>