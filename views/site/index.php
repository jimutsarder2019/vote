<?php
use yii\helpers\Url;
$baseUrl = Url::base();


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISPAB Voter List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/custom/css/style.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <style>
	img.voter-img{
		width:200px;
	}
	
	@media (max-width: 767px) {
	  .chosen-container {
		width: 300px !important;
	  }
	}
	</style>
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary py-0">
        <div class="container">
          <a class="navbar-brand" href="#"><img src="web/image/logo.png" width="150px"></a>
          <a class="navbar-brand" href="#"> Voter List</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="#">About Us</a>
              </li> -->
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link d-inline-block" aria-disabled="true" href="https://www.facebook.com/profile.php?id=61556949321159"><img src="web/image/facebook.svg" width="20px"></a>
                <a class="nav-link d-inline-block" aria-disabled="true" href="https://chat.whatsapp.com/E0OotRE5XpwGfHFnO3YQmi"><img src="web/image/whatsapp.svg" width="20px"></a>
              </li>
              <li class="nav-item ps-2">
                <p id="demo" class="mb-0 pt-2" style="font-size: 18px;border: 1px solid #bfbfbf;border-radius: 100px;padding: 8px 20px;background: #ededed;"></p>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <section class="py-5 main-sec" style="height: 80vh;">
      <div class="container">
        <div class="text-center pb-3">
          <img src="web/image/logo-big.png" width="400px">
          <h1>ISPAB Associate Members Voter List-2024</h1>
        </div>

        <ul class="nav nav-pills mt-5" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active brand-color" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Thana</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link brand-color" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">District</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            


            

          <div class="card" >
            <div class="card-body py-5">
                <form>
                  <div class="row g-3 align-items-center">
                      <div class="col-auto">
						<div>
							<select id="js_search_thana" data-placeholder="Choose Company..." class="chosen-select" style="width:350px;" tabindex="4">
								<option value=""></option>
								<?php if(isset($company_thana) && !empty($company_thana)){ ?>
									<?php foreach($company_thana as $thana){ ?>
										<option><?=$thana?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					  </div>
                    <div class="col-auto">
                      <button data-type="thana" type="button" class="btn btn-primary mt-3 px-5 js_voter_details">Search</button>
                    </div>
                  </div>
                </form>
            </div>
          </div>

          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            
            <div class="card" >
            <div class="card-body py-5">
                <form>
                  <div class="row g-3 align-items-center">
                      <div class="col-auto">
						<div>
						<select id="js_search_district" data-placeholder="Choose Company..." class="chosen-select" style="width:350px;" tabindex="4">
							<option value=""></option>
							<?php if(isset($company_district) && !empty($company_district)){ ?>
								<?php foreach($company_district as $district){ ?>
									<option><?=$district?></option>
								<?php } ?>
							<?php } ?>
						</select>
						</div>
                      </div>
                    <div class="col-auto">
                      <button data-type="district" type="button" class="btn btn-primary mt-3 px-5 js_voter_details">Search</button>
                    </div>
                  </div>
                </form>
            </div>
          </div>


          </div>
        </div>

      </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Voter Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="details">
            
             <div class="mb-3 row">
              <div class="col-md-8 row">
                <label class="col-sm-4 pt-3"><strong>Company Name: </strong></label>
                <div class="col-sm-8 pt-3"><label class="company_name"></label></div>

                <label class="col-sm-4 pt-3"><strong>Voter Name: </strong></label>
                <div class="col-sm-8 pt-3"><label class="voter_name"></label></div>

                <label class="col-sm-4 pt-3"><strong>Voter No: </strong></label>
                <div class="col-sm-8 pt-3"><label class="voter_no"></label></div>

                <label class="col-sm-4 pt-3"><strong>Membership Level: </strong></label>
                <div class="col-sm-8 pt-3"><label class="membership"></label></div>

                <label class="col-sm-4 pt-3"><strong>Address: </strong></label>
                <div class="col-sm-8 pt-3"><label class="address"></label></div>
              </div>

              <div class="col-md-4 text-right js_profile">
                
              </div>

            </div>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<footer class="mt-5 pt-5 bg-light text-center" style="padding-top:5em;">
  <div class="container-fluid">
    <div class="row pb-5">
      <div class="col-md-12">
        <p>All information is collected from the voter list published by ISPAB  (Date of publish February 06, 2024).</p>
        <!-- <p>For any other technical feedback or issues on the portal kindly send your feedback to <a href="#">ESPAB Support</a></p> -->
      </div>
    </div>
    
  </div>
  <div class="footer-bottom bg-dark d-flex justify-content-between px-5">
      <h6 class="elementor-heading-title elementor-size-default align-self-center py-0"> Copyright © 2024</h6>
      <h6 class="elementor-heading-title elementor-size-default py-0" style="font-size:12px; ">Design & Developed by <a href="https://www.facebook.com/profile.php?id=61556949321159"><img src="web/image/footer-logo.png" width="50px" style="padding-left:12px;"></a></h6>
</div>
</footer>


<?php if(isset($popup) && $popup){?>
<div class="onload-popup">
  <div id="myModalOnload" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <img src="<?=$baseUrl?>/<?=$popup?>" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

	<script src="<?=$baseUrl?>/js/choosen.js"></script> 
</head>

    <script>
	  var search_string = '';
      $(document).ready(function(){
		  
		  
		  /*
		  var company_district = new Array();
		  <?php foreach($company_district as $key => $val){ ?>
			company_district.push("<?php echo $val; ?>");
		  <?php } ?>
		  
		  var company_thana = new Array();
		  <?php foreach($company_thana as $key => $val){ ?>
			company_thana.push("<?php echo $val; ?>");
		  <?php } ?>
	
	
		  $( "#js_search_district" ).autocomplete({
			  source: company_district
		  });
		  
		  $( "#js_search_thana" ).autocomplete({
			  source: company_thana
		  });*/
	
	
          $("#myModalOnload").modal('show');
		  
		  $('.js_voter_details').click(function(){
			    search_string = '';
			    var type = $(this).data('type');
				getVoterDetails(type);
				//exampleModal
		  });
		  
		    $('.chosen-select').chosen({ width: '600px' }).change( function(obj, result) {
				search_string = '';
				search_string = result.selected;
			});
      });
	  
	  function getVoterDetails(type)
      {
		$(".company_name").html('-');
		$(".voter_name").html('-');
		$(".voter_no").html('-');
		$(".membership").html('-');
		$(".address").html('-');
		var search = $('#js_search_'+type).val();
		if(search){
			if(search.length > 2){
				$('.data-render').html('<tr><td style="color:#FF0000">Loading......</td></tr>');
				$.ajax({  
					url: '<?=$baseUrl?>'+'/?r=api/voter',
					type: 'POST',
					dataType: 'JSON',
					data:{
						search:search,
						type:type
					},		
					success: function(response) {   
						if(response.voters){
							$('.js_search').val('');
							$(".company_name").html(response.voters.company);
							$(".voter_name").html(response.voters.name);
							$(".voter_no").html(response.voters.voter_no);
							$(".membership").html(response.voters.ispab_member);
							$(".address").html(response.voters.address);
							$(".js_profile").html('<img class="voter-img justify-content-right" src="<?=$baseUrl?>/uploads/profile/'+response.voters.voter_no+'.png" height="auto">');
							$("#exampleModal").modal('show');
						}else{
							$('.js_search').val('');
							alert('No data found!');
						}				
					}  
				});
			}else{
				alert('Minimum Search string limi 3!');
			}
		}else{
			alert('Search string missing!');
		}
		
     }

    </script>

    <script>
      // Set the date we're counting down to
      var countDownDate = new Date("May 5, 2024 15:37:25").getTime();

      // Update the count down every 1 second
      var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();
          
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
          
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          
        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
          
        // If the count down is over, write some text 
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("demo").innerHTML = "EXPIRED";
        }
      }, 1000);
      </script>
  </body>
</html>