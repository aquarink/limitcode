<div class="layout-footer">

	<div class="layout-footer-body">

		<small>All right reserved <a target="__blank" href="http://mobiwin.co.id">Mobiwin</a>.</small>

	</div>

</div>

</div>



<script type="text/javascript">

    var baseurl = "<?php echo base_url(); ?>";

</script>



<script src="<?php echo base_url(); ?>layout/elephant/js/vendor.min.js"></script>

<script src="<?php echo base_url(); ?>layout/elephant/js/elephant.min.js"></script>

<script src="<?php echo base_url(); ?>layout/elephant/js/application.min.js"></script>


<?php if(isset($chart)):?>
<script src="<?php echo base_url(); ?>layout/chartjs/Chart.js"></script>
<script>
var ctx = document.getElementById("myChart");

var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: [<?php if(isset($label)) { echo $label;} ?>],
        datasets: [
        {
            label: 'Views in Times',
            data: [<?php if(isset($view)) { echo $view;} ?>],
            backgroundColor: [
                <?php if(isset($dataLimit)): ?>
                <?php foreach($dataLimit as $limit): ?>
                '#12e081',
                <?php endforeach; ?>
                <?php endif; ?>
            ],
            borderWidth: 1
        },
        {
            label: 'Bounce in Minutes',
            data: [<?php if(isset($bounce)) { echo $bounce;} ?>],
            backgroundColor: [
            <?php if(isset($dataLimit)): ?>
                <?php foreach($dataLimit as $limit): ?>
                '#125be0',
                <?php endforeach; ?>
                <?php endif; ?>
            ],
            borderWidth: 1
        }
        ],
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php endif; ?>


<script type="text/javascript">    



	jQuery(document).ready(function($){



        $("#repass").keyup(function(){

            var pass = $("#pass").val();

            var repass = $("#repass").val();



            if(pass !== repass) {

                $("#changepassbtn").prop("disabled", true);

            } else {

                $("#changepassbtn").prop("disabled", false);

            }



        });



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



    function readImageThumPop(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();



            reader.onload = function (e) {



                console.log(e);

                $('#blah')

                .show()

                .attr('src', e.target.result)

                .width(200);

            };



            reader.readAsDataURL(input.files[0]);

        }

    }



    function readImageThumPopKtp(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();



            reader.onload = function (e) {



                console.log(e);

                $('#blahKtp')

                .show()

                .attr('src', e.target.result)

                .width(200);

            };



            reader.readAsDataURL(input.files[0]);

        }

    }



	function readURL(input) {

		if (input.files && input.files[0]) {

			var reader = new FileReader();



            var sizeChoose = $('#sizebanner').val();



            var splitSize = sizeChoose.split('x');



            reader.onload = function (e) {

            $('#blah')

            .show()

            .attr('src', e.target.result)

            .width(200);



            var img = new Image();

            img.onload = function() {





                if(splitSize[0].toString() !== this.width.toString() && splitSize[1].toString() !== this.height.toString()) {

                    $("#blah").removeAttr('src');

                    $("#submt").attr('disabled', true);

                    $('#bannerMsg').modal('show', function () {

                        $(".modal-backdrop.in").hide();

                    });

                }

            }

            

            img.src = e.target.result;



            };



        reader.readAsDataURL(input.files[0]);

      }

    }

  </script>

</body>

</html>