<div class="col-md-12"> 
    
    <p>
        <a class="btn btn-default" id="collapseBtn" onclick="toggleCollapse()" aria-expanded="true">
        <i class="mdi mdi-window-minimize"></i> <?php echo $this->lang->line('minimize');?>
        </a>
        <a class="btn btn-default" id="uncollapseBtn" onclick="toggleCollapse()" style="display: none;" aria-expanded="true">
        <i class="mdi mdi-window-maximize"></i> <?php echo $this->lang->line('maximize');?>
        </a>
    </p>
    
        <script>
        function toggleCollapse() {
            $('#collapseExample').collapse('toggle'); // toggle the collapse element
            $('#collapseBtn').toggle(); // toggle the visibility of the collapse button
            $('#uncollapseBtn').toggle(); // toggle the visibility of the uncollapse button
        }
        </script>
</div>