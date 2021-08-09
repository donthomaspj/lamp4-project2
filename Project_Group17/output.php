<!--Page to output the results from database
Author: Joseph Piquero-->
<html>

<head>
  <meta charset="utf-8">
  <title>File Upload</title>
  <style>
  body {
    color: navy;
  }

  h1 {
    text-align: center;
  }

  table {
    width: 100%;
    margin: auto;
    background-color: whitesmoke;
    color: navy;
  }
  </style>
</head>

<body>
  <h1> Display Employees Data</h1>


  <?php
require_once("db_connection.php");
session_start();

// get value of array from index.php
$arr = $_SESSION['csv'];
// get unique value value from $arr
$unique = array_unique($arr,SORT_REGULAR);
// get duplicate value
// $duplicates = array_diff_assoc($arr, $unique);
$duplicates = array_udiff_assoc($arr, $unique, function($a, $b) {
  return $a != $b;
});

echo "<table border=\"1\">\n";
echo "<tr><th>ID</th><th>Name</th><th>SurName</th></tr>\n";
foreach ($arr as $key=>$row) {
    // if each value same one of value of $duplicates (it means the value if dupicate)
    if(array_search($row, $duplicates)) {
        echo "<tr style='background: pink'><td>";
        echo $key + 1;
        echo "</td>";
        foreach($row as $value) {
            echo "<td>";
            echo $value;
            echo "</td>";
        }
        echo "</tr>";
    } else {
        
        echo "<tr><td>";
        echo $key + 1;
    
        echo "</td>";
        
        foreach($row as $value) {
            echo "<td>";
            echo $value;
            echo "</td>";
        }
        echo "</tr>";
    }

}
    
 ?>
  <br />
  <a href="index.php">Return to menu</a>
</body>

</html>