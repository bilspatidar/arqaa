<form class="form-sample" id="" action="<?php echo API_DOMAIN; ?>api/user/add_permissions/add" method="POST">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Module</th>
                <th>View</th>
                <th>Create</th>
                <th>Update</th>
                <th>Delete</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <td><?php echo $this->lang->line('control_de_precios'); ?></td>
                <td><input type="checkbox" name="permissions[control_de_precios][view]"></td>
                <td><input type="checkbox" name="permissions[control_de_precios][create]"></td>
                <td><input type="checkbox" name="permissions[control_de_precios][update]"></td>
                <td><input type="checkbox" name="permissions[control_de_precios][delete]"></td>
            </tr>

            <tr>
                <td><?php echo $this->lang->line('categorias'); ?></td>
                <td><input type="checkbox" name="permissions[categorias][view]"></td>
                <td><input type="checkbox" name="permissions[categorias][create]"></td>
                <td><input type="checkbox" name="permissions[categorias][update]"></td>
                <td><input type="checkbox" name="permissions[categorias][delete]"></td>
            </tr>

            <tr>
                <td><?php echo $this->lang->line('subcategorias'); ?></td>
                <td><input type="checkbox" name="permissions[subcategorias][view]"></td>
                <td><input type="checkbox" name="permissions[subcategorias][create]"></td>
                <td><input type="checkbox" name="permissions[subcategorias][update]"></td>
                <td><input type="checkbox" name="permissions[subcategorias][delete]"></td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

