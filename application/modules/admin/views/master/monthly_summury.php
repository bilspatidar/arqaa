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