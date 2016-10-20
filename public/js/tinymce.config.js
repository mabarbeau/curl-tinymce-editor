tinymce.init({
  selector: 'textarea',
  height: 600,
  theme: 'modern',
  removed_menuitems: 'newdocument',
  plugins: [
  'advlist autolink lists link image charmap preview hr anchor pagebreak',
  'searchreplace wordcount visualblocks visualchars code fullscreen',
  'insertdatetime media nonbreaking save table contextmenu directionality',
  'emoticons paste textcolor colorpicker textpattern '
  ],
  toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'preview media | forecolor backcolor',
  image_advtab: true,
  relative_urls: true,
  document_base_url: '//flh.fhwa.dot.gov/',
  content_css: [
  'https://flh.fhwa.dot.gov/library/template/style/',
   'https://flh.fhwa.dot.gov/library/template/style/carousel.css'
  ]
});
