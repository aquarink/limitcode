<div class="layout-content">
	<div class="layout-content-body"> 
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>
		</div>
		<div class="col-md-12">

            <div class="row gutter-xs">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-9">
                                    <input class="form-control custom-select custom-select-lg" type="text" name="titlebanner" placeholder="Type title for banner" required="">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Advertiser</label>
                                <div class="col-sm-9">
                                    <input class="form-control custom-select custom-select-lg" type="text" name="advertiserbanner" placeholder="Type advertiser for banner" required="">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form-control-6">Position</label>
                                <div class="col-sm-9">
                                    <select id="sizebanner" class="form-control custom-select custom-select-lg" name="sizebanner" required="">
                                        <option value="0">-Choose-</option>
                                        <option value="728x90x1">Rectangle Top - Size 728x90</option>
                                        <option value="300x250x2">Square Left Side - Size 300x250</option>
                                        <option value="728x90x3">Between Content Middle - Size 728x90</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="form-control-9">Image Banner</label>
                                <div class="col-sm-9">

                                    <label id="choseFile" disabled class="btn btn-success file-upload-btn">
                                      Choose Banner File
                                      <input disabled="" id="inputFile" class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*" name="thebanner">
                                  </label>
                                  <br>
                                  <br>
                                  <img id="blah" src="#" alt="Choose Banner File" />
                                  <p class="help-block">
                                    <small>1 image can be uploaded to this field. Allowed types: png gif jpg jpeg.</small>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"> 
                            </div>
                            <div class="col-sm-9">
                                <!-- <button name="submit" value="drafarticle" type="submit" class="btn btn-info"> Save as Draft</button> -->

                                <button id="submt" disabled="" name="submit" value="uploadbanner" type="submit" class="btn btn-info"> Publish Banner</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>            
    </div>

</div>
</div>

<div id="bannerMsg" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h3 class="text-default">Image size and potition size not match.</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($msg)): ?>
    <?php if(!empty($msg)): ?>
        <div id="" class="modal fade in" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h3 class="text-default"><?php echo $msg; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>