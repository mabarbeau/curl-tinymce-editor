tinymce.init({
  selector: 'textarea',
  height: 600,
  theme: 'modern',
  plugins: [
  'advlist autolink lists link image charmap print preview hr anchor pagebreak',
  'searchreplace wordcount visualblocks visualchars code fullscreen',
  'insertdatetime media nonbreaking save table contextmenu directionality',
  'emoticons paste textcolor colorpicker textpattern '
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons',
  image_advtab: true,
  relative_urls: true,
  document_base_url: '//flh.fhwa.dot.gov/',
  content_css: [
  'https://flh.fhwa.dot.gov/library/template/style/',
   'https://flh.fhwa.dot.gov/library/template/style/carousel.css'
  ]
});
