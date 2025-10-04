<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");

if(isset($_POST['id'])){
    ?>
<option value="">Select Subcategory</option>
<?php
$csql=$obj->query("select * from ".$_POST['tbl']." where category_id='".$_POST['id']."' and status='1'");
while($cline=$obj->fetchNextObject($csql)){?>
<option value="<?php echo $cline->id ?>"><?php echo $cline->name ?></option>
<?php
 } 
}

if(isset($_POST['val'])){
    $i=1;
     $whr = '';
     if($_SESSION['level_id'] == 32){
        $whr = " and q.cat_id in (1,2,3)"; 
     }
    if($_POST['val']=='2'){
        $qSql = $obj->query("SELECT 
        q.question AS question, 
        q.answer AS answer,
        q.id AS id, 
        c.name AS cat_name  
    FROM 
        tbl_question q
    INNER JOIN 
        tbl_category c ON q.cat_id = c.id 
    LEFT JOIN 
        tbl_subcategory sc ON q.subcat_id = sc.id  
    LEFT JOIN (
        SELECT 
            MIN(q1.displayorder) AS min_displayorder,
            q1.cat_id,
            q1.subcat_id
        FROM 
            tbl_question q1
        INNER JOIN 
            tbl_category c1 ON q1.cat_id = c1.id 
        LEFT JOIN 
            tbl_subcategory sc1 ON q1.subcat_id = sc1.id 
        WHERE 
            q1.status = 1 
        GROUP BY 
            q1.cat_id, q1.subcat_id
    ) min_disp ON q.displayorder = min_disp.min_displayorder AND q.cat_id = min_disp.cat_id AND q.subcat_id = min_disp.subcat_id
    WHERE 
        q.status = 1  $whr
    ORDER BY 
        CASE WHEN sc.id IS NOT NULL THEN sc.displayorder ELSE c.displayorder END,
        c.displayorder, 
        q.displayorder");
    }else{
        if(isset($_POST['cat_id'])){
            $query = 'q.cat_id = '.$_POST['cat_id'];
        }
        elseif(isset($_POST['subcat_id'])){
            $query = 'q.subcat_id = '.$_POST['subcat_id'];
        }else{
            $query = "q.question like '%".$_POST['val']."%'";
        }
        $qSql = $obj->query("SELECT 
            q.question AS question, 
            q.answer AS answer,
            q.id AS id, 
            c.name AS cat_name,  
            sc.name AS subcat_name  
        FROM 
            tbl_question q
        INNER JOIN 
            tbl_category c ON q.cat_id = c.id 
        LEFT JOIN 
            tbl_subcategory sc ON q.subcat_id = sc.id  
        LEFT JOIN (
            SELECT 
                MIN(q1.displayorder) AS min_displayorder,
                q1.cat_id,
                q1.subcat_id
            FROM 
                tbl_question q1
            INNER JOIN 
                tbl_category c1 ON q1.cat_id = c1.id 
            LEFT JOIN 
                tbl_subcategory sc1 ON q1.subcat_id = sc1.id 
            WHERE 
                q1.status = 1 
            GROUP BY 
                q1.cat_id, q1.subcat_id
        ) min_disp ON q.displayorder = min_disp.min_displayorder AND q.cat_id = min_disp.cat_id AND q.subcat_id = min_disp.subcat_id
        WHERE 
            q.status = 1 AND $query $whr
        ORDER BY 
            CASE WHEN sc.id IS NOT NULL THEN sc.displayorder ELSE c.displayorder END,
            c.displayorder, 
            q.displayorder");
    }
    
    while($qResult = $obj->fetchNextObject($qSql)){
        ?>

    <div class="accordion-item">
        <?php
            if(isset($_POST['cat_id']) || isset($_POST['subcat_id']) || $_POST['val']=='2'){
            }else{
                    ?>
        <span class="cat"><?=$qResult->cat_name?></span> <?php if($qResult->subcat_name !='' ){ ?> > <span
            class="cat"><?php echo $qResult->subcat_name; }?></span>
        <?php
                } ?>
        <button id="accordion-button-<?=$qResult->id?>" aria-expanded="false">
            <span class="accordion-title"><?=$qResult->question?></span>
            <span class="icon" aria-hidden="true"></span>
        </button>
        <div class="accordion-content">
            <p><?=$qResult->answer?> </p>
        </div>
    </div>

<?php 
    } 
    ?>
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
}

if(isset($_POST['val1'])){
    $i=1;
      $whr = '';
     if($_SESSION['level_id'] == 32){
        $whr = " and q.cat_id in (1,2,3)"; 
     }
    if($_POST['val1']=='2'){
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
        q.status = 1  $whr
    ORDER BY 
        CASE WHEN sc.id IS NOT NULL THEN sc.displayorder ELSE c.displayorder END,
        c.displayorder, 
        q.displayorder");
    }else{
        if(isset($_POST['cat_id'])){
            $query = 'q.cat_id = '.$_POST['cat_id'];
        }
        elseif(isset($_POST['subcat_id'])){
            $query = 'q.subcat_id = '.$_POST['subcat_id'];
        }else{
            $query = "q.question like '%".$_POST['val']."%'";
        }
        $qSql = $obj->query("SELECT 
            q.question AS question, 
            q.answer AS answer,
            q.id AS id, 
            c.name AS cat_name,  
            sc.name AS subcat_name  
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
            q.status = 1 AND $query $whr
        ORDER BY 
            CASE WHEN sc.id IS NOT NULL THEN sc.displayorder ELSE c.displayorder END,
            c.displayorder, 
            q.displayorder");
    }
    $count = 1;
    while($qResult = $obj->fetchNextObject($qSql)){
        ?>

<div class="accordion-item">
    <?php
        if(isset($_POST['cat_id']) || isset($_POST['subcat_id']) || $_POST['val']=='2'){
        }else{
                ?>
    <span class="cat"><?=$qResult->cat_name?></span> <?php if($qResult->subcat_name !='' ){ ?> > <span
        class="cat"><?php echo $qResult->subcat_name; }?></span>
    <?php
            } ?>
    <button id="accordion-button-<?=$qResult->id?>" aria-expanded="<?=$count == 1 ? 'true' : 'false'?>">
        <span class="accordion-title"><?=$qResult->question?></span>
        <span class="icon" aria-hidden="true"></span>
    </button>
    <div class="accordion-content">
        <p><?=$qResult->answer?> </p>
    </div>
</div>

<?php 
   $count++; } 
    ?>
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
}


if(isset($_POST['submit_board_name'])){
    $name = $_POST['name'];
    $sql = $obj->query("select count(*) as total from tbl_board where name='$name'");
	$total=$obj->fetchNextObject($sql);
    if($total->total > 0){
        $inert = $obj->query("update tbl_board set status='1' where name='$name'"); 
        if($inert){
            echo 1;
        }else{
            echo 1;
        }
    }else{
        $inert = $obj->query("insert tbl_board set name='$name', status=1"); 
        if($inert){
            echo 1;
        }else{
            echo 1;
        }
    }
}



?>