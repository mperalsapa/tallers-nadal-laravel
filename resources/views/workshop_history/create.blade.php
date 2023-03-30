<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Workshop</title>
    @include('common.bootstrap-header')
    @include('common.custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />




</head>

<body>
    @include('common.navbar')
    <div class="container d-flex gap-3 my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Tallers</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('showWorkshopsHistory') }}">Historic</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $workshop->name }}</li>
            </ol>
        </nav>
        <form action="{{ route('storeWorkshop') }}" method="post" class="col-8">
            @csrf
            <input type="hidden" name="workshop-id" id="workshop-id"
                value="{{ isset($workshop->id) ? $workshop->id : '' }}">
            @if ($errors->any())
                <div class="alert alert-danger mt-3" role="alert">
                    <h3>S'han trobat els seguents errors</h3>
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nom del taller</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom del taller"
                    value="{{ $workshop->name ?? old('name') }}">
            </div>
            <div class="mb-3">
                <label for="max_students" class="form-label">Numero de participants</label>
                <input class="form-control" id="max_students" name="max_students" type="number" min="1"
                    max="60" value="{{ $workshop->max_students ?? old('max_students') }}">

            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripcio del taller</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $workshop->description ?? old('description') }}</textarea>

            </div>
            <div class="mb-3">
                <label for="material" class="form-label">Material necessari</label>
                <textarea class="form-control" id="material" name="material" rows="3">{{ $workshop->material ?? old('material') }}</textarea>

            </div>
            <div class="mb-3">
                <label for="observation" class="form-label">Observacions</label>
                <textarea class="form-control" id="observation" name="observation" rows="3">{{ $workshop->observations ?? old('observation') }}</textarea>

            </div>
            <div>
                <label for="addressed-to" class="form-label">Adreçat a</label>

                <div class=" d-flex flex-wrap">

                    <div class="form-check col p-0 text-nowrap">
                        <select class="form-select" id="multiple-select-field" data-placeholder="Seleccionar curs"
                            name="multiselect[]" multiple>
                            @foreach (Auth::User()->getCourseList() as $key => $value)
                                <option value="{{ $key }}"
                                    @if (old('multiselect') || isset($workshop)) {{ in_array($key, old('multiselect') ? old('multiselect') : $workshop->addressed_to) ? 'selected' : '' }} @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" value="{{ isset($workshop->id) ? 'update' : 'new' }}"
                name="submit">{!! isset($workshop->id) ? '<i class="bi bi-pencil"></i> Actualitzar' : '<i class="bi bi-save"></i> Guardar' !!}</button>

            @if (isset($workshop->id))
                <button type="submit" class="btn btn-danger mt-3" value="delete" name="submit"><i
                        class="bi bi-trash"></i> Esborrar</button>
            @endif
        </form>
        <div class="col">

            <div class="d-flex flex-column bg-light rounded p-2">
                <h2 class="text-center">Administració</h2>
                <a class="btn btn-primary mt-3" href="{{ route('showWorkshopsHistory') }}">Copiar del historic de
                    tallers</a>
            </div>

        </div>
    </div>
    @include('common.bootstrap-body')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

        function removeFirstChildMultiList() {
            document.querySelectorAll("[title='{{ Auth::User()->fancyCourseName() }}']")[0].firstChild.remove();
        }

        removeFirstChildMultiList();


        $(".form-select").on("change", function() {
            removeFirstChildMultiList();
        })
    </script>
</body>

</html>
