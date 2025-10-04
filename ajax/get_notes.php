<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
?><div class="panel panel-default card-view">
                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <div class="panel-group accordion-struct" id="accordion_11"
                                                            role="tablist" aria-multiselectable="true">
                                                            <div class="panel panel-default">
                                                                <i class="bi bi-arrow-down-short"></i>
                                                                <?php 
                                                                    $mainnote=0;
                                                                    $note=10000000;
                                                                    $mainnoteSql = $obj->query("select MAX(id) as id, stu_id,univercity_id,portal_status,remarks,user_id,MIN(seen_status) as seen_status,cdate,status from $tbl_student_notes where stu_id='".$_POST['stu_id']."' group by univercity_id order by id desc");
                                                                    while($mainnoteResult = $obj->fetchNextObject($mainnoteSql)){ $mainnote++; ?>
                                                                <div class="panel-heading tabnewclass" role="tab"
                                                                    id="heading_1">
                                                                    <a role="button" data-toggle="collapse"
                                                                        onclick="change_seen_status(<?=$mainnoteResult->id?>,<?=$mainnoteResult->univercity_id?>,<?=$mainnoteResult->stu_id?>)"
                                                                        data-parent="#accordion_<?php echo $mainnote; ?>"
                                                                        href="#collapse_<?php echo $mainnote; ?>"
                                                                        aria-expanded="false"
                                                                        class="collapse-in collapsed"
                                                                        style="background: #2a3e4c !important; color: #fff !important">
                                                                        <?php 
                                                                            if($mainnoteResult->univercity_id==0){
                                                                                echo "General"; 
                                                                            }else{
                                                                                echo getField('name','tbl_univercity',$mainnoteResult->univercity_id) !='' ? getField('name','tbl_univercity',$mainnoteResult->univercity_id) : $mainnoteResult->univercity_id;
                                                                            }
                                                                            if($mainnoteResult->seen_status==0){
                                                                                ?>
                                                                        <span style="float:right;font-size: xx-large;"
                                                                            id="hide_star<?=$mainnoteResult->id?>">*</span>
                                                                        <?php 
                                                                            }
                                                                            ?>
                                                                    </a>
                                                                </div>

                                                                <div id="collapse_<?php echo $mainnote; ?>"
                                                                    class="panel-collapse collapse" role="tabpanel"
                                                                    aria-expanded="false" style="height: 0px;">
                                                                    <div class="panel-body">
                                                                        <div class="panel panel-default card-view">
                                                                            <div class="panel-wrapper collapse in">
                                                                                <div class="panel-body">
                                                                                    <div class="panel-group accordion-struct"
                                                                                        id="accordion_11" role="tablist"
                                                                                        aria-multiselectable="true">
                                                                                        <?php 

																							$noteSql = $obj->query("select * from $tbl_student_notes where stu_id='".$_POST['stu_id']."' and univercity_id='".$mainnoteResult->univercity_id."' group by portal_status order by id desc");
																							while($noteResult = $obj->fetchNextObject($noteSql)){ $note++; ?>
                                                                                        <div
                                                                                            class="panel panel-default">
                                                                                            <div class="panel-heading tabnewclass"
                                                                                                role="tab"
                                                                                                id="heading_<?php echo $note; ?>">
                                                                                                <a role="button"
                                                                                                    data-toggle="collapse"
                                                                                                    data-parent="#accordion_1"
                                                                                                    href="#collapse_<?php echo $note; ?>"
                                                                                                    aria-expanded="false"
                                                                                                    class="collapsed  collapse-in "><?php 
																									if($noteResult->portal_status!=''){
																										echo $noteResult->portal_status;
																									}else{
																										echo "General Discussion";
																									}
																									?>
                                                                                                </a>
                                                                                                <div
                                                                                                    class="comment_icon">
                                                                                                    <a href="javascript:void(0);"
                                                                                                        class="comment-box"
                                                                                                        onclick="showCommentBox(<?php echo $noteResult->id; ?>)"><span
                                                                                                            class="comment-box"></span></a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div id="collapse_<?php echo $note; ?>"
                                                                                                class="panel-collapse collapse <?php if($note==1){?> in <?php }?>"
                                                                                                role="tabpanel"
                                                                                                aria-expanded="false"
                                                                                                style="height: auto;">
                                                                                                <div
                                                                                                    class="panel-body pa-15">

                                                                                                    <div
                                                                                                        class="comments ml-30 ">
                                                                                                        <div
                                                                                                            class="comment-header">
                                                                                                            <p
                                                                                                                class="comment-author">
                                                                                                                <i
                                                                                                                    class="fa fa-user user-icon"></i><span
                                                                                                                    class="comment-author-name"
                                                                                                                    itemprop="name"><a
                                                                                                                        href=""
                                                                                                                        class="comment-author-link"><?php echo  getField('name','tbl_admin',$noteResult->user_id); ?></a></span>
                                                                                                            </p>

                                                                                                            <p
                                                                                                                class="comment-meta">
                                                                                                                <?php echo $noteResult->cdate; ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="comment-content">
                                                                                                            <p><?php echo $noteResult->remarks; ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="replies my-3">
                                                                                                    </div>

                                                                                                    <?php 

																		$pstatussql = $obj->query("select * from $tbl_student_notes where stu_id='".$_POST['stu_id']."' and univercity_id='".$noteResult->univercity_id."' and portal_status='".$noteResult->portal_status."' and id!='".$noteResult->id."' order by id asc",-1);

																		while($npstatusResult = $obj->fetchNextObject($pstatussql)){?>
                                                                                                    <div
                                                                                                        class="comments ml-30 ">
                                                                                                        <div
                                                                                                            class="comment-header">
                                                                                                            <p
                                                                                                                class="comment-author">
                                                                                                                <i
                                                                                                                    class="fa fa-user user-icon"></i><span
                                                                                                                    class="comment-author-name"
                                                                                                                    itemprop="name"><a
                                                                                                                        href=""
                                                                                                                        class="comment-author-link"><?php echo  getField('name','tbl_admin',$npstatusResult->user_id); ?></a></span>
                                                                                                            </p>

                                                                                                            <p
                                                                                                                class="comment-meta">
                                                                                                                <?php echo $npstatusResult->cdate; ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="comment-content">
                                                                                                            <p><?php echo $npstatusResult->remarks; ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="replies my-3">
                                                                                                    </div>

                                                                                                    <?php }?>

                                                                                                    <!-- <?php
																			$repSql = $obj->query("select * from $tbl_student_notes_comment where note_id='".$noteResult->id."'");
																			while($repResult = $obj->fetchNextObject($repSql)){?>
																				<div class="comments ml-30 ">
																					<div class="comment-header">
																						<p class="comment-author">
																							<i class="fa fa-user user-icon"></i><span class="comment-author-name" itemprop="name"><a href="" class="comment-author-link"><?php echo  getField('name','tbl_admin',$repResult->sender_id); ?></a></span></p>

																							<p class="comment-meta"><?php echo $repResult->cdate; ?></p>
																						</div>
																						<div class="comment-content" ><p><?php echo $repResult->comments; ?></p>
																						</div>
																					</div>
																					<div class="replies my-3"></div>
																				<?php }?> -->
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php }?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>