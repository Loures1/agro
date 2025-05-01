const input = document.getElementById("num_mat");
input.addEventListener("keypress", function (event) {
  if (event.key == "Enter" && input.value != null) {
    mat = input.value;
    input.value = null;
    window.location.assign("/training/get/" + mat);
  }
});
