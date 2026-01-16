<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
if (!isset($_SESSION['userid'])) {
  header("location:login.php");
}
include 'partials/layout-pre.php';
include 'includes/config.php';

$situation = $date1 = $tasks = $date2 = $actions = $date3 = $results = $date4 = $learned = $date5  = '';

if (isset($_SESSION['userid']) && isset($_SESSION['emailid'])) {

  $emailid = $_SESSION['emailid'];

  $sql = "SELECT * FROM `worksheet_starl` WHERE emailid ='$emailid' ORDER BY id ASC LIMIT 1";

  $resa = mysqli_query($con, $sql);
  if (mysqli_num_rows($resa) > 0) {
    $row = mysqli_fetch_assoc($resa);
    $id = $row['id'] . 'test';
    $summary = $row['summary'];
	if (!empty($row)) {
      $situation = $row['situation'];
      $date1 = $row['date1'];
      $tasks = $row['tasks'];
      $date2 = $row['date2'];
      $actions = $row['actions'];
      $date3 = $row['date3'];
      $results = $row['results'];
      $date4 = $row['date4'];
      $learned = $row['learned'];
      $date5 = $row['date5'];
    } else {
      $situation = $date1 = $tasks = $date2 = $actions = $date3 = $results = $date4 = $learned = $date5 = '';
    }
  }
} else {
  // Form data is now loaded from localStorage via JavaScript on page load
  // No need to read from cookies to reduce HTTP header size
  $situation = $date1 = $tasks = $date2 = $actions = $date3 = $results = $date4 = $learned = $date5 = '';
}

  $rbCriticalThinking = $slCriticalThinking = $rbcommunication = $slcommunication = $rbteamwork = $slteamwork = $rbleadership = $slleadership = $rbprofessionalism = $slprofessionalism = $rbtechnology = $sltechnology = $rbequityInclusion = $slequityInclusion = $rbcareerDevelopment = $slcareerDevelopment = $rbotherSkills = $slotherSkills = '';
  $sql2 = "SELECT * FROM `worksheet_ai_response` WHERE emailid ='$emailid' ORDER BY id ASC LIMIT 1";
  $resa2 = mysqli_query($con, $sql2);
  if (mysqli_num_rows($resa2) > 0) {
    $respData = mysqli_fetch_assoc($resa2);
	// echo "<pre>"; print_r($respData); echo "</pre>";
	// echo "<pre>"; print_r($CriticalThinking); echo "</pre>";
    // echo "<pre>"; print_r($respData['criticalThinking']); echo "</pre>";
	$rbCriticalThinkingRes = $respData['res_rb_criticalThinking'];
	$slCriticalThinkingRes = $respData['res_sl_criticalThinking'];
	// if($respData['criticalThinking'] == $CriticalThinking){
	   $rbCriticalThinking = $respData['btn_rb_criticalThinking'];
	   $slCriticalThinking = $respData['btn_sl_criticalThinking'];
	// }else{
	  // $rbCriticalThinking = false;
	  // $slCriticalThinking = false;
	// }
	// if($respData['communication'] == $communication){
	   $rbcommunication = $respData['btn_rb_communication'];
	   $slcommunication = $respData['btn_sl_communication'];
	// }else{
	  // $rbcommunication = false;
	  // $slcommunication = false;
	// }
	// if($respData['teamwork'] == $teamwork){
	   $rbteamwork = $respData['btn_rb_teamwork'];
	   $slteamwork = $respData['btn_sl_teamwork'];
	// }else{
	  // $rbteamwork = false;
	  // $slteamwork = false;
	// }
	// if($respData['leadership'] == $leadership){
	   $rbleadership = $respData['btn_rb_leadership'];
	   $slleadership = $respData['btn_sl_leadership'];
	// }else{
	  // $rbleadership = false;
	  // $slleadership = false;
	// }
	// if($respData['professionalism'] == $professionalism){
	   $rbprofessionalism = $respData['btn_rb_professionalism'];
	   $slprofessionalism = $respData['btn_sl_professionalism'];
	// }else{
	  // $rbprofessionalism = false;
	  // $slprofessionalism = false;
	// }
	   $rbtechnology = $respData['btn_rb_technology'];
	   $sltechnology = $respData['btn_sl_technology'];
	   $rbequityInclusion = $respData['btn_rb_equityInclusion'];
	   $slequityInclusion = $respData['btn_sl_equityInclusion'];
	   $rbcareerDevelopment	 = $respData['btn_rb_careerDevelopment'];
	   $slcareerDevelopment	 = $respData['btn_sl_careerDevelopment'];
	   $rbotherSkills = $respData['btn_rb_otherSkills'];
	   $slotherSkills = $respData['btn_sl_otherSkills'];
  }
?>


<head>
  <title><?= TITLE ?> | Career Readiness Skills Worksheet</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <link rel="stylesheet" href="vendor/%40fortawesome/fontawesome-free/css/brands.css">
  <link rel="stylesheet" href="vendor/%40fortawesome/fontawesome-free/css/regular.css">
  <link rel="stylesheet" href="vendor/%40fortawesome/fontawesome-free/css/solid.css">
  <link rel="stylesheet" href="vendor/%40fortawesome/fontawesome-free/css/fontawesome.css">
  <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendor/animate.css/animate.css">
  <!-- WHIRL (spinners)-->
  <link rel="stylesheet" href="vendor/whirl/dist/whirl.css">
  <!-- =============== PAGE VENDOR STYLES ===============-->
  <!-- WEATHER ICONS-->
  <link rel="stylesheet" href="vendor/weather-icons/css/weather-icons.css">
  <!-- =============== BOOTSTRAP STYLES ===============-->
  <!-- =============== APP STYLES ===============-->
  <link rel="stylesheet" href="css/app.css" id="maincss">
  <link rel="stylesheet" href="css/dashboard.css">
  <style type="text/css" id="operaUserStyle"></style>
</head>
<style type="text/css">
	footer #footerNav ul li {
			display: inline-block;
			margin: 0em !important;
			font-weight: 600;
			font-size: 1.05556rem;
			line-height: 2em !important;
			color: #019ff0;
		}
		footer ul {
			margin: 2.8125rem 0;
			list-style-type: none;
			display: inline-block;
			padding: 0rem;
		}
		footer ul li {
			float: unset;  
			font-size: 1.05556rem;
			// margin: 0;
		}
		
		@media(max-width:37.5rem) {
			img {
				max-width: 70% !important;
				height: auto;
			}
			.log-inpart-sec{
				// margin-top:1.25rem !important;
				width:100%;
				margin: 1.25rem auto 0.5rem auto !important; 
			}
			
		}
  .fixed-bottom,
  .fixed-top {
    position: fixed;
    right: 0;
    left: 0;
    z-index: 1030;
  }

  .btn-group-vertical>.btn-group:after,
  .btn-group-vertical>.btn-group:before,
  .btn-toolbar:after,
  .btn-toolbar:before,
  .clearfix:after,
  .clearfix:before,
  .container-fluid:after,
  .container-fluid:before,
  .container:after,
  .container:before,
  .dl-horizontal dd:after,
  .dl-horizontal dd:before,
  .form-horizontal .form-group:after,
  .form-horizontal .form-group:before,
  .modal-footer:after,
  .modal-footer:before,
  .modal-header:after,
  .modal-header:before,
  .nav:after,
  .nav:before,
  .navbar-collapse:after,
  .navbar-collapse:before,
  .navbar-header:after,
  .navbar-header:before,
  .navbar:after,
  .navbar:before,
  .pager:after,
  .pager:before,
  .panel-body:after,
  .panel-body:before,
  .row:after,
  .row:before {
    display: none !important;
  }

  .modal-header:before {
    // display: none!important;
    // content: unset!important;
  }

  body {
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 0;
    /* padding: 1.25rem; */
    padding: 0.3125rem;
  }

  h2,
  h3 {
    text-align: center;
    color: #333;
    font-weight: bold;
  }

  form {
    max-width: 62.5rem;
    margin: 0 auto;
    background: #fff;
    padding: 1.25rem;
    border-radius: 0.5rem;
    box-shadow: 0 0 0.625rem rgba(0, 0, 0, 0.1);
  }

  label {
    font-weight: 300;
    font-family: Roboto, sans-serif;
    letter-spacing: 0.025em;
    line-height: 1.6em;
    font-size: 1.125rem;
  }

  label.title {
    font-weight: bold !important;
  }

  textarea {
    width: 100%;
    padding: 0.5rem;
    margin-top: 0.375rem;
    border-radius: 0.25rem;
    border: 0.0625rem solid #ccc;
    resize: vertical;
  }

  textarea:focus {
    outline: none;
    border-color: #66afe9;
    box-shadow: 0 0 0.3125rem rgba(102, 175, 233, 0.5);
  }

  .submissiondate {
    padding: 0.5rem;
    margin-top: 0.375rem;
    border-radius: 0.25rem;
    border: 0.0625rem solid #ccc;
    resize: vertical;
    font-weight: 300;
    font-family: Roboto, sans-serif;
    letter-spacing: 0.025em;
    line-height: 1.6em;
    font-size: 1.125rem;
  }

  input[type="submit"] {
    margin-top: 1.25rem;
    border: none;
    border-radius: 0.25rem;
    background-color: #1D9EEF;
    border-color: #1D9EEF;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.5rem 1rem;
  }

  input[type="submit"]:hover {
    background: #45a049;
  }

  button {
    border: none;
    border-radius: 0.25rem;
    background-color: #1D9EEF;
    border-color: #1D9EEF;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0.5rem 1rem;
    margin-top: 3%;
  }

  div#img-container:after {
    content: '';
    background: #1D9EEF;
    width: 80%;
    height: 100%;
    position: absolute;
    right: -1.875rem;
    z-index: -1;
    top: 1.875rem;
  }

  .cover {
    background: url('https://elevatetrak.com/images/NACEWorksheetheader.png') !important;
    background-size: 100% auto !important;
  }

  hr {
    border-width: 0.1875rem;
    border-top: 0.1875rem solid #fff !important;
    opacity: 1 !important;
  }

  // .ai-container {
    // display: none;
  // }
  // #reset_btn {
    // display: none;
  // }

  .invalid-feedback {
    margin-top: 0 !important;
    font-size: 100% !important;
  }

  .spinner-border {
    width: 1.6rem !important;
    height: 1.6rem !important;
  }

  #spiner {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: 4.375rem;
    // display: flex;
    align-items: center;
  }

  pre {
    height: auto !important;
    white-space: break-spaces;
    font-size: 1.125rem;
  }

  div#ai_wrap_rb label, div#ai_wrap_sl label {
    padding: 0.625rem;
    background: #1d9eef;
    width: 100%;
    color: #fff;
  }

  .copy_wrap {
    width: 6.25rem;
    float: right;
    padding: 0.6875rem;
    position: relative;
    top: 0;
    left: 2rem;
    cursor: pointer;
  }

  .btn-primary:disabled {
    cursor: no-drop;
    background-color: #78abd7;
  }

  .btn-primary.disabled.focus,
  .btn-primary.disabled:focus,
  .btn-primary.disabled:hover,
  .btn-primary[disabled].focus,
  .btn-primary[disabled]:focus,
  .btn-primary[disabled]:hover,
  fieldset[disabled] .btn-primary.focus,
  fieldset[disabled] .btn-primary:focus,
  fieldset[disabled] .btn-primary:hover {
    background-color: #78abd7;
    border-color: #2e6da4;
  }
  button#reset_btn {
    margin: 0.9375rem 0.0625rem;
    padding: 0.5rem 2.125rem;
}
.spinner-border.text-secondary {
    color: #fff !important;
}
/* Hide Save buttons on all pages except the last page */
.question-page .btn-success[onclick*="saveWorksheet"],
.question-page .btn-success[onclick*="saveAllWorksheet"] {
  display: none;
}

/* Show Save button only on the last page (page5) */
#page5 .btn-success[onclick*="saveAllWorksheet"],
#page5 .btn-success[onclick*="saveWorksheet"] {
  display: inline-block;
}

#save_message {
	display: none;
	padding: 0.625rem;
	background-color: #4CAF50;
	color: white;
	margin: 1.25rem 0;
}
.ai_btn_wrap {
  position: relative;
  display: inline-block;
  margin-top: 0.9375rem;
}
.ai_btn_wrap .tooltiptext1 {
    width: 84%;
    /* border: 0.0625rem solid #00000087; */
    color: #fff;
    text-align: center;
    border-radius: 0.1875rem;
    position: absolute;
    bottom: 87%;
    left: 33%;
    margin-left: -3.25rem;
    transition: opacity 0.3s;
    font-size: 0.75rem;
    font-weight: 300;
    box-shadow: 0rem 0rem 0.3125rem black;
    background: #39558d;
}
.ai_btn_wrap .tooltiptext2 {
    width: 82%;
    /* border: 0.0625rem solid #00000087; */
    color: #fff;
    text-align: center;
    border-radius: 0.1875rem;
    position: absolute;
    bottom: 87%;
    left: 36%;
    margin-left: -3.25rem;
    transition: opacity 0.3s;
    font-size: 0.75rem;
    font-weight: 300;
    box-shadow: 0rem 0rem 0.3125rem black;
    background: #39558d;
}
.ai_btn_wrap:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
.bullet_point {
	z-index: 2;
	position: relative;
}
 
.hero-banner .hero-img {
    width: 80%;
}
.hero-banner {
    text-align: center;
    background: #fff;
}
@media only screen and (max-width: 30rem) {
    .content-wrapper{
		padding: 0;
	}
	.p-5{
		padding: 0 !important;
	}
	button {
        font-size: 0.875rem;
        padding: 0.3rem .5rem;
        margin-top: 6%;
    }
	input#submitButton {
		font-size: 0.875rem;
		padding: 0.3rem .5rem;
		margin-top: 6%;
	}
	#ai_wrap_sl,#ai_wrap_rb {
		padding: 0;
	}
	.container.example-container.mt-5.bg-light {
		padding: 0;
	}
	.copy_wrap {
		width: 0rem;
		top: -0.3125rem;
		left: -0.6875rem;
		cursor: pointer;
	}
	.ai_btn_wrap .tooltiptext1 {
		width: 87%;
		bottom: 76%;
		left: 33%;
		margin-left: -2.3125rem;
	}
	.ai_btn_wrap .tooltiptext2 {
		width: 86%;
		bottom: 78%;
		left: 36%;
		margin-left: -2.25rem;
	}
}
/*header-banner start */
.header-hero{
    height: 31.25rem; 
    position:relative;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #2e2e2f;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
	}
	.hero-content{
		position:relative;
		z-index:1; 
		text-align:center; 
		color:#fff;
	}
	.header-hero .hero-title{
		font-size:2.625rem; 
		font-weight:800;
	}
	.header-hero .hero-desc{
		margin:0.875rem auto; 
		max-width:38.4375rem;
	}
	.header-hero .hero-desc span{
		font-size:1rem; 
		color:#f5f7fc;
	}
	.star-l-worksheet-hero{
    background-image: url('/images/dashboard-header/STAR-L-Worksheet.png'); 
}
</style>
<section>
          <div class="header-hero star-l-worksheet-hero">
                <div class="hero-content">
                    <div class="hero-title">
                        STAR-L Worksheet
                    </div>
                <div class="hero-desc">
                    <span>
                    This interactive worksheet is based on the STAR-L (Situation, Task, Action, Result, and Learn) interview method, a structured approach that assists candidates in articulating their experiences effectively during interviews. It, also, serves as a tool to help individuals craft and track compelling narratives that could resonate with employers in an interview.
                    </span>
                </div>
            </div>
        </div>
    </section>
<section class="row m-0 p-0 mb-5">
  <div class="content-wrapper">
    <!-- <section>
      <div class="hero-banner"> -->
        <!--<img class="hero-img" src="https://elevatetrak.com/images/NACEWorksheetheader1.png" alt="Woman studying">-->
        <!-- <img class="hero-img lazy" data-src="https://elevatetrak.com/images/starl_worksheet/STAR_L_WORKSHEET_banner.png" alt="Woman studying">
      </div>
    </section> -->

    <div class="row m-0 shadow-lg shadow-3 position-relative">
      <div class="conteiner d-flex justify-content-center p-5 flex-wrap">
        <!--<div class="col-12 col-sm-4 border-after position-relative text-end" id="imgwithtext">-->
		<div class="col-12 col-sm-4 position-relative text-end" id="imgwithtext" style="padding:3rem;">
          <div id="img-container-2" class="position-relative" style="background: #1D9EEF; text-align: center; padding: 0.9375rem;">
            <img data-src="/img/college-list-builder/left-side.jpg" width="100%" alt="college list builder logo" class="position-relative lazy" id="relimg">
          </div>
        </div>
		<!--<div class="col-12 col-sm-4 border-after position-relative text-end" id="imgwithtext">
            <div id="video-container" class="position-relative">
                <video src="https://www.elevatetrak.com/soonVideo/CareerPlanBuilder-12.mp4" width="100%" height="400" controls>
                </video>

            </div>
        </div>-->

        <div class="col-12 col-sm-8 py-5 m-0 ps-5 xs-padding-x-0" id="container3">
          <button class="btn-primary" id="spiner">
            <div class="spinner-border text-secondary">
              <span class="sr-only">Loading...</span>
            </div>
          </button>
          <form id="skillsForm" action="star-l-summary.php" method="post">
		  <div id="save_message">Your information has been successfully saved.</div>
            <div class="question-page" id="page1">
			<label style="font-weight:500">Welcome students to the STAR-L practice worksheet section of ElevateTrak.com. You’ll see that there are the following sections:</label>
			<span>
				S = Situation T = Tasks A = Actions R = Results L = Learned
			</span>
			<label>It is suggested that for each area of STAR-L students construct 2-4 sentences for each of the sections.</label>
			<label>When finished, be sure to hit the submit button at the end to gain access to your STAR-L summary page. Now, let’s begin practicing responding to a behavioral based interview question using the STAR-L method.</label>
			<label for="situation"><b>Question:</b> Please tell us how you came to choose 
				Tennessee Tech as your college of choice?  
				Walk us through your decision making process. </label>
            <label class="title" for="situation">S = Situation</label>
            <label for="situation">Definition: This is where you describe the context or 
			  background of your experience. 
			  What was happening? Where were you? Who was involved? </label>
              <textarea id="situation" name="situation" class="queryBox word-limit"  rows="4"
                cols="50"><?php echo $situation; ?></textarea>
				<p id="situationMessage" class="word-msg"></p>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <!--br-->
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date1" name="date1" value="<?php echo $date1; ?>">
              <br>
              <button onclick="nextPage('page2',1,event)">Next</button>
              <!-- <button class="btn-success" onclick="saveWorksheet('page2',1,event)">Save</button> -->
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_1" onclick="searchBulletPoint('bullet_point',1,event)"
                <?php echo $rbCriticalThinking ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',1,event)" id="s_l_1" <?php echo $slCriticalThinking ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>-->
            </div>

            <div class="question-page" id="page2" style="display: none;">
              <label class="title" for="Tasks">T = Tasks</label>
              <label for="tasks">Definition: This describes the specific goals or responsibilities 
			  you had within the situation. What needed to be done? 
			  What was expected of you? What problem needed to be solved?</label>
              <textarea id="tasks" name="tasks" class="queryBox word-limit" rows="4"
                cols="50"><?php echo $tasks; ?></textarea>
				<p id="tasksMessage" class="word-msg"></p>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <!--br-->
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date2" name="date2" value="<?php echo $date2 ?>">
              <br>
              <button onclick="previousPage('page1', 2)">Back</button>
              <button onclick="nextPage('page3',2,event)">Next</button>
              <!-- <button class="btn-success" onclick="saveWorksheet('page3',2,event)">Save</button> -->
              <button type="submit" class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_2" onclick="searchBulletPoint('bullet_point',2,event)"
                <?php echo $rbcommunication ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			 </div>
			 <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',2,event)" id="s_l_2" <?php echo $slcommunication ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
            </div>-->
            </div>

            <div class="question-page" id="page3" style="display: none;">
              <!-- Content for the third question -->
              <label class="title" for="Actions">A = Actions</label>
              <label for="Actions">Definition: This is the core of your response – 
			  what specific steps did you take to address the situation and complete your tasks? Focus on your 
			  individual contributions and use action verbs.</label>
              <textarea id="actions" name="actions" class="queryBox word-limit" rows="4" cols="50"><?php echo $actions; ?></textarea>
			  <p id="actionsMessage" class="word-msg"></p>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <!--br-->
              <label for="submissiondate">Date:</label>

              <input type="date" class="submissiondate" id="date3" name="date3" value="<?php echo $date3 ?>">
              <br>
              <button onclick="previousPage('page2', 3)">Back</button>
              <button onclick="nextPage('page4',3,event)"  id="nextButton">Next</button>
              <!-- <button class="btn-success" onclick="saveWorksheet('page4',3,event)">Save</button> -->
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_3" onclick="searchBulletPoint('bullet_point',3,event)"
                <?php echo $rbteamwork ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',3,event)" id="s_l_3" <?php echo $slteamwork ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>-->
            </div>  

            <div class="question-page" id="page4" style="display: none;">
              <label class="title" for="Results">R = Results</label> <br>
              <label for="Results">Definition: This describes the outcome of your actions. 
			  What happened as a result of what you did? What did you achieve? What did you learn? 
			  This is where you quantify your achievements whenever possible.</label>
              <textarea id="results" name="results" class="queryBox word-limit" rows="4"
                cols="50"><?php echo $results; ?></textarea>
				<p id="resultsMessage" class="word-msg"></p>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <!--br-->
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date4" name="date4" value="<?php echo $date4 ?>">
              <br>
              <button onclick="previousPage('page3', 4)">Back</button>
              <button onclick="nextPage('page5',4,event)">Next</button>
              <!-- <button class="btn-success" onclick="saveWorksheet('page5',4,event)">Save</button> -->
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_4" onclick="searchBulletPoint('bullet_point',4,event)"
                <?php echo $rbleadership ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',4,event)" id="s_l_4" <?php echo $slleadership ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>-->
            </div>
            <!--<div class="question-page" id="page5" style="display: none;">
              <label class="title" for="professionalism">L = Learned  </label>
              <label for="professionalismTextarea">This section is to record 
			  what you learned from the experience and how you might use
			  this skill in the future.</label>
              <textarea id="professionalismTextarea" name="professionalism" class="queryBox" rows="4"
                cols="50"><?php echo $professionalism; ?></textarea>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <br>
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date5" name="date5" value="<?php echo $date5; ?>">

              <br>
              <button onclick="previousPage('page4', 5)">Back</button>
              <button onclick="nextPage('page6',5,event)">Next</button>
              <button class="btn-success" onclick="saveWorksheet('page6',5,event)">Save</button>
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_5" onclick="searchBulletPoint('bullet_point',5,event)"
                <?php echo $rbprofessionalism ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',5,event)" id="s_l_5" <?php echo $slprofessionalism ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>
            </div>-->

            <!--<div class="question-page" id="page6" style="display: none;">
              <label class="title" for="technology">Technology</label>
              <label for="technologyTextarea">I have at least one example of using data, software, or other technology
                to
                help me make a critical decision. That example would be:</label>
              <textarea id="technologyTextarea" name="technology" class="queryBox" rows="4"
                cols="50"><?php echo $technology; ?></textarea>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <br>
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date6" name="date6" value="<?php echo $date6; ?>">
              <br>
              <button onclick="previousPage('page5', 6)">Back</button>
              <button onclick="nextPage('page7',6,event)">Next</button>
              <button class="btn-success" onclick="saveWorksheet('page7',6,event)">Save</button>
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_6" onclick="searchBulletPoint('bullet_point',6,event)"
                <?php echo $rbtechnology ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',6,event)" id="s_l_6" <?php echo $sltechnology ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>
            </div>-->

            <!--<div class="question-page" id="page7" style="display: none;">
              <label class="title" for="equityInclusion">Equity & Inclusion</label>
              <label for="equityInclusionTextarea">I have at least one good example of where I have worked in a
                multicultural or global capacity. My best example would be:</label>
              <textarea id="equityInclusionTextarea" name="equityInclusion" class="queryBox" rows="4"
                cols="50"><?php echo $equityInclusion; ?></textarea>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <br> 
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date7" name="date7" value="<?php echo $date7 ?>">
              <br>,
              <button onclick="previousPage('page6', 7)">Back</button>
              <button onclick="nextPage('page8',7,event)">Next</button>
              <button class="btn-success" onclick="saveWorksheet('page8',7,event)">Save</button>
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_7" onclick="searchBulletPoint('bullet_point',7,event)"
                <?php echo $rbequityInclusion ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',7,event)" id="s_l_7" <?php echo $slequityInclusion ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>
            </div>-->
            <!--<div class="question-page" id="page8" style="display: none;">
              <label class="title" for="careerDevelopment">Career & Self-Development</label>
              <label for="careerDevelopmentTextarea">I have at least one example of where I had to make an important
                decision concerning my career. That example would be:</label>
              <textarea id="careerDevelopmentTextarea" name="careerDevelopment" class="queryBox" rows="4"
                cols="50"><?php echo $careerDevelopment; ?></textarea>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <br>
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date8" name="date8" value="<?php echo $date8; ?>">
              <br>
              <button onclick="previousPage('page7', 8)">Back</button>
              <button onclick="nextPage('page9',8,event)">Next</button>
              <button class="btn-success" onclick="saveWorksheet('page9',8,event)">Save</button>
              <button class="example btn-primary">Example</button>
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_8" onclick="searchBulletPoint('bullet_point',8,event)"
                <?php echo $rbcareerDevelopment ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',8,event)" id="s_l_8" <?php echo $slcareerDevelopment ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>
            </div>-->

            <div class="question-page" id="page5" style="display: none;">
              <label class="title" for="Learned">L = Learned</label> <br>
              <label for="Learned">This section is to record what you learned from the experience and 
			  how you might use this skill in the future.</label>
              <textarea id="learned" name="learned" class="queryBox word-limit" rows="4"
                cols="50"><?php echo $learned; ?></textarea>
				<p id="learnedMessage" class="word-msg"></p>
              <div class="invalid-feedback">Please complete this section to proceed forward</div>
              <!--br-->
              <label for="submissiondate">Date:</label>
              <input type="date" class="submissiondate" id="date5" name="date5" value="<?php echo $date5; ?>">
              <br>
              <button onclick="previousPage('page4', 5)">Back</button>
              <input type="submit" value="Preview" id="submitButton" name="preview" onclick="submitForm(event)">
              <button class="btn-success" onclick="saveAllWorksheet(event)">Save</button>

              <!-- <button class="btn-success" onclick="saveWorksheet('page6',5,event)">Save</button> -->
			  <!--<div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" id="b_p_9" onclick="searchBulletPoint('bullet_point',9,event)"
                <?php echo $rbotherSkills ? 'disabled' : ''; ?>>Resume Bullet Point</button>
				<span class="tooltiptext1">AI Generated</span>
			  </div>
			  <div class="ai_btn_wrap">
              <button class="bullet_point btn-primary" onclick="searchBulletPoint('star_l',9,event)" id="s_l_9" <?php echo $slotherSkills ? 'disabled' : ''; ?>>STAR-L Response</button>
			  <span class="tooltiptext2">AI Generated</span>
			  </div>-->
            </div>
            <!-- <input type="submit" value="Update" id="update_button" name="update" onclick="Update(event)"> -->
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="nextModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          Are you sure you wish to proceed? By leaving this section, your AI Response will be lost. So, it is important
          to copy the AI Response to a separate document if you would like to keep it.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="proceedToSave('page2',1,event)">Proceed to Save</button>
      </div>
    </div>
  </div>
</div>
<div class="container example-container mt-5 bg-light">
  <div class="worksheet-example" tabindex="0" style="box-shadow: rgba(0, 0, 0, 0.35) 0rem 0.3125rem 0.9375rem; padding: 1.5625rem;"
    id="example_div"> </div>
</div>
<?php if($rbCriticalThinkingRes){ ?>
<style>#ai_wrap_rb{ display: block; }</style>
<?php }else{ ?>
<style>#ai_wrap_rb{ display: none; }</style>	
<?php  } ?>
<!--<div class="container ai-container-rb mt-5 bg-light" id="ai_wrap_rb">
  <label class="title">Isuriz AI Resume Bullet Response</label>
  <div class="copy_wrap"><span class="fa fa-copy text-dark" id="drop_upd_stng" style="font-size: 1.25rem;"></span></div>
  <div class="worksheet-ai-rb" tabindex="0" style="box-shadow: rgba(0, 0, 0, 0.35) 0rem 0.3125rem 0.9375rem; padding: 1.5625rem;"
    id="ai_div_rb"><?php echo $rbCriticalThinkingRes; ?> </div>
</div>-->
<?php if($slCriticalThinkingRes){ ?>
<style>#ai_wrap_sl{ display: block; }</style>
<?php }else{ ?>
<style>#ai_wrap_sl{ display: none; }</style>	
<?php  } ?>
<!--<div class="container ai-container-sl mt-5 bg-light" id="ai_wrap_sl">
  <label class="title">Isuriz AI STAR-L Response</label>
  <div class="copy_wrap"><span class="fa fa-copy text-dark" id="drop_upd_stng" style="font-size: 1.25rem;"></span></div>
  <div class="worksheet-ai-sl" tabindex="0" style="box-shadow: rgba(0, 0, 0, 0.35) 0rem 0.3125rem 0.9375rem; padding: 1.5625rem;"
    id="ai_div_si"><?php echo $slCriticalThinkingRes; ?> </div>
</div>-->

<p id="currentDateDisplay"></p>
<input type="hidden" name="email" id="email_id" value="<?php echo $_SESSION['emailid']; ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/worksheet-new-example.js"></script>

<script>
	$(document).ready(function() {
		// Handle both key typing and input change for each form individually
		$('.queryBox').on('input change', function() {
			var form = $(this).closest('div.question-page'); // Get the closest form element
			var submitButton = form.find('.bullet_point'); 
			var section = $(this).attr('name');
			
			if ($(this).val().length > 0) {
				submitButton.prop('disabled', false);
				$('.invalid-feedback').hide();
				// resetResponse(section);
			} else {
				submitButton.prop('disabled', true);
			}
		});
	});
</script>

<script>
  function resetResponse(section) {
	  var email = $('#email_id').val();
	  $.ajax({
      url: 'ajax/resetAIResponse.php',
      method: 'POST',
      data: {
        section: section,
        email_id: email,
      },
      success: function (data) {
        // $('#ai_wrap_rb').hide();
        // $('#ai_wrap_sl').hide();
      }
    });
	  
  }
  
  function proceedToSave(nextPageId, page_id, responseData, search_type) {
	  alert();
    // var page_id = $("#nextModal").attr('page-id');
    // var nextPageId = $("#nextModal").attr('next-page');
    // event.preventDefault();

    var inputName = $("div#page" + page_id + " textarea").attr('name');
    var inputVal = $("div#page" + page_id + " textarea").val();

    // var ai_div = document.getElementById("ai_div");
    var responseData = responseData.replace(/'/g, "\\'");

    var input_name = $("div#page" + page_id + " input").attr('name');
    var input_val = $("div#page" + page_id + " input").val();

    console.log("textarea->" + inputName + " " + inputVal);
    console.log("date->" + input_name + " " + input_val);

    var email = $('#email_id').val();
    const currentPage = document.querySelector('.question-page:not([style*="display: none"])');

    // if (currentPage.id !== 'page9') {
      // currentPage.style.display = 'none';

      // const nextPage = document.getElementById(nextPageId);
      // nextPage.style.display = 'block';
    // }
    $.ajax({
      url: 'ajaxAiResponseSave.php',
      method: 'POST',
      data: {
        name1: inputName,
        value1: inputVal,
        search_type: search_type,
        // value2: input_val,
        response: responseData,
        email_id: email
      },
      success: function (data) {
        console.log(data);
        // nextPage(nextPageId, page_id, event, true)
      }
    });
  }

  function nextPage(nextPageId, page_id, event, proceed = false) {
    event.preventDefault();
	//alert(nextPageId);
	
	// Get the Next button that was clicked and disable it with spinner
	var nextButton = event.target;
	var originalButtonText = nextButton.innerHTML;
	nextButton.disabled = true;
	nextButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
	
		// setWorksheetCount(nextPageId);
    $('.example-container').hide();
    $('.ai-container-rb').hide();
    $('.ai-container-sl').hide();
    var inputName = $("div#page" + page_id + " textarea").attr('name');
    var inputVal = $("div#page" + page_id + " textarea").val();
	
	var nextPageNo = (page_id+1);
	var nextInputName = $("div#page" + nextPageNo + " textarea").attr('name');

    if (inputVal == "" || inputVal == null) {
      // Re-enable button if validation fails
      nextButton.disabled = false;
      nextButton.innerHTML = originalButtonText;
      $("div#page" + page_id + " textarea").focus();
      $("div#page" + page_id + " div.invalid-feedback").show();
      return false;
    }

    // if (proceed == false) {
      // jQuery.noConflict();
      // $("#nextModal").modal('show');
      // $("#nextModal").attr('next-page', nextPageId);
      // $("#nextModal").attr('page-id', page_id);
      // return false;
    // } else {
      // $("#nextModal").modal('hide');
    // }

    var input_name = $("div#page" + page_id + " input").attr('name');
    var input_val = $("div#page" + page_id + " input").val();

    console.log("textarea->" + inputName + " " + inputVal);
    console.log("date->" + input_name + " " + input_val);
    localStorage.setItem(inputName, inputVal);
    localStorage.setItem(input_name, input_val);

    // Save to database before navigating
    var email = $('#email_id').val();
    $.ajax({
      url: 'ajax/ajaxStarLWorksheetSummary.php',
      type: 'POST',
      data: {
        name1: inputName,
        value1: inputVal,
        name2: input_name,
        value2: input_val,
        email_id: email
      },
      success: function (data) {
        console.log("Saved to database on Next click:", data);
        
        // Show success message (AJAX success means save was successful)
        $("#save_message").fadeIn();
        setTimeout(function() {
          $("#save_message").fadeOut();
        }, 3000);
        
        // Re-enable button after successful save
        nextButton.disabled = false;
        nextButton.innerHTML = originalButtonText;
        
        // After successful save, navigate to next page
        const currentPage = document.querySelector('.question-page:not([style*="display: none"])');

        // Check if the current page is the last page before displaying summary
        $('.ai-container').hide();
        if (currentPage.id !== 'page9') {
          currentPage.style.display = 'none';

          const nextPage = document.getElementById(nextPageId);
          nextPage.style.display = 'block';
          
          // Show/hide Save button based on current page (only show on last page - page5)
          toggleSaveButtonVisibility(nextPageId);

        }
        getAiResponse(nextInputName);
      },
      error: function(xhr, status, error) {
        console.error("Save error on Next click:", error);
        // Re-enable button even if save fails
        nextButton.disabled = false;
        nextButton.innerHTML = originalButtonText;
        
        // Still navigate even if save fails (data is in localStorage)
        const currentPage = document.querySelector('.question-page:not([style*="display: none"])');

        $('.ai-container').hide();
        if (currentPage.id !== 'page9') {
          currentPage.style.display = 'none';

          const nextPage = document.getElementById(nextPageId);
          nextPage.style.display = 'block';
          
          // Show/hide Save button based on current page (only show on last page - page5)
          toggleSaveButtonVisibility(nextPageId);

        }
        getAiResponse(nextInputName);
      }
    });
  }
  
  
  // function setWorksheetCount(nextPageId) {
			// alert("ajax");

		// const criticalThinkingTextarea = document.getElementById("criticalThinkingTextarea");
		
		// const communicationTextarea = document.getElementById("communicationTextarea");
		// const teamworkTextarea = document.getElementById("teamworkTextarea");
		// const leadershipTextarea = document.getElementById("leadershipTextarea");
		// const professionalismTextarea = document.getElementById("professionalismTextarea");
		// const technologyTextarea = document.getElementById("technologyTextarea");
		// const equityInclusionTextarea = document.getElementById("equityInclusionTextarea");
		// const careerDevelopmentTextarea = document.getElementById("careerDevelopmentTextarea");
		// const otherSkillsTextarea = document.getElementById("otherSkillsTextarea");
			
			// const criticalThinking = criticalThinkingTextarea?.value || '';
			// const communication = communicationTextarea?.value || '';
			// const  teamwork = teamworkTextarea?.value || '';
			// const leadership = leadershipTextarea?.value || '';
			// const professional = professionalismTextarea?.value || '';
			// const  technology = technologyTextarea?.value || '';
			// const  equityInclusion = equityInclusionTextarea?.value || '';
			// const  careerDevelopment = careerDevelopmentTextarea?.value || '';
			// const  otherSkills = otherSkillsTextarea?.value || '';
			// alert(teamwork);
			
			// try {
				// $.ajax({
					// url: 'ajax/updateWorksheetCount.php',
					// type: 'POST', // Use type instead of method if jQuery < 1.9
					// data: {
						// currentPage:nextPageId,
						// criticalThinking:criticalThinking,
						// communication: communication,
						// teamwork: teamwork,
						// leadership: leadership,
						// professional: professional,
						// technology: technology,
						// equityInclusion: equityInclusion,
						// careerDevelopment: careerDevelopment,
						// otherSkills: otherSkills,
						
					// },
					// success: function (data) {
						// alert('success');
					// }
				// });
			// } catch (e) {
				// console.error("JavaScript error:", e.message);
			// }
		// }
		
  
  function getAiResponse(section){
	  var email = $('#email_id').val();
	  $.ajax({
      url: 'ajax/getAIResponse.php',
      method: 'POST',
	  dataType: 'json',
      data: {
        section_rb: 'res_rb_'+section,
        section_sl: 'res_sl_'+section,
        email_id: email,
      },
      success: function (data) {
		  
		if(data.data_rb){
			$('.ai-container-rb').show();
            $('.worksheet-ai-rb').html(data.data_rb);
		}
		if(data.data_sl){
			$('.ai-container-sl').show();
            $('.worksheet-ai-sl').html(data.data_sl);
		}
      }
    });
  }

  function saveWorksheet(nextPageId, page_id, event) {
    event.preventDefault();
	
	console.log(nextPageId,page_id);
    var inputName = $("div#page" + page_id + " textarea").attr('name');
    var inputVal = $("div#page" + page_id + " textarea").val();

    var input_name = $("div#page" + page_id + " input").attr('name');
    var input_val = $("div#page" + page_id + " input").val();

    console.log("textarea->" + inputName + " " + inputVal);
    console.log("date->" + input_name + " " + input_val);

    var email = $('#email_id').val();
    const currentPage = document.querySelector('.question-page:not([style*="display: none"])');

    // Store field names in variables that will be accessible in success callback
    var fieldNameToClear = inputName;
    var dateFieldNameToClear = input_name;

    // if (currentPage.id !== 'page9') {
    //   currentPage.style.display = 'none';

    //   const nextPage = document.getElementById(nextPageId);
    //   nextPage.style.display = 'block';
    // }
    $.ajax({
      url: 'ajax/ajaxStarLWorksheetSummary.php',
      type: 'POST',
      data: {
        name1: inputName,
        value1: inputVal,
        name2: input_name,
        value2: input_val,
        email_id: email
      },
      success: function (data) {
        console.log(data);
		$("#save_message").fadeIn();
			setTimeout(function() {
				$("#save_message").fadeOut();
			}, 3000);
		
		// Clear ALL localStorage fields for STAR-L worksheet after successful save
		const allStarLFields = ['situation', 'date1', 'tasks', 'date2', 'actions', 'date3', 'results', 'date4', 'learned', 'date5'];
		allStarLFields.forEach(function(fieldName) {
		  console.log("Clearing localStorage for: " + fieldName);
		  localStorage.removeItem(fieldName);
		});
		
		// Refetch form data from database and populate form
		refetchStarLDataFromDB(email);
      },
      error: function(xhr, status, error) {
        console.error("Save error:", error);
        // Don't clear localStorage on error
      }
    });
  }

  function saveAllWorksheet(event) {
    event.preventDefault();

    var email = $('#email_id').val();

    var data = {
        email_id: email,
        situation: $("#situation").val(),
        date1: $("#date1").val(),
        tasks: $("#tasks").val(),
        date2: $("#date2").val(),
        actions: $("#actions").val(),
        date3: $("#date3").val(),
        results: $("#results").val(),
        date4: $("#date4").val(),
        learned: $("#learned").val(),
        date5: $("#date5").val()
    };

    console.log("Sending:", data);

    $.ajax({
        url: 'ajax/saveAllWorksheet.php',
        type: 'POST',
        data: data,
        success: function (response) {
            console.log(response);
            $("#save_message").fadeIn();
            setTimeout(() => $("#save_message").fadeOut(), 3000);
            
            // Clear all localStorage fields after successful save
            const formFieldsToClear = ['situation', 'date1', 'tasks', 'date2', 'actions', 'date3', 'results', 'date4', 'learned', 'date5'];
            formFieldsToClear.forEach(function(fieldName) {
              console.log("Clearing localStorage for: " + fieldName);
              localStorage.removeItem(fieldName);
            });
            
            // Refetch form data from database and populate form
            refetchStarLDataFromDB(email);
        },
        error: function(xhr, status, error) {
            console.error("Save error:", error);
            // Don't clear localStorage on error
        }
    });
  }


  function searchBulletPoint(search_type, page_id, event) {
    $('#spiner').show();
    event.preventDefault();
    var sCount = 10;
    var qqq = '';
    var qus = '';
    var inputName = $("div#page" + page_id + " textarea").attr('name');
    var inputVal = $("div#page" + page_id + " textarea").val();
    // $("div#page" + i + " textarea").val('');
    // qqq = inputName+' - '+inputVal;
    if (search_type == 'bullet_point') {
      $('#b_p_' + page_id).prop('disabled', true);
      qus = 'Help me design a bullet point for my resume using NACE Competencies and language from my profession from the supplied example: ' + inputVal;
    } else {
      $('#s_l_' + page_id).prop('disabled', true);
      qus = 'Help me create a behavioral based response using STAR-L to this question focused on critical thinking and problem solving using language from my profession: ' + inputVal;
    }
    $.ajax({
      url: 'ai/ajaxBulletResponse.php',
      method: 'POST',
      data: {
        qqq: qus,
        search_type: search_type,
        page_id: page_id,
      },
      success: function (data) { 
        console.log(data);
        data1 = data.replace(/\*/g, '');
		proceedToSave(search_type, page_id, data1, search_type);
        // data2 = data1.replace('<pre>', '');
        // data3 = data2.replace('</pre>', '');
        $('html, body').animate({ scrollTop: $(document).height() - $(window).height() - 100 }, 1000);
        
		if(search_type=="star_l"){
			$('.ai-container-sl').show();
			$('.worksheet-ai-sl').html(data1);
		}else{
			$('.ai-container-rb').show();
			$('.worksheet-ai-rb').html(data1);
		}
        $('#spiner').hide();
      }
    });
  }


  function previousPage(previousPageId, page_id) {
    event.preventDefault();
    $('.example-container').hide();
    $('.ai-container').hide();
    const currentPage = document.querySelector('.question-page:not([style*="display: none"])');
    currentPage.style.display = 'none';

    const previousPage = document.getElementById(previousPageId);
    previousPage.style.display = 'block';
	
	var nextPageNo = (page_id-1);
	var nextInputName = $("div#page" + nextPageNo + " textarea").attr('name');
	
	// Show/hide Save button based on current page (only show on last page - page5)
	toggleSaveButtonVisibility(previousPageId);
	
	getAiResponse(nextInputName);

  }
  
  // Function to show/hide Save button - only show on last page (page5)
  function toggleSaveButtonVisibility(pageId) {
    // Hide all Save buttons
    $('.question-page .btn-success[onclick*="saveWorksheet"], .question-page .btn-success[onclick*="saveAllWorksheet"]').hide();
    
    // Show Save button only on the last page (page5)
    if (pageId === 'page5') {
      $('#page5 .btn-success[onclick*="saveAllWorksheet"], #page5 .btn-success[onclick*="saveWorksheet"]').show();
    }
  }

  function submitForm(event) {
    event.preventDefault(); // Prevent the default form submission
    // for text area
	
    var inputName = $("div#page" + 9 + " textarea").attr('name');
    var inputVal = $("div#page" + 9 + " textarea").val();
    localStorage.setItem(inputName, inputVal);
    // for date
    var input_name = $("div#page" + 9 + " input").attr('name');
    var input_val = $("div#page" + 9 + " input").val();
    localStorage.setItem(input_name, input_val);

    let text_area = $("textarea");
    let input = $("input");

    let len = text_area.length;
    
    // Clear localStorage after form is submitted
    const formFieldsToClear = ['situation', 'date1', 'tasks', 'date2', 'actions', 'date3', 'results', 'date4', 'learned', 'date5'];
    formFieldsToClear.forEach(function(fieldName) {
      localStorage.removeItem(fieldName);
    });
    
    $('#skillsForm')[0].submit();
  }
</script>
<script>
  $("body").on("click", ".copy_wrap", function () {
    var copyId = $(this).next().attr('id');

    var copyText = document.getElementById(copyId);
    var range = document.createRange();
    console.log(range);
    var selection = window.getSelection();
    range.selectNodeContents(copyText);
    selection.removeAllRanges();


    selection.addRange(range);

    document.execCommand("copy");
  })
</script>
<script>
  const urlParams = new URLSearchParams(window.location.search);
  const pageToLoad = urlParams.get('page');

  // Function to navigate to a specific page
  function goToPage(pageNumber) {
    const page = document.getElementById('page' + pageNumber);
    if (page) {
      const currentPage = document.querySelector('.question-page:not([style*="display: none"])');
      currentPage.style.display = 'none';
      page.style.display = 'block';
    }
  }

  // Load the specific page if the 'page' parameter exists in the URL
  if (pageToLoad) {
    goToPage(pageToLoad);
  }
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const lazyImages = document.querySelectorAll("img.lazy");
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.remove("lazy");
        observer.unobserve(img);
      }
    });
  });

  lazyImages.forEach(img => imageObserver.observe(img));
  
  // Load form data from localStorage on page load
  loadFormDataFromLocalStorage();
  
  // Initialize Save button visibility on page load (hide on all pages except last)
  const initialPage = document.querySelector('.question-page:not([style*="display: none"])');
  if (initialPage) {
    toggleSaveButtonVisibility(initialPage.id);
  }
});

// Function to load form data from localStorage
function loadFormDataFromLocalStorage() {
  // List of all form field names
  const formFields = ['situation', 'date1', 'tasks', 'date2', 'actions', 'date3', 'results', 'date4', 'learned', 'date5'];
  
  formFields.forEach(function(fieldName) {
    const savedValue = localStorage.getItem(fieldName);
    if (savedValue) {
      const field = document.querySelector('[name="' + fieldName + '"]');
      if (field) {
        field.value = savedValue;
      }
    }
  });
}

// Function to refetch form data from database and populate form
function refetchStarLDataFromDB(email) {
  $.ajax({
    url: 'ajax/fetchWorksheetData.php',
    type: 'POST',
    data: {
      email_id: email,
      form_type: 'starl'
    },
    dataType: 'json',
    success: function(response) {
      if (response.success && response.data) {
        console.log("Refetching STAR-L form data from database:", response.data);
        // Populate all form fields with data from database
        Object.keys(response.data).forEach(function(fieldName) {
          const field = document.querySelector('[name="' + fieldName + '"]');
          if (field) {
            field.value = response.data[fieldName] || '';
          }
        });
      } else {
        console.error("Failed to refetch data:", response.error);
      }
    },
    error: function(xhr, status, error) {
      console.error("Error refetching data:", error);
    }
  });
}
</script>
<script>
  // FIXED WORD LIMIT SCRIPT - Replace the existing word limit script with this:

// limit word count 
const TARGET = 201; // 200 words max (0-200 = 201 total)

function getWords(text) {
    return text.trim().split(/\s+/).filter(Boolean);
}

function truncateToWordLimit(text, maxWords) {
    const words = getWords(text);
    if (words.length > maxWords) {
        return words.slice(0, maxWords).join(' ');
    }
    return text;
}

document.querySelectorAll('.word-limit').forEach(textarea => {
    const message = document.getElementById(textarea.id + "Message");
    
    // Handle paste events - intercept and truncate if needed
    textarea.addEventListener("paste", (event) => {
        event.preventDefault(); // Prevent default paste
        
        // Get pasted text from clipboard
        const pastedText = (event.clipboardData || window.clipboardData).getData('text');
        
        // Get current text and cursor position
        const currentText = textarea.value;
        const startPos = textarea.selectionStart;
        const endPos = textarea.selectionEnd;
        
        // Combine current text with pasted text
        const textBefore = currentText.substring(0, startPos);
        const textAfter = currentText.substring(endPos);
        const newText = textBefore + pastedText + textAfter;
        
        // Count words in the new text
        let words = getWords(newText);
        
        // If exceeds limit, truncate to max words
        if (words.length > TARGET - 1) {
            // Truncate the entire text to max words
            const truncatedText = truncateToWordLimit(newText, TARGET - 1);
            textarea.value = truncatedText;
            
            // Set cursor position to end
            const newCursorPos = truncatedText.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            
            // Show warning message
            message.textContent = "🚫 Maximum 200 words reached! Pasted content was truncated.";
            message.style.color = "red";
            
            // Update word count
            words = getWords(truncatedText);
            setTimeout(() => {
                message.textContent = `Word Count: ${words.length} / ${TARGET - 1}`;
                message.style.color = "#333";
            }, 2000);
        } else {
            // Allow paste if within limit
            textarea.value = newText;
            
            // Set cursor position after pasted text
            const newCursorPos = startPos + pastedText.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            
            // Update word count
            words = getWords(newText);
            message.textContent = `Word Count: ${words.length} / ${TARGET - 1}`;
            message.style.color = "#333";
        }
    });
    
    // Handle beforeinput event for typing
    textarea.addEventListener("beforeinput", (event) => {
        const isDeleting =
            event.inputType === "deleteContentBackward" ||
            event.inputType === "deleteContentForward" ||
            event.inputType === "deleteByCut";
        
        // Allow deleting always
        if (isDeleting) return;
        
        // Prevent paste (we handle it separately above)
        if (event.inputType === "insertFromPaste") {
            return; // Let paste event handle it
        }
        
        let words = getWords(textarea.value);
        
        // For typing, prevent if already at limit
        if (words.length >= TARGET - 1) {
            event.preventDefault();
            message.textContent = "🚫 Maximum 200 words reached!";
            message.style.color = "red";
            return;
        }
    });
    
    // Handle input event for real-time word count
    textarea.addEventListener("input", () => {
        let words = getWords(textarea.value);
        
        // Double-check limit on input (in case something bypassed)
        if (words.length > TARGET - 1) {
            // Truncate if somehow exceeded
            const truncatedText = truncateToWordLimit(textarea.value, TARGET - 1);
            textarea.value = truncatedText;
            words = getWords(truncatedText);
            message.textContent = "🚫 Maximum 200 words reached!";
            message.style.color = "red";
            setTimeout(() => {
                message.textContent = `Word Count: ${words.length} / ${TARGET - 1}`;
                message.style.color = "#333";
            }, 2000);
        } else {
            message.textContent = `Word Count: ${words.length} / ${TARGET - 1}`;
            message.style.color = "#333";
        }
    });
    
    // Initialize on load
    textarea.dispatchEvent(new Event("input"));
});
</script>
<?php
include 'partials/layout-post.php';
?>