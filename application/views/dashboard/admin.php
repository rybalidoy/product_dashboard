<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dashboard.css')?>">
</head>
<body>
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/dashboard"> Dashboard</a>
        <a href="/profile"> Profile </a>
        <a href="/logout" class="left-a"> Log off </a>
    </div>
    <div class="contents">
        <h1>Manage Products</h1>
        <?php if($this->session->flashdata('is_admin')) { ?>
            <a href="/products/new" class="link-btn">Add new</a>
        <?php } ?>
        <!-- Add new should be hidden if not admin -- add conditions to show and process -->
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Inventory Count</th>
                <th>Quantity Sold</th>
                <th>Action</th>
            </tr>
        <!-- foreach the contents here -->
        <?php if(isset($products_list)) {
                foreach($products_list as $key => $product) {?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><a href="/products/show/<?= $product['id']?>"><?= $product['name'] ?></a></td>
                <td><?= $product['inventory_count'] ?></td>
                <td><?= $product['quantity_sold'] ?></td>
                <td class="actions">
                    <a href="/products/edit/<?=$product['id']?>">Edit</a>
                    <a href="/products/remove/<?=$product['id']?>">Remove</a>
                </td>
            </tr>
            <?php } 
        } ?>
        </table>
    </div>
</body>
</html>