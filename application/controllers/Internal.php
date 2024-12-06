<?php
class Internal extends CI_Controller {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Internal_model');
        $this->lang->load('information','english');
    }

  
        function switch_lang($language = "") {
               $language = ($language != "") ? $language : "english";
               $this->session->set_userdata('site_lang', $language);
               redirect($_SERVER['HTTP_REFERER']);
    }
    
    // Load language file
  function ddd(){
      $uuu = $this->db->get('users')->result_array();
      print_r($uuu);
  }
  
  function country_currency(){
      $this->db->select('shortname,id');
      $this->db->from('countries');
      $this->db->where('currency_code','');
      $this->db->limit(400);
      $countries =  $this->db->get()->result();
     foreach($countries as $cnt){
       
         
         $country_code =  $cnt->shortname; // Change this to any valid ISO 3166-1 alpha-2 country code

        // Create the URL for the API request
        $url = "https://restcountries.com/v3.1/alpha/$country_code";
        
        // Initialize cURL session
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL to fetch
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string instead of outputting it
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL certificate verification (for development)
        
        $response = curl_exec($ch); // Execute cURL request
        
        // Check if the request was successful
        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch); // Output error if any
        } else {
            // Decode the JSON response
            $country_data = json_decode($response, true);
        
            // Output the country data
            if (isset($country_data[0])) {
                // Example of displaying country name and currency
                //echo "Country: " . $country_data[0]['name']['common'] . "\n";
                //echo "Currency: " . key($country_data[0]['currencies']) . " - " . $country_data[0]['currencies'][key($country_data[0]['currencies'])]['name'] . "\n";
               
                
                // Output the results
                $ind['currency_code'] = key($country_data[0]['currencies']);
                $ind['currency_name'] =  $country_data[0]['currencies'][key($country_data[0]['currencies'])]['name'];
                // $this->db->where('id',$cnt->id);
                // $this->db->update('countries',$ind);




            } else {
               $ind['currency_code'] = ''; 
            }
            
            $this->db->where('id',$cnt->id);
            $this->db->update('countries',$ind);
        }
        
        // Close cURL session
        curl_close($ch);
        
        
        
        
     }
  }

    public function get_state($countryId='',$StateId=''){
        $states = $this->Internal_model->get_state($countryId);
        if(count($states)>0)
        {
            foreach($states as $state){
                ?>
           <option value='<?php echo $state->id; ?>' <?php if(!empty($StateId && $StateId==$state->id)){ echo'selected'; } ?>>
               <?php echo $state->name; ?></option>	
           <?php 
            }
        }
        else
        {
            echo"<option value=''>no state found!</option>";
        }
         }
    public function get_city($StateId='',$CityId=''){
            $cities = $this->Internal_model->get_city($StateId);
            if(count($cities)>0)
            {
                foreach($cities as $city){
                    ?>
               <option value='<?php echo $city->id; ?>' <?php if(!empty($CityId && $CityId==$city->id)){ echo'selected'; } ?>>
                   <?php echo $city->name; ?></option>	
               <?php 
                }
            }
            else
            {
                echo"<option value=''>no city found!</option>";
            }
        }
    public function getDateUserData($date){
        $user_data = $this->Internal_model->getUser($date);
?>
<table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Remarks</th>
                    <!-- <th>Latitude</th>
                    <th>Longitude</th> -->
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            
                <?php 
                $getUsuser_dataer = $this->Internal_model->getUser();
                $sr = 1;
                foreach($user_data as $row){ ?>
                <tr>
                    <td><?php echo $sr++;?></td>
                    
                    <td><input type="hidden" name="id[]" value="<?php echo $row->attendance_id;?>" readonly>
                      <input type="hidden" name="user_id[]" value="<?php echo $row->users_name;?>" readonly>
                    <input type="text" value="<?php echo $row->first_name;?>" readonly></td>
                    <td><input type="text" name="remarks[]" value="<?php echo $row->remarks;?>"></td>
                   <input type="hidden" name="latitude[]" value="<?php echo $row->latitude;?>">
                   <input type="hidden" name="longitude[]" value="<?php echo $row->longitude;?>">
                    <td><select name="status[]"><option value="Absent" <?php if($row->status == 'Absent'){echo 'selected';} ?>>Absent</option>
                            <option value="Present" <?php if($row->status == 'Present'){echo 'selected';} ?>>Present</option>
                            <option value="Half day" <?php if($row->status == 'Half day'){echo 'selected';} ?>>Half day</option>
                            <option value="Leave" <?php if($row->status == 'Leave'){echo 'selected';} ?>>Leave</option>
                        </select>
                    </td>
                </tr>
                <?php  } ?>
            </tbody>
        </table>

   <?php }                                                                                                       
    public function get_col_by_key(){
        $id = $this->input->get('id'); // POST request se ID retrieve karo
        $this->db->select('first_name');
        $this->db->from('users');
        $this->db->where('id',$id);
        $res = $this->db->get();
        if($res->num_rows() > 0) {
            echo json_encode($res->row());
        } else {
            echo json_encode(null); 
        }
    }
    
    public function get_total_expenses($project_id=''){
        $project_id = $this->input->get('project_id');
        $this->db->select_sum('amount');
        $this->db->from('expenses');
        $this->db->where('project_id', $project_id);
        $res = $this->db->get();
        if($res->num_rows() > 0) {
            echo json_encode($res->row());
        } else {
            echo json_encode(null); 
        }
    }
    
    public function get_total_income($project_id=''){
        $project_id = $this->input->get('project_id');
        $this->db->select_sum('amount');
        $this->db->from('payments');
        $this->db->where('project_id', $project_id);
        $res = $this->db->get();
        if($res->num_rows() > 0) {
            echo json_encode($res->row());
        } else {
            echo json_encode(null); 
        }
    }
    public function get_total_due($project_id=''){
        $project_id = $this->input->get('project_id');
        $this->db->select_sum('amount');
        $this->db->from('payments');
        $this->db->where('project_id', $project_id);
        $res = $this->db->get();
        if($res->num_rows() > 0) {
            echo json_encode($res->row());
        } else {
            echo json_encode(null); 
        }
    }
    
    public function get_project($year = '') {
        $this->db->select("*");
        $this->db->from('pms_project');
        $this->db->order_by('id', 'desc');
        
        if ($year != '') {
            $this->db->where('YEAR(added)', $year);
        }
        
        $this->db->limit(4);
        $project = $this->db->get()->result();
        
        foreach ($project as $row) {
            $project_id = $row->id;
            $Income = $row->amount; //$this->Internal_model->getTotalIncomeIndex($project_id);
            $ExpensesProject = $this->Internal_model->getexpensesProject($project_id);
            $TotalIncome = $Income - $ExpensesProject;
            ?>
    
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0"><?php echo $Income; ?></h3>
                                    <?php if ($ExpensesProject >= $Income) { ?>
                                        <p class="text-danger ml-2 mb-0 font-weight-medium">
                                            <?php echo $ExpensesProject; ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="text-success ml-2 mb-0 font-weight-medium">
                                            <?php echo $ExpensesProject; ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-arrow-top-right icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal"><?php echo $row->title; ?></h6>
                    </div>
                </div>
            </div>
            
            <?php
        }
    }
    
    public function get_status_data() {
        $this->db->select("*");
        $this->db->from('pms_project');
        $this->db->order_by('id', 'desc'); 
        $this->db->where('status', 'In Progress');
        
        $project = $this->db->get()->result();
        
        foreach ($project as $row) {
            $project_id = $row->id;
            $Income = $row->amount; //$this->Internal_model->getTotalIncomeIndex($project_id);
            $ExpensesProject = $this->Internal_model->getexpensesProject($project_id);
            $TotalIncome = $Income - $ExpensesProject;
    
            $addedTime = new DateTime($row->added); 
            $currentTime = new DateTime();
        
            $timeDiff = $currentTime->diff($addedTime); 
            $unit = ($timeDiff->h > 0) ? "hours" : "minutes";
            $value = ($unit === "hours") ? $timeDiff->h : $timeDiff->i;
            ?>
    
                            <div class="preview-list">
                              <div class="preview-item border-bottom">
                                <div class="preview-thumbnail">
                                  <div class="preview-icon bg-primary">
                                    <i class="mdi mdi-file-document"></i>
                                  </div>
                                </div>
                                <div class="preview-item-content d-sm-flex flex-grow">
                                  <div class="flex-grow">
                                    <h6 class="preview-subject"><?php echo $row->title; ?></h6>
                                    <p class="text-muted mb-0"><?php echo $row->location; ?></p>
                                  </div>
                                  <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                    <p class="text-muted"><?php  echo $value . " " . $unit . " ago";?> ago</p>
                                    <p class="text-muted mb-0">30 tasks, 5 issues </p>
                                  </div>
                                </div>
                              </div>
                            </div>
            
            <?php
        }
    }

}
?>

