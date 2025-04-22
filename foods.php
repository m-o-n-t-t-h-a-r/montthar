<?php include('partials-front/menu.php'); ?>
<head>
    <link rel="stylesheet" href="css/styles.css">
</head>

<!-- قسم البحث عن الوجبة -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="ابحث عن وجبة.." required>
            <input type="submit" name="submit" value="بحث" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- نهاية قسم البحث عن الوجبة -->

<!-- قسم قائمة الوجبات -->
<section class="food-menu">
    <div class="container" style="width:65%;">
        <h2 class="text-center">قائمة وجباتنا</h2>

        <?php 
            // عرض الوجبات النشطة
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
            $res=mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            // التحقق من توفر الوجبات
            if($count>0)
            {
                // الوجبات متاحة
                while($row=mysqli_fetch_assoc($res))
                {
                    // استخراج قيم الوجبة
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                // التحقق من توفر الصورة
                                if($image_name=="")
                                {
                                    // الصورة غير متاحة
                                    echo "<div class='error'>الصورة غير متاحة.</div>";
                                }
                                else
                                {
                                    // الصورة متاحة
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">اطلب الان</a>
                        </div>
                    </div>

                    <?php
                }
            }
            else
            {
                // الوجبة غير متاحة
                echo "<div class='error'>الوجبة هذه غير موجودة.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- نهاية قسم قائمة الوجبات -->

<?php include('partials-front/footer.php'); ?>