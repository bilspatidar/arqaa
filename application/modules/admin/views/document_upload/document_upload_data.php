
    <table class="table table-dark table-striped" id="data_show">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Title</th>
                <?php 
                $documentCategory = $this->Internal_model->get_document_category();
                foreach($documentCategory as $dc){ ?>
                    <th><?php echo $dc->name; ?></th>
                <?php } ?>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="api_response_table_body">
            <?php
           
            $this->db->select("documents.*,(users.first_name) as firstName,(document_category.name) as DC_name,(users.id) as UserId");
            $this->db->from('documents');
            $this->db->join('users','users.id = documents.users_id','left');
            $this->db->join('document_category','document_category.id = documents.document_category_id','left');
            $this->db->group_by('users.id');
            if(isset($filterData['name']) && !empty($filterData['name'])){
                $this->db->where('documents.title', $filterData['name']);
            }
            if(isset($filterData['status']) && !empty($filterData['status'])){
                    $this->db->where('documents.status', $filterData['status']);
            }
            
            $data= $this->db->get()->result();
            $sr = 1;
            foreach($data as $row){ ?>
                <tr>
                    <td><?php echo $sr++ ;?></td>
                    <td><?php echo $row->firstName ;?></td>
                    <td><?php echo $row->title ;?></td>
                    <?php foreach($documentCategory as $dc){ 
                        $catId = $dc->id; 
                        $validate = $this->db->get_where('documents', array('users_id' => $row->users_id, 'document_category_id' => $catId));
                        if($validate->num_rows() > 0){
                            $DocFiles = $validate->row()->document_front_file;
                            if(!empty($DocFiles)){ 
                                $downloadURL = $DocFiles;
                                $downloadLink = "<a href='$downloadURL' target='_blank'>Click</a>";
                            } else {
                                $downloadLink = "<span style='color: red; cursor: pointer;' onclick='openModal($row->users_id, $catId)'>No</span>";
                            }
                        } else {
                            $downloadLink = "<span style='color: red; cursor: pointer;' onclick='openModal($row->users_id, $catId)'>No</span>";
                        }
                        ?>
                        <td>
                            <?php echo $downloadLink; ?>
                        </td>
                    <?php } ?>
                    <td><?php echo $row->status ;?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


<!-- Bootstrap Modal -->

    
<script>
$(document).ready(function(){
    // $('#api_response_table').DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": {
    //         "url": "< ?php echo API_DOMAIN; ?>api/document_upload/document_upload_list",
    //         "type": "POST"
    //     },
    //     "columns": [
    //         { "data": "id" },
    //         { "data": "firstName" },
    //         { "data": "title" },
    //         < ?php foreach($documentCategory as $dc){ ?>
    //             { "data": "<?php echo $dc->name; ?>" },
    //         < ?php } ?>
    //         { "data": "status" }
    //     ],
    //     "paging": true, 
    //     "pageLength": 10 
    // });

 

 
});

</script>
</div>

<script>
    function openModal(userId, categoryId) {
        $('#userId').val(userId);
        $('#categoryId').val(categoryId);
        $('#categoryModal').modal('show');
    }

    function saveData() {
        var userId = $('#userId').val();
        var categoryId = $('#categoryId').val();
        $.ajax({
            type: "POST",
            url: "save_data.php",
            data: { userId: userId, categoryId: categoryId },
            success: function(response) {
                alert('Data saved successfully!');
                $('#categoryModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error saving data. Please try again.');
            }
        });
    }
</script>