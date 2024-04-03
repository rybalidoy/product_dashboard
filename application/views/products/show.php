<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/product.css')?>">
</head>
<body>
    <div class="top-nav">
        <h2> V88 Merchandise </h2>
        <a href="/dashboard"> Dashboard</a>
        <a href="/profile"> Profile </a>
        <a href="/logout" class="left-a"> Log off </a>
    </div>

    <!-- Product info populated later using database variables -->
    <section>
    <?php if(isset($product_details)) { ?>
        <h1><?= $product_details['name'] . ' (' . $product_details['price'] . ')' ?></h1>
        <p> Added since: <?= date_format(date_create($product_details['created_at']),"F jS Y")?></p>
        <p> Product ID: # <?= $product_details['id'] ?></p>
        <p> Description: <?= $product_details['description'] ?> </p>
        <p> Total sold: <?= $product_details['quantity_sold'] ?> </p>
        <p> Number of available stocks: <?= $product_details['inventory_count'] ?> </p>

        <form action="/reviews/add_review" method="post">
            <h2> Leave a Review </h2>
            <input type="hidden" name="product_id" value = "<?=$product_details['id']?>">
            <textarea name="review_input" id="review_box" cols="30" rows="10"></textarea>
            <input type="submit" name="post" value="Post review">
        </form>
    <?php } ?>
    </section>
    <div id="reviews_container">
    <!-- Contains the reviews of this code and replies in each review -->
    <?php foreach($inbox as $review) { ?>
            <div class="reviews">
                <p class="review_name"><span><?=$review["user_name"] . ' '?></span>wrote:</p>
                <p class="review_age"><?= $review['review_age'] ?></p>
                <p><?=$review["message"]?></p>
            </div>
                
    <?php   if(isset($review['replies'])) { 
        foreach($review['replies'] as $reply) { ?>             
            <div class="replies">
                <p class="review_name"> <span><?=$reply['user_name']?></span> wrote:</h4>
                <p class="reply_age"><?= $reply['reply_age'] ?></p>
                <p><?=$reply['reply']?></p>
            </div>
    <?php   }?>   
    <?php } ?>       
            <form action="/reviews/add_reply" method="post" class="reply_form">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="product_id" value = "<?=$product_details['id']?>">
                <input type="hidden" name="review_id" value="<?=$review['review_id']?>"/>
                <textarea name="reply_message" id="reply_box" placeholder="Write a message"></textarea>               
                <input type="submit" value="Post reply" id="reply-btn"/>
            </form> 
    <?php   } ?>
    </div>
</body>
</html>