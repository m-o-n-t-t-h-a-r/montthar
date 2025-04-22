<!-- تحميل ملف قائمة التنقل -->
<?php include('partials-front/menu.php'); ?>

<head>
<link rel="stylesheet" href="css/styles.css">
</haed>

    <!-- بدء قسم الفئات -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">استكشف الاطعمة</h2>

            <?php 

                //عرض جميع الفئات النشطة
                //استعلام SQL
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //تنفيذ الاستعلام
                $res = mysqli_query($conn, $sql);

                //عد الصفوف
                $count = mysqli_num_rows($res);

                //تحقق من توفر الفئات أم لا
                if($count>0)
                {
                    //الفئات متوفرة
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //الحصول على القيم
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
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
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //الفئات غير متوفرة
                    echo "<div class='error'>الفئة غير متوفرة.</div>";
                }
            
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- نهاية قسم الفئات -->

    <?php include('partials-front/footer.php'); ?>