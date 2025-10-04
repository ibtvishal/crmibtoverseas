
<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");

if(isset($_POST['id'])){
    ?>
    <option value="">Select Subcategory</option>
    <?php
$csql=$obj->query("select * from tbl_subcategory where category_id='".$_POST['id']."'");
while($cline=$obj->fetchNextObject($csql)){?>
<option value="<?php echo $cline->id ?>"><?php echo $cline->name ?></option>
<?php
 } 
}

if(isset($_POST['val'])){
    $i=1;

    if(isset($_POST['cat_id'])){
        $query = 'tbl_question.cat_id = '.$_POST['cat_id'];
    }
    elseif(isset($_POST['subcat_id'])){
        $query = 'tbl_question.subcat_id = '.$_POST['subcat_id'];
    }else{
        $query = "tbl_question.question like '%".$_POST['val']."%'";
    }

    if($_POST['val']=='2'){
        $qSql = $obj->query("select * from $tbl_question where status=1 order by displayorder asc");
    }else{
        $qSql = $obj->query("SELECT 
        tbl_question.question AS question,
        tbl_question.answer AS answer,
        tbl_question.id AS id,
        tbl_category.name AS cat_name,
        COALESCE(tbl_subcategory.name, '') AS subcat_name  
    FROM 
        tbl_question 
    INNER JOIN 
        tbl_category ON tbl_question.cat_id = tbl_category.id 
    LEFT JOIN 
        tbl_subcategory ON tbl_question.subcat_id = tbl_subcategory.id AND tbl_question.subcat_id != ''
    WHERE 
        tbl_question.status = 1 
        AND $query
    ORDER BY 
        tbl_category.displayorder ASC, tbl_question.displayorder ASC");
    }
    while($qResult = $obj->fetchNextObject($qSql)){
        ?> 
     
    <div class="accordion-item">
        <?php
        if(isset($_POST['cat_id']) || isset($_POST['subcat_id']) || $_POST['val']=='2'){
        }else{
                ?>
                <span class="cat"><?=$qResult->cat_name?></span> <?php if($qResult->subcat_name !='' ){ ?> > <span class="cat"><?php echo $qResult->subcat_name; }?></span>
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


if(isset($_POST['submit_board_name'])){
    $name = $_POST['name'];
    $sql = $obj->query("select count(*) as total from tbl_board where name='$name'");
	$total=$obj->fetchNextObject($sql);
    if($total->total > 0){
        echo 2;
    }else{
        $inert = $obj->query("insert tbl_board set name='$name'"); 
        if($inert){
            echo 1;
        }else{
            echo 1;
        }
    }
}



?>

