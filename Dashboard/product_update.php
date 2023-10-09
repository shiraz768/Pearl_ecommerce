<?php
include('./includes/header.php');
?>


<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">


    <!-- Product add form conatiner-->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="card-body">
              <h4 class="card-title">Product update</h4>

              <!-- Fetching Previous Category details for knowing the previus value -->
              <?php
                if(isset($_GET['pid'])){
                $id=$_GET['pid'];
                $query=$pdo->prepare('select * from product where id=:pid');
                $query->bindParam('pid',$id);
                $query->execute();
                $data=$query->fetch(PDO::FETCH_ASSOC);
              }
              ?>

              <!-- Product Add Form -->
              <form class="forms-sample" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="text" name="pro_name" class="form-control" id="exampleInputName1" placeholder="<?php echo $data['pro_name']?>">
                </div>

                <div class="form-group">
                  <label for="exampleTextarea1">Description</label>
                  <textarea class="form-control" name="pro_des" id="exampleTextarea1" rows="4"
                    placeholder="<?php echo $data['pro_description']?>"></textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputName1">Price</label>
                  <input type="number" name="pro_price" class="form-control" id="exampleInputName1" placeholder="<?php echo $data['pro_price']?>">
                </div>


                <div class="form-group">
                  <label>Select Category</label>
                  <select class="form-select p-1 col-md-12" name="pro_cat" style="background-color:#2a3038;color:#6c7293;border:none">
                    <!-- Category fetch query for select dropdown (Start)-->
                    <option selected>Select Category</option>
                    <?php
                    $query=$pdo->query("select * from category");
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result as $cat_type){
                    ?>

                    <option value="<?php echo $cat_type['id']?>">
                      <?php echo $cat_type['name']?>
                    </option>
                    <?php
                    }
                ?>
                  </select>
                </div>
                <!-- Category fetch query for select dropdown (End)-->

                <div class="form-group">
                  <label>Image upload</label>
                  <div class="input-group col-xs-12">
                    <input type="file" name="pro_img" class="form-control file-upload-info" placeholder="Upload Image">
                  </div>
                </div>

                <div class="form-group">
                    <img src="assets/images/siteimages/productimg/<?php echo $data['pro_image']?>" width="100px" height="100px">
                </div>

                <button name="pro_update" class="btn btn-inverse-primary mr-2">Update</button>

              </form>



              <!-- Product update query start -->
              <?php
            if(isset($_POST['pro_update'])){

                $pid=$_GET['pid'];

                $pname=$_POST['pro_name'];
                $pdes=$_POST['pro_des'];
                $pprice=$_POST['pro_price'];
                $pcat=$_POST['pro_cat'];
                if(!empty($_FILES["pro_img"]["name"])){
                    $filename = $_FILES["pro_img"]["name"];
                    $tmpname= $_FILES["pro_img"]['tmp_name'];
                    $extension = pathinfo($filename,PATHINFO_EXTENSION);
                    $destination = "./assets/images/siteimages/productimg/" . $filename;
                    if($extension=="jpg" || $extension=="png" ||$extension=="jpeg" || $extension=="webp"){
                    if(move_uploaded_file($tmpname,$destination)){
                    $query=$pdo->prepare("update product set pro_name =:pname,pro_description=:pdes,pro_price=:pprice,pro_image=:pimg,cat_type_id =:pcat where id =:pid");
                    $query->bindParam("pid",$pid);
                    $query->bindParam("pname",$pname);
                    $query->bindParam("pdes",$pdes);
                    $query->bindParam("pprice",$pprice);
                    $query->bindParam("pcat",$pcat);
                    $query->bindParam("pimg",$filename);
                    $query->execute();

                    echo "
                    <script>
                    alert('updated product successfully with image')
                    location.assign('product_view.php');
                    
                    </script>";
                    
                }
                    }
                }
                else{

                    $pid=$_GET['pid'];

                    $query=$pdo->prepare("update product set pro_name =:pname,pro_description=:pdes, pro_price=:pprice,cat_type_id =:pcat where id =:pid");
                    $query->bindParam("pid",$pid);
                    $query->bindParam("pname",$pname);
                    $query->bindParam("pdes",$pdes);
                    $query->bindParam("pprice",$pprice);
                    $query->bindParam("pcat",$pcat);
                    $query->execute();
                    echo "<script>
                    alert('updated product successfully without image')
                    location.assign('product_view.php');
                    </script>"; 
                }

            }
              ?>
              <!-- Product update query end -->

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