<?php
include('./includes/header.php');
?>


<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">


    <!-- Category add form container-->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <h4 class="card-title">Category Add</h4>

              <!-- Category Add Query -->
              <?php
                    // add category 

if(isset($_POST['cat_add'])){ 
  $cname=$_POST['cat_name'];
  $cdes=$_POST['cat_des'];
  $filename=$_FILES["cat_img"]['name'];
  $file_tmp_name=$_FILES['cat_img']['tmp_name'];
  $filesize=$_FILES['cat_img']['size'];
  $extension = pathinfo($filename,PATHINFO_EXTENSION);
  $destination='./assets/images/siteimages/categoryimg/'.$filename;
  if($extension=="jpg" || $extension == "png" || $extension =="jpeg"){
if(move_uploaded_file($file_tmp_name,$destination)){
  $checkcategory=$pdo->prepare("select * from category where name=:pname");
  $checkcategory->bindParam("pname",$cname);
  $checkcategory->execute();
  $count = $checkcategory->fetchColumn();
  if($count>0){
      echo "<script>
        alert('Category Already Exists')
      </script>";
  }else{

 
  $query= $pdo->prepare("insert into category (name,description,image) values (:pname,:pdes,:pimg)");
  $query->bindParam("pname",$cname);
  $query->bindParam("pdes",$cdes);
  $query->bindParam("pimg",$filename);
  $query->execute();
  echo"
  <script>
    alert('category added succesfully')
  </script>
  ";
}
}
else{
  echo"
  <script>
    alert('something went wrong')
  </script>
  ";
}

  }
}
                    ?>

              <!-- Category Add Form -->
              <form class="forms-sample" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="text" name="cat_name" class="form-control" id="exampleInputName1" placeholder="Name">
                </div>

                <div class="form-group">
                  <label for="exampleTextarea1">Description</label>
                  <textarea class="form-control" name="cat_des" id="exampleTextarea1" rows="4"
                    placeholder="Enter Description Here"></textarea>
                </div>

                <div class="form-group">
                  <label>Image upload</label>
                  <div class="input-group col-xs-12">
                    <input type="file" name="cat_img" class="form-control file-upload-info" placeholder="Upload Image">
                  </div>
                </div>


                <button name="cat_add" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-dark">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- content-wrapper ends -->

  <?php
include('./includes/footer.php');
?>