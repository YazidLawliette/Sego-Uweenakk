<?php


require_once __DIR__ . '/../../DB/Conection.php';
require_once __DIR__ . '/../../Model/Model.php';
require_once __DIR__ . '/../../Model/Item.php';

$keyword = $_GET['keyword'];
$menus = new Item();
$menus = $menus-> search($keyword);



?>


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
                          <!-- <th>Status</th> -->
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
                          <td><?= $menu["name"] ?></td>
                          <td class="align-middle">
                            <img alt="image" src="../public/img/items/<?= $menu["attachment"] ?>" class="rounded-circle" width="55" data-toggle="tooltip" title="Fauzi M Noor">
                          </td>
                          <td><?= $menu["price"] ?></td>
                          <!-- <td><div class="badge badge-success"></div></td> -->
                          <td><a href="#" class="btn btn-secondary">Detail</a></td>
                        </tr>
                        <?php endforeach; ?>
                      </table>