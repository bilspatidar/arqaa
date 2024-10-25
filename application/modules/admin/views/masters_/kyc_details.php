<section class="section profile">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body pt-3">
          <div class="tab-content pt-2">
          <div class="col-md-4">
    <div class="card">
        <h5 class="card-title text-center">Adhar Image</h5>
        <span class="text-center m-4 ">
            <a href="#" id="<?= $urlAadhar;?>">
                <img src="<?= $urlAadhar;?>" class="card-img-top" alt="..." style="width:200px;" id="myImg">
            </a>
        </span>
        <span class='text-center m-3'>
            <?= $this->Common->aadharShow($row[0]->aadhar);?>
        </span>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <p class="">Please Upload Clear Scanned File </p>
    </div>
    <div class="panel-body">
        <form id="crudForm" method="POST" action="<?php echo base_url(); ?>member/add_kyc/add" enctype='multipart/form-data'>
            <input type="hidden" name="member_id" value="<?= $row[0]->member_id;?>" >
            <input type="hidden" name="form_no" value="<?= $row[0]->form_no;?>" >
        
            <?php
            $this->db->order_by('id','asc');
            $this->db->where('status','Active');
            $this->db->where('isDelete',0);
            $document_type = $this->db->get('document_type')->result();
            foreach($document_type as $doc_type){
                $id = $doc_type->id;
            ?>
            <div class="row" style="margin-top:10px;border:1px solid #dcdcdc;padding:10px;">
                <h5><?=$doc_type->name;?></h5>
                <input type="hidden" name="type_id[]" value="<?= $id;?>" >
                
                <?php 
                $this->db->where('status','Active');
                $this->db->where('isDelete',0);
                $document_category = $this->db->get_where('document_category',array('document_type_id'=>$id))->result(); 
                foreach($document_category as $doc_cat){
                ?>
                <div class="row mb-3">
                    <div class="col-md-3"><br/>
                        <input type="checkbox" name="document_id[<?=$id?>][]" value="<?=$doc_cat->id;?>"> <?= $doc_cat->name;?>
                    </div>
                    <div class="col-md-4" id="profile">
                        <label>Document File</label>
                        <div class="input-group mb-3">
                            <input type="file" name="document_file[<?=$id?>][<?=$doc_cat->id;?>]" class="form-control">
                        </div>
                        <input type="hidden" value="" name="document_file_back[<?=$id?>][<?=$doc_cat->id;?>]">
                        <?php if($doc_cat->side==2){ ?>
                        <input type="hidden" name="side[<?=$id?>][<?=$doc_cat->id;?>]" value="<?=$doc_cat->side;?>">
                        <label>Document File Back</label>
                        <div class="input-group mb-3">
                            <input type="file" name="document_file_back[<?=$id?>][<?=$doc_cat->id;?>]" class="form-control">
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3"><br/>
                        <input type="text" name="document_number[<?=$id?>][<?=$doc_cat->id;?>]" class="form-control" placeholder="Document Number" minlength="7" maxlength="<?=$doc_cat->doc_num_length;?>">
                    </div>
                    <div class="col-md-2"><br/>
                        <input type="checkbox" name="isVerified[<?=$id?>][<?=$doc_cat->id;?>]" value="1"> Verified
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </form>
    </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
