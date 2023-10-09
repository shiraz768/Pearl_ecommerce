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
            <h2 class="card-title">Categories</h2>
            <div class="table-responsive">
              <table class="table table-bordered bg-dark">
                <thead class="bg-light">
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Category View Query -->
                  <?php
                          $query=$pdo->prepare('select * from category');
                          $query->execute();
                          $data=$query->fetchAll(PDO::FETCH_ASSOC);
                          if($data){
                            foreach($data as $cat){
                          ?>
                  <tr>
                    <td>
                      <?php echo $cat['id']?>
                    </td>
                    <td>
                      <?php echo $cat['name']?>
                    </td>
                    <td><img class="w-20 h-20 ml-4" src="assets/images/siteimages/categoryimg/<?php echo $cat['image']?>" alt="">
                    </td>
                    <td>
                      <form method="GET">
                        <button class="btn btn-success ml-4"><a href="category_update.php?cid=<?php echo $cat['id']?>"
                            class="text-light"> Edit</a></button>
                      </form>
                    </td>
                    <td>
                      <form method="GET">
                        <button class="btn btn-danger ml-4"><a href="?cid=<?php echo $cat['id']?>"
                            class="text-light"> Delete</a></button>
                      </form>
                    </td>

                    <!-- Delete Category Query -->
                    <?php
                    if(isset($_GET["cid"])){
                      $id = $_GET['cid'];
                      $query= $pdo->prepare("delete from category where id =:pid");
                      $query->bindParam("pid",$id);
                      $query->execute();
                      echo "<script>
                      alert('Category Deleted Successfully');
              location.assign('category_view.php');
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
                    <td colspan="4" class="text-white text-center">No Categories to show</td>
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