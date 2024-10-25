<span class="pull-right" style="float:right"> 
    
    <p>
        <a class="btn btn-default" id="collapseBtnFilter" onclick="toggleCollapseFilter()" aria-expanded="true">
        <i class="mdi mdi-window-minimize"></i> Minimize
        </a>
        <a class="btn btn-default" id="uncollapseBtnFilter" onclick="toggleCollapseFilter()" style="display: none;" aria-expanded="true">
        <i class="mdi mdi-window-maximize"></i> Maximize
        </a>
    </p>
    
        <script>
        function toggleCollapseFilter() {
            $('#collapseExampleFilter').collapse('toggle'); // toggle the collapse element
            $('#collapseBtnFilter').toggle(); // toggle the visibility of the collapse button
            $('#uncollapseBtnFilter').toggle(); // toggle the visibility of the uncollapse button
        }
        </script>
</span>