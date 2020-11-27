<!DOCTYPE html>
<html lang="en" class="deeppurple-theme">
    <head>
        <title><?php COMPANY ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<script type="text/javascript">
//Fungsi untuk logout otomatis Jika 5 menit tidak ada aktifitas
function ceksession(){

	$.ajax({
	type : 'POST',
	url  : "<?php echo base_url('login/check_session'); ?>",
	success : function(data){
		if(data == 1){
			
		}else{
		  document.location.href = "<?php echo base_url('login/logout'); ?>"
		} 
	}
	});
	
}


setInterval("ceksession()", 1800000);
</script>

<!-- Home -->

    <link rel="stylesheet" href="<?php echo base_url('assets/mobile') ?>/vendor/materializeicon/material-icons.css">

    <!-- Roboto fonts CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/mobile') ?>/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link href="<?php echo base_url('assets/mobile') ?>/vendor/swiper/css/swiper.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/mobile') ?>/css/style.css" rel="stylesheet">

<body>
    <div class="row no-gutters vh-100 loader-screen">
        <div class="col align-self-center text-white text-center">
            <h1 class="mt-3"><span class="font-weight-light ">Scan</span>mobile</h1>
            <p class="text-mute text-uppercase small">Mobile Aplication</p>
            <div class="laoderhorizontal">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div class="mt-4 mb-3">
            <div class="row">
                <div class="col-auto">
                    <figure class="avatar avatar-60 border-0"><img src="<?php echo base_url('assets/mobile') ?>/img/user1.png" alt=""></figure>
                </div>
                <div class="col pl-0 align-self-center">
                    <h5 class="mb-1"><?php echo $this->session->userdata("username") ?></h5>
                    <p class="text-mute small">Work, London, UK</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="list-group main-menu">
                    <a href="index.html" class="list-group-item list-group-item-action active"><i class="material-icons icons-raised">home</i>Home</a>
                    <a href="notification.html" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">notifications</i>Notification <span class="badge badge-dark text-white">2</span></a>
                    <a href="alltransactions.html" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">find_in_page</i>History</a>
                    <a href="setting.html" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">important_devices</i>Settings</a>
                    <a href="<?php echo base_url('login/logout') ?>" class="list-group-item list-group-item-action"><i class="material-icons icons-raised bg-danger">power_settings_new</i>Logout</a>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" class="closesidemenu"><i class="material-icons icons-raised bg-dark ">close</i></a>
    <div class="wrapper homepage">
        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i><span class="new-notification"></span></button>
                </div>
                <div class="col text-center"><img src="img/logo-header.png" alt="" class="header-logo"></div>
                <div class="col-auto">
                    <a href="notification.html" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">9+</span></a>
                </div>
            </div>
        </div>
        <!-- header ends -->

        <div class="container">
            <div class="card bg-template shadow mt-4 h-190">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60"><img src="img/user1.png" alt=""></figure>
                        </div>
                        <div class="col pl-0 align-self-center">
                            <h5 class="mb-1"><?php echo $this->session->userdata("username") ?></h5>
                            <p class="text-mute small">Work, London, UK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container top-100">
            <div class="card mb-4 shadow">
                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col">
                            <h5 class="mb-0 font-weight-normal"><?php echo date('Y-m-d H:i:s') ?></h5>
                            <p class="text-mute">Last Input</p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-default btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"><i class="material-icons">add</i></button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-none">
                    <div class="row">
                        <div class="col">
                            <p>71.00 <i class="material-icons text-danger vm small">arrow_downward</i><br><small class="text-mute">INR</small></p>
                        </div>
                        <div class="col text-center">
                            <p>1.00 <i class="material-icons text-success vm small">arrow_upward</i><br><small class="text-mute">USD</small></p>
                        </div>
                        <div class="col text-right">
                            <p><i class="material-icons text-success vm small mr-1">arrow_upward</i>0.78<br><small class="text-mute">GBP</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="swiper-container icon-slide mb-4">
                    <div class="swiper-wrapper">
                        <a href="#" class="swiper-slide text-center" data-toggle="modal" data-target="#sendmoney">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons text-template">send</i>
                            </div>
                            <p class="small mt-2">Send</p>
                        </a>
                        <a href="#" class="swiper-slide text-center" data-toggle="modal" data-target="#bookmodal">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons text-template">directions_railway</i>
                            </div>
                            <p class="small mt-2">New Data</p>
                        </a>
                        <a href="#" class="swiper-slide text-center">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons text-template">assignment</i>
                            </div>
                            <p class="small mt-2">Bills</p>
                        </a>
                        <a href="#" class="swiper-slide text-center">
                            <div class="avatar avatar-60 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons text-template">camera</i>
                            </div>
                            <p class="small mt-2">History</p>
                        </a>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
		
        <div class="container">
            <h6 class="subtitle">History</h6>
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto pr-0">
                            <div class="avatar avatar-50 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons vm text-template">local_atm</i>
                            </div>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="font-weight-normal mb-1">EMI</h6>
                            <p class="text-mute small text-secondary">Home Loan</p>
                        </div>
                        <div class="col-auto align-self-center border-left">
                            <h6 class="font-weight-normal mb-1">1548</h6>
                            <p class="text-mute small text-secondary">Scan: 15-12-2019</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow border-0 mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto pr-0">
                            <div class="avatar avatar-50 no-shadow border-0">
                                <div class="overlay bg-template"></div>
                                <i class="material-icons vm text-template">local_atm</i>
                            </div>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="font-weight-normal mb-1">EMI</h6>
                            <p class="text-mute small text-secondary">Home Loan</p>
                        </div>
                        <div class="col-auto align-self-center border-left">
                            <h6 class="font-weight-normal mb-1">1658</h6>
                            <p class="text-mute small text-secondary">Scan: 18-12-2019</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		

    </div>

    <!-- notification -->
    <div class="notification bg-white shadow-sm border-primary">
        <div class="row">
            <div class="col-auto align-self-center pr-0">
                <i class="material-icons text-primary md-36">fullscreen</i>
            </div>
            <div class="col">
                <h6>Viewing in Phone?</h6>
                <p class="mb-0 text-secondary">Double tap to enter into fullscreen mode for each page.</p>
            </div>
            <div class="col-auto align-self-center pl-0">
                <button class="btn btn-link closenotification"><i class="material-icons text-secondary text-mute md-18 ">close</i></button>
            </div>
        </div>
    </div>
    <!-- notification ends -->


    <!-- Modal -->
    <div class="modal fade" id="addmoney" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center pt-0">
                    <img src="img/infomarmation-graphics2.png" alt="logo" class="logo-small">
                    <div class="form-group mt-4">
                        <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                    </div>
                    <p class="text-mute">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="sendmoney" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5>Send Money</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="form-group mt-4">
                        <select class="form-control form-control-lg text-center">
                            <option>Mrs. Magon Johnson</option>
                            <option selected>Ms. Shivani Dilux</option>
                        </select>
                    </div>

                    <div class="card shadow border-0 mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <div class="avatar avatar-60 no-shadow border-0">
                                        <img src="img/user2.png" alt="">
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                    <p class="text-mute small text-secondary">London, UK</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-4">
                        <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                    </div>
                    <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5>Pay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline1">To Bill</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" checked>
                        <label class="custom-control-label" for="customRadioInline2">To Person</label>
                    </div>

                    <div class="form-group mt-4">
                        <select class="form-control text-center">
                            <option>Mrs. Magon Johnson</option>
                            <option selected>Ms. Shivani Dilux</option>
                        </select>
                    </div>

                    <div class="card shadow border-0 mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <div class="avatar avatar-60 no-shadow border-0">
                                        <img src="img/user2.png" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center">
                                    <h6 class="font-weight-normal mb-1">Ms. Shivani Dilux</h6>
                                    <p class="text-mute small text-secondary">London, UK</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-4">
                        <input type="text" class="form-control form-control-lg text-center" placeholder="Enter amount" required="" autofocus="">
                    </div>
                    <p class="text-mute text-center">You will be redirected to payment gatway to procceed further. Enter amount in USD.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="bookmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5>Pay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline12" name="customRadioInline12" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline12">Flight</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline22" name="customRadioInline12" class="custom-control-input" checked>
                        <label class="custom-control-label" for="customRadioInline22">Train</label>
                    </div>
                    <h6 class="subtitle">Select Location</h6>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control text-center" placeholder="Select start point" required="" autofocus="">
                    </div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control text-center" placeholder="Select end point" required="">
                    </div>
                    <h6 class="subtitle">Select Date</h6>
                    <div class="form-group mt-4">
                        <input type="date" class="form-control text-center" placeholder="Select end point" required="">
                    </div>
                    <h6 class="subtitle">number of passangers</h6>
                    <div class="form-group mt-4">
                        <select class="form-control  text-center">
                            <option>1</option>
                            <option selected>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                        </select>
                    </div>                    
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-lg btn-rounded shadow btn-block" class="close" data-dismiss="modal">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery, popper and bootstrap js -->
    <script src="<?php echo base_url('assets/mobile') ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url('assets/mobile') ?>/js/popper.min.js"></script>
    <script src="<?php echo base_url('assets/mobile') ?>/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- swiper js -->
    <script src="<?php echo base_url('assets/mobile') ?>/vendor/swiper/js/swiper.min.js"></script>

    <!-- cookie js -->
    <script src="<?php echo base_url('assets/mobile') ?>/vendor/cookie/jquery.cookie.js"></script>

    <!-- template custom js -->
    <script src="<?php echo base_url('assets/mobile') ?>/js/main.js"></script>

    <!-- page level script -->
    <script></script>

</body>

</html>



