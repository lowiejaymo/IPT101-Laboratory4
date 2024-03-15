<?php
session_start();

if (
  isset($_SESSION['user_id'])
) {
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | User Profile</title>
    <link rel="icon" type="image/ico" href="favicon.ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE-3.2.0/dist/css/adminlte.min.css">

    <style>
      .rounded-image {
        width: 5px;
        /* Adjust as needed */
        height: 5px;
        /* Adjust as needed */
        border-radius: 50%;
        /* Create a circular shape */
        object-fit: cover;
        /* Ensure the entire image is visible without stretching */
      }

      .profile-picture {
        width: 128px;
        /* Adjust as needed */
        height: 128px;
        /* Adjust as needed */
        object-fit: cover;
        border-radius: 50%;
        /* to make it circular */
      }

      .change-profile-picture {
        width: 500px;
        /* Adjust as needed */
        height: 500px;
        /* Adjust as needed */
        object-fit: cover;
        border-radius: 50%;
        /* to make it circular */
      }
    </style>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- Navbar -->
      <?php include 'layout/fixed-topnav.php'; ?>
      <!-- /.navbar -->

      <!-- --------------------------------------------------- -->

      <!-- including Main Sidebar Container -->
      <?php include 'layout/fixed-sidebar.php'; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                  </ol>
                </div>
              </div>


              <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger">
                  <?php echo $_GET['error']; ?>
                </div>
              <?php } ?>

              <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                  <?php echo $_GET['success']; ?>
                </div>
              <?php } ?>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">

                <!-- Profile Information Card -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="row justify-content-center">
                      <div class="text-center"> <!-- Center the column content -->
                        <!-- displaying the profile picture -->
                        <img class="profile-picture img-fluid rounded-circle"
                          src="profile-picture/<?php echo $_SESSION['profile_picture']; ?>?<?php echo time(); ?>"
                          alt="User profile picture">
                      </div>
                    </div>

                    <!-- Concatinating Full name -->
                    <h3 class="profile-username text-center">
                      <?php echo $_SESSION['First_name'] . ' ' . $_SESSION['Middle_name'] . ' ' . $_SESSION['Lastname']; ?>
                    </h3>
                    <!--  diplaying username starts with @ -->
                    <p class="text-muted text-center">@
                      <?php echo $_SESSION['username']; ?>
                    </p>
                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <!-- Displaying Lastname -->
                        <b>Last Name</b> <a class="float-right">
                          <?php echo $_SESSION['Lastname']; ?>
                        </a>
                      </li>
                      <li class="list-group-item">
                        <!-- Displaying First name -->
                        <b>First Name</b> <a class="float-right">
                          <?php echo $_SESSION['First_name']; ?>
                        </a>
                      </li>
                      <li class="list-group-item">
                        <!-- Displaying Middle name -->
                        <b>Middle Name</b> <a class="float-right">
                          <?php echo $_SESSION['Middle_name']; ?>
                        </a>
                      </li>
                      <li class="list-group-item">
                        <!-- Displaying Birthday -->
                        <b>Birthday</b>
                        <?php if ($_SESSION['Birthday'] != '0000-00-00'): ?>
                          <a class="float-right">
                            <?php echo $_SESSION['Birthday']; ?>
                          </a>
                        <?php endif; ?>
                      </li>
                      <li class="list-group-item">
                        <!-- Displaying gender -->
                        <b>Gender</b> <a class="float-right">
                          <?php echo $_SESSION['gender']; ?>
                        </a>
                      </li>
                      <li class="list-group-item">
                        <!-- Displaying Phone Number -->
                        <b>Phone Number</b>
                        <?php if ($_SESSION['phone_number'] != '0'): ?>
                          <a class="float-right">
                            <?php echo $_SESSION['phone_number']; ?>
                          </a>
                        <?php endif; ?>
                      </li>

                      <li class="list-group-item">
                        <!-- Displaying email -->
                        <b>Email Address</b> <a class="float-right">
                          <?php echo $_SESSION['email']; ?>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <!--  this section display's other informations such as address, occupation, education, skills, and notes -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- DIRI NA -->
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
                    <!--  displaying address -->
                    <p class="text-muted">
                      <?php
                      $address_parts = array();
                      if (!empty($_SESSION['street_building_house'])) {
                        $address_parts[] = $_SESSION['street_building_house'];
                      }
                      if (!empty($_SESSION['Barangay'])) {
                        $address_parts[] = $_SESSION['Barangay'];
                      }
                      if (!empty($_SESSION['City'])) {
                        $address_parts[] = $_SESSION['City'];
                      }
                      if (!empty($_SESSION['Province'])) {
                        $address_parts[] = $_SESSION['Province'];
                      }
                      if (!empty($_SESSION['Region'])) {
                        $address_parts[] = $_SESSION['Region'];
                      }
                      if (!empty($_SESSION['Postal_Code'])) {
                        $address_parts[] = $_SESSION['Postal_Code'];
                      }

                      echo implode(', ', $address_parts);
                      ?>
                    </p>
                    <!-- i concat ni later -->
                    <hr>
                    <!--  displaying Occupation -->
                    <strong><i class="fas fa-briefcase"></i> Occupation</strong>
                    <p class="text-muted">
                      <?php echo $_SESSION['Occupation']; ?>
                    </p>
                    <hr>
                    <!--  displaying Education -->
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>
                    <p class="text-muted">
                      <?php echo $_SESSION['Education']; ?>
                    </p>
                    <hr>
                    <!--  displaying Skills -->
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                    <p class="text-muted">
                      <?php echo $_SESSION['Skills']; ?>
                    </p>
                    <hr>
                    <!--  displaying Notes -->
                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                    <p class="text-muted">
                      <?php echo $_SESSION['Notes']; ?>
                    </p>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <!-- <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                      <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> -->
                      <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="AdminLTE-3.2.0/dist/img/user1-128x128.jpg"
                              alt="user image">
                            <span class="username">
                              <a href="#">Jonathan Burke Jr.</a>
                              <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                            </span>
                            <span class="description">Shared publicly - 7:30 PM today</span>
                          </div>
                          <!-- /.user-block -->
                          <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                          </p>

                          <p>
                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                            <span class="float-right">
                              <a href="#" class="link-black text-sm">
                                <i class="far fa-comments mr-1"></i> Comments (5)
                              </a>
                            </span>
                          </p>

                          <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post clearfix">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="AdminLTE-3.2.0/dist/img/user7-128x128.jpg"
                              alt="User Image">
                            <span class="username">
                              <a href="#">Sarah Ross</a>
                              <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                            </span>
                            <span class="description">Sent you a message - 3 days ago</span>
                          </div>
                          <!-- /.user-block -->
                          <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                          </p>

                          <form class="form-horizontal">
                            <div class="input-group input-group-sm mb-0">
                              <input class="form-control form-control-sm" placeholder="Response">
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-danger">Send</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                          <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="AdminLTE-3.2.0/dist/img/user6-128x128.jpg"
                              alt="User Image">
                            <span class="username">
                              <a href="#">Adam Jones</a>
                              <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                            </span>
                            <span class="description">Posted 5 photos - 5 days ago</span>
                          </div>
                          <!-- /.user-block -->
                          <div class="row mb-3">
                            <div class="col-sm-6">
                              <img class="img-fluid" src="AdminLTE-3.2.0/dist/img/photo1.png" alt="Photo">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-sm-6">
                                  <img class="img-fluid mb-3" src="AdminLTE-3.2.0/dist/img/photo2.png" alt="Photo">
                                  <img class="img-fluid" src="AdminLTE-3.2.0/dist/img/photo3.jpg" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                  <img class="img-fluid mb-3" src="AdminLTE-3.2.0/dist/img/photo4.jpg" alt="Photo">
                                  <img class="img-fluid" src="AdminLTE-3.2.0/dist/img/photo1.png" alt="Photo">
                                </div>
                                <!-- /.col -->
                              </div>
                              <!-- /.row -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->

                          <p>
                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                            <span class="float-right">
                              <a href="#" class="link-black text-sm">
                                <i class="far fa-comments mr-1"></i> Comments (5)
                              </a>
                            </span>
                          </p>

                          <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse">
                          <!-- timeline time label -->
                          <div class="time-label">
                            <span class="bg-danger">
                              10 Feb. 2014
                            </span>
                          </div>
                          <!-- /.timeline-label -->
                          <!-- timeline item -->
                          <div>
                            <i class="fas fa-envelope bg-primary"></i>

                            <div class="timeline-item">
                              <span class="time"><i class="far fa-clock"></i> 12:05</span>

                              <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                              <div class="timeline-body">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                quora plaxo ideeli hulu weebly balihoo...
                              </div>
                              <div class="timeline-footer">
                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                              </div>
                            </div>
                          </div>
                          <!-- END timeline item -->
                          <!-- timeline item -->
                          <div>
                            <i class="fas fa-user bg-info"></i>

                            <div class="timeline-item">
                              <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                              <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend
                                request
                              </h3>
                            </div>
                          </div>
                          <!-- END timeline item -->
                          <!-- timeline item -->
                          <div>
                            <i class="fas fa-comments bg-warning"></i>

                            <div class="timeline-item">
                              <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                              <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                              <div class="timeline-body">
                                Take me to your leader!
                                Switzerland is small and neutral!
                                We are more like Germany, ambitious and misunderstood!
                              </div>
                              <div class="timeline-footer">
                                <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                              </div>
                            </div>
                          </div>
                          <!-- END timeline item -->
                          <!-- timeline time label -->
                          <div class="time-label">
                            <span class="bg-success">
                              3 Jan. 2014
                            </span>
                          </div>
                          <!-- /.timeline-label -->
                          <!-- timeline item -->
                          <div>
                            <i class="fas fa-camera bg-purple"></i>

                            <div class="timeline-item">
                              <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                              <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                              <div class="timeline-body">
                                <img src="https://placehold.it/150x100" alt="...">
                                <img src="https://placehold.it/150x100" alt="...">
                                <img src="https://placehold.it/150x100" alt="...">
                                <img src="https://placehold.it/150x100" alt="...">
                              </div>
                            </div>
                          </div>
                          <!-- END timeline item -->
                          <div>
                            <i class="far fa-clock bg-gray"></i>
                          </div>
                        </div>
                      </div>
                      <!-- /.tab-pane -->


                      <div class="active tab-pane" id="settings">
                        <p class="text-muted">Note: Fields marked with an asterisk (*) are required.</p>
                        <!-- ../indexes/profile-be.php -->

                        <div class="card card-primary card-outline bg-white" for="update-registration">
                          <div class="card-header">
                            <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                              Personal Information</h3><br>
                            <hr>

                            <form class="form-horizontal" action="indexes/profile-be.php" method="post">

                              <?php if (isset($_GET['updateprofileerror'])) { ?>
                                <div class="alert alert-danger">
                                  <?php echo $_GET['updateprofileerror']; ?>
                                </div>
                              <?php } ?>
                              <?php if (isset($_GET['updateprofilesuccess'])) { ?>
                                <div class="alert alert-success">
                                  <?php echo $_GET['updateprofilesuccess']; ?>
                                </div>
                              <?php } ?>
                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <!-- Last name input -->
                                  <label for="Fullname" class="fw-bold">Last Name</label>
                                  <input type="text" class="form-control" name="lastname" placeholder="Last Name*"
                                    value="<?php echo isset($_SESSION['Lastname']) ? $_SESSION['Lastname'] : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                  <!--  First anme Input -->
                                  <label for="Fullname" class="fw-bold">First Name</label>
                                  <input type="text" class="form-control" name="firstname" placeholder="First Name*"
                                    value="<?php echo isset($_SESSION['First_name']) ? $_SESSION['First_name'] : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                  <!-- Middle name Input -->
                                  <label for="Fullname" class="fw-bold">Middle Name</label>
                                  <input type="text" class="form-control" name="middlename" placeholder="Middle Name"
                                    value="<?php echo isset($_SESSION['Middle_name']) ? $_SESSION['Middle_name'] : ''; ?>">
                                </div>
                              </div>

                              <div class="mb-3">
                                <!-- Username Input -->
                                <label for="User Name" class="fw-bold">User Name</label>
                                <input type="text" class="form-control" name="uname" placeholder="User Name*"
                                  value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
                              </div>



                              <div class="form-group row">
                                <!-- mobile number input -->
                                <label for="inputName" class="col-sm-2 col-form-label">Mobile Phone Number</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" name="phone_number"
                                    pattern="09[0-9]{9}" title="Phone number must start with 09 and have 11 digits"
                                    placeholder="09123456789*"
                                    value="<?php echo isset($_SESSION['phone_number']) && $_SESSION['phone_number'] !== '0' ? $_SESSION['phone_number'] : ''; ?>">
                                </div>
                              </div>
                              <!-- birthdate input -->
                              <div class="form-group row">
                                <label for="birthday" class="col-sm-2 col-form-label">Birthdate</label>
                                <div class="col-sm-10" style="display: flex; gap: 10px;">
                                  <input type="date" class="form-control" name="birthday" id="birthday"
                                    value="<?php echo isset($_SESSION['Birthday']) ? $_SESSION['Birthday'] : ''; ?>">
                                </div>
                              </div>

                              <!-- gender input -->
                              <div class="form-group row">
                                <label for="inputGender" class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-10">
                                  <select class="form-select form-select-lg mb-3 btn border border-light" name='gender'
                                    aria-label=".form-select-lg example">
                                    <option value="" selected disabled>Gender*</option>
                                    <option value="Prefer not to say" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'Prefer not to say' ? 'selected' : ''; ?>>Prefer not to say
                                    </option>
                                    <option value="Male" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                  </select>
                                </div>
                              </div>


                              <!-- address input -->
                              <div class="form-group row mb-3 ">
                                <label for="address1" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-md-4 dropdown">
                                  <input type="text" class="form-control" name="street_building_house"
                                    placeholder="Street Name, Building, House No.*"
                                    value="<?php echo isset($_SESSION['street_building_house']) ? $_SESSION['street_building_house'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="barangay" placeholder="Barangay*"
                                    value="<?php echo isset($_SESSION['Barangay']) ? $_SESSION['Barangay'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="city" placeholder="City*"
                                    value="<?php echo isset($_SESSION['City']) ? $_SESSION['City'] : ''; ?>">
                                </div>
                              </div>
                              <div class="form-group row mb-3 ">
                                <label for="address2" class="col-sm-2 col-form-label"></label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="province" placeholder="Province*"
                                    value="<?php echo isset($_SESSION['Province']) ? $_SESSION['Province'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="region" placeholder="Region*"
                                    value="<?php echo isset($_SESSION['Region']) ? $_SESSION['Region'] : ''; ?>">
                                </div>
                                <div class="col-md-2">
                                  <input type="text" class="form-control" name="postal_code" placeholder="Postal Code*"
                                    pattern="\d{4}" title="Postal code must be a 4-digit number"
                                    value="<?php echo ($_SESSION['Postal_Code'] !== '0') ? $_SESSION['Postal_Code'] : ''; ?>">
                                </div>

                              </div>

                              <!-- Occupation input -->
                              <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Occupation</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" name="occupation"
                                    placeholder="Occupation"
                                    value="<?php echo isset($_SESSION['Occupation']) ? $_SESSION['Occupation'] : ''; ?>">
                                </div>
                              </div>

                              <!-- education input -->
                              <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Education</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" name="education"
                                    placeholder="Education"
                                    value="<?php echo isset($_SESSION['Education']) ? $_SESSION['Education'] : ''; ?>">
                                </div>
                              </div>

                              <!-- Skills input -->
                              <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Skills</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputName" name="skills"
                                    placeholder="Skills"
                                    value="<?php echo isset($_SESSION['Skills']) ? $_SESSION['Skills'] : ''; ?>">
                                </div>
                              </div>

                              <!-- notes input -->
                              <div class="form-group row">
                                <label for="inputNotes" class="col-sm-2 col-form-label">Notes</label>
                                <div class="col-sm-10">
                                  <textarea class="form-control" id="inputNotes" rows="3" name="notes"
                                    placeholder="Note up to 1,000 characters only"><?php echo isset($_SESSION['Notes']) ? $_SESSION['Notes'] : ''; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <div class="checkbox">
                                    <label>
                                      <input type="checkbox" required='required'> I agree to the <a href="404.php">terms
                                        and
                                        conditions</a>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <!-- password input -->
                              <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                  <input type="password" class="form-control" id="inputName" name="profile_password"
                                    placeholder="Password">
                                  <p class="text-muted">To verify your identity, please enter your password to
                                    successfully
                                    update your profile.</p>
                                </div>
                              </div>
                              <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <button type="submit" value="Submit" name="profile_update"
                                    class="btn btn-success">Update</button>
                                </div>
                              </div>
                            </form>

                          </div>
                          <!-- /.card-body -->
                        </div>




















                        <div class="card card-primary card-outline bg-white" for="change-email">
                          <div class="card-header">
                            <!-- changing email address -->
                            <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                              Request to Change Email Address</h3><br>
                            <hr>


                            <form style="width: 100%" action="indexes/send_request_code.php" method="post">
                              <?php if (isset($_GET['sencodeerror'])) { ?>
                                <div class="alert alert-danger">
                                  <?php echo $_GET['sencodeerror']; ?>
                                </div>
                              <?php } ?>
                              <?php if (isset($_GET['sencodesuccess'])) { ?>
                                <div class="alert alert-success">
                                  <?php echo $_GET['sencodesuccess']; ?>
                                </div>
                              <?php } ?>
                              <div class="mb-3">
                                <!-- Current email address input -->
                                <label for="currentEmail" class="fw-bold">Current Email Address</label>
                                <input type="text" class="form-control" id="inputName" name="current_email"
                                  placeholder="Current Email Address" style="font-weight: bold;"
                                  value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" disabled>
                              </div>

                              <div class="mb-3">
                                <!-- New email address input -->
                                <label for="newEmail" class="fw-bold">New Email Address</label>
                                <div class="input-group">
                                  <?php if (isset($_GET['new_email_data'])) { ?>
                                    <input type="email" class="form-control col-9 me-2" name="new_email"
                                      placeholder="New Email Address*" required
                                      value="<?php echo $_GET['new_email_data']; ?>">
                                  <?php } else { ?>
                                    <input type="email" class="form-control col-9 me-2" name="new_email"
                                      placeholder="New Email Address*" required>
                                  <?php } ?>
                                  <button class="btn btn-primary mx-2" type="submit" name="send_code"
                                    value="send_request_code">Send Request Code</button>
                                </div>
                              </div>
                            </form>




                            <form style="width: 100%" action="indexes/changemail-be.php" method="post">

                              <?php if (isset($_GET['requestcodeerror'])) { ?>
                                <div class="alert alert-danger">
                                  <?php echo $_GET['requestcodeerror']; ?>
                                </div>
                              <?php } ?>
                              <?php if (isset($_GET['requestcodesuccess'])) { ?>
                                <div class="alert alert-success">
                                  <?php echo $_GET['requestcodesuccess']; ?>
                                </div>
                              <?php } ?>
                              <div class="mb-3">
                                <!-- Verification code input -->
                                <label for="requestCode" class="fw-bold">Request Code</label>
                                <?php if (isset($_GET['request_code_data'])) { ?>
                                  <input type="text" class="form-control" id="requestCode" name="request_code"
                                    placeholder="Verification Code" value="<?php echo $_GET['request_code_data']; ?>">
                                <?php } else { ?>
                                  <input type="text" class="form-control" id="requestCode" name="request_code"
                                    placeholder="Verification Code">
                                <?php } ?>



                              </div>

                              <div class="mb-3">
                                <!-- Password input -->
                                <label for="password" class="fw-bold">Password</label>
                                <input type="password" class="form-control " id="password" name="change_email_password"
                                  placeholder="Password">

                                <p class="text-muted">To verify your identity, please enter your password to successfully
                                  update your profile.</p>
                              </div>

                              <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <button type="submit" value="update_email_address" class="btn btn-success"
                                    name="update_email">Update</button>
                                </div>
                              </div>
                            </form>


                          </div>
                          <!-- /.card-body -->
                        </div>




































                        <div class="card card-primary card-outline bg-white" for="update-profilepicture">
                          <div class="card-header">
                            <!--  changing profile picture -->
                            <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                              Change Profile Picture</h3><br>
                            <hr>
                            <form style="width: 100%" action="indexes/update-profilepicture.php" method="post"
                              enctype="multipart/form-data">
                              <?php if (isset($_GET['proferror'])) { ?>
                                <div class="alert alert-danger">
                                  <?php echo $_GET['proferror']; ?>
                                </div>
                              <?php } ?>
                              <?php if (isset($_GET['profsuccess'])) { ?>
                                <div class="alert alert-success">
                                  <?php echo $_GET['profsuccess']; ?>
                                </div>
                              <?php } ?>
                              <div class="row justify-content-center">
                                <div class="image">
                                  <!-- displaying current profile picture -->
                                  <img class="change-profile-picture img-fluid"
                                    src="profile-picture/<?php echo $_SESSION['profile_picture']; ?>?<?php echo time(); ?>"
                                    alt="User profile picture">
                                </div>
                              </div>
                              <hr>
                              <div class="mb-3">
                                <!-- uploading file -->
                                <input class="form-control" type="file" id="formFile" name='file'>
                              </div>


                              <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <button type="submit" value="Submit" class="btn btn-success"
                                    name='upload'>Update</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <!-- /.card-body -->
                        </div>

                        <div class="card card-primary card-outline bg-white" for="change-password">
                          <div class="card-header">
                            <!-- changing password -->
                            <h3 class="card-title text-center" style="font-size: 1.25rem; font-weight: bold;">
                              Change Password</h3><br>
                            <hr>
                            <?php if (isset($_GET['passerror'])) { ?>
                              <div class="alert alert-danger">
                                <?php echo $_GET['passerror']; ?>
                              </div>
                            <?php } ?>
                            <?php if (isset($_GET['passsuccess'])) { ?>
                              <div class="alert alert-success">
                                <?php echo $_GET['passsuccess']; ?>
                              </div>
                            <?php } ?>
                            <form style="width: 100%" action="indexes/changepassword-be.php" method="post">
                              <div class="mb-3">
                                <!-- Current password input -->
                                <label for="currentPassword" class="fw-bold">Current Password</label>
                                <input type="password" class="form-control" name="currentPassword"
                                  placeholder="Current Password" required='required'>
                              </div>
                              <div class="mb-3">
                                <!-- new password input -->
                                <label for="newPassword" class="fw-bold">New Password</label>
                                <input type="password" class="form-control" name="newPassword" placeholder="New Password"
                                  required='required'>
                              </div>
                              <div class="mb-3">
                                <!-- retyping new password input -->
                                <label for="retypeNewPassword" class="fw-bold">Retype New Password</label>
                                <input type="password" class="form-control" name="retypeNewPassword"
                                  placeholder="Retype New Password" required='required'>
                              </div>
                              <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                  <button type="submit" value="Submit" class="btn btn-success">Update</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <!-- /.card-body -->
                        </div>

                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <!-- <script src="AdminLTE-3.2.0/dist/js/demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>

  </html>
  <?php
} else {
  header("Location: login-v2.php");
  exit();
}
?>