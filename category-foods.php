    <!-- DisplayingFoodsForAParticularCategory -->

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <!-- Important to make website responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restaurant Website</title>
        <!-- Link our CSS file -->
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/foods.css">

    </head>

    <body>

        <!-- navbarPortion -->
    <?php include './front-end-partials/menu.php'; ?>

        <!-- checkIfIdPassed? -->
        <?php if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
            // getTheCategoryTitleBasedOnCategoryID
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            // executeQuery
            $res = mysqli_query($conn, $sql);
            // getTheValues
            $row = mysqli_fetch_assoc($res);
            // getTheTitle
            $category_title = $row['title'];
        } else {
            header('location:' . HOMEURL);
        } ?>

        <!-- fOOD sEARCH Section Starts Here -->
        <section class="food-search text-center">
            <div class="container">

                <h3><b>Here's what we have under <a href="#" class="text-white"><?php echo $category_title; ?></a> category !</b></h3>

            </div>
        </section>
        <!-- fOOD sEARCH Section Ends Here -->

        <!-- FoodMenuSectionStarts -->
        <section class="food-menu">
            <div class="container">
                <h2 class="text-center">Category Menu</h2>
                
                <div class="row">
                    <?php
                    // queryToGetFoodBasedOnSearch
                    // searchingFromTitleOrDescription
                    $sql_food = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                    // executeTheQuery
                    $res_food = mysqli_query($conn, $sql_food);
                    $count_food = mysqli_num_rows($res_food);

                    // checkIfFoodAvailable
                    if ($count_food > 0) {
                        // foodAvailable
                        while ($rows = mysqli_fetch_assoc($res_food)) {

                            // gettingTheValuesFromDatabase
                            $title = $rows['title'];
                            $id = $rows['id'];
                            $price = $rows['price'];
                            $description = $rows['description'];
                            $image_name = $rows['image_name'];
                            ?>      
        <div class="col-md-4 col-sm-6">
                
                
                        <div class="card">
                
                        <!-- checkWhetherImageAvailableOrNot? -->
                        <?php if ($image_name == '') {
                            // imageNotAvailable
                            $_SESSION['no-food-image-available'] =
                                'Image Unvailable !';
                            header('location:' . HOMEURL);
                        }
                        // imageAvailable
                        else {
                             ?>
                    <img class="card-img-top" src="<?php echo HOMEURL; ?>images/food/<?php echo $image_name; ?>" >
                                            <?php
                        } ?>
                
                
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $title; ?></h5>
                            <p class="card-text description"><?php
                            $maxLength = 100;

                            if (strlen($description) > $maxLength) {
                                $shortText = substr(
                                    $description,
                                    0,
                                    $maxLength
                                );
                                echo $shortText . '...';
                            } else {
                                echo $description;
                            }
                            ?></p>
                            <p class="card-text">Price: $<?php echo $price; ?></p>
                            <a href="<?php echo HOMEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn adminPanelBtn">Order Now</a>
                        </div>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        // foodUnavailable
                        echo "
                        <div class = 'error-message text-center'>
                        Searched category isn't having any listed food items at the moment !
                        </div>
                        ";
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </section>
        <!-- FoodMenuSectionEnds -->

        <!-- footer -->
        <?php include './front-end-partials/footer.php'; ?>

    </body>
    </html>
