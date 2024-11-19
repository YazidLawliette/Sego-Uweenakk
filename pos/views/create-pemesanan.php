<?php

require_once __DIR__ . '/../Model/Model.php';
require_once __DIR__ . '/../Model/Category.php';
require_once __DIR__ . '/../Model/Sale.php';

if (!isset($_SESSION['full_name'])) {
    header("Location: login.php");
    exit;
}

$categories = new Category();
$salesModel = new Pemesanan();

// Ambil data penjualan dengan batas tertentu
$sales = $salesModel->pesan(0, 3);

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
    <title>Tambah Pesanan</title>

    <script>
        const itemSelected = [];
        function addItem(idItem, quantity = 1) {
    // Cari apakah item sudah ada dalam itemSelected
    const existingItem = itemSelected.find(item => item.id === idItem);

    if (existingItem) {
        // Jika item sudah ada, tambahkan kuantitasnya
        existingItem.q += quantity;
    } else {
        // Jika item belum ada, tambahkan ke itemSelected
        itemSelected.push({
            id: idItem,
            q: quantity
        });
    }

    // Perbarui nilai span badge di DOM
    const badge = document.querySelector(`#badge-${idItem}`);
    if (badge) {
        badge.textContent = existingItem ? existingItem.q : quantity;
    }

    alert("Item yang dipilih: " + itemSelected.map(item => `ID: ${item.id}, Q: ${item.q}`).join(", "));
}

    </script>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../assets/modules/select2/dist/css/select2.min.css">

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
                        <h1>Tambah Pesanan</h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 p-2">
                                <div class="row g-2">
                                    <?php foreach ($sales as $sale) : ?>
                                    <button 
                                        onclick="addItem(<?= htmlspecialchars($sale['id_item']) ?>)" 
                                        class="p-2 rounded overflow-hidden m-0 col-6 h-fit position-relative">
                                        <span id="badge-<?= htmlspecialchars($sale['id_item']) ?>" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary text-white">
                                              <?= htmlspecialchars($sale['quantity'] ?? '0') ?>
                                        </span>
                                        <img alt="image" src="../public/img/items/<?= htmlspecialchars($sale["attachment"]) ?>" class="img-fluid" width="500px">
                                        <h5 class="m-0"><?= htmlspecialchars($sale["name_item"]) ?></h5>
                                        <p class="m-0">Rp<?= number_format($sale["price"], 0, ',', '.') ?></p>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control selectric">
                                                <option>Paid</option>
                                                <option>Debt</option>
                                                <option>Rejected</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary">Tambahkan</button>
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
    </div>

    <!-- General JS Scripts -->
    <script src="../assets/modules/jquery.min.js"></script>
    <script src="../assets/modules/popper.js"></script>
    <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../assets/modules/moment.min.js"></script>
    <script src="../assets/js/stisla.js"></script>

    <!-- JS Libraries -->
    <script src="../assets/modules/select2/dist/js/select2.full.min.js"></script>

    <!-- Template JS File -->
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>

</html>
