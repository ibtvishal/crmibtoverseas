<!-- 03b5d2 -->
<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
$_SESSION['reload']="1";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<Style>
table tbody tr td {
    border: 1px solid #dedede !important;
}

.nav-link {
    background: #f3f3f3;
}



.panel {
    padding: 0 18px;
    display: none;
    background-color: white;
    overflow: hidden;
    margin-left: 10px;
    width: 100%;
}

.nav>li>a {
    padding: 15px 15px;
    box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;
    border-radius: 5px;
}

.nav .nav-item .nav-link:hover {
    background-color: #4543de !important;
    color: white !important;
    box-shadow: rgb(255 255 255 / 14%) 4px 6px 4px 0px inset, rgba(0, 0, 0, 0.15) 0px 5px 15px 0px, rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
    ;
}

.nav-item.dropdown .collapse li:hover {
    background-color: #4543de !important;
    box-shadow: rgb(251 251 251 / 38%) 0px 2px 5px 0px inset, rgb(251 251 251 / 48%) 0px 1px 1px 0px inset;
}

.nav-item.dropdown .collapse li:hover a {
    color: white !important;
}

.active1 {
    background-color: #4543de !important;
    box-shadow: rgb(251 251 251 / 38%) 0px 2px 5px 0px inset, rgb(251 251 251 / 48%) 0px 1px 1px 0px inset !important;
    color: white !important;

}

.active1 a {
    color: white !important;

}

.sublist {
    padding: 15px 30px !important;
    box-shadow: rgba(50, 50, 105, 0.15) 0px 2px 5px 0px, rgba(0, 0, 0, 0.05) 0px 1px 1px 0px;
}

.accordion .accordion-item {
    border-bottom: 1px solid #e5e5e5;
    padding-top: 5px;
}

.accordion .accordion-item button[aria-expanded='true'] {
    border-bottom: 1px solid #4543de;
}

.accordion button {
    position: relative;
    display: block;
    text-align: left;
    width: 100%;
    padding: 1em 0;
    color: #7288a2;
    font-size: 1.15rem;
    font-weight: 400;
    border: none;
    background: none;
    outline: none;
}

.accordion button:hover,
.accordion button:focus {
    cursor: pointer;
    color: #4543de;
}

.accordion button:hover::after,
.accordion button:focus::after {
    cursor: pointer;
    color: #4543de;
    border: 1px solid #4543de;
}

.accordion button .accordion-title {
    padding: 1em 1.5em 1em 0;
}

.accordion button .icon {
    display: inline-block;
    position: absolute;
    top: 18px;
    right: 0;
    width: 22px;
    height: 22px;
    border: 1px solid;
    border-radius: 22px;
}

.accordion button .icon::before {
    display: block;
    position: absolute;
    content: '';
    top: 9px;
    left: 5px;
    width: 10px;
    height: 2px;
    background: currentColor;
}

.accordion button .icon::after {
    display: block;
    position: absolute;
    content: '';
    top: 5px;
    left: 9px;
    width: 2px;
    height: 10px;
    background: currentColor;
}

.accordion button[aria-expanded='true'] {
    color: #4543de;
}

.accordion button[aria-expanded='true'] .icon::after {
    width: 0;
}

.accordion button[aria-expanded='true']+.accordion-content {
    opacity: 1;
    max-height: 100%;
    transition: all 200ms linear;
    will-change: 1, 100%;
}

.accordion .accordion-content {
    opacity: 0;
    max-height: 0;
    overflow-x: overlay;
    transition: 0 200ms linear, 0 200ms linear;
    will-change: 0, 0;
}

.accordion .accordion-content p {
    font-size: 1rem;
    font-weight: 300;
    margin: 2em 0;
}

.accordion-item .cat {
    background: #4543de;
    color: white;
    padding: 2px 5px 2px 5px;
    border-radius: 5px;
}

@media (min-width: 992px) {
    .wikipedia-list {
        margin-left: 50px;
        margin-top: -50px;

    }
}

.color-white {
    background: white !important;
}
</Style>

<body>

    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Our Policies</h5>
                    </div>
                </div>




                <div class="row p-1 " style="display: flex; justify-content: center; padding: 10px;">

                </div>
                <div class="row">
                    <div class="col-md-3" style="padding:0;">
                        <div class="sidebar" style="height: 400px;overflow: auto;">
                            <ul class="nav flex-column">
                                <li class="nav-item dropdown" onclick="getAllData()">
                                    <a class="nav-link dropdown-toggle active1" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="collapse" data-bs-target="#homeSubmenu1"
                                        aria-expanded="false">
                                        All Policies
                                    </a>
                                </li>
                                <?php
                                $catSql = $obj->query("select * from $tbl_policy_category where status=1 order by displayorder asc");
                                while($res = $obj->fetchNextObject($catSql)){
                                    $countSql = $obj->query("select count(*) as total_rows from $tbl_policy_subcategory where category_id='".$res->id."' and status=1");
                                    $countResult = $obj->fetchNextObject($countSql);
                                    $totalRows = $countResult->total_rows;
                                    ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle"
                                        href="#" id="navbarDropdown<?=$res->id?>" role="button"
                                        data-bs-toggle="collapse" data-bs-target="#homeSubmenu1<?=$res->id?>"
                                        aria-expanded="false" <?php if($totalRows == '0'){ ?>
                                        onclick="get_question_cat(<?=$res->id?>)"
                                        <?php }else{ ?>onclick="check_subcat(<?=$res->id?>)" <?php } ?>>
                                        <?=$res->name?>
                                        <?=$totalRows == '0' ? '' : '<span style="float: right;"><i class="zmdi zmdi-caret-down"></i></span>'?>
                                    </a>
                                    <?php
                                    $c = 1;
                                    if($totalRows > '0'){
                                    ?>
                                    <ul class="collapse list-unstyled " aria-labelledby="navbarDropdown<?=$res->id?>"
                                        class="" id="homeSubmenu1<?=$res->id?>">
                                        <?php
                                        $gets = $obj->query("select * from $tbl_policy_subcategory where category_id='".$res->id."' and status=1 order by displayorder asc");
                                        while($res_sub = $obj->fetchNextObject($gets)){
                                        ?>
                                        <li class="bg-light sublist subcat<?=$res->id?><?=$c++?>"
                                            id="subcat<?=$res_sub->id?>"
                                            onclick="get_question_subcat(<?=$res_sub->id?>)"><a class="dropdown-item"
                                                href="#"><?=$res_sub->name?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!-- col-md-4 end -->

                    <!-- col-md-8 start -->

                    <div class="col-md-8 wikipedia-list" style="margin-top:0">
                        <!-- <input class="form-control" type="search" placeholder="Search Your Question" aria-label="Search"
                            id="search_box"
                            style="box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px; border-radius: 5px;     margin-bottom: 15px;height: 50px;"
                            onkeyup="get_question(this.value)"> -->
                        <div class="row" style="background: white;padding: 10px;border-radius: 10px;margin: 0px;">
                            <div class="accordion" id="get_question">
                                <?php
                                $qSql = $obj->query("SELECT 
                                q.question AS question, 
                                q.answer AS answer,
                                q.id AS id, 
                                c.name AS cat_name  
                            FROM 
                                $tbl_policy_question q
                            INNER JOIN 
                                $tbl_policy_category c ON q.cat_id = c.id 
                            LEFT JOIN 
                                $tbl_policy_subcategory sc ON q.subcat_id = sc.id  
                            LEFT JOIN (
                                SELECT 
                                    MIN(q1.displayorder) AS min_displayorder,
                                    q1.cat_id,
                                    q1.subcat_id
                                FROM 
                                    $tbl_policy_question q1
                                INNER JOIN 
                                    $tbl_policy_category c1 ON q1.cat_id = c1.id 
                                LEFT JOIN 
                                    $tbl_policy_subcategory sc1 ON q1.subcat_id = sc1.id 
                                WHERE 
                                    q1.status = 1
                                GROUP BY 
                                    q1.cat_id, q1.subcat_id
                            ) min_disp ON q.displayorder = min_disp.min_displayorder AND q.cat_id = min_disp.cat_id AND q.subcat_id = min_disp.subcat_id
                            WHERE 
                                q.status = 1  
                            ORDER BY 
                                CASE WHEN sc.id IS NOT NULL THEN sc.displayorder ELSE c.displayorder END,
                                c.displayorder, 
                                q.displayorder");
                                $count =1;
                                while($qResult = $obj->fetchNextObject($qSql)){?>
                                <div class="accordion-item">
                                    <button id="accordion-button-<?=$qResult->id?>" aria-expanded="<?=$count == 1 ? 'true' : 'false'?>">
                                        <span class="accordion-title"><?=$qResult->question?></span>
                                        <span class="icon" aria-hidden="true"></span>
                                    </button>
                                    <div class="accordion-content">
                                        <p><?=$qResult->answer?> </p>
                                    </div>
                                </div>
                                <?php $count++ ; } ?>
                            </div>
                        </div>
                    </div>


                    <!-- col-md-8 end -->

                </div>


            </div>



            <footer class="footer container-fluid pl-30 pr-30">
                <div class="row">
                    <div class="col-sm-12">
                        <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    </div>
    <script>
    const items = document.querySelectorAll('.accordion button');

    function toggleAccordion() {
        const itemToggle = this.getAttribute('aria-expanded');

        for (i = 0; i < items.length; i++) {
            items[i].setAttribute('aria-expanded', 'false');
        }

        if (itemToggle == 'false') {
            this.setAttribute('aria-expanded', 'true');
        }
    }

    items.forEach((item) => item.addEventListener('click', toggleAccordion));
    </script>
    <?php
    include('footer.php')
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>



    <script>
    $(document).ready(function() {
        $("#global_search").keypress(function() {
            var global_search = $(this).val();
            fileter(global_search);
        })
    });


    function fileter(global_search) {
        $.ajax({
            type: "post",
            url: 'ajax/getProgrammelData.php',
            data: {
                global_search: global_search,
                type: 'filter'
            },
            success: function(response) {
                $("#programmeData").html(response);
            }
        });
    };
    </script>
    <script>
    function get_question(val) {
        if(val == ''){
            getAllData()
        }else{
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                val1: val
            },
            success: function(data) {
                $("#get_question").html(data);
            }
        })
    }
    }

    function get_question_cat(val) {
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                val1: '1',
                cat_id: val
            },
            success: function(data) {
                $("#search_box").val('');
                $(".sublist").removeClass("active1");
                $(".nav-link").removeClass("active1");

                $("#navbarDropdown" + val).addClass("active1");
                $("#get_question").html(data);
                closeAllTabs();
            }
        })
    }

    function get_question_subcat(val) {
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                val1: '1',
                subcat_id: val
            },
            success: function(data) {
                $("#search_box").val('');
                $(".sublist").removeClass("active1");
                $(".nav-link").removeClass("active1");
                $("#subcat" + val).addClass("active1");
                $("#get_question").html(data);
            }
        })
    }

    function getAllData() {
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                val1: '2',
            },
            success: function(data) {
                $("#search_box").val('');
                $(".sublist").removeClass("active1");
                $(".nav-link").removeClass("active1");
                $("#navbarDropdown").addClass("active1");
                $("#get_question").html(data);
                closeAllTabs();
            }
        })
    }
    </script>
    <script>
    function check_subcat(id) {
        var elements = document.getElementsByClassName("subcat" + id + "1");
        if (elements.length > 0) {
            elements[0].click();
            closeAllTabs();
        } else {
            console.error("Element not found: subcate" + id + "1");
        }
    }

    function closeAllTabs() {
        var dropdowns = document.querySelectorAll('.nav-item.dropdown .collapse');
        dropdowns.forEach(function(dropdown) {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
    }
    </script>
</body>

</html>