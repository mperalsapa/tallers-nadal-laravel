<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('admin.navbar')
    <div class="container">
        <h1>Panell d'administracio</h1>
        <div class="col">
            <h2>Data de seleccio</h2>
            <p>Modificar data de seleccio de taller</p>
            <form action="{{ route('adminStoreSetting') }}" method="post">
                @csrf
                <label for="starting-date">
                    <input class="form-control" type="datetime-local" name="setting" id="starting-date"
                        {{ isset($date) ? 'value=' . $date : '' }}>
                </label>
                <button type="submit" class="btn btn-primary" name="submit" value="Inici de seleccio"><i
                        class="ba ba-pencil" aria-hidden="true"></i>
                    Guardar</button>
            </form>
        </div>

    </div>
    @include('common.bootstrap-body')
</body>

</html>
