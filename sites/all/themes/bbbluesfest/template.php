<?php

/**
 * @file
 * Process theme data.
 *
 * Use this file to run your theme specific implimentations of theme functions,
 * such preprocess, process, alters, and theme function overrides.
 *
 * Preprocess and process functions are used to modify or create variables for
 * templates and theme functions. They are a common theming tool in Drupal, often
 * used as an alternative to directly editing or adding code to templates. Its
 * worth spending some time to learn more about these functions - they are a
 * powerful way to easily modify the output of any template variable.
 * 
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "bbbluesfest" to match
 *    your subthemes name, e.g. if your theme name is "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "bbbluesfest".
 * 2. Uncomment the required function to use.
 */


/**
 * Preprocess variables for the html template.
 */
/* -- Delete this line to enable.
function bbbluesfest_preprocess_html(&$vars) {
  global $theme_key;

  // Two examples of adding custom classes to the body.
  
  // Add a body class for the active theme name.
  // $vars['classes_array'][] = drupal_html_class($theme_key);

  // Browser/platform sniff - adds body classes such as ipad, webkit, chrome etc.
  // $vars['classes_array'][] = css_browser_selector();

}
// */


/**
 * Process variables for the html template.
 */
/* -- Delete this line if you want to use this function
function bbbluesfest_process_html(&$vars) {
}
// */


/**
 * Override or insert variables for the page templates.
 */
function bbbluesfest_preprocess_page(&$vars) {
  global $theme_key;
  $theme_name = $theme_key;

  // Set up logo element
  if (at_get_setting('toggle_logo', $theme_name) === 1) {
    $vars['site_logo'] = drupal_static('adaptivetheme_preprocess_page_site_logo');
    if (empty($vars['site_logo'])) {
      $logo_path = check_url($vars['logo']);
      $logo_alt = check_plain(variable_get('site_name', t('Site logo')));
      $logo_vars = array('path' => $logo_path, 'alt' => $logo_alt, 'attributes' => array('class' => 'site-logo'));
      $vars['logo_img'] = theme('image', $logo_vars);
      $vars['site_logo'] = $vars['logo_img'] ? l($vars['logo_img'], '<front>', array('attributes' => array('title' => t('Home page')), 'html' => TRUE)) : '';
    }
    // Maintain backwards compatibility with 7.x-2.x sub-themes
    $vars['linked_site_logo'] = $vars['site_logo'];
  }
  else {
    $vars['site_logo'] = '';
    $vars['logo_img'] = '';
    $vars['linked_site_logo'] = '';
  }

  // Site name
  $vars['site_name'] = &drupal_static('adaptivetheme_preprocess_page_site_name');
  if (empty($vars['site_name'])) {
    $vars['site_name_title'] = variable_get('site_name', 'Drupal');
    $vars['site_name'] = l($vars['site_name_title'], '<front>', array('attributes' => array('title' => t('Home page'))));
    $vars['site_name_unlinked'] = $vars['site_name_title'];
  }

  // Site name visibility and other classes and variables
  $vars['site_name_attributes_array'] = array();
  $vars['visibility'] = '';
  $vars['hide_site_name'] = FALSE;
  if (at_get_setting('toggle_name', $theme_name) === 0) {
    // Keep the visibility variable to maintain backwards compatibility
    $vars['visibility'] = 'element-invisible';
    $vars['site_name_attributes_array']['class'][] = $vars['visibility'];
    $vars['hide_site_name'] = TRUE;
  }

  // Build a variable for the main menu
  if (isset($vars['main_menu'])) {
    $vars['primary_navigation'] = theme('links', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('menu', 'primary-menu', 'clearfix'),
       ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }

  // Build a variable for the secondary menu
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_navigation'] = theme('links', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('menu', 'secondary-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary navigation'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }

  // Build variables for Primary and Secondary local tasks
  $vars['primary_local_tasks'] = menu_primary_local_tasks();
  $vars['secondary_local_tasks'] = menu_secondary_local_tasks();

  // Add back the $search_box var to D7
  if (module_exists('search')) {
    $search_box = drupal_get_form('search_form');
    $vars['search_box'] = '<div id="search-box">' . drupal_render($search_box) . '</div>';
  }

  // Process enabled Extensions
  if (at_get_setting('enable_extensions', $theme_name) === 1) {
    // Generate page classes, in AT Core these are all Extensions
    if ($page_classes = generate_page_classes($vars, $theme_name)) {
      foreach ($page_classes as $class_name) {
        $vars['classes_array'][] = $class_name;
      }
    }
    // Process modify markup settings
    if (at_get_setting('enable_markup_overides', $theme_name) === 1) {
      // Remove the infernal feed icons
      if (at_get_setting('feed_icons_hide', $theme_name) === 1) {
        $vars['feed_icons'] = '';
      }
    }
  }

  // Strip stupid contextual-links-region class, wtf?
  $vars['classes_array'] = array_values(array_diff($vars['classes_array'], array('contextual-links-region')));

  // page attributes
  $vars['page_attributes_array']['id'][] = 'page';
  $vars['page_attributes_array']['class'] = $vars['classes_array'];

  // header attributes
  $vars['header_attributes_array']['id'][] = 'header';
  $vars['header_attributes_array']['class'][] = 'clearfix';
  $vars['header_attributes_array']['role'][] = 'banner';

  // hgroup attributes
  $vars['hgroup_attributes_array'] = array();
  if (!$vars['site_slogan'] && $vars['hide_site_name']) {
    $vars['hgroup_attributes_array']['class'][] = $vars['visibility'];
  }

  // branding attributes
  $vars['branding_attributes_array']['id'][] = 'branding';
  $vars['branding_attributes_array']['class'][] = 'branding-elements';
  //$vars['branding_attributes_array']['class'][] = 'clearfix';

  // hgroup attributes
  $vars['hgroup_attributes_array']['id'][] = 'name-and-slogan';

  // site name attributes
  $vars['site_name_attributes_array']['id'][] = 'site-name';

  // site slogan attributes
  $vars['site_slogan_attributes_array']['id'][] = 'site-slogan';

  // main content header attributes
  $vars['content_header_attributes_array']['id'][] = 'main-content-header';
  $vars['content_header_attributes_array']['class'][] = 'clearfix';

  // footer attributes
  $vars['footer_attributes_array']['id'][] = 'footer';
  $vars['footer_attributes_array']['class'][] = 'clearfix';
  $vars['footer_attributes_array']['role'][] = 'contentinfo';

  // Attribution variable used in admin theme and some others
  $vars['attribution'] = "<small class=\"attribution\"><a href=\"http://adaptivethemes.com\">Premium Drupal Themes</a></small>";

  // Work around a perculier bug/feature(?) in Drupal 7 which incorrectly sets
  // the page title to "User account" for all three of these pages.
  if (arg(0) === 'user') {
    if (arg(1) === 'login' || arg(1) == '') {
      drupal_set_title(t('User login'));
    }
    if (arg(1) === 'password') {
      drupal_set_title(t('Request new password'));
    }
    if (arg(1) === 'register') {
      drupal_set_title(t('Create new account'));
    }
  }
}
function bbbluesfest_process_page(&$vars) {
}
// */


/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function bbbluesfest_preprocess_node(&$vars) {
}
function bbbluesfest_process_node(&$vars) {
}
// */


/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function bbbluesfest_preprocess_comment(&$vars) {
}
function bbbluesfest_process_comment(&$vars) {
}
// */


/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function bbbluesfest_preprocess_block(&$vars) {
}
function bbbluesfest_process_block(&$vars) {
}
// */
