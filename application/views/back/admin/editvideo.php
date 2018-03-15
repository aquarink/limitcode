<div class="layout-content">

<div id="myModal" class="modal fade in" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"> 
                <div class="text-center">
                    <h3 class="text-default"><?php if(isset($errors)) { echo $errors; } ?></h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="layout-content-body">
  <div class="title-bar">
     <h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
     <p class="title-bar-description">
        <small><div id="todaysDate"></div></small>
    </p>
</div>

<?php if(isset($article)): ?>
    <?php foreach($article as $k => $v): ?>
        <div class="col-md-12">                    
            <div class="row gutter-xs">
                <div class="card">
                    <div class="card-body">

                        <div class="col-md-12">
                            <div class="col-sm-3 col-md-3"></div>
                            <div class="col-sm-6 col-md-6">
                                <video width="400" controls>
                                    <source src="<?php echo base_url().$v->video; ?>" type="video/mp4">
                                        Your browser does not support HTML5 video.
                                    </video>
                                </div>
                                <div class="col-sm-3 col-md-3"></div>
                            </div>

                            <form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-9">
                                        <input class="form-control custom-select custom-select-lg" type="text" name="titlearticle" placeholder="Type title for article" value="<?php echo $v->title; ?>">
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-control-6">Category</label>
                                    <div class="col-sm-9">
                                        <select id="parentMenu" class="form-control custom-select custom-select-lg" name="parentmenu">
                                            <?php foreach($menu as $row) {?>
                                            <?php if($row->id_menu == $v->menu) { ?>
                                            <option selected value="<?php echo $row->id_menu;?>"><?php echo ucfirst($row->menu_name);?></option>

                                            <?php } else { ?>

                                            <option value="<?php echo $row->id_menu;?>"><?php echo ucfirst($row->menu_name);?></option>

                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="form-control-6">Sub Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-control childmenu custom-select custom-select-lg" name="childmenu">
                                            <option value="0">Choose</option>
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
                                      <br>
                                      <img id="blah" src="<?php if(empty($v->thumbnail)) { echo base_url().'layout/img/no-thumbnail.jpg'; } else { echo $v->thumbnail; } ?>" alt="Chose your thumbnil" style="width: 265px"/>
                                      <p class="help-block">
                                        <small>1 image can be uploaded to this field. Allowed types: png gif jpg jpeg.</small>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Content</label>
                                <div class="col-sm-9">
                                    <textarea placeholder="Type video description" class="form-control" style="height: 150px" name="article"><?php echo $v->describ; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"> 
                                </div>
                                <div class="col-sm-9">
                                    <!-- <button name="submit" value="drafarticle" type="submit" class="btn btn-info"> Save as Draft</button> -->

                                    <button name="submit" value="uploadvideo" type="submit" class="btn btn-success"> Post Video</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
        <?php endforeach; ?>
    <?php endif; ?>         
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