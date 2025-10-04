<?php 
$action = admin_url('academic/add');
$title = '';
$subtitle = '';
$photo = '';
$target_url = '';

if(isset($data['academic']) && !empty($data['academic']))
{
    $action = admin_url('academic/edit/'.$data['academic']->id);
    $title = $data['academic']->title;
    $subtitle = $data['academic']->sub_title;
    $photo = $data['academic']->photo;
    $target_url = $data['academic']->target_url;
}


?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2><?php if(isset($data['academic'])) echo "Edit"; else echo "Add"; ?> Academic Block</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a href="<?php echo base_url('admin/academic-list') ?>" title="Academic Block List"><i class="glyphicon glyphicon-list"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
             <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                
               <div class="rows">
                
                  <div class="col-md-6 margin-bottom10">
                      <label for="fullname">Title :</label>
                      <input type="text" id="" class="form-control" name="title" value="<?php echo $title ?>" required />
                  </div>
                
                  <div class="col-md-6 margin-bottom10">
                      <label for="fullname">Sub Title :</label>
                      <input type="text" id="" class="form-control" name="sub_title" value="<?php echo $subtitle ?>" required />
                  </div>
                
                  <div class="col-md-6 margin-bottom10">
                      <label for="fullname">Target URL :</label>
                      <input type="text" id="" class="form-control" name="target_url" value="<?php echo $target_url ?>" required />
                  </div>
                  <div class="col-md-6 margin-bottom10">
                      <label for="fullname">Image :</label>
                      <input type="file" id="" class="form-control" placeholder="select image" name="photo"  />
                      <p class="image-type">Only .jpg, .jpeg, .gif type are allowed. <span>For best view upload image ratio in 85px*70px</span></p>
                      <?php 
                        if(!empty($data['academic']->photo)){ ?>
                          <img src="<?php echo assets_url('/upload/academic/thumb/').$data['academic']->photo; ?>" class="thumb-img">
                       <?php } ?>
                  </div>
                  
                  <div class="col-md-12 margin-bottom10">
                      <input type="submit"  class="btn btn-success" name="submit" value="Submit" style="width:200px;float:right;" />
                  </div>
               </div>
           </form>
               
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>
<!-- /page content --> 


