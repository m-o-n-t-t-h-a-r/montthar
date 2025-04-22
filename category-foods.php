 
<?php include('partials-front/menu.php'); ?>
<head>
<link rel="stylesheet" href="css/styles.css">
</head>

<?php 
    //تحقق مما إذا تم تمرير معرّف الفئة أم لا
    if(isset($_GET['category_id']))
    {
        //تم تعيين معرّف الفئة والحصول عليه
        $category_id = $_GET['category_id'];
        // الحصول على عنوان الفئة على أساس معرّف الفئة
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //تنفيذ الاستعلام
        $res = mysqli_query($conn, $sql);

        //الحصول على القيمة من قاعدة البيانات
        $row = mysqli_fetch_assoc($res);
        //الحصول على العنوان
        $category_title = $row['title'];
    }
    else
    {
        //لم يتم تمرير الفئة
        //إعادة التوجيه إلى الصفحة الرئيسية
        header('location:'.SITEURL);
    }
?>


<!-- قسم بحث الأطعمة بدأ هنا -->
<section class="food-search text-center">
    <div class="container">
        
        <h2><a href="#" class="text-white">الأطعمة على "<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- قسم بحث الأطعمة انتهى هنا -->



<!-- قسم قائمة الطعام بدأ هنا -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">قائمة وجباتنا</h2>

        <?php 
        
            //إنشاء استعلام SQL للحصول على الأطعمة على أساس الفئة المحددة
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

            //تنفيذ الاستعلام
            $res2 = mysqli_query($conn, $sql2);

            //عد الصفوف
            $count2 = mysqli_num_rows($res2);

            //التحقق مما إذا كان الطعام متوفرًا أم لا
            if($count2>0)
            {
                //الطعام متوفر
                while($row2=mysqli_fetch_assoc($res2))
                {
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                    
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php 
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
                //الطعام غير متوفر
                echo "<div class='error'>هذا الطعام غير متوفر.</div>";
            }
        
        ?>

        

        <div class="clearfix"></div>

    

    </div>

</section>
<!-- قسم قائمة الطعام انتهى هنا -->

<?php include('partials-front/footer.php'); ?>