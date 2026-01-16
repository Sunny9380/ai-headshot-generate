<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['userid'])) {
  header("location:login.php");
}
include 'partials/layout-pre.php';
include 'includes/config.php';
$title = defined("TITLE") ? TITLE : 'Default Title';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.0/html2pdf.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <meta charset="UTF-8">
    <title>Summary Page</title>
</head>
<style>
	ul#drp_st_pr{
		top: 30px!important;
	}
    .button-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        /* Adjust the gap between buttons */
    }

    .popupbutton {
        padding: 5px 10px;
        /* Adjust padding to reduce button size */
        font-size: 15px;
        /* Adjust font size */
    }

    .popupbutton {
        margin-top: 2%;
    }

    #summaryDisplay {
        margin: auto;
        padding: 8px;
        border-radius: 4px;
        border: none;
        resize: vertical;
        outline: none;
        width: 80%;
    }

    .back {
        margin-top: 2%;
    }

    button,
    input {
        border: none;
        border-radius: 4px;
        background-color: #1D9EEF;
        border-color: #1D9EEF;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        padding: 0.7rem 1rem;
        /* Adjusted padding to match heights */
        text-decoration: none;
        display: inline-block;
    }

    .done1 {
        border: none;
        border-radius: 4px;
        /* background-color: #1D9EEF; */
        /* border-color: #1D9EEF; */
        /* color: white; */
        font-size: 1.25rem;
        cursor: pointer;
        padding: 0.7rem 1rem;
        /* Adjusted padding to match heights */
        text-decoration: none;
        display: inline-block;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        text-align: center;
    }


    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .alert {
        display: block;
        position: fixed;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px;
        z-index: 999;
    }
    
.button_group {
    display: flex;
    justify-content: center;
    margin-bottom: 1%;
}
.button_2,.button_4,.button_1{
    margin-right: 10px;
}
button.head_btn {
    width: 100%;
}
.card_inner button.head_btn {
    border-radius: 0px;
	text-transform: uppercase;
}
.card_wrap {
    padding: 0;
}
.val_txt {
    // text-align: center;
    display: table;
    width: 100%;
    padding: 10px 10px;
}
div#summaryDisplay h3 {
    text-align: center;
}
.card_wrap{
   padding: 0px;
}
.card_inner {
    margin: 15px 30px;
    border: 1px solid #9d9697;
	min-height: 200px;
}
.card_inner span {
    color: #004aac;
}
button.head_btn {
    background-color: #004aac;
}
.col-sm-8.name_wrap {
    padding: 9px 30px;
}
.col-sm-4.date_wrap {
    padding: 9px 30px;
}
div#summaryDisplay h3 {
    font-size: 42px;
    padding: 20px 0px;
    color: #019ff0;
}
a.col-6.text-dark.text-decoration-none.p-0 {
    display: none;
}
p.val_txt span {
    position: relative;
    top: 10px;
	// margin: 0 auto;
    display: table;
	white-space: normal;
    word-break: break-word;
}
.col-sm-4.date_wrap span {
    float: inline-end;
}
.col-6.d-flex.align-items-center.d-sm-block.p-0 {
    width: 100%;
}
.list_item{
	border: 1px solid #004aac91;
    padding: 5px 5px;
    margin: 5px 5px;
    line-height: 2.5;
	white-space: normal;
    word-break: break-word;
}
.list_wrap{
	padding: 5px 5px;
}
.list_wrap span{
	display: block;
}
div.list_item span {
    // background: #8b8b8b5c;
    padding: 5px 5px;
    color: #004aac;
    border-radius: 3px;
	display: inline;
}
@media only screen and (max-width: 480px) {
    .content-wrapper{
		padding: 0;
	}
	.p-5{
		padding: 0 !important;
	}
	button {
        font-size: 14px;
        padding: 0.3rem .5rem;
        // margin-top: 2%;
    }
	input#submitButton, input#save_Datat, a#doneBtn {
		font-size: 14px;
		padding: 0.3rem .5rem;
		margin-top: 4%;
	}
	.card_inner {
        margin: 10px 0px;
		min-height: auto;
	}
	.val_txt {
		padding: 10px 5px;
	}
	.col-sm-8.name_wrap {
		padding: 5px 10px;
	}
	.col-sm-4.date_wrap {
		padding: 5px 10px;
	}
	div#summaryDisplay h3 {
		font-size: 22px;
		padding: 10px 0px;
		margin-top: 20px;
	}
	.col-sm-4.date_wrap span {
		float: unset;
	}
}
</style>
 
<body>
    <div id="summaryDisplay">
	<a href="<?= URL; ?>"><img src="/img/logo.png" alt="<?= TITLE; ?>" class="logo"></a>
        <h3>STAR-L Worksheet</h3>
        <!-- <h3>STAR-L Worksheet</h3> -->
        <!--<h3>Track NACE Competencies</h3>-->
        <br>
		<div class="row">
		<?php //echo "<pre>"; print_r($_POST); echo "</pre>";  ?>
			<div class="col-sm-8 name_wrap">
			<span>Name:  <?php echo @$_SESSION['name']; ?></span>
			</div>
			<div class="col-sm-4 date_wrap">
			<span>Date:  <?php echo  date("m-d-Y"); ?></span>
			</div>
			<label for="situation" style="margin: 15px 0px 0px 15px;"><b>Question:</b> Please tell us how you came to choose 
				Tennessee Tech as your college of choice?  
				Walk us through your decision making process. </label>
        <?php
		$colors = ['#004aac', '#9d9697', '#74b657', '#0bc1e1'];
		$keyT = '';
		$index = 0;
		$index1 = 0;
		$secData = array();
		$array = $_POST;
		$array1 = $_POST;
		$_SESSION['post'] = $_POST;
		$email_id = $_SESSION['emailid'];
		// echo "<pre>"; print_r($_SESSION); echo "</pre>";
		for ($i = 1; $i <= 5; $i++) {
			$key = "date" . $i;
			unset($array[$key]); // Unset each date key from the array
		}
		// echo "<pre>"; print_r($_POST); echo "</pre>";
        foreach ($array as $key => $value) {
			// echo $key;
			$color = $colors[$index % count($colors)];
			$index1= $index+1;
			$sql = "SELECT `$key`, `date$index1` 
        FROM worksheet_starl 
        WHERE emailid = '$email_id'";
			$result = $con->query($sql);
            // $secData = $result->fetch_assoc();
			if ($row = $result->fetch_assoc()) {
				$secData['name_1'] = !empty($row[$key]) ? explode(',', $row[$key]) : [];
				$secData['name_2'] = !empty($row['date'.$index1]) ? explode(',', $row['date'.$index1]) : [];
			}
			// echo "<pre>"; print_r($secData); echo "</pre>";
			if($key == 'situation'){
				$keyT = 'S = Situation';
			}elseif($key == 'tasks'){
				$keyT = 'T = Tasks';
			}elseif($key == 'actions'){
				$keyT = 'A = Actions';
			}elseif($key == 'results'){
				$keyT = 'R = Results '; 
			}elseif($key == 'learned'){
				$keyT = 'L = Learned ';
			}
			if($key == 'date1' || $key == 'date2' || $key == 'date3' || $key == 'date4' || $key == 'date5'){
				$key1 = 'Date';
				$date = date("m-d-Y", strtotime($value));
			} 
			
			

			

			
			if($key != 'savedata'){
            ?>
			
				<div class="col-sm-6 card_wrap">
					<div class="card_inner">
						<button class="head_btn"><?php echo $keyT ?></button>
						<div class="list_wrap">
						<!--<p class="val_txt"><span>Date of Entry: <?php echo date("m/d/Y", strtotime($array1['date1'])); ?></span><br><?php echo $secData[$key] ?>.</p>-->
						<?php 
						  if(!empty($secData['name_1'])){
							  foreach($secData['name_1'] as $i=>$data){
							  echo '<div class="list_item"><span>'. date('m-d-Y', strtotime($secData['name_2'][$i])) .' :</span> '. $data .'</div>';
							  }
						  }
						  ?>
					    </div>
					</div>
				</div>
			
            <?php } $index++; 
        }
		// echo "<pre>"; print_r($get_data); echo "</pre>";
        echo '</div>';
        
        if (isset($_POST['savedata'])) {
			unset($_POST['savedata']);
			$get_data = $_POST;
			// echo "<pre>"; print_r($get_data); echo "</pre>"; exit;
            $save_Summary = json_encode($get_data);
            $email = $_SESSION['emailid'];
            $sql_check = "SELECT * FROM `worksheet_starl` WHERE emailid='$email' ORDER BY id ASC LIMIT 1";
            $result_1 = mysqli_query($con, $sql_check);
            if (mysqli_num_rows($result_1) > 0) {
                $row = mysqli_fetch_assoc($result_1);
				// echo "<pre>"; print_r($row);  echo "</pre>"; 
                $id = $row['id'];

                $update = "UPDATE `worksheet_starl` SET `summary`='$save_Summary' WHERE id = '$id'";

                $result_2 = $con->query($update);
                if ($result_2) {
                    echo "<div class='alert alert-success'>
                    You have <strong> successfully </strong> saved the information in your STAR-L Worksheet.
                  </div>";
                } else {
                    echo "<div class='alert alert-danger'>
                    <strong>Failed!</strong>
                  </div>";
                }
            } else {
                $save_Summary = json_encode($get_data);
                $sql_2 = "INSERT INTO `worksheet_starl` (emailid,summary) VALUE ('$email','$save_summary')";
                $result_2 = $con->query($sql_2);
                if ($result_2) {
                    echo "<div class='alert alert-success'>
                    You have <strong> successfully </strong> saved the information in your STAR-L Worksheet.
                  </div>";
                } else {
                    echo "<div class='alert alert-danger'>
                    <strong>Failed!</strong> Please try after some time.
                  </div>";
                }

            }
        }

        ?>

    </div>
    <div class="button_group">
        <div class="button_2">
            <a href="<?= URL; ?>STAR-L-worksheet.php">
                <button class="back">Back</button>
            </a>
        </div>
        <div class="button_4">
            <form action="" method="POST">
                <input name="situation" type="hidden" value="<?php echo $_POST['situation']; ?>">
                <input name="date1" type="hidden" value="<?php echo $_POST['date1']; ?>">
                <input name="tasks" type="hidden" value="<?php echo $_POST['tasks']; ?>">
                <input name="date2" type="hidden" value="<?php echo $_POST['date2']; ?>">
                <input name="actions" type="hidden" value="<?php echo $_POST['actions']; ?>">
                <input name="date3" type="hidden" value="<?php echo $_POST['date3']; ?>">
                <input name="results" type="hidden" value="<?php echo $_POST['results']; ?>">
                <input name="date4" type="hidden" value="<?php echo $_POST['date4']; ?>">
                <input name="learned" type="hidden" value="<?php echo $_POST['learned']; ?>">
                <input name="date5" type="hidden" value="<?php echo $_POST['date5']; ?>">
                <input name="savedata" class="btn-success" type="submit" id="save_Datat" value="Save">
            </form>
        </div>
        <div class="button_1">
            <button id="download-button" class="btn-secondary">Download PDF </button>
			<!-- <button onclick="downloadPDF()" class="btn-secondary">Download PDF</button> -->
        </div>
            <div class="button_3">
                <a href="#" id="doneBtn" class="done1 btn-info">Done</a>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <p>Please make sure that you download the worksheet as a PDF in order to save a copy on your own
                        computer. By clicking the Confirm button below, you understand that the worksheet will not be
                        saved
                        in your user account on <?= $title ?>.</p>
                    <div class="button-row">
                        <button id="confirmBtn" class="popupbutton">Confirm</button>
                        <button id="cancelBtn" class="popupbutton">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the content from the HTML element
            const content = document.getElementById('summaryDisplay').innerText;

            // Add the content to the PDF
            doc.text(content, 10, 10);

            // Generate the PDF as a Blob
            const pdfBlob = doc.output('blob');

            // Use FileSaver.js to trigger the download
            saveAs(pdfBlob, 'star-L-summary.pdf');
        }
    </script>

</body>
</html>

<script>
    function downloadSummaryAsText() {
        const summaryDisplay = document.getElementById('summaryDisplay');
        const content = summaryDisplay.innerText;

        const blob = new Blob([content], { type: "text/plain" });
        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.download = 'summary.txt';
        link.click();
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.js"></script>
<script>
const button = document.getElementById('download-button');

function generatePDF() {
    const element = document.getElementById('summaryDisplay');
    const isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);

    html2pdf().from(element).set({
        margin: 5,
        filename: 'star-L-summary.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 1.5, scrollY: 0, logging: false },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: { mode: 'avoid-all', avoid: '.page-break' }
    }).toPdf().get('pdf').then(function (pdf) {
        // Create a Blob from the PDF
        const blob = pdf.output('blob');
        
        // Create a temporary link element
        const link = document.createElement('a');
        const url = window.URL.createObjectURL(blob);

        if (isIOS) {
            // For iOS devices, open in a new tab
            window.open(url, '_blank');
            alert('On iOS, please tap the share button and choose "Save to Files" to download the PDF.');
        } else {
            // For other devices, force download
            link.href = url;
            link.download = 'star-L-summary.pdf';
            link.click();
        }

        // Clean up by revoking the blob URL
        window.URL.revokeObjectURL(url);
    });
}

button.addEventListener('click', generatePDF);


</script>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById('doneBtn');

    // Get the confirm button inside the modal
    var confirmBtn = document.getElementById('confirmBtn');

    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }

    // When the user clicks the button, open the modal
    btn.onclick = function (event) {
        event.preventDefault();
        openModal();
    };

    // When the user clicks on confirm button, close the modal
    confirmBtn.onclick = function () {
        closeModal();
        // Redirect to worksheet link (uncomment line below if needed)
        // window.location.href = 'https://elevatetrak.com/worksheet.php';
    };
    var cancelBtn = document.getElementById('cancelBtn');

    // Function to handle cancel button click (closes the modal)
    cancelBtn.onclick = function () {
        closeModal();
    };


    // Save form data to sessionStorage
    function saveFormData() {
        const formData = document.getElementById('skillsForm').innerHTML; // Change 'yourForm' to the actual form ID or container
        sessionStorage.setItem('formData', formData);
    }

    // Load form data from sessionStorage
    function loadFormData() {
        const savedFormData = sessionStorage.getItem('formData');
        if (savedFormData) {
            document.getElementById('skillsForm').innerHTML = savedFormData; // Change 'yourForm' to the actual form ID or container
        }
    }

    // Call the loadFormData function when the page loads
    window.onload = loadFormData;


    $(window).scroll(function () {

        if ($(this).scrollTop() > 0) {
            $('.alert').hide();
        }

    });
</script>