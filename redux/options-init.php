<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "opt_FetchFacebookPhotosPage";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'opt_FetchFacebookPhotosPage',
        'dev_mode' => TRUE,
        'use_cdn' => TRUE,
        'display_name' => 'FetchFacebookPhotosPage',
        'display_version' => '1.0.0',
        'page_title' => 'FetchFacebookPhotosPage',
        'menu_type' => 'submenu',
        'menu_title' => 'FetchFacebookPhotosPage',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'options-general.php',
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_color' => 'lightgray',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
        'show_options_object' => FALSE,
        'show_import_export' => FALSE,
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'     => 'Settings',
        'desc'      => 'The settings of FetchFacebookPhotosPage plugin',
        'icon'      => 'el el-facebook',
        'fields'    => array(
            array(
                'id'        => 'opt-facebook-id',
                'type'      => 'password',
                'title'     => 'The ID of the Facebook app',
                'desc'      => 'Enter the ID of the Facebook app',
                'default'   => '',
                'username'  => FALSE,
            ),
            array(
                'id'        => 'opt-facebook-secret',
                'type'      => 'password',
                'title'     => 'The SECRET of the Facebook app',
                'desc'      => 'Enter the SECRET of the Facebook app',
                'default'   => '',
                'username'  => FALSE,
            ),
            array(
                'id'        => 'opt-facebook-token',
                'type'      => 'password',
                'title'     => 'The ACCESS TOKEN of the Facebook app',
                'desc'      => 'Enter the ACCESS TOKEN of the Facebook app',
                'default'   => '',
                'username'  => FALSE,
            ),
        ),
    ) );

    Redux::setSection( $opt_name, array(
        'title'     => 'Status',
        'desc'      => 'The status of the FetchFacebookPhotosPage plugin',
        'icon'      => 'el el-play',
        'fields'    => array(
            array(
                'id'        => 'opt-facebook-start',
                'type'      => 'switch',
                'title'     => 'Start/Stop the plugin',
                'desc'      => 'Start or Stop the FetchFacebookPhotosPage plugin',
                'default'   => FALSE,
                'on'        => 'Start',
                'off'       => 'Stop',
            ),
        ),
    ) );

    /*
     * <--- END SECTIONS
     */
