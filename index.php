 
<?php include('partials-front/menu.php'); ?>
<head>
<link rel="stylesheet" href="css/styles.css">
</haed>
<!-- قسم البحث عن الطعام بدأ هنا -->
<section class="food-search text-center">
    <div class="container">
        
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="ابحث عن وجبة" required>
            <input type="submit" name="submit" value="بحث" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- قسم البحث عن الطعام ينتهي هنا -->

<?php 
    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

<!-- قسم الفئات يبدأ هنا -->
<section class="categories">
<div class="container">
        <h2 class="text-center">اكتشف فئات الطعام المختلفة لدينا</h2>

        <?php 
            //إنشاء استعلام SQL لعرض الفئات من قاعدة البيانات
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' ORDER BY id DESC LIMIT 3";
            //تنفيذ الاستعلام
            $res = mysqli_query($conn, $sql);
            //عد الصفوف للتحقق من إذا كانت الفئة متاحة أم لا
            $count = mysqli_num_rows($res);

            if($count>0)
            {
                //الفئات متاحة
                while($row=mysqli_fetch_assoc($res))
                {
                    //الحصول على القيم مثل المعرف والعنوان واسم الصورة
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php 
                                //التحقق مما إذا كانت الصورة متاحة أم لا
                                if($image_name=="")
                                {
                                    //عرض الرسالة
                                    echo "<div class='error'>الصورة غير متاحة</div>";
                                }
                                else
                                {
                                    //الصورة متاحة
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            

                            <h3 class="float-text text-white" ><mark style="background-color:white;"><?php echo $title; ?></mark></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                //الفئات غير متاحة
                echo "<div class='error'>الفئة غير مضافة.</div>";
            }
        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- قسم الفئات ينتهي هنا -->



<!-- قسم قائمة الطعام يبدأ هنا -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center"> وجباتنا المميزة</h2>

        <?php 
        
        //الحصول على الأطعمة من قاعدة البيانات التي هي نشطة وبارزة
        //استعلام SQL
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 10";

        //تنفيذ الاستعلام
        $res2 = mysqli_query($conn, $sql2);

        //عد الصفوف
        $count2 = mysqli_num_rows($res2);

        //التحقق مما إذا كان الطعام متاح أم لا
        if($count2>0)
        {
            //الطعام متاح
            while($row=mysqli_fetch_assoc($res2))
            {
                //الحصول على جميع القيم
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php 
                            //التحقق مما إذا كانت الصورة متاحة أم لا
                            if($image_name=="")
                            {
                                //الصورة غير متاحة
                                echo "<div class='error'>الصورة غير متاحة.</div>";
                            }
                            else
                            {
                                //الصورة متاحة
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
            //الطعام غير متاح 
            echo "<div class='error'>لا تتوفر اي وجبة الان</div>";
        }
        
        ?>


        <div class="clearfix"></div>

        

    </div>

    <p class="text-center">
    <button class="button button1"><a href="foods.php">جميع وجباتنا</a> </button>
    </p>
</section>
<!-- قسم قائمة الطعام ينتهي هنا -->


<?php include('partials-front/footer.php'); ?>