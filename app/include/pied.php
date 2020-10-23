	<script src="../Parsley/parsley.js"></script>
	<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<!-- NProgress -->
	<!-- Chart.js -->
	<!-- bootstrap-progressbar -->
	<!-- iCheck -->
	<script src="../vendors/iCheck/icheck.min.js"></script>
	<!-- Skycons -->
	<script src="../vendors/skycons/skycons.js"></script>

	<!-- bootstrap-daterangepicker -->
	<script src="../vendors/moment/min/moment.min.js"></script>
	<!-- bootstrap-datepicker -->
	<script src="../js/bootstrap-datepicker.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="../build/js/custom.min.js"></script>
	<!-- jquery.inputmask -->
	<script src="../vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

    <!-- formatage du nombre en bloc de 3 chiffre -->
    <script>
        function formatMoney(objet , localize,fixedDecimalLength){
            if($(objet).val() != '')
            {
                num= $(objet).val().split(' ').join('')+"";
                $(objet).val(num);

                var str=num;
                var reg=new RegExp(/(\D*)(\d*(?:[\.|,]\d*)*)(\D*)/g)
            if(reg.test(num)){
                var pref=RegExp.$1;
                var suf=RegExp.$3;
                var part=RegExp.$2;
                if(fixedDecimalLength/1)part=(part/1).toFixed(fixedDecimalLength/1);
                if(localize)part=(part/1).toLocaleString();
                str= pref +part.match(/(\d{1,3}(?:[\.|,]\d*)?)(?=(\d{3}(?:[\.|,]\d*)?)*$)/g ).join(' ')+suf ;
            };
          $(objet).val(str);
          }
        }

        // au lancement de la fonction ajax
        $(document).ajaxStart(function(){
            $('.spinner').css('display','inline-table');
        });

        // au lancement de la fonction ajax
        $(document).ajaxStop(function(){
            $('.spinner').css('display','none');
        });
    </script>

</body>
</html>
