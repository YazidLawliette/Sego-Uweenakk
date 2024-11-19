<?php

require_once __DIR__ . '/../Model/Model.php';
require_once __DIR__ . '/../Model/Category.php';

if (!isset($_SESSION['full_name'])) {
  header("Location: login.php");
  exit;
}

$categories = new Category();

$limit = 3; 
$pageActive = isset($_GET["page"]) ? (int)$_GET["page"] : 1; 
$key = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$length = count($categories->all($key)); 
$countPage = ceil($length / $limit);

$offset = ($pageActive - 1) * $limit;

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 : $countPage;

// Query dengan pagination dan pencarian
$categories = $categories->paginate($offset, $limit, $key);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>&mdash; Makan</title>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <link rel="icon" href="../assets/img/favicon/logo-favicon.png">


  
  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../assets/modules/prism/prism.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

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
            <h1>Home Category</h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Ini dia Kategoriyy!!</h4>
                    <div class="card-header-form">
                      <form method="GET" action="">
                        <div class="input-group">
                          <input type="text" class="form-control" id="search" name="keyword" placeholder="Search" value="<?= $key ?>">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div id="content" class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>
                            <div class="custom-checkbox custom-control">
                              <!-- <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label> -->
                            </div>
                          </th>
                          <th>Nama Categori</th>
                          <th>Action</th>
                        </tr>
                        <?php foreach ($categories as $category) : ?>
                        <tr>
                          <td>
                            <div class="custom-checkbox custom-control">
                              <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-<?= $category["id_category"] ?>">
                              <label for="checkbox-<?= $category["id_category"] ?>" class="custom-control-label">&nbsp;</label>
                            </div>
                          </td>
                          <td><?= htmlspecialchars($category["name_category"]) ?></td>
                          <td class="justify-content-end">
                            <button onclick="modalDetail(<?= $category['id_category'] ?>,'<?= $category['name_category'] ?>')" class="btn btn-primary mr-1"><i class="far fa-eye" data-toggle="tooltip" title="Detail"></i></button>
                            <a href="edit-category.php?id=<?= $category["id_category"] ?>" class="btn btn-success mr-1"> <i class="far fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                            <a href="../service/delete-category.php?id=<?= $category["id_category"]?>" class="btn btn-danger mr-1"><i class="far fa-trash-alt " data-toggle="tooltip" title="Hapus"></i></a>
                          </td>
                        </tr>
                        <?php endforeach ?>
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
    <!-- Modal -->
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
  <script src="../assets/modules/prism/prism.js"></script>

  <!-- Page Specific JS File -->
  <script src="../assets/js/page/bootstrap-modal.js"></script>
  
  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>

  <script>
    $(document).ready(function() {
      let debounceTimer;
      $("#search").on("keyup", function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          $("#content").load("../assets/search/category.php?keyword=" + $(this).val());
        }, 300);
      });
    });

    function modalDetail(id, name){
      $('#detailModal .modal').empty();
      let 
      content = '<ul>';
      content += `<li><strong>No Kategory:</strong> ${id}</li>`;
      content += `<li><strong>Name Kategory:</strong> ${name}</li>`;
      content += '</ul>';
      $('#detailModal .modal-body').html(content);
      $('#detailModal').modal('show');
    }
  </script>
</body>

</html>
