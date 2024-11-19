<?php

require_once __DIR__ . '/../Model/Model.php';
require_once __DIR__ . '/../Model/Category.php';
require_once __DIR__ . '/../Model/Item.php';

if (!isset($_SESSION['full_name'])) {
  header("Location: login.php");
  exit;
}

$categories = new Category();
$menus = new Item();


$limit = 3; 
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; 
$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$length = count($menus->all($key)); 
$countPage = ceil($length / $limit);

$offset = ($pageActive - 1) * $limit;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

// Query dengan pagination dan pencarian
$menus = $menus->all2($offset, $limit, $key);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>&mdash; Menu</title>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="icon" href="../assets/img/favicon/logo-favicon.png">



  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include('../components/layout/navbar.php'); ?>

      <?php include('../components/layout/sidebar.php'); ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Home Menu</h1>
          </div>

          <div class="section-body">
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Ini dia Menu!!</h4>
                    <div class="card-header-form">
                      <form method="GET" action="">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Search" name="keyword" id="search_menu" value="<?= $key ?>">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div id="content_menu" class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>
                            <div class="custom-checkbox custom-control">
                              <!-- <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label> -->
                            </div>
                          </th>
                          <th>Name</th>
                          <th>Attachment</th>
                          <th>Price</th>
                          <th>Category</th>
                          <th>Created at</th>
                          <th>Action</th>
                        </tr>
                        <?php foreach ($menus as $menu) : ?>
                        <tr>
                          <td class="p-0 text-center">
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">
                              <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td><?= $menu["name_item"] ?></td>
                          <td class="align-middle">
                            <img alt="image" src="../public/img/items/<?= $menu["attachment"] ?>" class="rounded-md" width="55" height="55" data-toggle="tooltip" title="Orang">
                          </td>
                          <td><?= $menu["price"] ?></td>
                          <td><?= $menu["name_category"] ?></td>
                          <td><?= $menu["created_at_item"] ?></td>
                          <td>
                          <button onclick="modalDetail(<?= $menu['id_item'] ?>,'<?= $menu['name_item'] ?>', '<?= $menu['attachment'] ?>', '<?= $menu['price'] ?>', '<?= $menu['name_category'] ?>', '<?= $menu['created_at_item'] ?>')" class="btn btn-primary mr-1"><i class="far fa-eye" data-toggle="tooltip" title="Detail"></i></button>
                          <a href="./edit-menu.php?id=<?= $menu["id_item"] ?>" class="btn btn-primary" data-toggle="tool-tip" title="Edit">Edit</a>
                          <a href=".. /service/delete-menu.php?id=<?= $menu["id_item"] ?>" class="btn btn-danger" data-toggle="tool-tip" title="Hapus">Hapus</a>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </table>
                      <div class="card-body d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li class="page-item <?= $pageActive == 1 ? 'disabled' : '' ?>">
                              <a class="page-link" href="?page=<?= $prev ?>&keyword=<?= $key ?>"><i class="ph ph-arrow-circle-left text-3xl px-2"></i></a>
                            </li>
                            <?php for ($i = 1; $i <= $countPage; $i++) : ?>
                              <li class="page-item <?= $pageActive == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&keyword=<?= $key ?>"><?= $i ?></a>
                              </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $pageActive == $countPage ? 'disabled' : '' ?>">
                              <a class="page-link" href="?page=<?= $next ?>&keyword=<?= $key ?>"><i class="ph ph-arrow-circle-right text-3xl px-2"></i></a>
                            </li>
                          </ul>
                        </nav>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php include('../components/layout/footer.php'); ?>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="detailModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Detail Kategory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- <p>Modal body text goes here.</p> -->
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
              </div>
            </div>
          </div>
        </div>
  </div>

  <!-- General JS Scripts -->
  <script src="../assets/modules/jquery.min.js"></script>
  <script src="../assets/modules/popper.js"></script>
  <script src="../assets/modules/tooltip.js"></script>
  <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../assets/modules/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="../assets/modules/jquery.sparkline.min.js"></script>
  <script src="../assets/modules/chart.min.js"></script>
  <script src="../assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="../assets/modules/summernote/summernote-bs4.js"></script>
  <script src="../assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="../assets/js/page/index.js"></script>
  
  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
  <script>
    $(document).ready(function() {
      let debounceTimer;
      $("#search_menu").on("keyup", function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          $("#content_menu").load("../assets/search/menu.php?keyword=" + $(this).val());
        }, 300);
      });
    });

    function modalDetail(id, name, attachment, price, category, created_at) {
    let content = '<ul>';
    content += `<li><strong>No Menu:</strong> ${id}</li>`;
    content += `<li><strong>Name Menu:</strong> ${name}</li>`;
    content += `<li><strong>Attachment:</strong> <img src="../public/img/items/${attachment}" alt="${name}" width="50" height="50" ></li>`;
    content += `<li><strong>Price:</strong> ${price}</li>`;
    content += `<li><strong>Kategory:</strong> ${category}</li>`;
    content += `<li><strong>Created At:</strong> ${created_at}</li>`;
    content += '</ul>';

    $('#detailModal .modal-body').html(content);
    $('#detailModal').modal('show');
}

  </script>
</body>
</html>