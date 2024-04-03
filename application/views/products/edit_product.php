<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Product - Admin </title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/product_form.css')?>">
</head>
<body>
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/dashboard"> Dashboard</a>
        <a href="/profile"> Profile </a>
        <a href="/logout" class="left-a"> Log off </a>
    </div>
    <div class="contents">
        
        <form action="/products/process_update_product" method="post">
            <h1>Edit Product #<?= $product_details['id']?></h1>
            <input type="hidden" name="id" value="<?= $product_details['id']?>">
            <a href="/" class="link-btn"> Return to Dashboard </a>
            <label for="name"> Name: </label>
            <input type="text" name="name" value="<?= $product_details['name']?>">
            <label for="description"> Description: </label>
            <textarea name="description" id="" cols="30" rows="10"><?= $product_details['description']?>
            </textarea>
            <label for="price"> Price: </label>
            <input type="number" name="price" value="<?= $product_details['price']?>">
            <label for="inventory_count"> Inventory Count: </label>
            <input type="number" name="inventory_count"value="<?= $product_details['inventory_count']?>">
            <input type="submit" name="edit" value="Save" class="form-btn">
        </form>
    </div>
</body>
</html>