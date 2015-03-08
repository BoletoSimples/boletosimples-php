<?php

namespace BoletoSimples;

class Util {
  /**
   * Pluralize the element name.
   */
  public static function pluralize($word) {
    $word .= 's';
    $word = preg_replace('/(x|ch|sh|ss])s$/', '\1es', $word);
    $word = preg_replace('/ss$/', 'ses', $word);
    $word = preg_replace('/([ti])ums$/', '\1a', $word);
    $word = preg_replace('/sises$/', 'ses', $word);
    $word = preg_replace('/([^aeiouy]|qu)ys$/', '\1ies', $word);
    $word = preg_replace('/(?:([^f])fe|([lr])f)s$/', '\1\2ves', $word);
    $word = preg_replace('/ieses$/', 'ies', $word);
    return $word;
  }

  /**
   * Undescorize the element name.
   */
  public static function underscorize($word) {
    $word = preg_replace('/[\'"]/', '', $word);
    $word = preg_replace('/[^a-zA-Z0-9]+/', '_', $word);
    $word = preg_replace('/([A-Z\d]+)([A-Z][a-z])/', '\1_\2', $word);
    $word = preg_replace('/([a-z\d])([A-Z])/', '\1_\2', $word);
    $word = trim($word, '_');
    $word = strtolower($word);
    $word = str_replace('boleto_simples_', '', $word);
    return $word;
  }
}