<style>
      .table.table-custom tbody tr {
            background: #383b3f !important;
            /* border-radius: .1875rem; */
      }
         
        .row-gap {
        margin-bottom: 8px; /* Row spacing if needed */
      }
          .card2{
      height: 150px;
      background-color:#383b3f;

          }
        .yearDropdown, .monthDropdown {
          display: flex;
          align-items: center;
          cursor: pointer;
          position: relative;
        }

        #yearInput {
          cursor: pointer;
          width: 100%;
        }

        .dropdownMenu {
          display: none;
          flex-direction: column;
          background-color: #fff;
          border: 1px solid #ddd;
          border-radius: 5px;
          padding: 10px;
          position: absolute;
          top: 100%;
          left: 0;
          z-index: 10;
          width: 100%;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdownMenu p {
          margin: 0;
          padding: 5px;
          cursor: pointer;
          font-size: 14px;
        }

        .dropdownMenu p:hover {
          background-color: #f0f0f0;
        }

        .btn-secendory {
          background-color: #383b3f;
          color: white;  /* Ensures the button text is white */
          border: 1px solid #383b3f;
        }

        .btn-secendory:hover {
          background-color: #2c2f33;
          border-color: #2c2f33;
        }
   

.card-section {
  background-color: #007bff; /* Primary Blue */
  border-radius: 10px;
  text-align: left;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.card-section h3 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.card-section h1 {
  font-size: 2.5rem;
  font-weight: bold;
}

@media (max-width: 768px) {
  .row {
    flex-direction: column;
  }
  .card-section {
    margin-bottom: 15px;
  }
}
    
</style>

<div class="row">

  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        <p class="texth2">Here we find all the data including incomes, revenue, expense and taxes...</p>

        <div class="collapse show" id="collapseExampleFilter">
          <form id="filterForm">
            <div class="row">
              <!-- Year Dropdown -->
              <div class="col-md-2 form-group">
                  <?php $app_years = $this->Common->get_app_years(); 
                   $current_year  = date('Y');
                  ?>
                <div class="yearDropdown position-relative">
                  <select id="yearSelect" class="form-control select2">
                    <option value="" disabled selected>Select Year</option>
                    <?php foreach($app_years as $year){ 
                     ?>
                     <option value="<?php echo $year->year; ?>" <?php if($year->year==$current_year){ echo'selected'; }?>><?php echo $year->year; ?></option>
                     <?php 
                    }?>
                  </select>
                </div>
              </div>

              <!-- Month Dropdown -->
              <div class="col-md-2 form-group">
                <div class="monthDropdown position-relative">
                  <select id="monthSelect" class="form-control select2">
                    <option value="" disabled selected>Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
              </div>

              <!-- Filter Button -->
              <div class="col-md-3 form-group">
                <?php $this->load->view('includes/filter_form_btn'); ?>
              </div>
            </div>
          </form>
        </div>

        <!-- Table and Content Section -->
        <div class="row">
          <!-- First Column (Table) -->
          <div class="col-md-5">
            <div class="table-responsive">
            <h4>Monthly Fixed Cost</h4>

              <table  style="border-collapse: collapse !important;" class="table table-hover js-basic-example dataTable table-custom spacing5">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('concept1'); ?></th>
                    <th><?php echo $this->lang->line('cost'); ?></th>
                    <th><?php echo $this->lang->line('%'); ?></th>
                    <th><?php echo $this->lang->line('tax_concept'); ?></th>
                    <th><?php echo $this->lang->line('tax'); ?></th>
                  </tr>
                </thead>
                <tbody id="api_response_table_body dataTables_paginate">
                <tr>
                  <th>Rent</th>
                    <th>$1,500</th>
                    <th>21</th>
                    <th>Non food</th>
                    <th>$315</th>
                    </tr>
                    <tr>
                    <th>Rent</th>
                    <th>$1,500</th>
                    <th>21</th>
                    <th>Non food</th>
                    <th>$315</th>
                    </tr>
                </tbody>
              </table>
              <button class="btn btn-secendory"onclick="openPopup()">+ Add New</button>
            </div>
          </div>

          <!-- Second Column (Empty) -->
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <!-- Third Column (Currency Dropdown) -->
          <!-- <div class="col-md-2 mt-3">
            
                <h5 class=""><?php echo $this->lang->line('currency'); ?></h5>
                <select name="currency" class="form-control select2">
                  <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                  <?php
                    $get_currencys = $this->Internal_model->get_currency();
                    foreach ($get_currencys as $get_currency) { ?>
                      <option value="<?php echo $get_currency->symbol; ?>"><?php echo $get_currency->name; ?> (<?php echo $get_currency->symbol; ?>)</option>
                  <?php } ?>
                </select>
              
          </div> -->
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <div class="col-md-3 mt-3">
           <h5 class="texth2 fs-2"><?php echo $this->lang->line('total'); ?></h5>
     <div class="card card2">
       <div class="table-responsive">
      <table class="table  table-striped texth2 text-bold">
        
        <tbody>
          <!-- Static Data -->
          <tr class="text-primary ">
            <td>Subtotal</td>
            <td>$500</td>
          </tr>
          <tr>
            <td>Total without taxes</td>
            <td>$450</td>
          </tr>
          <tr>
            <td>Tax (21%) Non food</td>
            <td>$50</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<div class="row">
          <!-- First Column (Table) -->
          <div class="col-md-5">
            <div class="table-responsive">
              <h4>Monthly Fixed Cost</h4>
              <table style="border-collapse: collapse !important;" class="table table-hover js-basic-example dataTable table-custom spacing5">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('concept1'); ?></th>
                    <th><?php echo $this->lang->line('cost'); ?></th>
                    <th><?php echo $this->lang->line('%'); ?></th>
                    <th><?php echo $this->lang->line('tax_concept'); ?></th>
                    <th><?php echo $this->lang->line('tax'); ?></th>
                  </tr>
                </thead>
                <tbody id="api_response_table_body dataTables_paginate">
                  <!-- Data will be dynamically inserted here -->
                   <tr>
                  <th>Rent</th>
                    <th>$1,500</th>
                    <th>21</th>
                    <th>Non food</th>
                    <th>$315</th>
                    </tr>
                    <tr>
                    <th>Rent</th>
                    <th>$1,500</th>
                    <th>21</th>
                    <th>Non food</th>
                    <th>$315</th>
                    </tr>
                </tbody>
              </table>
              <button class="btn btn-secendory"onclick="openPopup1()">+ Add New</button>
            </div>
          </div>

          <!-- Second Column (Empty) -->
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <!-- Third Column (Currency Dropdown) -->
          <!-- <div class="col-md-2 mt-3">
            
                <h5 class=""><?php echo $this->lang->line('currency'); ?></h5>
                <select name="currency" class="form-control select2">
                  <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                  <?php
                    $get_currencys = $this->Internal_model->get_currency();
                    foreach ($get_currencys as $get_currency) { ?>
                      <option value="<?php echo $get_currency->symbol; ?>"><?php echo $get_currency->name; ?> (<?php echo $get_currency->symbol; ?>)</option>
                  <?php } ?>
                </select>
              
          </div> -->
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <div class="col-md-3 mt-3">
           <h5 class="texth2 fs-2"><?php echo $this->lang->line('total'); ?></h5>
     <div class="card card2">
       <div class="table-responsive">
      <table class="table  table-striped texth2 text-bold">
        
        <tbody>
          <!-- Static Data -->
          <tr class="text-primary ">
            <td>Subtotal</td>
            <td>$500</td>
          </tr>
          <tr>
            <td>Total without taxes</td>
            <td>$450</td>
          </tr>
          <tr>
            <td>Tax (21%) Non food</td>
            <td>$50</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<div class="container-fluid">
<div class="row mt-3 ml-2">
  <div class="col-md-4 card-section bg-primary text-white p-3">
    <h3>Monthly Sales</h3>
    <h1>$563,518.13</h1>
  </div> 
  <div class="col-md-1 "></div>
 
  <div class="col-md-4 offset-md-2 card-section bg-primary text-white p-3">
    <h3>Total Expense Tax Inc.</h3>
    <h1>$3,005</h1>
  </div>
  
  <div class="col-md-1"></div>
</div>

          </div>

          <div class="mt-3">
  <div class="table-responsive">
    <table style="border-collapse: collapse !important;" class="table table-hover js-basic-example dataTable table-custom spacing5">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('concept1'); ?></th>
          <th><?php echo $this->lang->line('price_per_unit'); ?></th>
          <th><?php echo $this->lang->line('quantity'); ?></th>
          <th><?php echo $this->lang->line('total_tax'); ?></th>
          <th><?php echo $this->lang->line('tax_report'); ?></th>
          <th><?php echo $this->lang->line('tax_return'); ?></th>
          <th><?php echo $this->lang->line('total_after_tax'); ?></th>
          <th><?php echo $this->lang->line('revenue'); ?></th>
        </tr>
      </thead>
     
     
      <!-- First Row -->
      <tr style="background-color: #4c4f52; border-top: 5px solid #22252a;">
        <td><div class="d-flex align-items-center">
            <b class="texth2">Overall</b>
            <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div></td>
        <td>--</td>
        <td>41,204</td>
        <td>$ 563,518.13</td>
        <td>$ 118,339</td>
        <td>$ 3,005</td>
        <td>$ 445,179.13</td>
        <td>$ 445,179.13</td>
      </tr>
   
<!-- Spacing Row (for dropdown) -->


<tr class="mt-2"style="background-color: #4c4f52; border-top: 5px solid #22252a;">
        <td>
          <div class="d-flex align-items-center">
            <b class="texth2">H. A. P.</b>
            <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
        </td>
        <td colspan="7"></td>
      </tr>

      <!-- Data Rows -->
      <tr>
        <td>Handy Andy</td>
        <td>$ 9.99</td>
        <td>10,000</td>
        <td>$ 99,900</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>


      <!-- Spacing Row (for dropdown) -->
      <tr class="mt-2"style="background-color: #4c4f52; border-top: 5px solid #22252a;">
        <td>
          <div class="d-flex align-items-center">
            <b class="texth2">C. Profile</b>
            <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
        </td>
        <td colspan="7"></td>
      </tr>

      <!-- Data Rows -->
      <tr>
        <td>Micro Company</td>
        <td>$14.99</td>
        <td>6,000</td>
        <td>$89,940</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td>Small Profiles</td>
        <td>$19.99</td>
        <td>7,000</td>
        <td>$139,930</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td>Medium Profiles</td>
        <td>$24.99</td>
        <td>8,000</td>
        <td>$124,950</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td>Large Profiles</td>
        <td>$49.99</td>
        <td>3,237</td>
        <td>$161,817.63</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>


        <!-- Spacing Row (for dropdown) -->

        <tr class=""style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>
            <div class="d-flex align-items-center ">
              <b class="texth2">Boost P.</b>
              <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                  stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </td>
          <td colspan="7"></td>
        </tr>

        <!-- Data Rows -->
        <tr>
          <td>Position 1</td>
          <td>$5.00</td>
          <td>1</td>
          <td>$5.00</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>Position 2</td>
          <td>$5.00</td>
          <td>1</td>
          <td>$5.00</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>Position 3</td>
          <td>$5.00</td>
          <td>1</td>
          <td>$5.00</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>Position 4</td>
          <td>$5.00</td>
          <td>1</td>
          <td>$5.00</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        

        <!-- Spacing Row (for dropdown) -->
        <tr class="mt-3"style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>
            <div class="d-flex align-items-center ">
              <b class="texth2">Ext. Serv.</b>
              <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                  stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </td>
          <td colspan="7"></td>
        </tr>

        <!-- Data Rows -->
        <tr>
          <td>Extra service 2</td>
          <td>$14.99</td>
          <td>5,270</td>
          <td>$26,350</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>Extra service 3</td>
          <td>$2.50</td>
          <td>2,356</td>
          <td>$5,890</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>Banners</td>
          <td>$2.50</td>
          <td>2,356</td>
          <td>$5,890</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
       

        <tr style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>CV’s</td>
          <td>$2.50</td>
          <td>2,356</td>
          <td>$670</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<style scoped>


.normal-button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.icon-eye {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 40px;  /* Adjust the icon size as needed */
}
.normal-button:hover {
  background-color: #0056b3;
}
</style>
<!-- Button Section -->
<div class="" style="height: 45px;">
  <button class="normal-button text-left" style="width: 650px; position: relative;">
    <h3>Partners <i class="icon-eye"></i></h3>
  </button>
</div>

</div> 
<style>
  .custom-bg {
    background-color: #FFFFFF33 !important;
}

  .custom-card {
    background-color: #0061f2;
    color: white;
    border-radius: 15px;
    padding: 10px; /* Padding कम की गई */
    text-align: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease-in-out;
    height: 300px;
  }

  .custom-card:hover {
    transform: scale(1.05);
  }

  .profile-img {
    width: 70px; /* इमेज का साइज छोटा किया गया */
    height: 70px;
    object-fit: cover;
    margin-bottom: 5px; /* इमेज के नीचे का स्पेस कम किया */
    border: 2px solid white;
    border-radius: 50%;
  }

  .role {
    font-size: 14px; /* फॉन्ट साइज छोटा किया */
    font-weight: bold;
    margin-bottom: 5px; /* रोल के नीचे का स्पेस कम किया */
  }

  .info-section {
    font-size: 12px; /* कंटेंट का फॉन्ट साइज छोटा किया */
    margin: 3px 0; /* सेक्शन के बीच का स्पेस कम किया */
  }

  hr {
    border: 1px solid white;
    margin: 5px 0; /* लाइन के ऊपर-नीचे का स्पेस कम किया */
  }

  .create-btn {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 6px 10px; /* बटन का साइज छोटा किया */
    border-radius: 5px;
    cursor: pointer;
  }

  .create-btn:hover {
    background-color: #5a6268;
  }
</style>


<div class="container mt-5">
  <h3>Partners</h3>
    <button class="btn btn-secendory ml-4"onclick="openPopup()">+ Create New</button>
   <div class="row mt-3 ml-4">
   <div class="col-md-11 custom-bg card-body">
    <h2 class="ml-4 mt-3">Stack Holders</h2>

   </div>
    </div>
    </div>

</div>   
<div class="container-fluid mt-5">
  <div class="row justify-content-center d-flex ml-2">
    <!-- Card 1 -->
    <div class="col-md-3">
      <div class="custom-card">
        <img src="https://s3-alpha-sig.figma.com/img/ee2e/b392/11faece97f5ea3b1513a82115d92cb22?Expires=1736121600&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=S25nQmiM2JS8K4YDI5pyE-ifid-P-d4AC~NQolvqMMy61SO-QpE0n4kVnkoL~kyYXlgYYb2TF4Zn7oEQUPNg7KZYF4GgCzEBRouAsXjflNYrcImXvM-z4W8NH1g1ODOQPYdvyctZUNmms76ShQH3pOt5pPrhfWKnSy1ud7ybIW1l6XTM3KJ0gRSNdOm7jCLS3sCgm3HGMmHoa7wgNqS0x5hNE3TocvYbF6MROhRr-ofZSR3P54L225xcmcV3WOh021FC3XcpqsKeB4If1NAABnT7ZOuf5yLa0rFXEXpiOrQqPYtoL6mWlKX1cY-wD2ObXIpQPVuFSFbR2Fy-9nD2~A__" alt="Profile" class="rounded-circle profile-img">
        <h5 class="role">Director</h5>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Nombre</strong></p>
          <p class="partner text-right">M.P.</p>
          </div>
          <div class="info-section d-flex justify-content-between">
           <p class="nombre"><strong>Partner</strong></p>
          <p class="partner text-right">27 January 2025</p>
          </div>
          <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake %</strong></p>
          <p class="partner text-right">85%</p>
        </div>
      
        <hr >
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>ARQAA Revenue</strong></p>
          <p class="partner text-right">$ 445,179.13</p>
        </div>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake</strong></p>
          <p class="partner text-right">$378,402</p>
        </div>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="col-md-3">
      <div class="custom-card">
        <img src="https://s3-alpha-sig.figma.com/img/b8c5/ceb3/2da89aa67fd15b75afcb5207dfd0a9d7?Expires=1736121600&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=UnWEgMwrtiPEKSuXKFf8OmtoeZMFZ7hqD3NmNTPdo6mLRSkG9~xzNVhEB6zvRgzTngDL8WEttMdWM2Z-3kyuxig3tR4IIxHN1vHkM5UYJ48ZRkTvXRXBfIp4j2SQHGflCX6E1DXskkcFBATUfBpfOjCS3HK~12d1oW~SO2haa8f9dD1lKYjLvPONx7dZ8xUXXbyE~tjDLUtG~FFoQPP7N1OmZRe2uG3vwpcfm~XYl9DXH-gNev~uBmI1d3O056ynzB79vZlxxSmxLOK5y8TjmPxZA7Pweah1ZR9OIZAgGyB5CQSe6HKIdP1WhTMIhx49TmFfNxKwA9VkLrDnzuzgVg__" alt="Profile" class="rounded-circle profile-img">
        <h5 class="role">Director</h5>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Nombre</strong></p>
          <p class="partner text-right">M.P.</p>
          </div>
          <div class="info-section d-flex justify-content-between">
           <p class="nombre"><strong>Partner</strong></p>
          <p class="partner text-right">27 January 2025</p>
          </div>
          <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake %</strong></p>
          <p class="partner text-right">85%</p>
        </div>
      
        <hr>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>ARQAA Revenue</strong></p>
          <p class="partner text-right">$ 445,179.13</p>
        </div>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake</strong></p>
          <p class="partner text-right">$378,402</p>
        </div>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="col-md-3">
      <div class="custom-card">
        <img src="https://s3-alpha-sig.figma.com/img/30aa/473e/e21ae3eb7e3b8c79f5ecfb8173b840a3?Expires=1736121600&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=Lz2qYqVq011o245IcOhleTLjj4FyUHHugQy7a7ALbFGfgvPNy9OjB0lLR4XqXDu-dIvkg2qSe1LcgjhuuO7mYai2Ah6vfRjArrj-OdsPrOuPKMe3r3FtMAaAlvSzieEa5P7XmEc3dLuouBV4br3-Rj25YlMPlmKA2mrayKXEsBpGieJHVUZTCy9pDQECR5~OiyYeR-q9LwZ01yXpxzFNEE1s8E8uGiEXraNcYYlQi43IPle6wCrqfJATel9DWjkOYN4DGPjL-0od6HbB6o2LYKYfKX4wgmLsmDOJurIuEAeeTaYuBdm7LucA8Y4-ZzBPrak6tvx3FMZlSBiWMMKRlw__" alt="Profile" class="rounded-circle profile-img">
        <h5 class="role">Director</h5>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Nombre</strong></p>
          <p class="partner text-right">M.P.</p>
          </div>
          <div class="info-section d-flex justify-content-between">
           <p class="nombre"><strong>Partner</strong></p>
          <p class="partner text-right">27 January 2025</p>
          </div>
          <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake %</strong></p>
          <p class="partner text-right">85%</p>
        </div>
      
        <hr>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>ARQAA Revenue</strong></p>
          <p class="partner text-right">$ 445,179.13</p>
        </div>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake</strong></p>
          <p class="partner text-right">$378,402</p>
        </div>
      </div>
    </div>
    <!-- Card 4 -->
    <div class="col-md-3">
      <div class="custom-card">
        <img src="https://s3-alpha-sig.figma.com/img/534a/ab05/852ac2546d87081b636eb52bb85b2a47?Expires=1736121600&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=pWhB-GtSDirD8stGT-L5DSx5mdIwJ-ZKpvq5g6q1IotnS1SawSIKbtWg5~bZXBX1~-dV3zCn2Ki13IFtT9RaRB3nlDfC9DvnVtsZCZMEGzT7~tkQE41FRirR-VawMsxLF1PO8DVm0TtU6lK1wu8JFVQ5ldDsioJidPIvT4zH9JRqgHXISX5jl-CXoOLy~AGT9pSXqRhbvzd-XnYj4n747HtUwmk4tkFuFveGBf~qv6~dlFWqDbIMowtE8nT4~3fXyaS97tMqeqowvezAlTZieQjNunL9Vy0XCWoaCW7FR~x6N64UzzGzPf--iK4hxVSoS4igexMgKnocOEX21cMcpQ__" alt="Profile" class="rounded-circle profile-img">
        <h5 class="role">Director</h5>
       <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Nombre</strong></p>
          <p class="partner text-right">M.P.</p>
          </div>
          <div class="info-section d-flex justify-content-between">
           <p class="nombre"><strong>Partner</strong></p>
          <p class="partner text-right">27 January 2025</p>
          </div>
          <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake %</strong></p>
          <p class="partner text-right">85%</p>
        </div>
      
        <hr>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>ARQAA Revenue</strong></p>
          <p class="partner text-right">$ 445,179.13</p>
        </div>
        <div class="info-section d-flex justify-content-between">
          <p class="nombre"><strong>Stake</strong></p>
          <p class="partner text-right">$378,402</p>
        </div>
      </div>
    </div>

</div>






</div> 
<style>

/* Modal Background */
.modal {
    display: none; 
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: auto;
    overflow: auto;
    padding-top: 60px;
    background-color: rgba(0, 0, 0, 0.5); /* Slightly darkened background */
}

/* Modal Content */
.modal-content {
    background-color: #22252a;
    margin: 5% auto;
    padding: 30px;
    border: 1px solid #22252a;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.3s ease-out;
}

/* Fade-in Animation */
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

/* Close Button */
.close {
    color: #aaa;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 15px;
    right: 20px;
}

.close:hover,
.close:focus {
    color: #000;
    cursor: pointer;
}

/* Form Styles */
.form-sample {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.col-form-label {
    font-weight: 600;
    color: #333;
}

</style>



      </div>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3 class="card-title">Add New</h3>
        <p class="texth2">Here you can fill up your monthly cost</p>

        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/category/category/add" method="POST">
            <!-- <h4 class="card-description"><?php echo $this->lang->line('add_new');?> </h4> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('concept');?></label>
                        <input type="text" class="form-control" name="name" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('cost');?></label>
                        <input type="text" class="form-control" name="cost" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('%');?></label>
                        <input type="text" class="form-control" name="%" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('tax_concept');?></label>
                        <input type="text" class="form-control" name="tax_concept" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2"><?php echo $this->lang->line('submit');?></button>
            <button class="btn btn-danger mr-2" type="reset"onclick="closePopup()"><?php echo $this->lang->line('cancel');?></button>
            </div>
        </form>
        <br>
    </div>
</div>

<div id="myModal1" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePopup1()">&times;</span>
        <h3 class="card-title">Add New</h3>
        <p class="texth2">Here you can fill up your monthly cost</p>

        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/category/category/add" method="POST">
            <!-- <h4 class="card-description"><?php echo $this->lang->line('add_new');?> </h4> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('concept');?></label>
                        <input type="text" class="form-control" name="name" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('cost');?></label>
                        <input type="text" class="form-control" name="Cost" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('%');?></label>
                        <input type="text" class="form-control" name="%" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('tax_concept');?></label>
                        <input type="text" class="form-control" name="tax_concept" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2"><?php echo $this->lang->line('submit');?></button>
            <button class="btn btn-danger mr-2" type="reset"onclick="closePopup1()"><?php echo $this->lang->line('cancel');?></button>
            </div>
        </form>
        <br>
    </div>
</div>



<script>
  // Function to open the popup
function openPopup() {
    document.getElementById("myModal").style.display = "flex";
}

// Function to close the popup
function closePopup() {
    document.getElementById("myModal").style.display = "none";
}

// Function to handle removal confirmation
function confirmRemoval() {
    alert("Item removed!");
    closePopup(); // Close the popup after confirmation
}

function openPopup1() {
    document.getElementById("myModal1").style.display = "flex";
}

// Function to close the popup
function closePopup1() {
    document.getElementById("myModal1").style.display = "none";
}

// Function to handle removal confirmation
function confirmRemoval1() {
    alert("Item removed!1");
    closePopup(); // Close the popup after confirmation
}

    function renderTableData() {
      return [
        { "data": "concept", "orderable": true },
        { "data": "cost", "orderable": true },
        { "data": "%", "orderable": true },
        { "data": "tax_concept", "orderable": true },
        { "data": "tax", "orderable": true },
      ];
    }

    function toggleDropdown() {
      const dropdownMenu = document.getElementById('dropdownMenu');
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    function selectYear(year) {
      document.getElementById('yearInput').value = year;
      document.getElementById('dropdownMenu').style.display = 'none';
    }

    function filterDropdown() {
      const input = document.getElementById('yearInput').value.toUpperCase();
      const dropdownMenu = document.getElementById('dropdownMenu');
      const options = dropdownMenu.getElementsByTagName('p');

      for (let i = 0; i < options.length; i++) {
        const year = options[i].textContent || options[i].innerText;
        options[i].style.display = year.toUpperCase().indexOf(input) > -1 ? '' : 'none';
      }
    }
</script>

