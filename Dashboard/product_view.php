<?php
include('./includes/header.php');
?>


<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">


    <!-- Product view Table conatiner -->
    <div class="row ">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title">Products</h2>
            <div class="table-responsive">
              <table class="table table-bordered bg-dark">
                <thead class="bg-light">
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Product View Query -->
                  <?php
                          $query=$pdo->prepare('select * from product');
                          $query->execute();
                          $data=$query->fetchAll(PDO::FETCH_ASSOC);
                          if($data){
                            foreach($data as $pro){
                          ?>
                  <tr>
                    <td>
                      <?php echo $pro['id']?>
                    </td>
                    <td>
                      <?php echo $pro['pro_name']?>
                    </td>
                    <td>
                      <?php echo $pro['pro_price']?>
                    </td>
                    <td><img class="w-20 h-20 ml-4" src="assets/images/siteimages/productimg/<?php echo $pro['pro_image']?>" alt="">
                    </td>
                    <td>
                      <form method="GET">
                        <button class="btn btn-success ml-4"><a href="product_update.php?pid=<?php echo $pro['id']?>"
                            class="text-light"> Edit</a></button>
                      </form>
                    </td>
                    <td>
                      <form method="GET">
                        <button class="btn btn-danger ml-4"><a href="?pid=<?php echo $pro['id']?>"
                            class="text-light"> Delete</a></button>
                      </form>
                    </td>

                    <!-- Delete Category Query -->
                    <?php
                    if(isset($_GET["pid"])){
                      $id = $_GET['pid'];
                      $query= $pdo->prepare("delete from product where id =:pid");
                      $query->bindParam("pid",$id);
                      $query->execute();
                      echo "<script>
                      alert('Product Deleted Successfully');
              location.assign('product_view.php');
                      </script>";
                  }
                    ?>

                  </tr>
                  <?php 
                            }
                          }

                          else{
                            ?>
                  <tr>
                    <td colspan="4" class="text-white text-center">No Products to show</td>
                  </tr>
                  <?php
                          }
                          ?>
                </tbody>
              </table>
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