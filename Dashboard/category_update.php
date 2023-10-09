<?php
include('./includes/header.php');
?>


<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">


    <!-- Category add form -->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <h4 class="card-title">Category Update</h4>

              <!-- Fetching Previous Category details for knowing the previus value -->
              <?php
              if(isset($_GET['cid'])){
                $id=$_GET['cid'];
                $query=$pdo->prepare('select * from category where id=:cid');
                $query->bindParam('cid',$id);
                $query->execute();

                $data=$query->fetch(PDO::FETCH_ASSOC);
                ?>
                 <!-- Category Update Form -->
              <form class="forms-sample" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="text" name="cat_name" class="form-control" id="exampleInputName1" placeholder="<?php echo $data['name']?>">
                </div>

                <div class="form-group">
                  <label>Image upload</label>
                  <div class="input-group col-xs-12">
                    <input type="file" name="cat_img" class="form-control file-upload-info" placeholder="Upload Image">
                  </div>
                </div>
                <div class="form-group">
                    <img src="assets/images/siteimages/categoryimg/<?php echo $data['image'];?>" width="100px" height="50px" alt="">
                </div>


                <button name="cat_update" class="btn btn-primary mr-2">Update</button>
              </form>




                <?php
              }

            //   Category Update Query

              if(isset($_POST["cat_update"])){
                
                $cid = $_GET['cid'];
                $cname= $_POST["cat_name"];
                if(!empty($_FILES["cat_img"]["name"])){
                    $filename = $_FILES["cat_img"]["name"];
                    $tmpname= $_FILES["cat_img"]['tmp_name'];
                    $extension = pathinfo($filename,PATHINFO_EXTENSION);
                    $destination = "./assets/images/siteimages/categoryimg/" . $filename;
                    if($extension=="jpg" || $extension=="png" ||$extension=="jpeg" || $extension=="webp" ){
if(move_uploaded_file($tmpname,$destination)){
$query=$pdo->prepare("update category  set name =:cname, image=:cimg where id =:pid");
$query->bindParam("pid",$cid);
$query->bindParam("cname",$cname);
$query->bindParam("cimg",$filename);
$query->execute();
echo "
<script>
alert('update category successfully with image')
location.assign('category_view.php');

</script>";

}
                    }
                }else{

                    $cid = $_GET['cid'];

                    $query=$pdo->prepare("update category  set name =:cname where id =:pid");
                    $query->bindParam("pid",$cid);
                    $query->bindParam("cname",$cname);
                    $query->execute();
                    echo "<script>
                    alert('update category successfully without image')
                    location.assign('category_view.php');
                    </script>"; 
                }

            }
              ?>

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