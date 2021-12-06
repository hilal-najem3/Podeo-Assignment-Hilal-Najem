$(document).ready(function(){
  
  $('#description').change(function(){
    $('#description_changed').val(true);
  });

  $('#podcast').change(function(){
    $('#podcast_file_changed').val(true);
    if (this.files && this.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#audio-control').attr('src', e.target.result)[0];
        $('#audio-control').pause();
        $('#audio-control').load();
      }
     reader.readAsDataURL(this.files[0]);
    }
  });

});