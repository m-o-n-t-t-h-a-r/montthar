 
<?php include('partials-front/menu.php'); ?>
<head>
<link rel="stylesheet" href="css/styles.css"> 
</haed>

    <?php 
        // تحقق مما إذا كان معرف الطعام محدد أم لا
        if(isset($_GET['food_id']))
        {
            // احصل على معرف الطعام وتفاصيل الطعام المحدد
            $food_id = $_GET['food_id'];

            // احصل على تفاصيل الطعام المحدد
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            // تنفيذ الاستعلام
            $res = mysqli_query($conn, $sql);
            // عد عدد الصفوف
            $count = mysqli_num_rows($res);
            // تحقق مما إذا كانت البيانات متاحة أم لا
            if($count==1)
            {
                // لدينا بيانات
                // احصل على البيانات من قاعدة البيانات
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                // الطعام غير متاح
                // إعادة التوجيه إلى الصفحة الرئيسية
                header('location:'.SITEURL);
            }
        }
        else
        {
            // إعادة التوجيه إلى الصفحة الرئيسية
            header('location:'.SITEURL);
        }
    ?>

    <!-- قسم البحث عن الطعام يبدأ هنا -->
    <section class="food-search2" style="background-image: url(images/bg.jpg">
        <div class="container">
            
            <h2 class="text-center text-white">املأ هذا النموذج لتاكيد طلبك.</h2>

            <form action="" method="POST" class="order">
                <fieldset>

                    <div class="food-menu-img">
                        <?php 
                        
                            // تحقق مما إذا كانت الصورة متاحة أم لا
                            if($image_name=="")
                            {
                                // الصورة غير متاحة
                                echo "<div class='error'>االصورة غير متاحة.</div>";
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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">اختار الكمية</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>تفاصيل التسليم</legend>
                    <div class="order-label">الاسم الكامل</div>
                    <input type="text" name="full-name" placeholder="اكتب اسم الكامل" class="input-responsive" required>

                    <div class="order-label">رقم الهاتف</div>
                    <input type="tel" name="contact" placeholder="اكتب رقم هاتف" class="input-responsive" required>

                    <div class="order-label">البريد الالكتروني</div>
                    <input type="email" name="email" placeholder="اكتب بريدك الالكتروني " class="input-responsive" required>

                    <div class="order-label">العنوان</div>
                    <textarea name="address" rows="10" placeholder="المدينة/ المنطقة/ رقم الشارع او اسم البناء " class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="تاكيد الطلب" class="btn btn-primary" style="margin-left: 243px;">
                </fieldset>

            </form>

            <?php 

                // تحقق مما إذا تم النقر على الزر المحدد أم لا
                if(isset($_POST['submit']))
                {
                    // احصل على جميع التفاصيل من النموذج

                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // المجموع = السعر × الكمية 

                    $order_date = date("Y-m-d h:i:sa"); // تاريخ الطلب

                    $status = "Ordered";  // تم الطلب، قيد التسليم، تم التسليم، تم الإلغاء

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];


                    // حفظ الطلب في قاعدة البيانات
                    // إنشاء SQL لحفظ البيانات
                    $sql2 = "INSERT INTO tbl_order SET 
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // تنفيذ الاستعلام
                    $res2 = mysqli_query($conn, $sql2);

                    // تحقق مما إذا كان الاستعلام قد تم تنفيذه بنجاح أم لا
                    if($res2==true)
                    {
                        // تم تنفيذ الاستعلام وحفظ الطلب
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully تم الطلب بنجاح والدفع عند التسليم.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // فشل في حفظ الطلب
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food فشل.</div>";
                        header('location:'.SITEURL);
                    }

                }
            
            ?>

        </div>
    </section>
    <!-- قسم البحث عن الطعام ينتهي هنا -->

    <?php include('partials-front/footer.php'); ?>