<?php
use yii\helpers\Url;
$baseUrl = Url::base();


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="shortcut icon" href="web/image/fav.png">
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
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <section class="py-5 main-sec" style="margin-bottom: 10em;">
      <div class="container">
        <div class="text-center pb-3">
          <img src="web/image/logo-big.png" width="400px">
          <h1>ISPAB Associate Members Voter List-2024</h1>
          <p id="demo" class="mb-0 pt-2" style="font-size: 18px;border-radius: 100px;padding: 8px 20px;background: #ededed;display: inline-block;letter-spacing: 5px;"></p>
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


<section class="participation-candidate">
  <div class="container">
    <h1 class="text-center py-3 mb-3"><strong>ISPAB স্বত্বাধিকারী</strong></h1>
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="participation-candidate-details">
          <img src="web/image/zubair.jpg" width="100%">
          <div class="py-3 text-center">
            <h3 class="pc-name"><strong>মোঃ জুবায়ের ইসলাম</strong></h3>
            <p class="my-0">স্বত্বাধিকারী, জুবায়ের আইটি এক্সপার্ট</p>
          </div>
          <p class="text-center" style="text-align:justify !important;">মোঃ জুবায়ের ইসলাম দ্রুতগতির ইন্টারনেট সার্ভিস সেবা জনগণের দ্বোরগোড়ায় পৌঁছে দেবার  লক্ষ্যে ২০১৬ সালে  জুবায়ের আইটি এক্সপার্ট প্রতিষ্ঠা করেন ও বিটিআরসির লাইসেন্স এর জন্য আবেদন করেন। ২০১৭ সালে জুবায়ের আইটি এক্সপার্ট বি ক্যাটাগরির লাইসেন্স প্রাপ্ত হয় এবং ইন্টারনেট ইন্টারনেট সার্ভিস প্রোভাইডিং  শুরু করে। উন্নত মানের ব্যান্ডউইথ ও যুগোপযোগী কাস্টমার কেয়ার সেবার প্রদানের কারণে অল্প কিছুদিনের মধ্যেই জুবায়ের আইটি এক্সপার্ট প্রবল জনপ্রিয় হয়ে ওঠে। পরবর্তীতে ২০১৯ সালে শহরে লাইসেন্সপ্রাপ্ত  ইন্টারনেট সার্ভিস প্রোভাইটেডদেরকে সংগঠিত করে ' খুলনা ইন্টারনেট ব্যবসায়ী সমিতি' নামে  শ্রম মন্ত্রণালয়ের অন্তর্ভুক্ত একটি সংগঠন প্রতিষ্ঠা করেন। যা উনার যোগ্য নেতৃত্বে  পরবর্তীতে খুলনার শহরে আইএসপি ব্যবসায়ীদের জন্য একটি সুন্দর ব্যবসায়ী পরিবেশ নিশ্চিত করতে সক্ষম হয়। এরই ধারাবাহিকতায় ২০২০ সালে ইন্টারনেট ব্যবসায়ী সমিতির অন্তর্ভুক্ত সদস্যদের সব ধরনের সহযোগিতা দিয়ে ইন্টারনেট সার্ভিস প্রোভাইডারদের জাতীয় সংগঠন  আইএসপিএবির অন্তর্ভুক্ত হতে সহায়তা করেন। মাননীয় প্রধানমন্ত্রীর স্বপ্নের ডিজিটাল বাংলাদেশ গড়ার লক্ষ্যে উদ্যমী উদ্যোক্তাদের  আইএসসি ব্যবসায় উদ্বুদ্ধ করতে ২০২২ সাল থেকে "জুবায়ের ভাই" নামে একটি ইউটিউব চ্যানেল পরিচালনা করছেন, যা আইএসপি ব্যবসা সংক্রান্ত প্রয়োজনীয় সকল ধরনের কনটেন্ট তৈরি করে থাকে। বর্তমানে আইএসপি ব্যবসায় প্রয়োজনীয় লিগ্যাল ডকুমেন্টস এর জন্য "জুবায়ের ভাই" একটি নির্ভরতার নাম। উনি ২০১৪ সালে লন্ডনের ইউনিভার্সিটি অব গ্রিনউইচ থেকে মেকানিক্যাল ইঞ্জিনিয়ারিং  স্নাতক সম্পন্ন করেন, এবং পরবর্তীতে নেটওয়ার্কিং বিষয়ে বিভিন্ন প্রশিক্ষণে অংশগ্রহণ করেন।</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="participation-candidate-details">
          <img src="web/image/arman.jpg" width="100%">
          <div class="py-3 text-center">
            <h3 class="pc-name"><strong>মোঃ আরমান হোসেন</strong></h3>
            <p class="my-0">স্বত্বাধিকারী, ফ্রিডম অনলাইন</p>
          </div>
          <p class="text-center" style="text-align:justify !important;">"ফ্রিডম অনলাইন"
ইন্টারনেট ব্যবসায়ীদের অসুবিধা নিরসনের অপর নাম ফ্রিডম অনলাইন।

ফ্রিডম অনলাইন বিটিআরসি থেকে লাইসেন্সর জন্য আবেদন করে  এবং ২০১৮ সালে লাইসেন্স গ্রহণ করে মিরপুর পল্লবী এলাকায় ফ্রিডম অনলাইন সুনামের সাথে  মানসম্মত দ্রুতগতির  ব্রডব্যান্ড  ইন্টারনেট সেবা  প্রদান করে আসছেন এবং একই সাথে উন্নত মানের গ্রাহক সেবা প্রদান করে আসছেন।
ইতিমধ্যে  মিরপুর পল্লবী এলাকায় ফ্রিডম অনলাইন সুপরিচিত  ইন্টারনেট সেবা প্রদানকারী প্রতিষ্ঠান হিসেবে ব্যাপক সুনাম অর্জন করেছেন।


মোঃ আরমান হোসেন  
সাধারণ ইন্টারনেট ব্যবসায়ী ভাইদের  বিভিন্ন সমস্যা নিয়ে কাজ করেছেন এবং করে যাচ্ছেন।
ইতিমধ্যে পল্লবী তে  বিভিন্ন স্থানে  এলাকা দখল নেটওয়ার্ক দখলের  মতো সমস্যা নিয়ে কাজ করেছেন এবং সমস্যা সমাধান করার চেষ্টা  
করে যাচ্ছেন।
উল্লেখ্য যে, মিরপুর সেকশন-১১ বাউনিয়াবাধ, মিরপুর-১১,সি ব্লক,মিরপুর-১১ এভিনিউ ৫ এলাকার বেশির ভাগ সমস্যা আইএসপিএবি এবং এলাকার ব্যবসায়ীর মাধ্যমে সমাধান করেছেন । 

থানা /উপজেলা লাইসেন্সধারী ব্যবসায়ীদের পক্ষে সব সময় প্রতিবাদী  কণ্ঠস্বর মোঃ আরমান হোসেন যেখানে অন্যায় হয়েছে সেখনেই কথা বলেছেন,প্রতিবাদ করেছেন সামর্থ্য অনুযায়ী।

বিটিআরসি- যখন লাইসেন্স আপগ্রেডেশন বন্ধ ঘোষণা করেন তখন মিরপুরে মেরিমেন্ট কমিউনিটি সেন্টারে সর্বপ্রথম 
১৪ই জানুয়ারি ২০২৩ ইং তারিখ প্রতিবাদের ডাক দেন।
এই ডাকে সারা দিয়ে বিপুল সংখ্যক  ঢাকা এবং  আশপাশের থানা উপজেলা ব্যবসায়ীগন উপস্থিত থেকে প্রতিবাদ সমর্থন করেন এবং ক্ষতিগ্রস্ত সাধারণ থানা উপজেলা আইএসপি  ব্যবসায়ীদের নিয়ে তীব্র আন্দোলন গড়ে তোলেন।</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="participation-candidate-details">
          <img src="web/image/alamgir.jpg" width="100%">
          <div class="py-3 text-center">
            <h3 class="pc-name"><strong>মোহাম্মদ আলমগির হোসেন</strong></h3>
            <p class="my-0">স্বত্বাধিকারী, ডিজিটাল কমিউনিকেশন</p>
          </div>
          <p class="text-center" style="text-align:justify !important;">মোহাম্মদ আলমগির হোসেন ২০১৫ সালের মাঝামাঝি ডিজিটাল কমিউনিকেশন প্রতিষ্ঠা মাধ্যমে দ্রুতগতির ইন্টারনেট সেবা প্রদান শুরু করেন। তিনি ১৯৯৫ সালে মোহাম্মদপুর কেন্দ্রীয় বিশ্ববিদ্যলয় কলেজ থেকে উচ্চ মাধ্যমিক সম্পূর্ণ করেন। এছাড়াও নিউ হরিজনস কম্পিউটার লার্নিং সেন্টার থেকে MOUSE, A+ Certification, MCSE, CWNA এবং এরিনা মাল্টিমিডিয়া থেকে ডিপ্লোমা ইন গ্রাফিক্স ডিজাইন সম্পুর্ন করেন। তিনি পাঠশালা থেকে ফটোজার্নালিজম উপর গ্রাজুয়েশন কোর্স সম্পন্ন করেন। তিনি দৈনিক ভোরের কাগজ পত্রিকায় লাইফস্টাইল, প্রযুক্তি ও ইনফোটেইনমেন্ট (ফিচার ডিপার্টমেন্ট) এ ফটোসাংবাদিক হিসেবের ১০ বছর কাজ করছেন। তিনি ২০০৬ সালে গঠিত লাইসেন্সবিহীন আইএসপিদের সংগঠন বিসিআইওএ – এর সাধারন সম্পাদক হিসেবে দায়িত্ব পালন করেন। এবং ২০০৭ – ২০০৮ সালে বিটিআরসিতে লাইসেন্সবিহীন আইএসপিদের লাইসেন্সের আওতায় আনার দাবি আদায়ে উক্ত সংগঠনে গুরুত্ব পূর্ণ দায়িত্ব পালন করেন। লোকাল ব্রডব্যান্ড নেটওয়ার্ক ওনার্স অ্যাসোসিয়েশানের প্রতিষ্ঠাতা সাধারন সম্পাদক হিসেবে দির্ঘদিন যাবত দায়িত্ব পালন করছেন। তিনি দির্ঘ ৫ বছর যাবত দলমত নির্বিষেশে আইএসপি এবং আইটি সেক্টরের সকল ব্যবসায়ীদের নিয়ে রসের মেলা নামে সর্ব বৃহৎ খেজুরের রস এবং গ্রাম বাংলা ঐতিহ্যের সঙ্গে যুক্ত খাবার নিয়ে রসের মেলা আয়োজন করে।</p>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="mt-5 pt-5 bg-light text-center" style="padding-top:5em;">
  <div class="container-fluid">
    <div class="row pb-5">
      <div class="col-md-12">
        <div class="mb-3">
          <a class="nav-link d-inline-block me-3" aria-disabled="true" href="https://www.facebook.com/profile.php?id=61556949321159"><img src="web/image/facebook.png" width="25px"></a>
          <a class="nav-link d-inline-block" aria-disabled="true" href="https://chat.whatsapp.com/E0OotRE5XpwGfHFnO3YQmi"><img src="web/image/whatsapp.png" width="30px"></a>
        </div>
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