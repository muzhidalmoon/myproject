
<?php 

  session_start();

  require('dbconnect.php');

                    // insert data into database

            $insert = false;
            $update = false;
            $delete = false;   


          if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
              

            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                  $title = $_POST['title'];

                  $description = $_POST['description'];
        
        
                  if(!empty($title) && !empty($description)){
                    
                    $sql = "INSERT INTO notes (title,description) VALUES('$title','$description')";
                    mysqli_query($conn,$sql);
        
                    $insert = true;
                    
                  }
            }else{
              header('location: login.php');
            }


          
        }



        if(isset($_POST['snoEdit'])){
          if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            $title = $_POST['titleEdit'];
            $s_no = $_POST['snoEdit'];
            $description = $_POST['descriptionEdit'];
  
            if(!empty($title) && !empty($description)){
              
              $update_sql = "UPDATE notes SET title = '$title' , description = '$description' WHERE s_no = $s_no ";
  
              mysqli_query($conn,$update_sql);
  
              $update = true;
              
            }
      }else{
        header('location: login.php');
      }

          
        }

                        // delete data

                        if(isset($_GET['delete'])){

                          if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                            $s_no = $_GET['delete'];
        
                            
                            $delete_sql = "DELETE FROM notes  WHERE s_no = $s_no ";
            
                            mysqli_query($conn,$delete_sql);
                
                            $delete = true;
                      }else{
                        header('location: login.php');
                      }
                  
       
                          
                        }


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Procject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  </head>
  <body>

<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="crud.php" method="post">
      <div class="modal-body">
        <input type="hidden" id="snoEdit" name="snoEdit">
        <div class="mb-3">
          <label for="titleEdit" class="form-label">Note Title</label>
          <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="descriptionEdit" class="form-label">Note Description</label>
          <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="sumbit" class="btn btn-primary" id="update" name="update">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="crud.php">iNote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="crud.php">Home</a>
            </li>
          <?php
                  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                        echo '<li class="nav-item dropdown">
                        <a class="nav-link" href="logout.php" role="button" aria-expanded="false">
                          Logout
                        </a>
                      </li>';
                  }else{
                    echo '<li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link" href="signup.php" role="button" aria-expanded="false">
                      Signup
                    </a>
                  </li>';
                  }
              ?>
          </ul>
          <div class="d-flex">
            
            <?php if(isset($_SESSION['name'])){
                echo '<span class=" text-light">'.$_SESSION['name'].'</span>';
            } ?>
          </div>
        </div>
      </div>
    </nav>

    <?php
        if($insert){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your note has been inserted successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>
    <?php
        if($update){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your note has been updated successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>
    <?php
        if($delete){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your note has been deleted successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>

    <div class="container my-4">
        <h2>Add a Note</h2>
      <form action="crud.php" method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Note Title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Note Description</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <input type="submit" class="btn btn-primary" id="submit" value="Add Note" name="submit">
      </form>
    </div>
    <div class="container">
    <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
        <?php

                // fetching data from database

                $sql = 'SELECT * FROM notes';

                $result = mysqli_query($conn,$sql);
              
                $s_no = 0;
                while($data = mysqli_fetch_assoc($result)){
                  $s_no++;
                    echo "<tr>".
                    "<th>".$s_no."</th>".
                    "<td>".$data['title']."</td>"
                    ."<td>".$data['description']."</td>"
                    ."<td><button class='btn btn-primary edit'  id= '".$data['s_no']."'>Edit</button> <button class='btn btn-primary delete' id= '".$data['s_no']."'>Delete</button></td>"
                  ."</tr>";
                }
        ?>
  </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="app.js"></script>
  </body>
</html>