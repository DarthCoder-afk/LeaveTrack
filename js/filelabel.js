document.getElementById('formFile').addEventListener('change', function(){
    var fileName = this.files[0].name;
    var label = document.getElementById('formLabel');
    label.textContent = fileName;

  });

  document.getElementById('updateFile').addEventListener('change', function(){
    var fileName = this.files[0].name;
    var label = document.getElementById('updateLabel');
    label.textContent = fileName;

  });