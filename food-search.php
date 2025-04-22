هذا هو تعليق الكود العربي:

<?php include('partials-front/menu.php'); ?>
<head>
<link rel="stylesheet" href="css/styles.css">
</haed>
<!-- فقرة البحث عن الوجبات -->
<section class="food-search text-center">
    <div class="container">
        <?php 
            // الحصول على كلمة البحث
            $search = $_POST['search'];
        ?>
        <h2><a href="#" class="text-white">قد بحثت على  "<?php echo $search; ?>"</a></h2>
    </div>
</section>
<!-- نهاية فقرة البحث عن الوجبات -->

<!-- قائمة الوجبات -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">وجبـاتنـا</h2>

        <?php 
            // استعلام SQL للحصول على الوجبات المطابقة لكلمة البحث
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR price LIKE '%$search%'";

            // تنفيذ الاستعلام
            $res = mysqli_query($conn, $sql);

            // عد عدد الصفوف
            $count = mysqli_num_rows($res);

            // التحقق من توفر الوجبات
            if($count>0)
            {
                // الوجبات متوفرة
                while($row=mysqli_fetch_assoc($res))
                {
                    // الحصول على تفاصيل الوجبة
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
                                // التحقق من توفر الصورة
                                if($image_name=="")
                                {
                                    // الصورة غير متوفرة
                                    echo "<div class='error'>الصورة غير متاحة.</div>";
                                }
                                else
                                {
                                    // الصورة متوفرة
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
                // الوجبات غير متوفرة
                echo "<div class='error'><center><b>للاسف هذه الوجبة غير متوفر ابحث عن وجبة اخرى. </center> </b></div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- نهاية قائمة الوجبات -->

<?php include('partials-front/footer.php'); ?>



 