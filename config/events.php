<?php defined('BASEPATH') || exit('No direct script access allowed');
/*
	Copyright (c) 2011 Lonnie Ezell

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/


    $config['search_geral'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Events_contact.php',
            'class'  => 'Events_contact',
            'method'     => '_geral_search'
        );

        $config['search_geral_ajax'][] = array(
                'module'     => 'contact',
                'filepath'   => 'controllers',
                'filename'   => 'Events_contact.php',
                'class'  => 'Events_contact',
                'method'     => '_geral_search_ajax'
            );

    $config['search_contact'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Events_contact.php',
            'class'  => 'Events_contact',
            'method'     => '_ajax_search'
        );

    $config['load_tours'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Events_contact.php',
            'class'      => 'Events_contact',
            'method'     => '_tour_link'
        );

        $config['load_initial_config'][] = array(
                'module'     => 'contact',
                'filepath'   => 'controllers',
                'filename'   => 'Events_contact.php',
                'class'  => 'Events_contact',
                'method'     => '_config_link'
            );

    $config['search_groups'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Group.php',
            'class'  => 'Group',
            'method'     => 'search_groups'
        );

    $config['insert_contact'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Group.php',
            'class'  => 'Group',
            'method'     => '_add_to_group'
        );


    $config['save_user'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Events_contact.php',
            'class'  => 'Events_contact',
            'method'     => 'Create_user_contact'
        );

        $config['show_profile_contact'][] = array(
                'module'     => 'contact',
                'filepath'   => 'controllers',
                'filename'   => 'Events_contact.php',
                'class'  => 'Events_contact',
                'method'     => 'contact_create_access'
            );

    $config['show_profile_contact'][] = array(
            'module'     => 'contact',
            'filepath'   => 'controllers',
            'filename'   => 'Events_contact.php',
            'class'  => 'Events_contact',
            'method'     => 'company_contacts'
        );

        $config['get_notifications_user'][] = array(
                'module'     => 'contact',
                'filepath'   => 'controllers',
                'filename'   => 'Events_contact.php',
                'class'  => 'Events_contact',
                'method'     => 'get_user_notif'
            );


            $config['show_create_contact_field'][] = array(
                    'module'     => 'contact',
                    'filepath'   => 'controllers',
                    'filename'   => 'Events_contact.php',
                    'class'  => 'Events_contact',
                    'method'     => '_form_widget'
                );

            $config['get_markers'][] = array(
                    'module'     => 'contact',
                    'filepath'   => 'controllers',
                    'filename'   => 'Events_contact.php',
                    'class'  => 'Events_contact',
                    'method'     => '_get_markersbound'
                );

            $config['search_markers'][] = array(
                    'module'     => 'contact',
                    'filepath'   => 'controllers',
                    'filename'   => 'Events_contact.php',
                    'class'      => 'Events_contact',
                    'method'     => '_get_marker_list'
                );

            $config['show_header_user_page'][] = array(
                    'module'     => 'contact',
                    'filepath'   => 'controllers',
                    'filename'   => 'Events_contact.php',
                    'class'      => 'Events_contact',
                    'method'     => '_card_related_contact'
                );
