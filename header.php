<div class='header0'>
    
    <div class='header1'>
        <?php
        if (!empty($arrID['Logo']))
            echo "<div class='headerImg'><img src='$_URL$arrID[Logo]' height=93 hspace=0></div>";
        //echo "<div class='headerTitle'>$arrID[Nama]</div>";
        ?>
    </div>
    
    <div class='header2'>
        Jl. Boulevard Bintaro, Bintaro Jaya Sektor 7 <br> 
        Tangerang Selatan, Banten, Indonesia. <br>
        Telp (021) 745-5555<br> 
        Website : www.upj.ac.id
    </div>
    
</div>
<!-- Bootstrap core CSS -->
<!--<link href="others/bootstrap.min.css" rel="stylesheet">-->

<!-- Custom styles for this template -->
<!--<link href="others/justified-nav.css" rel="stylesheet">-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="others/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="others/bootstrap.min.js"></script>-->
<?php
print_r($_SESSION);
?>