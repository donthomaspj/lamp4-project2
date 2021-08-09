<!--Create initial arrays and create a function to generate 400 databases
Author: Minh Hoang Tran, Hong Son Tran-->
<?php
error_reporting(E_ALL);   
ini_set("display_errors","On");

$first_name = ['Christian', 'Josh', 'Nolan', 'Jack', 'Mary', 'Patricia', 'Jennifer', 'Michael', 'Linda', 'Barbara', ' Richard', 'Susan', 'Joseph', 'Jessica', 'Thomas', 'Sarah', 'Charles', 'Karen', 'Christopher', 'Nancy', 'Daniel', 'Lisa', 'Matthew', 'Margaret', ' Andrew', 'Emily', 'Kenneth', 'Donna', 'Joshua', 'Mechille', 'Kevin', 'Carol', 'Brian', 'Amanda', 'George', 'Melissa', 'Edward', 'Deborah', 'Ronald', 'Sephanie', 'Timothy', 'Rebecca', 'Jason', 'Laura', 'Jeffrey', 'Sharon', 'Ryan', 'Cynthia'
];

$last_name = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopzed', 'Gonzales', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker', 'Young', 'Allen', 'King', 'Scott', 'Nguyen', 'Hill', 'Tran', 'Baker', 'Rivera', 'Carter', 'Gomez'];

$middle_name = ['Mae', 'Marie', 'Elizabeth', 'May', 'Louise', 'Mary', 'Margaret', 'Irene', 'Ann', 'William', 'Joseph', 'Edward', 'John', 'Henry', 'James', 'Francis', 'Charles', 'Lee', 'George'];

$genre = ['Male', 'Female'];

$data = array();

// a loop to get random of name and surname
for ($x = 0; $x < 400; $x++) {
  //get random of name
  $name = $first_name[array_rand($first_name,1)];
  // get random of surname
  $sur_name = $last_name[array_rand($last_name,1)];

  $full_name = array();

  // push name and surname in an array 
  array_push($full_name, $name, $sur_name);

  // push full_name in an array
  array_push($data, $full_name);

  
}

// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="employee.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// send the column headers
fputcsv($file, array('Name', 'Surname'));
 
// output each row of the data
foreach ($data as $row)
{
fputcsv($file, $row);
}
 
exit();

?>