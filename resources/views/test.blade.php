<!DOCTYPE html>
<html>
<body>

<form enctype="multipart/form-data">
    {{ csrf_field() }}
    Select image to upload:
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple >

</form>

<button onclick="change()">Click</button>
<script>
    function change() {
        var files = new FileList();
        console.log(files);

       var array = document.getElementById('fileToUpload').files;
       console.log(array);
       var n = array.length;
       console.log(n);
       newArray = array + array[n-1];
       console.log(newArray.length);
       console.log(newArray[0]);
       console.log(newArray[n-1]);
       console.log(newArray);
       //document.getElementById('fileToUpload').files = newArray;
       console.log(document.getElementById('fileToUpload').files);
       document.getElementById('fileToUpload').files[0] = null;
       console.log(document.getElementById('fileToUpload').files)
    }
</script>
</body>
</html>