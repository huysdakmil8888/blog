<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body>
<div id="app">

<form action="" method="post" @submit.prevent="onsubmit" @keydown="errors.clear($event.target.name)">
    <input type="text" name="title" v-model="form.title">
    <span v-text="errors.get('title')"></span>
    <br>
    <input type="text" name="description" v-model="form.description">
    <span v-text="errors.get('description')"></span>
    <br>
    <input type="submit" value="send" :disabled="errors.any()">
</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="/js/app.js"></script>
</body>
</html>
