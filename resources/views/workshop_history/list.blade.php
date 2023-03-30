<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historic de tallers</title>
    @include('common.bootstrap-header')
</head>

<body>
    @include('common.navbar')
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Tallers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Historic</li>
            </ol>
        </nav>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Descripcio</th>
                    <th scope="col">Adreçat a</th>
                    <th scope="col">Places</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($history as $workshop)
                    <tr>
                        <td>
                            <a class="" href="{{ route('showWorkshopHistory', $workshop->id) }}">
                                {{ $workshop->name }}
                            </a>
                        </td>
                        <td>{{ $workshop->description }}</td>
                        <td>{{ implode(', ', $workshop->addressed_to) }}</td>

                        <td>{{ $workshop->max_students }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $history->links() }}

    </div>
    @include('common.bootstrap-body')
</body>

</html>
