<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="/web/bundles/app/bootstrap.min.css" rel="stylesheet">
    <link href="/web/bundles/app/style.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Stint+Ultra+Condensed' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.44/css/bootstrap-datetimepicker.min.css" />

</head>
<body>
<div id="preloader"></div>
<?php $this->childContent(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.44/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
<script>
    $(document).ready(function(){
        $('#dataTable').DataTable({
            "searching": false
        });
        $('#dataTable_ssp').DataTable({
            "searching": false
        });

        $('#date').on('change', function () {
            if($(this).val()==5){
                $('.form-inline').show();
            }else{
                $('.form-inline').hide();
                $('#preloader').show();
                $('#sendForm').submit();

            }
        });

        $('#datetimepicker_1').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#datetimepicker_2').datetimepicker({
            //useCurrent: false,
            format: 'DD/MM/YYYY'
        });
        /*$("#datetimepicker_1").on("dp.change", function (e) {
            $('#datetimepicker_2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker_2").on("dp.change", function (e) {
            $('#datetimepicker_1').data("DateTimePicker").maxDate(e.date);
        });*/
        window.onload = function () {
            $('#preloader').hide();
        }
        window.onbeforeunload = function(e) {
            $('#preloader').show();
        };

    });
</script>
</body>
</html>