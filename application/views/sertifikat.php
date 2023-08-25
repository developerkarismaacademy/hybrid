<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>My PDF Document</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    .page {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <div class="page">
    <h1>Page 1</h1>
    <p>This is the first page of my PDF document.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet vestibulum ipsum, in faucibus sapien. Donec vehicula consequat neque vel luctus.</p>
  </div>
  <div class="page">
    <h1>Page 2</h1>
    <p>This is the second page of my PDF document.</p>
    <p>Aliquam eget turpis sit amet odio rutrum ultricies. Ut elementum dolor eu nulla venenatis, vel dictum lorem consectetur. Etiam consequat orci eu ex tempor, a sollicitudin orci fringilla. Aliquam nec malesuada ex.</p>
  </div>
</body>

</html>