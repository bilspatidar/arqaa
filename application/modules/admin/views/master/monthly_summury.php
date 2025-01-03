<!-- Table and Content Section -->
        <div class="row">
          <!-- First Column (Table) -->
          <div class="col-md-8">
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
                  <?php $ttl_fix_cost = 0; $ttl_fix_cost_tax = 0; foreach($monthly_fixed_cost as $mfc){ ?>
                    <tr>
                      <th><?php echo $mfc->concept; ?></th>
                      <th><?php echo $mfc->currency; ?> <?php echo $mfc->amount; ?></th>
                      <th><?php echo $mfc->tax; ?></th>
                      <th><?php echo $mfc->tax_concept; ?></th>
                      <th><?php echo $mfc->currency; ?> <?php echo $tax_fix =  $this->Common->calculate_tax($mfc->amount,$mfc->tax); ?></th>
                    </tr>
                    
                  <?php $ttl_fix_cost+=$mfc->amount; $ttl_fix_cost_tax+=$tax_fix;  } ?>
                </tbody>
              </table>
              <button class="btn btn-secendory"onclick="openPopup()">+ Add New</button>
            </div>
          </div>

          
         
          <div class="col-md-4 mt-4">
           <h5 class="texth2 fs-2"><?php echo $this->lang->line('total'); ?></h5>
     <div class="card card2">
       <div class="table-responsive">
      <table class="table  table-striped texth2 text-bold">
        
        <tbody>
          <!-- Static Data -->
          <tr class="text-primary ">
            <td>Subtotal</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_fix_cost+$ttl_fix_cost_tax; ?></td>
          </tr>
          <tr>
            <td>Total without taxes</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_fix_cost; ?></td>
          </tr>
          <tr>
            <td>Tax (<?php echo $filterTax; ?> %)</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_fix_cost_tax; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<div class="row">
          <!-- First Column (Table) -->
          <div class="col-md-8">
            <div class="table-responsive"><br><br>
              <h4>Monthly Variable Cost</h4>
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
                  <?php $ttl_var_cost=0; $ttl_var_cost_tax=0; foreach($monthly_variable_cost as $mvc){ ?>
                    <tr>
                      <th><?php echo $mvc->concept; ?></th>
                      <th><?php echo $mvc->currency; ?> <?php echo $mvc->amount; ?></th>
                      <th><?php echo $mvc->tax; ?></th>
                      <th><?php echo $mvc->tax_concept; ?></th>
                      <th><?php echo $mvc->currency; ?> <?php echo $tax_var = $this->Common->calculate_tax($mvc->amount,$mvc->tax); ?></th>
                    </tr>
                    
                   <?php $ttl_var_cost+=$mvc->amount; $ttl_var_cost_tax+=$tax_var;  } ?>
                </tbody>
              </table>
              <button class="btn btn-secendory"onclick="openPopup1()">+ Add New</button>
            </div>
          </div>

          <!-- Second Column (Empty) -->
       
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
         
          <div class="col-md-4 mt-4">
           <h5 class="texth2 fs-2"><?php echo $this->lang->line('total'); ?></h5>
     <div class="card card2">
       <div class="table-responsive">
      <table class="table  table-striped texth2 text-bold">
        
        <tbody>
          <!-- Static Data -->
          <tr class="text-primary ">
            <td>Subtotal</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_var_cost+$ttl_var_cost_tax; ?></td>
          </tr>
          <tr>
            <td>Total without taxes</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_var_cost; ?></td>
          </tr>
          <tr>
            <td>Tax (<?php echo $filterTax; ?> %)</td>
            <td><?php echo $filterCurrency; ?> <?php echo $ttl_var_cost_tax; ?></td>
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
    <h1><?php echo $filterCurrency; ?> <?php echo $get_over_all_m_y[0]->total_amount;?></h1>
  </div> 
  <div class="col-md-1 "></div>
 
  <div class="col-md-4 offset-md-2 card-section bg-primary text-white p-3">
    <h3>Total Expense Tax Inc.</h3>
    <h1><?php echo $filterCurrency; ?> <?php echo $ttl_var_cost_tax+$ttl_fix_cost_tax; ?></h1>
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
          <?php foreach($get_over_all_m_y as $oall){ ?>
            <td>--</td>
            <td>41,204</td>
            <td>$ 563,518.13</td>
            <td>$ 118,339</td>
            <td>$ 3,005</td>
            <td>$ 445,179.13</td>
            <td>$ 445,179.13</td>
        <?php } ?>
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
            <b class="texth2">CV Resume data</b>
            <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
        </td>
        <td colspan="7"></td>
      </tr>

      <!-- Data Rows -->
      <?php foreach($cv_resume_data as $crd){ ?>
      <tr>
        <td><?php echo $crd->details; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $crd->amount; ?></td>
        <td><?php echo $crd->total_count; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $crd->total_amount; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $tax_cv = $this->Common->calculate_tax($crd->total_amount,$crd->tax); ?> </td>
        <td></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv = $crd->total_amount-$tax_cv; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv; ?></td>
      </tr>
    <?php } ?>


        <!-- Spacing Row (for dropdown) -->

        <tr class=""style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>
            <div class="d-flex align-items-center ">
              <b class="texth2">Boost Profile</b>
              <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                  stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </td>
          <td colspan="7"></td>
        </tr>

        <!-- Data Rows -->
        <!-- Data Rows -->
      <?php foreach($boost_profile_data as $bpd){ ?>
      <tr>
        <td><?php echo $bpd->details; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $bpd->amount; ?></td>
        <td><?php echo $bpd->total_count; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $bpd->total_amount; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $tax_cv = $this->Common->calculate_tax($bpd->total_amount,$bpd->tax); ?> </td>
        <td></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv = $bpd->total_amount-$tax_cv; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv; ?></td>
      </tr>
    <?php } ?>

        


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

        
        <?php foreach($multiple_service_data as $msd){ ?>
      <tr>
        <td><?php echo $msd->details; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $msd->amount; ?></td>
        <td><?php echo $msd->total_count; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $msd->total_amount; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $tax_cv = $this->Common->calculate_tax($msd->total_amount,$msd->tax); ?> </td>
        <td></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv = $msd->total_amount-$tax_cv; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv; ?></td>
      </tr>
    <?php } ?>




        <!-- Spacing Row (for dropdown) -->
        <tr class="mt-3"style="background-color: #4c4f52; border-top: 5px solid #22252a;">
          <td>
            <div class="d-flex align-items-center ">
              <b class="texth2">Adv. Banner</b>
              <svg onclick="toggleDropdown()" width="21" height="8" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.9305 2.88886C17.9305 2.88886 12.2023 10.6666 10.1528 10.6666C8.10307 10.6666 2.375 2.88879 2.375 2.88879"
                  stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
          </td>
          <td colspan="7"></td>
        </tr>

        
        <?php foreach($advertisment_banner_data as $abd){ ?>
      <tr>
        <td><?php echo $abd->details; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $abd->amount; ?></td>
        <td><?php echo $abd->total_count; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $abd->total_amount; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo $tax_cv = $this->Common->calculate_tax($abd->total_amount,$abd->tax); ?> </td>
        <td></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv = $msd->total_amount-$tax_cv; ?></td>
        <td><?php echo $filterCurrency; ?> <?php echo  $after_tax_cv; ?></td>
      </tr>
    <?php } ?>


      </tbody>
    </table>
  </div>
</div>

<!-- Button Section -->
<div class="" style="height: 45px;">
  <button class="normal-button text-left" style="width: 650px; position: relative;">
    <h3>Partners <i class="icon-eye"></i></h3>
  </button>
</div>

       
</div>
</div>      
  







      </div>
    </div>
  </div>
</div>

