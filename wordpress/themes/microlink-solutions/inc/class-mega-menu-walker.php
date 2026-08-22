<?php

class Advanced_Mega_Menu_Walker extends Walker_Nav_Menu {

    private $menu_type = '';

    // ✅ OPEN SUBMENU
    function start_lvl(&$output, $depth = 0, $args = null) {

        if ($this->menu_type === 'company' && $depth === 0) {
            $output .= '<ul class="option-1">';
        } 
        elseif ($this->menu_type === 'solutions' && $depth === 0) {
            $output .= '<ul class="mega-menu">';
        } 
        elseif ($this->menu_type === 'solutions' && $depth === 1) {
            $output .= '<ul>';
        } 
        else {
            $output .= '<ul class="sub-menu">';
        }
    }

    // ✅ CLOSE SUBMENU
    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    // ✅ START ELEMENT
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {

        $menu_type = get_post_meta($item->ID, '_menu_type', true);

        if ($depth === 0) {
            $this->menu_type = $menu_type;
        }

        // 🔹 LEVEL 0
        if ($depth === 0) {

            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

            // COMPANY WRAPPER
            if ($menu_type === 'company') {
                $desc = get_post_meta($item->ID, '_menu_item_desc', true);

                $output .= '<div class="mega-menu-wrap option-1-wrap">';
                $output .= '<div class="left-part">';
                $output .= '<h5 class="mm_title">' . esc_html($item->title) . '</h5>';
                $output .= '<div class="cms"><p>' . esc_html($desc) . '</p></div>';
                $output .= '</div>';
            }

            // SOLUTIONS WRAPPER
            if ($menu_type === 'solutions') {
                $desc = get_post_meta($item->ID, '_menu_item_desc', true);

                $output .= '<div class="mega-menu-wrap">';
                $output .= '<div class="left-part">';
                $output .= '<h5 class="mm_title">' . esc_html($item->title) . '</h5>';
                $output .= '<div class="cms"><p>' . esc_html($desc) . '</p></div>';
                $output .= '</div>';
            }
        }

        // 🔹 COMPANY CHILD (RIGHT SIDE FIX ✅)
        elseif ($depth === 1 && $this->menu_type === 'company') {

            $desc = get_post_meta($item->ID, '_menu_item_desc', true);

            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

            if (!empty($desc)) {
                $output .= '<p>' . esc_html($desc) . '</p>';
            }

            $output .= '</li>';
        }

        // 🔹 SOLUTIONS COLUMN
        elseif ($depth === 1 && $this->menu_type === 'solutions') {

            $output .= '<li>';
            $output .= '<a href="#" class="mm_title">' . esc_html($item->title) . '</a>';
        }

        // 🔹 SOLUTIONS SUB ITEMS
        elseif ($depth === 2 && $this->menu_type === 'solutions') {

            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            $output .= '</li>';
        }

        // 🔹 SERVICES
        elseif ($this->menu_type === 'services') {

            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            $output .= '</li>';
        }
    }

    // ✅ CLOSE ELEMENT
    function end_el(&$output, $item, $depth = 0, $args = null) {

        // Close wrappers
        if ($depth === 0) {

            if ($this->menu_type === 'company' || $this->menu_type === 'solutions') {
                $output .= '</div>'; // close mega-menu-wrap
            }

            $output .= '</li>';
        }

        // Close solutions column
        if ($depth === 1 && $this->menu_type === 'solutions') {
            $output .= '</li>';
        }
    }
}