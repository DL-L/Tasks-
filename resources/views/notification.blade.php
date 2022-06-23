<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Ready to Listen to message</h1>
</body>
<script src="{{ asset("js/app.js") }}"> </script>
<script>
    Echo.channel('public-channel').listen(".App\\Events\\ActionEvent", (e)=> {
        console.log(e)
    })
</script>
</html>