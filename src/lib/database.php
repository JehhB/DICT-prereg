<?php

/**
 * Get the instance for the database connection
 *
 * @return \PDO Connection to database
 */
function getDB()
{
  static $conn = null;
  if ($conn !== null) return $conn;

  $host = $_ENV['MYSQL_HOST'] ?? 'localhost';
  $database = $_ENV['MYSQL_DATABASE'] ?? 'prereg';
  $username = $_ENV['MYSQL_USER'] ?? 'root';
  $password = $_ENV['MYSQL_PASSWORD'] ?? '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
  } catch (PDOException $e) {
    exit("Connection Failed: {$e->getMessage()}");
  }

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  return $conn;
};

/**
 * Execute a SQL statement  into the database
 *
 * @param string $sql     SQL statement to run
 * @param array  $params  Parameters to bind into statement
 *
 * @return \PDOStatement Executed SQL statement
 */
function execute($sql, $params = array())
{
  $conn = getDB();
  $stmt = $conn->prepare($sql);

  foreach ($params as $key => $value) {
    $param = is_int($key) ? $key + 1 : $key;
    $var = is_array($value) ? $value[0] : $value;
    $type = is_array($value) ? $value[1] : PDO::PARAM_STR;

    $stmt->bindValue($param, $var, $type);
  }
  $stmt->execute();

  return $stmt;
}


function placeholder(array $arr)
{
  $length = count($arr);
  return implode(',', array_fill(0, $length, '?'));
}
