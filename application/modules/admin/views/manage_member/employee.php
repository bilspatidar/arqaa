<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DP SAFEGUARD PVT.LTD</title>
    <style>
        .center {
            text-align: center;
        }


      




    </style>
</head>
<body>



<button class="print-button" onclick="printForm()">Print</button>
    <div id="printableForm">
<script>
    function printForm() {
        var printContents = document.getElementById('printableForm').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

<form  id="myForm">
   
    <div class="center">
       <h1>DP SAFEGUARD PVT.LTD.</h1>  
    </div>


 
     <div class="center">
        <label>Email: info@dpsafeguard.com Website: www.dpsafeguard.com</label><br>
    </div>
 
    <div class="center">
        <label>Mob. 79877 72686 , Tel (07422) 796391</label><br>
    </div>

     <div class="center" style="border: 1px solid blue; padding: 10px; margin: 10px;">
          <label> Head Office : 2nd Floor, Jhulelal Estate, Kambal Kendra Road, Nai Aabadi, Mandsaur (M.P.) - 458001</label><br>
     </div>


  
    <?php
            $id = 979;
            $get_user = $this->Internal_model->get_user_details($id); ?>
        <div class="center">
            <h3><u>EMPLOYEE JOINING FORM</u></h3>
        </div>
    

         <div>
              <h5 style="margin: 20px; padding: 5px;" >Appointment Place: ..............................</h5>
              <h5 style="margin: 20px; padding: 5px;" >Designation: ..............................</h5>
              <h5 style="margin: 20px; padding: 5px;" >Date: ..............................</h5>
         </div>


        <div style="text-align: right; margin-top: -110px;">
                <img class="logo_size_set1" src="<?php echo base_url(); ?>uploads/employee/henuu.jpg" alt="henuu" style="height: 200px; width: 200px;" />
        </div>




      <div>
           <h5 style="margin-left: 7%;">01. Employee Name :-First Name :<?php echo $get_user[0]->first_name;?>&nbsp;&nbsp;&nbsp;&nbsp;Last Name :<?php echo $get_user[0]->last_name;?></h5>
           <h5 style="margin-left: 7%;">02. Father Name :- <?php echo $get_user[0]->father_name;?> &nbsp;&nbsp;&nbsp;&nbsp; Last Name :<?php echo $get_user[0]->last_name;?></h5>
           <h5 style="margin-left: 7%;">03. Mother Name :- <?php echo $get_user[0]->mother_name;?> &nbsp;&nbsp;&nbsp;&nbsp; Last Name :<?php echo $get_user[0]->last_name;?></h5>
           <h5 style="margin-left: 7%;">04. Gender ( Male / Female / Others ) :<?php $get_user[0]->gender = 'male'; echo $get_user[0]->gender; ?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
           <h5 style="margin-left: 7%;">05. DOB (As per Aadhar Card ) :  <?php echo $get_user[0]->dob;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
           <h5 style="margin-left: 7%;">06. Blood Group :-<?php echo $get_user[0]->blood_group;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
           <h5 style="margin-left: 7%;">07. Identification Mark :-<?php echo $get_user[0]->identification_mark;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
           <h5 style="margin-left: 7%;">08. Mobile No. 01. <?php echo $get_user[0]->mobile;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
           <h5 style="margin-left: 7%;">08. Alt Mobile No. 02. <?php echo $get_user[0]->alt_mobile;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
           <h5 style="margin-left: 7%;">09. Email id:- <?php echo $get_user[0]->email;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
           <h5 style="margin-left: 7%;">10. Aadhar Card No.:- <?php echo $get_user[0]->aadhar_no;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
           <h5 style="margin-left: 7%;">11.Any other Identity : ( Voter ID / PAN Card / Passport ) :- <?php echo $get_user[0]->id_proof;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
        </div>


      <br><br>

  <div>
        <h5 style="margin-left: 7%;"> 12.Permanent Residential Address (as per Aadhar Card) :- <?php echo $get_user[0]->permanent_address;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> District :- <?php echo $get_user[0]->district;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> State :- <?php echo $get_user[0]->state_name;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> Pin Code  :- <?php echo $get_user[0]->pincode;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>

        <h5 style="margin-left: 7%;"> 13.Present Address :- <?php echo $get_user[0]->present_address;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> District :- <?php echo $get_user[0]->present_district;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> State :- <?php echo $get_user[0]->state_name;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> Pin Code  :- <?php echo $get_user[0]->present_pincode;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
        <h5 style="margin-left: 7%;">14. Bank Name:- <?php echo $get_user[0]->bank_name;?> &nbsp;&nbsp;&nbsp;&nbsp; 
        <h5 style="margin-left: 7%;"> Branch:- <?php echo $get_user[0]->branch_name;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> Account No. :- <?php echo $get_user[0]->account_no;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;"> IFSC Code  :- <?php echo $get_user[0]->ifsc_code;?> &nbsp;&nbsp;&nbsp;&nbsp;</h5>
    <div>
 

    <div>

       <h5 style="margin-left: 7%;">15. Height :<?php echo $get_user[0]->height;?> &nbsp;&nbsp;&nbsp;&nbsp;
       <h5 style="margin-left: 7%;"> Weight: <?php echo $get_user[0]->weight; ?> kg</h5>
       <h5 style="margin-left: 7%;"> Detail of Arm : <?php echo $get_user[0]->detail_of_arm;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>


       <h5 style="margin-left: 7%;">Arm Code : <?php echo $get_user[0]->arm_code;?> &nbsp;&nbsp;&nbsp;&nbsp;
       <h5 style="margin-left: 7%;">License No. : <?php echo $get_user[0]->license_no;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>


       <h5 style="margin-left: 7%;">Issue Date : <?php echo $get_user[0]->issue_date;?> &nbsp;&nbsp;&nbsp;&nbsp;
       <h5 style="margin-left: 7%;">Expiry Date : <?php echo $get_user[0]->expiry_date;?> &nbsp;&nbsp;&nbsp;&nbsp;
       <h5 style="margin-left: 7%;">Issue State: <?php echo $get_user[0]->state_name;?> &nbsp;&nbsp;&nbsp;&nbsp;
       <h5 style="margin-left: 7%;"> Issue District: <?php echo $get_user[0]->issue_district;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
       <h5 style="margin-left: 7%;">( Only for Security Guards )</h5>



       <br><br>


        <h5 style="margin-left: 7%;">16. Do you ever convicted by competent court for an offence, the prescribed punishmentfor which isimprisonment of not less than 2 years ? If yes then</h5>
        <h5 style="margin-left: 7%;">Police Station: <?php echo $get_user[0]->police_station;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;">Case No. & Year: <?php echo $get_user[0]->case_of_year;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
        <h5 style="margin-left: 7%;">Court Name :-  <?php echo $get_user[0]->court_name;?> &nbsp;&nbsp;&nbsp;&nbsp;
        <h5 style="margin-left: 7%;">Crime  :-  <?php echo $get_user[0]->crime;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>




         <h5 style="margin-left: 7%;">17. Police Verification Report : Issue Date <?php echo $get_user[0]->PV_issue_date;?> &nbsp;&nbsp;&nbsp;&nbsp;
         <h5 style="margin-left: 7%;"> Police Verification Report : Police Station<?php echo $get_user[0]->PV_police_station;?> &nbsp;&nbsp;&nbsp;&nbsp; </h5>
         <h5 style="margin-left: 7%;">District:-  <?php echo $get_user[0]->PV_district;?> &nbsp;&nbsp;&nbsp;&nbsp; 
         <h5 style="margin-left: 7%;">State:- <?php echo $get_user[0]->state_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    </div>

    

    <div class="center">
       <h3><u>SELF DECLARATION</u></h3>


        <h5 style="margin-left: 7%;">I hereby declare that all the information given above is true and correct to the best of my knowledge. All the information shared inthe Employee Joining Form is correct, and I take full responsibility for its correctness. I solemnly declare that the information in thisEmployee Joining Form is true to the best of my knowledge andbelief.</h5>
  </div>


 
        <div class="center">
            <h3><u>FOR OFFICIAL USE ONLY</u></h3>
        </div>
    <div>
         <h5 style="margin-left: 8%;">Location Code : ..............................</h5>
         <h5 style="margin-left: 8%;">Category : ..............................</h5>
         <h5 style="margin-left: 8%;">Designation Code : ..............................</h5>
         <h5 style="margin-left: 8%;">Department : ..............................</h5>
         <h5 style="margin-left: 8%;">Joining Date :  ..............................</h5>   
         <h5 style="margin-left: 8%;">ID CARD No : ............................. Issue Date ................ Expiry Date  ..............................</h5>
         <h5 style="margin-left: 8%;">Dress (If any) : Issue Date ................ . Charges : ..............................</h5>
     </div>





</form>


</body>
</html>