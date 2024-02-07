<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>
    <strong>Select Language</strong>
    <select class="form-select changeLang">
        <option value="en"{{session()->get('locale') == 'en'?'selected':''}}>English</option>
        <option value="fr"{{session()->get('locale') == 'fr'?'selected':''}}>France</option>
        <option value="es"{{session()->get('locale') == 'es'?'selected':''}}>Spanish</option>
    </select>
    <h3>{{ GoogleTranslate::trans('welcome to webapp',app()->getLocale()) }}</h3>
    <h3>{{ GoogleTranslate::trans('heloow world',app()->getLocale()) }}</h3>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        var url = "{{ route('changeLang') }}";
        $('.changeLang').change(function(event){
            window.location.href = url+"?lang="+$(this).val()
        });
    </script>
</body>
</html>