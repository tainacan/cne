function moveSectionInsideForm() {
  let form = document.querySelector('form.register');
  let section = document.getElementById('secao-interna-formulario');

  if ( form && section && form.childNodes.length > 2 ) {
    form.insertBefore(section, form.childNodes[2]);
  }
}

moveSectionInsideForm();
