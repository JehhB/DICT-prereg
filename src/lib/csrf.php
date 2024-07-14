<?php

/**
 * Generate new CsrfToken and save if to $_SESSION['csrf_token']
 */
function regenerateCsrfToken()
{
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Check validity of CsrfToken
 *
 * @return bool whether token is valid
 */
function validateCsrfToken(?string $token = null)
{
  if (is_null($token) && isset($_POST['__token'])) {
    $token = $_POST['__token'];
  }
  if (is_null($token)) return false;
  if (!hash_equals($_SESSION['csrf_token'], $token)) return false;

  //  regenerateCsrfToken();
  return true;
}

/**
 * Crate a field for csrf token
 *
 * @return string input element for token
 */
function csrf_field()
{
  if (!isset($_SESSION['csrf_token'])) regenerateCsrfToken();
  $token = $_SESSION['csrf_token'];

  return <<<END
<input type="hidden" name="__token" value="$token">
END;
}
