$(document).ready(function(){
  
  $('#description').change(function(){
    $('#description_changed').val(true);
  });

  $('#podcast').change(function(){
    $('#podcast_file_changed').val(true);
    
    fillAudios(this.files);
  });

  function fillAudios(files) {
    var audioDiv = document.getElementById("audio-div");
    audioDiv.className = "hidden";
    audioDiv.innerHTML = "";
    if (files) {
      for (let i = 0; i < files.length; i++) {
        audioDiv.appendChild(createAudioControl(i + 1, files[i]));
      }
    }
    audioDiv.className = "visible";
  }

  function createAudioControl(i, file) {
    var audio = document.createElement('audio');
    audio.id = "audio-control-" + i;
    audio.controls = 'controls';
    for(j = 1; j <= 4; j++) {
      readURL(audio, file, i);
    }
    return audio;
  }

  function readURL(audio, input, id) {
    if (input) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var src1 = createSourceControl(id, e.target.result, "audio/ogg");
        var src2 = createSourceControl(id, e.target.result, "audio/mpeg");
        var src3 = createSourceControl(id, e.target.result, "audio/mp3");
        var src4 = createSourceControl(id, e.target.result, "audio/x-m4a");
        audio.appendChild(src1);
        audio.appendChild(src2);
        audio.appendChild(src3);
        audio.appendChild(src4);
      }

      reader.readAsDataURL(input);
    }
  }

  function createSourceControl(id, src, type) {
    var source = document.createElement('source');
    source.id = id;
    source.src = src;
    source.type = type;
    return source;
  }

});