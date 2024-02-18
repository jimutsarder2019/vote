<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISPAB Voter List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
          <a class="navbar-brand" href="#">Voter List</a>
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
            <form class="d-flex me-3" role="search">
              <input class="form-control me-2" type="search" placeholder="Search voter list" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <!-- <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-disabled="true">Login</a>
              </li>
            </ul> -->
          </div>
        </div>
      </nav>
    </header>
    <section class="py-5 main-sec">
      <div class="container">
        <h1>ISPAB Associate Members Voter List-2024</h1>

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
                      <div class="mb-3 col-auto">
                        <label for="name" class="form-label"><strong>Type</strong> Company Name / Owner's Name / Mobile Number / Email / ISPAB Member ID</label>
                        <input type="name" class="form-control" id="name" aria-describedby="typeName">
                      </div>
                    <div class="col-auto">
                      <button type="button" class="btn btn-primary mt-3 px-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Search</button>
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
                      <div class="mb-3 col-auto">
                        <label for="name" class="form-label"><strong>Type</strong> Company Name / Owner's Name / Mobile Number / Email / ISPAB Member ID</label>
                        <input type="name" class="form-control" id="name" aria-describedby="typeName">
                      </div>
                    <div class="col-auto">
                      <button type="button" class="btn btn-primary mt-3 px-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Search</button>
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
                <label class="col-sm-4 pt-3"><strong>Company Name</strong></label>
                <div class="col-sm-8 pt-3"><label>: ABC Company Limited</label></div>

                <label class="col-sm-4 pt-3"><strong>Voter Name</strong></label>
                <div class="col-sm-8 pt-3"><label>: Md. Ahasan Habib</label></div>

                <label class="col-sm-4 pt-3"><strong>Voter No</strong></label>
                <div class="col-sm-8 pt-3"><label>: 547EDFD156</label></div>

                <label class="col-sm-4 pt-3"><strong>Membership Level</strong></label>
                <div class="col-sm-8 pt-3"><label>: Premium</label></div>

                <label class="col-sm-4 pt-3"><strong>Address</strong></label>
                <div class="col-sm-8 pt-3"><label>: 123, Khulna, Bangladesh.</label></div>
              </div>

              <div class="col-md-4 text-right">
                <img class="voter-img justify-content-right" src="assets/medias/voter.jpg" height="auto">
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

<footer class="mt-5 pt-5 bg-light text-center">
  <div class="container-fluid">
    <div class="row pb-5">
      <div class="col-md-12">
        <p>For details of eligibility criteria or any other additional information related to voter froms kindly visit www.ispab.org</p>
        <!-- <p>For any other technical feedback or issues on the portal kindly send your feedback to <a href="#">ESPAB Support</a></p> -->
      </div>
    </div>
    
  </div>
  <div class="footer-bottom bg-dark tex-center">
      <h6 class="elementor-heading-title elementor-size-default">Copyright © 2024</h6>
</div>
</footer>



<div class="onload-popup">
  <div id="myModalOnload" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <img src="assets/medias/under-construction.jpg" width="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

    <script>
      $(document).ready(function(){
          $("#myModalOnload").modal('show');
      });
    </script>
  </body>
</html>