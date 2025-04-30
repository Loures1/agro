var mat = document.getElementById("num_mat");
mat.addEventListener('keypress', function (event) {
    event.key == 'Enter' 
    ? window.location.assign("/training/get/" + mat.value) :
    null 
});
