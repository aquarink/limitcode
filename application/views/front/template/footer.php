<?php 

$ipaddress = '';

if (getenv('HTTP_CLIENT_IP')){

    $ipaddress = getenv('HTTP_CLIENT_IP');

}

else if(getenv('HTTP_X_FORWARDED_FOR')){

    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

}

else if(getenv('HTTP_X_FORWARDED')){

    $ipaddress = getenv('HTTP_X_FORWARDED');

}

else if(getenv('HTTP_FORWARDED_FOR')){

    $ipaddress = getenv('HTTP_FORWARDED_FOR');

}

else if(getenv('HTTP_FORWARDED')){

 $ipaddress = getenv('HTTP_FORWARDED');

}

else if(getenv('REMOTE_ADDR')){

    $ipaddress = getenv('REMOTE_ADDR');

}

else {

    $ipaddress = 'UNKNOWN'; 

}



if(isset($sess['id_user'])) {

    $idU = $sess['id_user'];

} else {

    $idU = '';

}

?>

<footer>

    <div class="container">

        <div class="footer-widgets-part">

            <div class="row">

                <div class="col-md-4">

                    <div class="widget text-widget" style="text-align: justify;">

                        <h1>About</h1>

                        <p>Limit Code adalah wadah untuk para penulis, video creator dan untuk para pengguna yang hanya ingin mengunggah album photo nya yang sifatnya dapat dibagikan kepada publik. </p>

                        <p>Jika memiliki pertanyaan, kritik dan saran dapat menghubungi kami melalui email <a href="mailto:info@limitcode.xyz">info@limitcode.xyz</a>. </p>

                    </div>

                </div>



                <div class="col-md-8">

                    <div class="widget categories-widget">

                        <h1>Hot Categories</h1>

                        <ul class="category-list">

                            <?php if(isset($submenu)): ?>

                                <?php foreach($submenu as $sbm) { ?>

                                <li>

                                    <a href="<?php echo base_url().index_with().'q/'.$sbm->menuurl.'/'.$sbm->suburl; ?>"><?php echo $sbm->subname; ?> <span><?php echo $sbm->countarticle; ?></span></a>

                                </li>

                                <?php } ?>

                            <?php endif; ?>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="footer-last-line">

            <div class="row">

                <div class="col-md-6">

                    <p>&copy; COPYRIGHT 2018 LimitCode.xyz</p>

                </div>

                <div class="col-md-6">

                    <nav class="footer-nav">

                        <ul>

                            <li><a href="<?php echo base_url().index_with(); ?>home">Home</a></li>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

    </div>

</footer>

<!-- End footer -->



</div>

<!-- End Container -->



<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.migrate.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.bxslider.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.magnific-popup.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.ticker.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.imagesloaded.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/jquery.isotope.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/owl.carousel.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/retina-1.1.0.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>layout/hotmagz/js/script.js"></script>

<script type="text/javascript">

    var baseurl = "<?php echo base_url(); ?>";

</script>

<?php if(isset($bounceArticle)): ?>

    <script type="text/javascript">

        var timeleft = 15;

        var randpageid = Math.random().toString().replace(/\./g,'');

        var downloadTimer = setInterval(function(){

            10 - --timeleft

            if(timeleft <= 0) {

                clearInterval(downloadTimer);

                $.ajax({

                    url : "<?php echo base_url().index_with(); ?>article/impressview",

                    method : "POST",

                    data : {client: "<?php echo $ipaddress; ?>",articleid: <?php echo $bounceArticle ?>,action: "view"},

                    async : false,

                    dataType : 'json',

                    success: function(data){

                        console.log(data);

                    }

                });



            // interval for bounce 



            setInterval(function(){

                $.ajax({

                    url : "<?php echo base_url().index_with(); ?>article/impressbounce",

                    method : "POST",

                    data : {client: "<?php echo $ipaddress; ?>",pageid: randpageid,user: "<?php echo $idU; ?>",articleid: <?php echo $bounceArticle ?>, action: 'bounce'},

                    async : false,

                    dataType : 'json',

                    success: function(data){

                        console.log(data);

                    }

                });

            },10000);

        }

    },1000);

</script>

<?php endif; ?>



<script type="text/javascript">

    jQuery(document).ready(function($){
        $('#titlePastesAfter').hide();
        $('#titlePastes').text('Click or tap here and paste or upload your');
    });

    document.addEventListener('paste', function (e) {
        if (e.clipboardData) {
            var items = e.clipboardData.items;
            if (items) {
                for (var i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") !== -1) {

                        var blob = items[i].getAsFile();
                        var URLObj = window.URL || window.webkitURL;
                        var source = URLObj.createObjectURL(blob);

                        var reader = new FileReader();
 
                        reader.onload = function (e) {

                            $('#pasteImage')
                            .show()
                            .attr('src', e.target.result);

                            $.ajax({
                                url : "<?php echo base_url().index_with(); ?>sendpaste",
                                method : "POST",
                                data : {action: 'sendpaste',base64: e.target.result},
                                async : false,
                                dataType : 'json',
                                success: function(data){

                                    if(data.status.toString() == '1') {
                                        var imageUrl = data.linkto;

                                        $('#titlePastes').hide();
                                        $('#titlePastesAfter').show();

                                        $('#valLink').val(imageUrl);
                                        
                                        var widthInput = document.getElementById("valLink");
                                        var int = Number(6.9) || 7.7;
                                        var lengText = ((imageUrl.length) * int);
                                        document.getElementById("valLink").style.width = lengText+"px";

                                        setTimeout(function(){ 

                                            try {
                                                $('#valLink').select();
                                                var successful = document.execCommand('copy');
                                                var msg = successful ? 'successful' : 'unsuccessful';
                                                console.log('Copying text command was ' + msg);
                                            } catch (err) {
                                                console.log('Oops, unable to copy');
                                            }

                                        }, 1000);
                                    }
                                }

                            });    
                        };
                        reader.readAsDataURL(blob);
                    }
                }
            }
        }
    });



    window.fbAsyncInit = function() {

        FB.init({

          appId            : '570962756574024',

          autoLogAppEvents : true,

          xfbml            : true,

          version          : 'v2.12'

      });

    };



    (function(d, s, id){

     var js, fjs = d.getElementsByTagName(s)[0];

     if (d.getElementById(id)) {return;}

     js = d.createElement(s); js.id = id;

     js.src = "https://connect.facebook.net/en_US/sdk.js";

     fjs.parentNode.insertBefore(js, fjs);

 }(document, 'script', 'facebook-jssdk'));







    <?php if(isset($imgResponsive)) { ?>

        $("img").load(function(){

            $("article img").addClass("img img-responsive");

        });

        <?php } ?>



    // $("#createarticle").click(function(){

    //     var list = document.getElementsByTagName("img");

    //     console.log(list);

    //     for(var i=0;i<list.length;i++){

    //         var tags = document.getElementsByTagName("img")[i];         

    //         tags.setAttribute('class', 'img img-responsive');

    //     }

    // });



    $("#clickShort").click(function(){

        var url = $('#urlpress').val();



        $.ajax({

            url : "<?php echo base_url().index_with(); ?>getshort",

            method : "POST",

            data : {longurl: url,action: 'generateurl'},

            async : false,

            dataType : 'json',

            success: function(data){

                if(data.error.toString() === '0') {

                    var sl = data.shotrurl.toString();

                    $("#shortUrl").val(sl);

                }

            }

        });

    });

    $('#formSubscrib').on('keypress', function(e) {
        return e.which !== 13;
    });


    $("#submitSubscribe").click(function(){

        var email = $('#subscribe').val();

        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var cekEmail = regex.test(email);

        if(cekEmail) {
            $.ajax({

                url : "<?php echo base_url().index_with().'subscribe'; ?>",

                method : "POST",

                data : {email: email},

                async : false,

                dataType : 'json',

                success: function(data){

                    document.getElementById("subscribe").reset();

                }

            });
        } else {
            console.log('bukan email');
        }

    });



    $("#copyShort").click(function(){

        var url = $('#urlpress').val();

        $('#shortUrl').select();

        document.execCommand("copy");

    });





    $.fn.pressEnter = function(fn) {  



        return this.each(function() {  

            $(this).bind('enterPress', fn);

            $(this).keyup(function(e){

                if(e.keyCode == 13)

                {

                  $(this).trigger("enterPress");

              }

          })

        });  

    }; 



    $('#urlpress').pressEnter(function(){

        var url = $('#urlpress').val();



        $.ajax({

            url : "<?php echo base_url().index_with(); ?>getshort",

            method : "POST",

            data : {longurl: url,action: 'generateurl'},

            async : false,

            dataType : 'json',

            success: function(data){

                if(data.error.toString() === '0') {

                    var sl = data.shotrurl.toString();

                    $("#shortUrl").val(sl);

                }

            }

        });

    });  



    jQuery(document).ready(function($){



        $('#sizebanner').change(function() {

            // update disabled property

            $("#choseFile").attr('disabled', this.value == 0);

            $("#inputFile").attr('disabled', this.value == 0);

            $("#submt").attr('disabled', this.value == 0);

            $("#blah").removeAttr('src', this.value == 0);            

            // trigger change event to set initial value

        }).change();  





        <?php if(isset($errors)):?>

        <?php if(!empty($errors) || $errors != ''):?>

        $('#myModal').modal('show', function () {

            $(".modal-backdrop.in").hide();

        });

        <?php endif;?>

        <?php endif;?>  



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

</script>



<script>

    (adsbygoogle = window.adsbygoogle || []).push({});

</script>



</body>

</html>