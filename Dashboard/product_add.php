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
              <h4 class="card-title">Product Add</h4>

              <!-- Product add query -->
              <?php
              if(isset($_POST['pro_add'])){
                $pname=$_POST['pro_name'];
                $pdes=$_POST['pro_des'];
                $pprice=$_POST['pro_price'];
                $pcat=$_POST['pro_cat'];

                $filename=$_FILES["pro_img"]['name'];
                $file_tmp_name=$_FILES['pro_img']['tmp_name'];
                $filesize=$_FILES['pro_img']['size'];
                $extension = pathinfo($filename,PATHINFO_EXTENSION);
                $destination='./assets/images/siteimages/productimg/'.$filename;
                if($extension=="jpg" || $extension == "png" || $extension =="jpeg"){
                if(move_uploaded_file($file_tmp_name,$destination)){
                  $query= $pdo->prepare("insert into product (pro_name,pro_description,pro_price,pro_image,cat_type_id) values (:pname,:pdes,:pprice,:pimg,:pcat)");
                  $query->bindParam("pname", $pname);
                  $query->bindParam("pdes", $pdes);
                  $query->bindParam("pprice", $pprice);
                  $query->bindParam("pimg", $filename);
                  $query->bindParam("pcat", $pcat);
                  $query->execute();
                  echo"
                  <script>
                    alert('Product added succesfully')
                  </script>
                  ";}
              }
            }
              ?>

              <!-- Product Add Form -->
              <form class="forms-sample" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="exampleInputName1">Name</label>
                  <input type="text" name="pro_name" class="form-control" id="exampleInputName1" placeholder="Name">
                </div>

                <div class="form-group">
                  <label for="exampleTextarea1">Description</label>
                  <textarea class="form-control" name="pro_des" id="exampleTextarea1" rows="4"
                    placeholder="Enter Description Here"></textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputName1">Price</label>
                  <input type="number" name="pro_price" class="form-control" id="exampleInputName1" placeholder="Price">
                </div>


                <div class="form-group">
                  <label>Select Category</label>
                  <select class="form-select p-1 col-md-12" name="pro_cat" style="background-color:#2a3038;color:#6c7293;border:none">
                    <option selected>Select Category</option>
                    <!-- Category fetch query for select dropdown (Start)-->
                    <?php
                    $query=$pdo->query("select * from category");
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach($data as $cat_type){
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





                <button name="pro_add" class="btn btn-inverse-primary mr-2">Submit</button>

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