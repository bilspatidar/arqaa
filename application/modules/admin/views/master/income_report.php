<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  <style>
    .card1{  
height: 300px;
border-radius: 10px 10px 10px 10px;
background-color:#3d4249 ;
padding: 10px; 


    }
    .card1 h6 {
        margin:0;
        color: #2D79E6;
        font-size: 14px;
        line-height: 23px;
        font-weight: 600;

    }
    /* Container for the dropdown */
.yearDropdown {
    margin-bottom:10px;
  position: relative;
  display: inline-block;
  cursor: pointer;
  color: white;
  border-radius: 5px;
  user-select: none;

}

/* Text displaying the current year */
.yearDropdown p {
  margin: 0;
  display: inline-block;
  font-size: 20px;
  color: #fff;
  font-weight:700;
}

/* Dropdown arrow (SVG) styling */
.yearDropdown svg {
  margin-left: 8px;
  vertical-align: middle;
  transition: transform 0.3s ease;
}

/* Rotate the arrow when dropdown is open */
.yearDropdown svg.rotate {
  transform: rotate(180deg);
}

/* Dropdown menu styling */
.dropdownMenu {
  display: none; /* Hidden by default */
  position: absolute;
  top: calc(100% + 5px);
  left: 0;
  background-color: #444;
  color: white;
  width: 100%;
  border-radius: 5px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  max-height: 200px;
  overflow-y: auto; /* Add scroll if too many items */
}

/* Individual year items */
.dropdownMenu p {
  padding: 10px;
  margin: 0;
  cursor: pointer;
  transition: background-color 0.2s ease;
  text-align: center;
  font-size: 14px;
}

/* Hover effect on year items */
.dropdownMenu p:hover {
  background-color: #555;
}

/* Scrollbar styling (optional) */
.dropdownMenu::-webkit-scrollbar {
  width: 6px;
}

.dropdownMenu::-webkit-scrollbar-thumb {
  background: #555;
  border-radius: 5px;
}

.dropdownMenu::-webkit-scrollbar-thumb:hover {
  background: #666;
}
.body1{
    background-color: #34C759 !important;
    color:#fff !important;
border-radius: 10px !important;

}
.body2{
    background-color: #FF3B30 !important;
    color:#fff !important;
border-radius: 10px !important;

}
.body3{
    background-color: #5856D6!important;
    color:#fff !important;
border-radius: 10px !important;

}
.body4{
    background-color:#30B0C7!important;
    color:#fff !important;
border-radius: 10px !important;

}
.h1{
  font-size: 30px;
}
.tax{
    display: flex;
    align-items: center;
    justify-content: space-between;

}
.taxbtn {
    margin-left: 0;
    font-size: 16px;
    font-weight: bold;
    padding: 5px 10px;
    margin-bottom:10px;
}
.texth2 {
    margin-right: 30px;
   
}
  </style>
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
      <div class="d-flex "style="justify-content: space-between !important;">
      <h3 class="card-title texth2"><?php echo $page_title; ?></h3>

                <div class="col-sm-6 text-right" >
                    <a href="<?php echo base_url();?>admin/master/monthly_fixed_cost" class="btn btn-primary btn-continue">Detail Info</a>
                </div>
            </div>
      
            <p class="texth2">Here we find all the data including incomes, revenue, expense adn taxes...</p>

      
         
      

        <div class="card1">
        <div class="tax d-flex justify-content-between align-items-center">
    <!-- Left Section: Yearly Dropdown -->
    <div>
        <h6>Yearly</h6>
        <div class="yearDropdown position-relative">
            <p id="currentYear">2024</p>
            <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879" 
                      stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            
             <?php $app_years = $this->Common->get_app_years(); 
                   $current_year  = date('Y');
                  ?>
                  
                  
            <div class="dropdownMenu position-absolute" id="dropdownMenu">
                <?php foreach($app_years as $year){  ?>
                <p onclick="selectYear(<?php echo $year->year; ?>)"><?php echo $year->year; ?></p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Right Section: Tax Buttons -->
    <div class="text-right">
        <h3 class="texth2 mb-0">Tax</h3>
        <div class="taxbtn1">
            <button class="btn btn-primary taxbtn"><?php echo $this->Common->get_tax_by_country($usersData['data']['id'],'user'); ?></button>
            <button class="btn btn-primary taxbtn">%</button>
        </div>
    </div>
</div>

           
          <div class="row clearfix">
         
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body1">
                            <div>Total revenue</div>
                            <div class="py-4 m-0 text-center h1">$ 563,518.13</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body2">
                            <div>Taxes to report</div>
                            <div class="py-4 m-0 text-center h1">$ 118, 339</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body3">
                            <div>Income After Tax</div>
                            <div class="py-4 m-0 text-center h1">$ 445,179.13</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body4">
                            <div>Expenses</div>
                            <div class="py-4 m-0 text-center h1">$ 3,005</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            </div>

            <style>

.dropdownMenu1 {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        background-color: #444;
        color: white;
        width: 100%;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    }

    .dropdownMenu1 p {
        padding: 10px;
        margin: 0;
        cursor: pointer;
        transition: background-color 0.2s ease;
        text-align: center;
        font-size: 10px;
        border-bottom: 1px solid #555;
    }

    .dropdownMenu1 p:last-child {
        border-bottom: none;
    }

    .dropdownMenu1 p:hover {
        background-color: #555;
    }

    /* Scrollbar styling */
    .dropdownMenu1::-webkit-scrollbar {
        width: 6px;
    }

    .dropdownMenu1::-webkit-scrollbar-thumb {
        background: #555;
        border-radius: 5px;
    }

    .dropdownMenu1::-webkit-scrollbar-thumb:hover {
        background: #666;
    }

    .monthDropdown {
        position: relative;
        margin-top: 20px;
    }

    #currentMonth {
        font-size: 14px;
        font-weight: 700;
        color: white;
        margin: 0;
        display: inline-block;
        cursor: pointer;
    }
</style>
           
            <div class="card1 mt-4">
            <h6>Montly</h6>

            <div class="yearDropdown">
            <p id="currentMonth">January</p>
            <svg onclick="toggleDropdown1()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879" stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="dropdownMenu1" id="dropdownMenu1">
            <p onclick="selectMonth('01')">January</p>
            <p onclick="selectMonth('02')">February</p>
            <p onclick="selectMonth('03')">March&nbsp;&nbsp;</p>
            <p onclick="selectMonth('04')">April&nbsp;&nbsp;</p>
            <p onclick="selectMonth('05')">May&nbsp;&nbsp;</p>
            <p onclick="selectMonth('06')">June&nbsp;&nbsp;</p>
            <p onclick="selectMonth('07')">July&nbsp;&nbsp;</p>
            <p onclick="selectMonth('08')">August</p>
            <p onclick="selectMonth('09')">September</p>
            <p onclick="selectMonth('10')">October</p>
            <p onclick="selectMonth('11')">November</p>
            <p onclick="selectMonth('12')">December</p>
        </div>
            </div>

          
          <div class="row clearfix">
            
          <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body1">
                            <div>Total revenue</div>
                            <div class="py-4 m-0 text-center h1">$ 563,518.13</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body2">
                            <div>Taxes to report</div>
                            <div class="py-4 m-0 text-center h1">$ 118, 339</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body3">
                            <div>Income After Tax</div>
                            <div class="py-4 m-0 text-center h1">$ 445,179.13</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="body body4">
                            <div>Expenses</div>
                            <div class="py-4 m-0 text-center h1">$ 3,005</div>
                            <div class="d-flex">
                                <small class="">Income</small>
                                <div class="ml-auto"><i class="fa fa-caret-up"></i> 4%</div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            </div>
      </div>
    </div>
  </div>
</div>



<script>
    function toggleDropdown1() {
    const dropdown = document.getElementById('dropdownMenu1');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

function selectMonth(month) {
    document.getElementById('currentMonth').innerText = month;
    toggleDropdown1(); // Close the dropdown after selecting
}

    function toggleDropdown() {
        const dropdownMenu = document.getElementById("dropdownMenu");
        const svgIcon = document.querySelector(".yearDropdown svg");

        if (dropdownMenu.style.display === "block") {
            dropdownMenu.style.display = "none";
            svgIcon.classList.remove("rotate");
        } else {
            dropdownMenu.style.display = "block";
            svgIcon.classList.add("rotate");
        }
        }

        function selectYear(year) {
        const currentYearElement = document.getElementById("currentYear");
        currentYearElement.textContent = year;

        const dropdownMenu = document.getElementById("dropdownMenu");
        dropdownMenu.style.display = "none";

        const svgIcon = document.querySelector(".yearDropdown svg");
        svgIcon.classList.remove("rotate");
        }

</script>

<script>
    let currentValue = 2; // Initial value

    function updateOutput() {
        document.getElementById('spinValue').textContent = currentValue;
		$("#value_of_spin").val(currentValue);
    }

    function increment() {
        if (currentValue < 1000) {
            currentValue++;
            updateOutput();
        }
    }

    function decrement() {
        if (currentValue > 1) {
            currentValue--;
            updateOutput();
        }
    }
    function increment() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    spinValue.innerText = currentValue + 1;
    hiddenInput.value = currentValue + 1; // Update the hidden input
}

function decrement() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    if (currentValue > 1) { // Prevent decrementing below 1
        spinValue.innerText = currentValue - 1;
        hiddenInput.value = currentValue - 1; // Update the hidden input
    }
}

	
</script>

