<?php

  // is_blank('abcd')
  function is_blank($value) {
    return !isset($value) || trim($value) === '';
  }

  // has_presence('abcd')
  function has_presence($value) {
    return !is_blank($value);
  }

  // has_length_greater_than('abcd', 3)
  function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
  }

  // has_length_less_than('abcd', 5)
    function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
  }

  // has_length_exactly('abcd', 4)
  function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
      return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
      return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_inclusion_of( 5, [1,3,5,7,9] )
  // * validate inclusion in a set
  function has_inclusion_of($value, $set) {
  	return in_array($value, $set);
  }

  // has_exclusion_of( 5, [1,3,5,7,9] )
  // * validate exclusion from a set
  function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
  }

  // has_string('nobody@nowhere.com', '.com')
  function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
  }

  // has_valid_email_format('nobody@nowhere.com')
  //    returns 1 for a match, 0 for no match
  //    http://php.net/manual/en/function.preg-match.php
  function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
  }

  function has_unique_page_menu_name($menu_name, $current_id = "0") {
    global $connection;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE menu_name='" . $menu_name . "' ";
    $sql .= "AND id != '" . $current_id . "'";

    $page_set = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $page_count = count($page_set);

    return $page_count === 0;
  }

// has_unique_username('johnqpublic')
// * Validates uniqueness of admins.username
// * For new records, provide only the username.
// * For existing records, provide current ID as second argument
//   has_unique_username('johnqpublic', 4)
function has_unique_username($username, $current_id = "0")
{
  global $connection;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE username='" . $username . "' ";
  $sql .= "AND id != '" . $current_id . "'";

  $result = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  $admin_count = count($result);

  return $admin_count === 0;
}

?>
