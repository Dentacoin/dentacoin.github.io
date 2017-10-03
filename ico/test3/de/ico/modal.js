$(document).ready(function(){
    
    $("#modalbtn").click(function(){
        $("#myModal").modal({backdrop: "static"});
    });

    $("#agreebtn").click(function(){
        $('#myModal').modal('hide');
        $('#myModal2').modal('show');
    });

});
