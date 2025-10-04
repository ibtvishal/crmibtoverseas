<div class="modal fade" id="get_note_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" id="addCountry" name="addCountry">
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title">Update Note</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
					<?php
                $gets = $obj->query('select * from tbl_note where id=1');
                $res1 = mysqli_fetch_array($gets);
				?>
                        <label for="recipient-name" class="control-label mb-10">Note:</label>
                        <input type="text" class="form-control" id="note_home" name="note" value="<?=$res1['note']?>">
                        <label for="recipient-name" class="control-label mb-10">Student Note:</label>
                        <input type="text" class="form-control" id="student_note_home" name="student_note" value="<?=$res1['student_note']?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="btnSubmit_home_note" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="dist/js/dataTables-data.js"></script>

<!-- <script src="vendors/bower_components/moment/min/moment.min.js"></script> -->
<!-- <script src="vendors/bower_components/FooTable/compiled/footable.min.js" type="text/javascript"></script>
<script src="dist/js/footable-data.js"></script> -->
<script src="dist/js/jquery.slimscroll.js"></script>
<script src="dist/js/dropdown-bootstrap-extended.js"></script>
<script src="vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="vendors/bower_components/switchery/dist/switchery.min.js"></script>
<script src="dist/js/init.js"></script>


<script src="vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
<!-- <script src="dist/js/simpleweather-data.js"></script> -->
<script src="vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
<script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/bower_components/raphael/raphael.min.js"></script>
<script src="vendors/bower_components/morris.js/morris.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script src="vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
<!-- <script src="dist/js/dashboard-data.js"></script> -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script>
/*Sidebar Navigation*/
$(document).on('click', '#toggle_nav_btn,#open_right_sidebar,#setting_panel_btn', function(e) {
    $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
    return false;
});
$(document).on('click', '#toggle_nav_btn', function(e) {
    $wrapper.removeClass('open-right-sidebar open-setting-panel').toggleClass('sidebar-hover');
    return false;
});

$(document).on('click', '#open_right_sidebar', function(e) {
    $wrapper.toggleClass('open-right-sidebar').removeClass('open-setting-panel');
    return false;

});

$(document).on('click', '.product-carousel .owl-nav', function(e) {
    return false;
});

$(document).on('click', 'body', function(e) {
    if ($(e.target).closest('.fixed-sidebar-right,.setting-panel').length > 0) {
        return;
    }
    $('body > .wrapper').removeClass('open-right-sidebar open-setting-panel');
    return;
});

$(document).on('show.bs.dropdown', '.nav.navbar-right.top-nav .dropdown', function(e) {
    $wrapper.removeClass('open-right-sidebar open-setting-panel');
    return;
});

$(document).on('click', '#setting_panel_btn', function(e) {
    $wrapper.toggleClass('open-setting-panel').removeClass('open-right-sidebar');
    return false;
});
$(document).on('click', '#toggle_mobile_nav', function(e) {
    $wrapper.toggleClass('mobile-nav-open').removeClass('open-right-sidebar');
    return;
});


$(document).on("mouseenter mouseleave", ".wrapper > .fixed-sidebar-left", function(e) {
    if (e.type == "mouseenter") {
        $wrapper.addClass("sidebar-hover");
    } else {
        $wrapper.removeClass("sidebar-hover");
    }
    return false;
});

$(document).on("mouseenter mouseleave", ".wrapper > .setting-panel", function(e) {
    if (e.type == "mouseenter") {
        $wrapper.addClass("no-transition");
    } else {
        $wrapper.removeClass("no-transition");
    }
    return false;
});
</script>
<script>
$(document).ready(function() {
    $('.table-hover').addClass('table-bordered');
})
</script>

<script type="text/javascript">
function userprofileupload(did, act) {

    $("#action").val(act);
    $("#did").val(did);
}


$("#uploadprofilefrm").on('submit', function(e) {
    e.preventDefault();
    var file_data = $('.file').prop('files')[0];
    var did = $("#did").val();
    var action = $("#action").val();
    if (file_data != undefined) {
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('did', did);
        form_data.append('action', action);
        form_data.append('ttype', 3);
        //alert(form_data); return;
        $.ajax({
            type: 'POST',
            url: 'ajax/getFileUpload.php',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(response) {
                //console.log(response); return;
                if (response == 1) {
                    $("#imgupload").modal('toggle');
                }
                $('.file').val('');
                location.reload();
            }
        });
    }
    return false;
});
</script>
<script>
function show_otp() {
    $('#search_form').show();
    $('#show_otp').hide();
    $('#hide_otp').show();
}

function hide_otp() {
    $('#search_form').hide();
    $('#show_otp').show();
    $('#hide_otp').hide();
}
</script>
<script>
function get_note_modal() {
    $("#get_note_modal").modal('show');
}
</script>
<script>
	$("#btnSubmit_home_note").on("click", function() {
    note_home = $("#note_home").val();
    student_note_home = $("#student_note_home").val();
   
	$.ajax({
        type: "POST", 
        url: 'controller.php', 
        data: {'note_home':note_home,'student_note_home':student_note_home}, 
        success: function (response) {
        	if(response==1){
        		location.reload(true);
        	}
        },
    });
});
$("#cname").keypress(function(){
$("#err_country_name").hide();
})
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("imageInput");
    const cropButton = document.getElementById("cropButton");
    const resultCanvas = document.getElementById("resultCanvas");
    const ctx = resultCanvas.getContext("2d");
    const imageElement = document.getElementById("image");

    let cropper;

    imageInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imageElement.src = e.target.result;
                imageElement.style.display = "block";

                // Destroy previous cropper if exists
                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(imageElement, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    cropBoxResizable: true,
                    cropBoxMovable: true,
                    ready() {
                        cropButton.disabled = false;
                    }
                });
            };
            reader.readAsDataURL(file);
        }
    });

    cropButton.addEventListener("click", () => {
        if (!cropper) return;

        const croppedCanvas = cropper.getCroppedCanvas({
            width: 200,
            height: 200,
        });

        // Prepare result canvas
        ctx.clearRect(0, 0, 200, 200);
        ctx.save();

        // Create circular clipping path
        ctx.beginPath();
        ctx.arc(100, 100, 100, 0, 2 * Math.PI);
        ctx.closePath();
        ctx.clip();

        ctx.drawImage(croppedCanvas, 0, 0, 200, 200);
        ctx.restore();

        // Convert to blob and upload
        resultCanvas.toBlob((blob) => {
            if (!blob) {
                alert("Image conversion failed.");
                return;
            }

            const formData = new FormData();
            formData.append("photo", blob, "profile.png");

            fetch("ajax/user-profile.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(response => {
                    console.log(response);
                    location.reload();
                })
                .catch(error => {
                    console.error("Upload failed", error);
                    alert("Image upload failed.");
                });
        }, "image/png");
    });
});

</script>

<script>
    	$(document).on('click', '#toggle_mobile_nav', function (e) {
		$wrapper.toggleClass('mobile-nav-open').removeClass('open-right-sidebar');
		return;
	});
	

</script>