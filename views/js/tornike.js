document.addEventListener("DOMContentLoaded", (event) => {
  let supplier = document.getElementById("supplier");
  let formWrapper = document.querySelector(".form-wrapper");

  let firstChild = supplier.children[0].cloneNode(true);
  let secondChild = supplier.children[1].cloneNode(true);

  supplier.removeChild(supplier.children[0]);
  supplier.removeChild(supplier.children[0]);

  formWrapper.insertBefore(secondChild, formWrapper.children[2]);
  formWrapper.insertBefore(firstChild, formWrapper.children[1]);
});
