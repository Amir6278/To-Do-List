<?php 
 $insert = false;
 $updateResult =false;
 $rdelete = false;

 $connection = mysqli_connect('localhost','root','','todo');

 if(!$connection)
 {
   echo "connection failed";
 }
 if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
  $rdelete= mysqli_query($connection,$delete);
  
}
 if(isset($_POST['snoEdit'])){
  //update record
  $sno = $_POST["snoEdit"];
  $title = $_POST['edittitle'];
  $description = $_POST['editdescription'];
  $update ="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno  ";


 $updateResult = mysqli_query($connection,$update);
  
}
else if(isset($_POST['submit']))


 {
   
     if(isset($_POST['title']))
     {
        $title = $_POST['title'];
        $description= $_POST['description'];
        
  $insertion = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
  
  $result = mysqli_query($connection,$insertion);
     }

  if($result){
    $insert = true;
  }
  else{
      echo mysqli_error($connection);
  }
 }

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>

    <!--Bootstrap links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!---->
    <link rel="stylesheet" href="style.css">
</head>

<body>
  
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="index.php" method="POST">
      <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Note-Title</label>
                <input type="text" class="form-control" id="edittitle" name="edittitle" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Note-Description</label>
                <textarea class="form-control" id="editdescription" name="editdescription" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update Note</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">To-do list</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact </a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <?php 
 if($insert)
 {
     echo " <div class='alert alert-success' role='alert'>
     Your Note has inserted Successfully ! 
   </div>   ";
 }
 else if($updateResult)
    {
      echo "  <div class='alert alert-primary' role='alert'>
      Your Note has updated successfully!
    </div>";

    }
    else if($rdelete)
    {
      echo "  <div class='alert alert-danger' role='alert'>
      Your Note has Deleted successfully!
    </div>";
    }
 
 ?>

    <div class="container my-3" id ="app">
        <h3>Add a note to i-notes</h3>
        <form action="index.php" method="POST">
            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Note-Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Note-Description</label>
                <textarea class="form-control" id="desc" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Add Note</button>
        </form>
    </div>

    <div class="container table">

        <table class="table mx-5" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Serial</th>
                    <th scope="col">Note- title</th>
                    <th scope="col">Note- description</th>
                    <th scope="col"> actions</th>
                </tr>
            </thead>
            <tbody>

                <?php 
        
        $show = "SELECT * FROM `notes`" ;

        $result = mysqli_query($connection,$show);
         
         $i = 1;
        while($row = mysqli_fetch_assoc($result)){
            
          //   echo var_dump($row);
          echo " <tr>
      <th scope='row'>" . $i . "</th> 
      <td > " . $row['title']  .  "</td> 
      <td > " .$row['description'] . "</td>
        <td> <button class='edit btn btn-small btn-primary m-3' id=".$row['sno'].">Edit</button>
          <button class='delete btn btn-small btn-primary' name='delete' id=".$row['sno'].">Delete</button></td>
    </tr> ";
          $i++;           
        }         
      
      ?>

            </tbody>

        </table>
        <br>
        <hr>
    </div>
    <script src="index.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>






</html>