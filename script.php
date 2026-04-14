<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "test";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo "Errore.";
  exit;
}

$table = trim($_POST["table_name"] ?? "");
$columns = $_POST["columns"] ?? [];

if ($table === "" || empty($columns)) {
  echo "";
  exit;
}

$colsSql = [];
$pk = [];

foreach ($columns as $col) {
  $name = trim($col["name"] ?? "");
  $type = trim($col["type"] ?? "");
  $len  = trim($col["length"] ?? "");
  $isPk = isset($col["pk"]);
  $isNotNull = isset($col["notnull"]);

  if ($name === "" || $type === "") continue;

  if ($type === "VARCHAR") {
    $len = ($len === "") ? 255 : (int)$len;
    $type = "VARCHAR($len)";
  }

  $colDef = "`$name` $type";
  if ($isNotNull) $colDef .= " NOT NULL";

  $colsSql[] = $colDef;
  if ($isPk) $pk[] = "`$name`";
}

if (empty($colsSql)) {
  echo "Nessuna colonna valida.";
  exit;
}

if (!empty($pk)) {
  $colsSql[] = "PRIMARY KEY (" . implode(", ", $pk) . ")";
}
e
$sql = "CREATE TABLE `$table` (" . implode(", ", $colsSql) . ")";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  echo "Errore: " . $conn->connect_error;
  exit;
}

if ($conn->query($sql) === TRUE) {
  echo "<h2>Tabella creata con successo.</h2>";
  echo "<p><strong>Query:</strong> " . htmlspecialchars($sql) . "</p>";
  echo "<h3>Struttura tabella: " . htmlspecialchars($table) . "</h3>";

  if (!empty($pk)) {
    $pkLabel = (count($pk) > 1) ? "Chiave primaria composta" : "Chiave primaria";
    echo "<p><strong>$pkLabel:</strong> " . htmlspecialchars(str_replace('`', '', implode(", ", $pk))) . "</p>";
  }

  echo "<table border='1' cellpadding='6' cellspacing='0'>";
  echo "<tr><th>Colonna</th><th>Tipo</th><th>PK</th></tr>";
  foreach ($columns as $col) {
    $name = htmlspecialchars($col["name"] ?? "");
    $type = htmlspecialchars($col["type"] ?? "");
    $len  = trim($col["length"] ?? "");
    $isPk = isset($col["pk"]) ? "Sì" : "No";
    if ($name === "" || $type === "") continue;

    if ($type === "VARCHAR") {
      $len = ($len === "") ? 255 : (int)$len;
      $type = "VARCHAR($len)";
    }

    echo "<tr><td>$name</td><td>$type</td><td>$isPk</td></tr>";
  }
  echo "</table>";
} else {
  echo "Errore: " . $conn->error;
}


$conn->close();
?>
