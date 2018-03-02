<?php  
    $this->load->view('back/template/header');
    $this->load->view('back/admin/'.$content);
    $this->load->view('back/template/footer');    
?>

<!-- <div class="layout-content">
  <div class="layout-content-body">
    <div class="title-bar">
      <h1 class="title-bar-title">Basic template</h1>
      <p class="title-bar-description">
        <small>Use this page as a basic template for developing your application.</small>
      </p>
      <button class="btn btn-outline-success" data-toggle="modal" data-target="#successModalAlert" type="button">Launch demo modal</button>
    </div>
  </div>

  <div id="successModalAlert" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <span class="text-success icon icon-check icon-5x"></span>
            <h3 class="text-success">Success</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              <br>Animi ducimus id itaque totam saepe reiciendis corporis consectetur.</p>
              <div class="m-t-lg">
                <button class="btn btn-success" data-dismiss="modal" type="button">Continue</button>
                <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
              </div>
            </div>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
  </div>
</div>
 -->