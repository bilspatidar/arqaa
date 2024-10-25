<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_upload_model extends CI_Model {

    protected $table      = 'documents';
    protected $primaryKey = 'id';

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();        
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    } 
    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    public function update($data, $users_id) {
        $response = $this->db->update($this->table, $data, array('users_id'=>$users_id));
        return $this->db->affected_rows();
    }
    public function upload($data, $users_id) {
        $response = $this->db->insert($this->table, $data, array('users_id'=>$users_id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get00($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("documents.*,(users.first_name) as firstName,(document_category.name) as DC_name,(users.id) as UserId");
        $this->db->from($this->table);
        $this->db->join('users','users.id = documents.users_id','left');
        $this->db->join('document_category','document_category.id = documents.document_category_id','left');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['users_id']) && !empty($filterData['users_id'])){
			$this->db->like('users_id',$filterData['users_id']);
		}
		if(isset($filterData['title']) && !empty($filterData['title'])){
			$this->db->like('title',$filterData['title']);
		}
		if(isset($filterData['document_category_id']) && !empty($filterData['document_category_id'])){
			$this->db->like('document_category_id',$filterData['document_category_id']);
		}
		if(isset($filterData['document_sub_category_id']) && !empty($filterData['document_sub_category_id'])){
			$this->db->like('document_sub_category_id',$filterData['document_sub_category_id']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where('status',$filterData['status']);
		}
		$this->db->order_by($this->primaryKey,'desc');
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();    
           } else {
            $this->db->limit($limit, $page);
            return  $this->db->get()->result();
            
            }
           }
          
           public function get_document_category() {
            $this->db->select("*");
            $this->db->from("document_category");
            $query = $this->db->get();
        
            if ($query === false) {
                $error = $this->db->error();
                log_message('error', 'Database error: ' . $error['message']);
                return false;
            }
            return $query->result();
        }
        
        public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
            $this->db->select("documents.*, (users.first_name) as firstName, (users.id) as UserId");
            $this->db->from($this->table);
            $this->db->join('users', 'users.id = documents.users_id', 'left');
            $this->db->join('document_category', 'document_category.id = documents.document_category_id', 'left');
        
            if (!empty($id)) {
                $this->db->where($this->primaryKey, $id);
            }
        
            if (isset($filterData['users_id']) && !empty($filterData['users_id'])) {
                $this->db->like('users_id', $filterData['users_id']);
            }
        
            if (isset($filterData['title']) && !empty($filterData['title'])) {
                $this->db->like('title', $filterData['title']);
            }
        
            if (isset($filterData['document_category_id']) && !empty($filterData['document_category_id'])) {
                $this->db->like('document_category_id', $filterData['document_category_id']);
            }
        
            if (isset($filterData['document_sub_category_id']) && !empty($filterData['document_sub_category_id'])) {
                $this->db->like('document_sub_category_id', $filterData['document_sub_category_id']);
            }
        
            if (isset($filterData['status']) && !empty($filterData['status'])) {
                $this->db->where('status', $filterData['status']);
            }
        
            $this->db->order_by($this->primaryKey, 'desc');
        
            if ($isCount == 'yes') {
                $all_res = $this->db->get();
                return $all_res->num_rows();
            } else {
                $output = '
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Title</th>';
            $documentCategory = $this->get_document_category();
            foreach ($documentCategory as $dc) {
                $output .= '<th>'.$dc->name.'</th>';
            }
            $output .= '<th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        
                $this->db->select("documents.*, (users.first_name) as firstName, (document_category.name) as DC_name, (users.id) as UserId");
                $this->db->from('documents');
                $this->db->join('users', 'users.id = documents.users_id', 'left');
                $this->db->join('document_category', 'document_category.id = documents.document_category_id', 'left');
                $this->db->group_by('users.id');
                $data = $this->db->get()->result();
                $sr = 1;
                foreach ($data as $row) {
                    $output .= '<tr>
                                    <td>' . $sr++ . '</td>
                                    <td>' . $row->firstName . '</td>
                                    <td>' . $row->title . '</td>';
        
                    foreach ($documentCategory as $dc) {
                        $catId = $dc->id;
                        $validate = $this->db->get_where('documents', array('users_id' => $row->users_id, 'document_category_id' => $catId));
                        if ($validate->num_rows() > 0) {
                            $DocFiles = $validate->row()->document_front_file;
                            if (!empty($DocFiles)) {
                                $downloadURL = $DocFiles;
                                $output .= "<td><a href='$downloadURL' target='_blank'>Click</a></td>";
                            } else {
                                $output .= "<td><span style='color: red; cursor: pointer;' onclick='openModal($row->users_id, $catId)'>No</span></td>";
                            }
                        } else {
                            $output .= "<td><span style='color: red; cursor: pointer;' onclick='openModal($row->users_id, $catId)'>No</span></td>";
                        }
                    }
        
                    $output .= '<td>' . $row->status . '</td>
                                </tr>';
                }
        
                $output .= '</tbody>
                            </table>
        <script>
        $(document).ready(function(){
            $("#crudFormAddApiDataModel").on("submit",(function(e) {
                e.preventDefault();
                $(".loading").show();
                var token = $("#api_access_token").val();
                var post_link = $(this).attr("action");
                var formData = new FormData();
        
                $(this).find(":input").each(function() {
                    var field_name = $(this).attr("name");
                    var field_value = $(this).val();
                    if (field_name) {
                        formData.append(field_name, field_value);
                    }
                });
        
                var files = $(this).find("input[type=file]");
                files.each(function(index, fileInput) {
                    if (fileInput.files.length > 0) {
                        var file = fileInput.files[0];
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            formData.append(fileInput.name, e.target.result);
                            if (index === files.length - 1) {
                                sendAjaxRequest(formData, token, post_link);
                            }
                        };
                        reader.readAsDataURL(file);
                    } else {
                        if (index === files.length - 1) {
                            // If all files have been processed, send the AJAX request
                            sendAjaxRequest(formData, token, post_link);
                        }
                    }
                });
        
                if (files.length === 0) {
                    sendAjaxRequest(formData, token, post_link);
                }
            }));
        
            function sendAjaxRequest(formData, token, post_link) {
                var jsonObject = {};
                formData.forEach(function(value, key){
                    jsonObject[key] = value;
                });
                var jsonData = JSON.stringify(jsonObject);
        
                $.ajax({
                    url: post_link,
                    type: "POST",
                    dataType: "json",
                    headers: {
                        "Token": token
                    },
                    data: jsonData,
                    contentType: "application/json",
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $(".loading").hide();
                        toastr.success(response.message);
                        $("#categoryModal").modal("hide");
                        updateTable();  
                        updateTable();
                    },
                    error: function(xhr, status, error) {
                        $(".loading").hide();
                        var json = $.parseJSON(xhr.responseText);
                        
                        if(json.errors){
                            if(json.errors.length>1){
                                var formattedErrors = json.errors.map(function(error) {
                                    var lineLength = 100;
                                    var regex = new RegExp(".{1," + lineLength + "}", "g");
                                    var formattedError = error.replace(regex, function(match) {
                                        return match + "\n";
                                    });
                                    return formattedError;
                                });
                                var errorsString = formattedErrors.join(".\n");
                                toastr.error(errorsString);
                            }else{
                                toastr.error(json.errors);
                            }
                        }else{
                            toastr.error(json.message);
                        }
                    }
                });
            }
        
            function updateTable() {
                $("#api_response_table").DataTable().ajax.reload();
            }
        
            function openModal(userId, categoryId) {
                $("#userId").val(userId);
                $("#categoryId").val(categoryId);
                $("#categoryModal").modal("show");
            }
        
            function saveData() {
                var userId = $("#userId").val();
                var categoryId = $("#categoryId").val();
                $.ajax({
                    type: "POST",
                    url: "save_data.php",
                    data: { userId: userId, categoryId: categoryId },
                    success: function(response) {
                        alert("Data saved successfully!");
                        $("#categoryModal").modal("hide");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error saving data. Please try again.");
                    }
                });
            }
        });
        </script>';
        
        $output .= '<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
                            <!-- Modal content here -->
                        </div>';
        
        return $output;
        }
    }
        
        
    }

