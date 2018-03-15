<head>  
	<link rel="stylesheet" href="<?php echo base_url(); ?>layout/uploads/css/style.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>layout/uploads/css/jquery.fileupload.css">
	
	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/vendor/jquery.ui.widget.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script type="text/javascript" src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script type="text/javascript" src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
	<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload.js"></script>
	<!-- The File Upload processing plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload-process.js"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload-image.js"></script>
	<!-- The File Upload audio preview plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload-audio.js"></script>
	<!-- The File Upload video preview plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload-video.js"></script>
	<!-- The File Upload validation plugin -->
	<script type="text/javascript" src="<?php echo base_url(); ?>layout/uploads/js/jquery.fileupload-validate.js"></script>


    <script type="text/javascript">        
        $(document).ready(function(){

            $('#blah').hide();

            $('#parentMenu').change(function(){
                var id=$(this).val();

                if(id == 0) {
                    html += '<option value="0">-Choose-</option>';
                    $('.childmenu').html(html);
                } else {
                    var html = '';
                    $.ajax({
                        url : "<?php echo base_url().index_with(); ?>article/submenu",
                        method : "POST",
                        data : {id: id,vals: 'getsubmenu'},
                        async : false,
                        dataType : 'json',
                        success: function(data){

                            var i;
                            for(i=0; i<data.length; i++){
                                html += '<option value='+data[i].id_sub+'>'+data[i].sub_name+'</option>';
                            }
                            $('.childmenu').html(html);

                        }
                    });
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                    .show()
                    .attr('src', e.target.result)
                    .width(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script type="text/javascript">
      jQuery(document).ready(function($){

        var fileArray = [];
       /*jslint unparam: true, regexp: true */
       /*global window, $ */
       $(function () {
        'use strict';
        $('#formnya').hide();
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
    '//jquery-file-upload.appspot.com/' : 'fileupload/',
    uploadButton = $('<button/>')
    .addClass('btn btn-primary')
    .prop('disabled', true)
    .text('Processing...')
    .on('click', function () {
    	var $this = $(this),
    	data = $this.data();
    	$this
    	.off('click')
    	.text('Abort')
    	.on('click', function () {
    		$this.remove();
    		data.abort();
    	});
    	data.submit().always(function () {
    		$this.remove();
    	});
    });
    $('#fileupload').fileupload({
    	url: url,
        method: 'POST',
        dataType: 'json',
        autoUpload: false,
    	// acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        acceptFileTypes: /(\.|\/)(ogg|mp4)$/i,
        maxFileSize: 4000000000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
        .test(window.navigator.userAgent),
        previewMaxWidth: 425,
        previewMaxHeight: 600,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        $('#uploadBtn').hide();
    	// data.context = $('<div/>').appendTo('#files');
        data.context = $('<div class="col-md-4 videopreview" />').appendTo('#files');
        $.each(data.files, function (index, file) {
            var namenya = file.name;
            var expl = namenya.split(".");
            var newName = expl.slice(0, -1);
            var joins = newName.join();
            var repl = joins.replace(","," ").replace(","," ").replace(","," ").replace(","," ").replace(","," ").replace(","," ").replace(","," ").replace(","," ").replace(","," ");
            var repl2 = repl.replace("-"," ").replace("-"," ").replace("-"," ").replace("-"," ").replace("-"," ").replace("-"," ");

            $('#postFileOriName').val(file.name);
            $('#postFileMetaName').val(repl2);

            fileArray.push(file.name);

            var node = $('<p/>')
            .append($('<span/>').text(file.name));
            if (!index) {
             node
             .append('<br>')
             .append(uploadButton.clone(true).data(data));
         }
         node.appendTo(data.context);
     });
    }).on('fileuploadprocessalways', function (e, data) {
    	var index = data.index,
    	file = data.files[index],
    	node = $(data.context.children()[index]);
    	if (file.preview) {
    		node
    		.prepend('<br>')
    		.prepend(file.preview);
    	}
    	if (file.error) {
    		node
    		.append('<br>')
    		.append($('<span class="text-danger"/>').text(file.error));
    	}
    	if (index + 1 === data.files.length) {
    		data.context.find('button')
    		.text('Upload')
    		.prop('disabled', !!data.files.error);
    	}
    }).on('fileuploadprogressall', function (e, data) {
    	var progress = parseInt(data.loaded / data.total * 100, 10);
    	$('#progress .progress-bar').css(
    		'width',
    		progress + '%'
    		);
    }).on('fileuploaddone', function (e, data) {
    	$.each(data.result.files, function (index, file) {
            //
            $.ajax({
                url : "<?php echo base_url().index_with(); ?>video/insvid",
                method : "POST",
                data : {submit: 'videotemp',video: file.name, oriname: fileArray[0]},
                async : false,
                dataType : 'json',
                success: function(resdata){
                    $('#vidId').val(resdata.id_content);
                }
            });
            //
    		if (file.url) {
                $('#postFileName').val(file.name);
                $('#progress').hide();
                $('#formnya').show();

                var link = $('<a>')
                .attr('target', '_blank')
                .prop('href', file.url);
                $(data.context.children()[index])
                .wrap(link);
            } else if (file.error) {
             var error = $('<span class="text-danger"/>').text(file.error);
             $(data.context.children()[index])
             .append('<br>')
             .append(error);
         }
     });
    }).on('fileuploadfail', function (e, data) {
    	$.each(data.files, function (index) {
    		var error = $('<span class="text-danger"/>').text('File upload failed.');
    		$(data.context.children()[index])
    		.append('<br>')
    		.append(error);
    	});
    }).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
})
</script>
</head>

<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>
		</div>

		<span class="btn btn-success fileinput-button" id="uploadBtn">
			<i class="icon icon-video"></i>
			<span>Add Video</span>
			<!-- The file input field used as target for the file upload widget -->
			<input id="fileupload" type="file" name="files[]" accept="video/mp4">
		</span>
		<br>
		<br>
		<!-- The global progress bar -->
		<div id="progress" class="progress">
			<div class="progress-bar progress-bar-success"></div>
		</div>
		<!-- The container for the uploaded files -->
		<div id="files" class="files"></div>


        <div class="col-md-12" id="formnya">

            <div class="row gutter-xs">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
                            <input id="vidId" type="hidden" name="idvid">
                            <input id="postFileName" type="hidden" name="filename">
                            <input id="postFileOriName" type="hidden" name="fileoriname">
                            <input id="postFileMetaName" type="hidden" name="filemetaname">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-9">
                                    <input class="form-control custom-select custom-select-lg" type="text" name="titlearticle" placeholder="Type title for article">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form-control-6">Category</label>
                                <div class="col-sm-9">
                                    <select id="parentMenu" class="form-control custom-select custom-select-lg" name="parentmenu">
                                        <option value="0">-Choose-</option>
                                        <?php foreach($menu as $row):?>
                                            <option value="<?php echo $row->id_menu;?>"><?php echo ucfirst($row->menu_name);?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form-control-6">Sub Category</label>
                                <div class="col-sm-9">
                                    <select class="form-control childmenu custom-select custom-select-lg" name="childmenu">
                                        <option value="0">-Choose-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tags (optional)</label>
                                <div class="col-sm-9">
                                    <input class="form-control custom-select custom-select-lg" type="text" name="tagscontent" placeholder="Type tag sparated with comas exm : news,world,animal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form-control-9">Thumbnail</label>
                                <div class="col-sm-9">

                                    <label class="btn btn-success file-upload-btn">
                                      Choose Thumbnail
                                      <input class="file-upload-input" type="file" onchange="readImageThumPop(this);" accept="image/*" name="thumbnailarticle">
                                  </label>
                                  <br>
                                  <img id="blah" src="#" alt="Chose your thumbnil" />
                                  <p class="help-block">
                                    <small>1 image can be uploaded to this field. Allowed types: png gif jpg jpeg.</small>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea placeholder="Type video description" class="form-control" style="height: 150px" name="article"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"> 
                            </div>
                            <div class="col-sm-9">
                                <!-- <button name="submit" value="drafarticle" type="submit" class="btn btn-info"> Save as Draft</button> -->

                                <button name="submit" value="uploadvideo" type="submit" class="btn btn-warning"> Upload Video</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>            
    </div>

</div>
</div>

<?php if($modals == 'true') { ?>
<div id="successModalAlert" tabindex="-1" role="dialog" class="modal fade in" style="display: block; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <span class="text-success icon icon-check icon-5x"></span>
                    <h3 class="text-success">Success Upload Videos</h3>
                    <p>Wait admin approval for publish your video.</p>
                    <div class="m-t-lg">
                        <a href="<?php echo base_url().index_with(); ?>video/list" class="btn btn-success">List Videos</a>
                        <a href="<?php echo base_url().index_with(); ?>video/new" class="btn btn-default">Create Again</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if(isset($errors)) { ?>
<div id="failedModalAlert" tabindex="-1" role="dialog" class="modal fade in" style="display: block; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <span class="text-danger icon icon-check icon-5x"></span>
                    <h3 class="text-danger">Error</h3>
                    <p><?php echo $errors; ?>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>