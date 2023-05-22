<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Punto 1</title>
</head>

<body>
  <?php
	
	
	 $errTitle="";
	 $errDescription="";
	 $errAuthor="";
	 $errId="";
	 $id="";
	 $bpost=false;
	 $bput=false;
	 $bdelete=false;
	if(isset($_POST['id'])) {$id= $_POST['id'];}
    if(isset($_POST['post'])) {
      // Check if title has been entered
      if(empty($_POST['title'])) {
        $errTitle= 'Please enter the title';
      }
      // Check if description has been entered and is valid
      else if(empty($_POST['description'])) {
        $errDescription = 'Please enter the description';
      }
      // check if a author has been entered and if it is a valid password
      else if(empty($_POST['author'])) {
        $errAuthor = 'Please enter an author';
      } else {
    $title= $_POST['title'];
    $description= $_POST['description'];
    $author = $_POST['author'];
	$bpost=true;
        echo "The form has been submitted";
      }
    }
	if (isset($_POST['put'])) {
        // Check if id has been entered
        if (empty($_POST['id'])) {
          $errId = 'Please enter the id';
        }
        // Check if title has been entered
        else if (empty($_POST['title'])) {
          $errTitle = 'Please enter the title';
        }
        // Check if description has been entered
        else if (empty($_POST['description'])) {
          $errDescription = 'Please enter the description';
        }
        // Check if author has been entered
        else if (empty($_POST['author'])) {
          $errAuthor = 'Please enter an author';
        } else {
          $id = $_POST['id'];
          $title = $_POST['title'];
          $description = $_POST['description'];
          $author = $_POST['author'];
          $bput = true;
          echo "The form has been submitted";
        }
      }
	if(isset($_POST['delete'])) {
      // Check if title has been entered
	   if(empty($_POST['id'])) {
        $errId= 'Please enter the id';
      }
       else {
	$bdelete=true;
        echo "The form has been submitted";
      }
    }
	
	
  ?>

  <div class="container">

    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="form-group row">
        <div class="col-sm-10">
          <input type="submit" name="get" value="Get" class="btn btn-info" />
          <input type="submit" value="Post" name="post" class="btn btn-info" />
          <input type="submit" value="Put" name="put" class="btn btn-info" />
          <input type="submit" value="Delete" name="delete" class="btn btn-danger" />
        </div>
      </div>
      <div class="text-center form-group row">
        <div class="col-sm-6">
          <input type="text" class="form-control" id="inputid" name="id" placeholder="Id">
          <?php echo $errId; ?>
        </div>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="inputtitle" name="title" placeholder="Title">
          <?php echo $errTitle; ?>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-6">
          <input type="text" class="form-control" id="inputdescription" name="description" placeholder="Description">
          <?php echo $errDescription; ?>
        </div>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="inputauthor" name="author" placeholder="Author">
          <?php echo $errAuthor; ?>
        </div>
      </div>

    </form>
    <div class="container p-5" style="background-color: white; max-height: 80vh;">
      <textarea class="container text-center p-5" id="result" name="result" rows="4" cols="50"
        style="width:1000px;height:250px;border:2px">
  <?php 
	if(array_key_exists('get', $_POST)) { 
            get(); 
        } 
        else if(array_key_exists('post', $_POST)) {
			if($bpost){
			$url = 'http://192.168.50.4:5000/books';
			$ch = curl_init($url);
			$data = array( 'title' => $title, 'description' => $description, 'author' => $author);
			$payload =json_encode($data);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result;
			} 
        } 
        else if (array_key_exists('put', $_POST)) {
            if ($bput) {
              $url = "http://192.168.50.4:5000/books/{$id}";
              
              $data = array('title' => $title, 'description' => $description, 'author' => $author);
              $payload = json_encode($data);
          
              $ch = curl_init($url);
              if ($ch) {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $result = curl_exec($ch);
                curl_close($ch);
                echo $result;
              }
            }
          }
		else if(array_key_exists('delete', $_POST)) {
			if($bdelete){
			$url = "http://192.168.50.4:5000/books/{$id}";
			
			//$ch = curl_init($url);
			

		   if($ch = curl_init($url))
		   {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result;
		   }
			
			} 
        } 
         function get(){
			 global $id;
		 if(empty($_POST['id'])){$url = "http://192.168.50.4:5000/books";} else {$url = "http://192.168.50.4:5000/books/{$id}";}
		$response =file_get_contents($url);
		echo $response;
		
  }
		
  ?>
  </textarea>
    </div>
    <div class="container text-center" style="background-color: white; max-height: 80vh;">
      <h2 class="mt-3 fs-3" style="font-family: sans-serif;">Parcial punto 1</h2>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
</body>

</html>