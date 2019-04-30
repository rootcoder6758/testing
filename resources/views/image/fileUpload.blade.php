<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">


<style type="text/css">
 body {
    font-family: Arial;
    width: 550px;
    padding: 10px
}

.form-container {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
    width: 550px;
    height: 450px;
}

form {
    display: block;
    margin: 10px;
    background: #d3d3d3;
    border-radius: 3px;
    padding: 15px
}

.progress {
    display: none;
    position: relative;
    margin: 20px;
    width: 400px;
    background-color: #ddd;
    border: 1px solid blue;
    padding: 1px;
    left: 15px;
    border-radius: 3px;
}

.progress-bar {
    background-color: green;
    width: 0%;
    height: 30px;
    border-radius: 4px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
}

.percent {
    position: absolute;
    display: inline-block;
    color: #fff;
    font-weight: bold;
    top: 50%;
    left: 50%;
    margin-top: -9px;
    margin-left: -20px;
    -webkit-border-radius: 4px;
}

#outputImage {
    display: none;
}

.error {
    color: #ad7b7b;
    background: #ffb3b3;
    padding: 10px;
    box-sizing: border-box;
    margin: 10px;
    border-radius: 3px;
    border: #f1a8a8 1px solid;
}

input#uploadImage {
    border: #f1f1f1 1px solid;
    padding: 6px;
    border-radius: 3px;
}

#outputImage img {
    max-width: 300px;
}

#submitButton {
    padding: 7px 20px;
    background: #9a9a9a;
    border: #898a89 1px solid;
    color: #F0F0F0;
    margin-left: 10px;
    border-radius: 3px;
    font-size: 0.8em;
}

.error {
    
}
</style>



</head>
<body>
    <h1>Image Upload </h1>
    <div class="form-container">
        <form action="" id="uploadForm" name="frmupload" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" id="uploadImage" name="uploadImage" /> <input
                id="submitButton" type="submit" name='btnSubmit'
                value="Submit Image" />
            

        </form>
        <div class='progress' id="progressDivId">
            <div class='progress-bar' id='progressBar'></div>
            <div class='percent' id='percent'>0%</div>
        </div>
        <div style="height: 10px;"></div>
        <div id='outputImage'>
           
        </div>


         <!-- @foreach($get as $row)
                <img src="{{ url('image')}}/{{ $row['image'] }}"> 
            @endforeach -->
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    type="text/javascript"></script>
<script type="text/javascript" src="{{url('js/jquery.form.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#submitButton').click(function () {
            $('#uploadForm').ajaxForm({
                url: '{{ url("file-upload") }}',
                beforeSubmit: function () {
                      $("#outputImage").hide();
                //        if($("#uploadImage").val() == "") {
                //            $("#outputImage").show();
                //            $("#outputImage").html("<div class='error'>Choose a file to upload.</div>");
                //     return false; 
                // }
                    $("#progressDivId").css("display", "block");
                    var percentValue = '0%';
                    $('#progressBar').width(percentValue);
                    $('#percent').html(percentValue);
                },
                uploadProgress: function (event, position, total, percentComplete) {

                    var percentValue = percentComplete + '%';
                    $("#progressBar").animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 5000,
                        easing: "linear",
                        step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
                            $("#percent").text(percentText + "%");
                        if(percentText == "100") {
                               $("#outputImage").show();
                        }
                        }
                    });
                },
                error: function (response, status, e) {
                    alert('Oops something went.');
                },
                
                complete: function (xhr) {
                    if (xhr.responseText && xhr.responseText != "error")
                    {
                          $("#outputImage").html(xhr.responseText);
                    }
                    else{  
                        $("#outputImage").show();
                            $("#outputImage").html("<div class='error'>Problem in uploading file.</div>");
                            $("#progressBar").stop();
                    }
                }
            });
    });
});
</script>
</html>