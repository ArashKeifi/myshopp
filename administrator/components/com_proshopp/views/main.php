
    <div id="wrapper">
        <?php include_once "menu_sidebar.php"; ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <?php include_once "nav_top.php"; ?>
            <?php echo $this->loadTemplate('main');?>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="components/com_proshopp/assets/theme/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="components/com_proshopp/assets/theme/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="components/com_proshopp/assets/theme/js/plugins/flot/jquery.flot.js"></script>
    <script src="components/com_proshopp/assets/theme/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="components/com_proshopp/assets/theme/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="components/com_proshopp/assets/theme/js/plugins/flot/jquery.flot.pie.js"></script>



    <!-- Peity -->
    <script src="components/com_proshopp/assets/theme/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="components/com_proshopp/assets/theme/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="components/com_proshopp/assets/theme/js/inspinia.js"></script>
    <script src="components/com_proshopp/assets/theme/js/plugins/pace/pace.min.js"></script>
    <!-- GITTER -->
    <script src="components/com_proshopp/assets/theme/js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Chosen -->
    <script src="components/com_proshopp/assets/theme/js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Toastr -->
    <script src="components/com_proshopp/assets/theme/js/plugins/toastr/toastr.min.js"></script>
    <script src="components/com_proshopp/assets/theme/js/custome.js"></script>



    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            function removejscssfile(filename, filetype){
                var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
                var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
                var allsuspects=document.getElementsByTagName(targetelement)
                for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
                    if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
                        allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
                }
            }
            removejscssfile("template.js", "js");
            removejscssfile("mootools-core.js", "js");
            removejscssfile("mootools-more.js", "js");
            removejscssfile("template.css", "css") ;
            removejscssfile("template-rtl.css", "css");
        });
    </script>

