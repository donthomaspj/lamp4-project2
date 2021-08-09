<!--Main site of the application
Author: Kaur Arjinder-->
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
  body {
    background-color: whitesmoke;
    color: navy;
    font-weight: bold;
  }
  </style>
</head>

<body>
  <?php
    require_once("db_connection.php");
    session_start();
	if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
		$err_msgs = validateFormData();
		if (count($err_msgs) >0){
			displayErrors($err_msgs);
			displayForm();
		} else {
			$status = processUploads();
			displayStatus($status);
		}
	} else {
		displayForm();
	}

function displayForm(){
?>
  <form action="" method="post" name="importCSV" enctype="multipart/form-data">
    <div>
      <label>Please Choose a csv file to upload!</label><br>
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />

      <input type="file" name="file" accept=".csv" /><br><br>
      <button type="submit" name="import" class="btn btn-primary">Import</button>
      <br>
    </div>
  </form>
  <?php
}
function validateFormData():array{
    $err_msgs = array();
    $allowed_exts = array( "csv");

	$allowed_types = array( "text/csv");
    if (isset($_FILES['file']) && !empty($_FILES['file']['name'])){
		$up =$_FILES['file'];
		if ($up['error'] == 0){
			if ($up['size'] == 0){
				$err_msgs[] = "An empty file was uploaded";
			}
            $ext = strtolower(pathinfo($up['name'], PATHINFO_EXTENSION));
			
            if (!in_array($ext,$allowed_exts)){
				$err_msgs[] = "File extension does not indicate that the uploaded file is of an  allowed file type";
			}
			
            if (!file_exists($up['tmp_name'])){
				$err_msgs[] = "No files exists on the server for this upload";
			}
			// Do virus scan of file in temporary storage here, if scanner available
		} else {
			$err_msgs[] = "An error occured during file upload";
		}
	} else {
		$err_msgs[] = "No file was uploaded";
	}
	
	// If there are other form data items to validate do so here

	return $err_msgs;
			


}
//check the import 
function processUploads(){
    $status = "OK";
	$db_conn = connectDB();
	if (!$db_conn){
	$status = "DBConnectionFail";
	} else {
	
if(isset($_POST['import'])){
    //declare the filename
    $fileName = $_FILES["file"]["tmp_name"];
    //check the size of file
    if($_FILES["file"]["size"]>0)
    {
        //open the file for read
        $file = fopen($fileName,"r");
         $selectquery=$db_conn->prepare("select ID from employees where Name=?&&Surname=?");

        //get the data of csv file and stored in column
        fgets($file);
        while(($column=fgetcsv($file,10000,','))!==false)
        { 
           
           $csv[] = $column;
            //$data = array($name,$surname);
           $qryResult= $selectquery->execute($column);//execute select statement
           if($selectquery->rowCount() > 0){
               $updateqry =$db_conn->prepare("update employees set Name=?,Surname=? where Name=?&&Surname=?");
               $data=array($column[0],$column[1],$column[0],$column[1]);
              $qryResu= $updateqry->execute($data);
           }
              else{
                //sql statement
                $stmt = $db_conn->prepare( "insert into employees(Name,Surname)values(?,?)");

                $result=$stmt->execute($column);
               
                if(!$result){
                    $status = "ExecuteFail";
                }
               
            }
        }
        echo "<p style='color:green;'>".'CSV Data imported successfully'.'</p>';

         }
         fclose($file);      
         $_SESSION['csv'] = $csv;
        //  var_dump($csv);           
         }
            
}
	return $status;
}
function displayStatus($status){
	if ($status == "FailMove"){
?>
  <p>File upload failed - failed to move file to permanent storage </p>
  <?php } else if ($status == "NoDirectory"){ ?>
  <p>File upload failed - The permanent storage directory does not exist or is not accessible </p>
  <?php } else if ($status == "PrepareFail"){ ?>
  <p>File upload failed - Error getting ready to insert data into the database </p>
  <?php } else if ($status == "ExecuteFail"){ ?>
  <p style="color:red;">File upload failed - Error insertng data into the database NOT IMPORTED. </p>
  <?php } else if ($status == "DBConnectionFail"){ ?>
  <p>File upload failed - Error connecting to the database </p>
  <?php } else { ?>
  <p>File uploaded successfully</p>
  <?php } ?>
  <a href="./output.php">Go to See the Output</a>
  <?php
}

function displayErrors(array $error_msg){
    echo "<p>\n";
    foreach($error_msg as $v){
        echo $v."<br>\n";
    }
    echo "</p>\n";
}
?>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
</body>

</html>