<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FYP Monitoring Portal</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/img/assets/img/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
   
    <!--Style-->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/styles.css">
 
</head>

<body id="page-top">
    <div class="wrapper" id="app"></div>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="">FYP Monitoring Portal</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    @if(Route::has('login'))

                        @auth
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ url('/home') }}">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('login') }}">Login</a></li>

                            @if(Route::has('register'))
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('register') }}">Register</a></li>
                            @endif
                        @endauth

                    @endif
                    <li class="nav-item"><a class="nav-link " href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link " href="#services">User Guidence</a></li>
                    <li class="nav-item"><a class="nav-link " href="#portfolio">Recent Projects</a></li>
                    <li class="nav-item"><a class="nav-link " href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class=" container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-uppercase text-white font-weight-bold">Faculty of Computing
                    </h1>
                    <hr class="divider my-4" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 font-weight-light text-bright mb-5">An automated platform to manage Documents and
                        Projects of Students.
                    </p>

                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primaryy" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">We've got what you need!</h2>
                    <hr class="divider light my-4" />
                    <p class="text-white-50 mb-4">Final Year Project Monitoring System is a web-based solution developed for Universities
                        which automates tasks of Final Year Projects. FYP monitoring System manages all the
                        processes involved in Final year projects and also keep repository of all projects.</p>

                </div>
            </div>
        </div>
    </section>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <h2 class="text-center mt-0"></h2>
            <hr class="divider my-4" />
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <a  data-toggle="modal" data-target="#adminModal">
                            <i  class="fas animate fa-4x fa-users-cog text-primary mb-4"></i>
                        </a>   
                        <h3 class="h4 mb-2">Admin</h3>
                         </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <a  data-toggle="modal" data-target="#supervisorModal">
                            <i class="fas animate fa-4x fa-chalkboard-teacher text-primary mb-4"></i>
                        </a>  
                      
                        <h3 class="h4 mb-2">Supervisor</h3>
                            </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">

                        <a  data-toggle="modal" data-target="#externalModal">
                            <i class="fas animate fa-4x fa-user-check text-primary mb-4"></i>
                        </a>  
                    
                        <h3 class="h4 mb-2">External Examiner</h3>
                          </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <a  data-toggle="modal" data-target="#studentsModal">
                            <i class="fas animate fa-4x fa-user-graduate text-primary mb-4"></i>
                        </a>  
                        
                        <h3 class="h4 mb-2">Students</h3>
                             </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio-->
    <div id="portfolio">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/1.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/1.jpg" alt="" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Project No 1</div>
                            <div class="project-name">MIT Cheetah</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/2.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/2.jpg" alt="" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Project No 2</div>
                            <div class="project-name">Data Science</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/3.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/3.jpg" alt="" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Project No 3</div>
                            <div class="project-name">Website</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/4.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/4.jpg" alt="" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Project No 4</div>
                            <div class="project-name">Java Applicstion</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/5.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/5.jpg" alt="" />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Project No 5</div>
                            <div class="project-name">Client Server Application</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="/img/assets/img/portfolio/fullsize/6.jpg">
                        <img class="img-fluid" src="/img/assets/img/portfolio/thumbnails/6.jpg" alt="" />
                        <div class="portfolio-box-caption p-3">
                            <div class="project-category text-white-50">Project No 6</div>
                            <div class="project-name">FYP Mpnitoring Portal</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact-->
    <section class="page-section" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mt-0">Let's Get In Touch!</h2>
                    <hr class="divider my-4" />
                    <p class="text-muted mb-5">Do You have any Query? Give us a call or send us an
                        email and we will get back to you as soon as possible!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                    <i class="fas fa-phone animate fa-3x mb-3 text-primary"></i>
                    <div>+92306-2612 585</div>
                </div>
                <div class="col-lg-4 mr-auto text-center">
                    <i class="fas fa-envelope animate fa-3x mb-3 text-primary"></i><a class="d-block"
                        href="contact@yourwebsite.com">mbilaldanish786@.gmailcom</a>
                </div>
            </div>
        </div>


        <!--//////////////////////////////////////////////////////////////////////////////////////-->
        <!-- Modal -->
<div class="modal fade " id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="adminModalLabel">Admin User Manual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <ol >
                <li><strong>User Management:</strong>Admin can Add, Delete, Update Users from Management under Control Panel in Admin Dashboard</li>
                <li><strong>Chat:</strong>Open chat room ,select User, Type Message and send</li>
                <li><strong>Manage Document:</strong>Open View Documents and Select Document and Compare, Delete, Update and view Documents</li>
                <li><strong>Manage All Document:</strong>Open View all Documents and Select Document and Compare, Delete, Update and view Documents</li>
                <li><strong>Edit Profile:</strong>Open Edit Profile under control panel and Fill all Feilds and submit </li>
                <li><strong>Recover Password:</strong>Open Login Form,Click on Forgot Password, Enter Email, Recover Password using reset Password Link which will be received in Email Inbox </li>
            </ol>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success  rounded-0" data-dismiss="modal">Close</button>
       
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade rounded-0" id="supervisorModal" tabindex="-1" role="dialog" aria-labelledby="supervisorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content   rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="supervisorModalLabel">Supervisor User Manual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <ol >
                <li><strong>Chat:</strong>Open chat room ,select User, Type Message and send</li>
                <li><strong>Manage Document:</strong>Open View Documents and Select Document and Compare, Delete, Update and view Documents</li>
                <li><strong>Edit Profile:</strong>Open Edit Profile under control panel and Fill all Feilds and submit </li>
                <li><strong>Recover Password:</strong>Open Login Form,Click on Forgot Password, Enter Email, Recover Password using reset Password Link which will be received in Email Inbox </li>
            </ol>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success   rounded-0" data-dismiss="modal">Close</button>
  
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade rounded-0" id="externalModal" tabindex="-1" role="dialog" aria-labelledby="externalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content   rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="externalModalLabel">External Examiner User Manual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <ol >
               <li><strong>Chat:</strong>Open chat room ,select User, Type Message and send</li>
                <li><strong>Manage Document:</strong>Open View Documents and Select Document and Compare, Delete, Update and view Documents</li>
                <li><strong>Manage All Document:</strong>Open View all Documents and Select Document and Compare, Delete, Update and view Documents</li>
                <li><strong>Edit Profile:</strong>Open Edit Profile under control panel and Fill all Feilds and submit </li>
                <li><strong>Recover Password:</strong>Open Login Form,Click on Forgot Password, Enter Email, Recover Password using reset Password Link which will be received in Email Inbox </li>
            </ol>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success    rounded-0"  data-dismiss="modal">Close</button>
 
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<div class="modal fade rounded-0" id="studentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content   rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Students User Manual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <ol >
                 <li><strong>Chat:</strong>Open chat room ,select User, Type Message and send</li>
                <li><strong>Manage Document:</strong>Open Manage Documents and You can update, Delete, Add Documents over there</li>
               <li><strong>Edit Profile:</strong>Open Edit Profile under control panel and Fill all Feilds and submit </li>
                <li><strong>Recover Password:</strong>Open Login Form,Click on Forgot Password, Enter Email, Recover Password using reset Password Link which will be received in Email Inbox </li>
            </ol>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success    rounded-0" data-dismiss="modal">Close</button>
        
        </div>
      </div>
    </div>
  </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container">
            <div class="small text-center text-muted">Copyright © 2020 - MBD WEB Tech</div>
        </div>
    </footer>
    <!-- Third party plugin JS-->
   <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- REQUIRED SCRIPTS -->
    <script src="/js/app.js"></script>

    <script src="/js/scripts.js"></script>
  
</body>

</html>
