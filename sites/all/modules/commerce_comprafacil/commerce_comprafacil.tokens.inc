<?php

/**
 * @file
 * Builds placeholder replacement tokens for order-related data.
 */


/**
 * Implements hook_token_info().
 */
function commerce_comprafacil_token_info() {
  $type = array(
    'name' => t('Orders', array(), array('context' => 'a drupal commerce order')),
    'description' => t('Tokens related to individual orders.'),
    'needs-data' => 'commerce-order',
  );
  
  // Tokens for Compra Fácil.
  $comprafacil = array();

  $comprafacil['order-comprafacil_entity'] = array(
    'name' => t('Multibanco Compra Fácil: Entity', array(), array('context' => 'a drupal commerce order')),
    'description' => t('Entity from Multibanco reference.'),
  );
  $comprafacil['order-comprafacil_reference'] = array(
    'name' => t('Multibanco Compra Fácil: Reference', array(), array('context' => 'a drupal commerce order')),
    'description' => t('Reference from Multibanco reference.'),
  );
  $comprafacil['order-comprafacil_value'] = array(
    'name' => t('Multibanco Compra Fácil: Value'),
    'description' => t('Value from Multibanco reference.'),
  );


  return array(
    'types' => array('commerce-order' => $type),
    'tokens' => array('commerce-order' => $comprafacil),
  );
}

/**
 * Implements hook_tokens().
 */
function commerce_comprafacil_tokens($type, $tokens, array $data = array(), array $options = array()) {
  $url_options = array('absolute' => TRUE);

  if (isset($options['language'])) {
    $url_options['language'] = $options['language'];
    $language_code = $options['language']->language;
  }
  else {
    $language_code = NULL;
  }

  $sanitize = !empty($options['sanitize']);

  $replacements = array();

  if ($type == 'commerce-order' && !empty($data['commerce-order'])) {
    $order = $data['commerce-order'];
    
    $ref = db_query("SELECT c.order_id, c.reference, c.entity, c.value FROM {commerce_comprafacil} c WHERE c.order_id = :order_id", 
                      array(':order_id' => $order->order_id));
    
    $record = $ref->fetchAssoc();

    foreach ($tokens as $name => $original) {
      switch ($name) {
        // Simple key values on the order.
        case 'order-comprafacil_entity':
          $replacements[$original] = $record['entity'];
          break;

        case 'order-comprafacil_reference':
          $replacements[$original] = $record['reference'];
          break;

        case 'order-comprafacil_value':
          $replacements[$original] = $record['value'];
          break;

       }
    }

  }

  return $replacements;
}