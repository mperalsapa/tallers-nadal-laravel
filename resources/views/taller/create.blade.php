<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Taller</title>
    @include('common.bootstrap-header')
    @include('common.custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />




</head>

<body>
    @include('common.navbar')
    <div class="container">
        <form action="{{ route('storeTaller') }}" method="post" class="col-8 mx-auto p-5">
            @csrf
            <input type="hidden" name="taller-id" id="taller-id" value="{{ isset($taller->id) ? $taller->id : '' }}">
            @if ($errors->any())
                <div class="alert alert-danger mt-3" role="alert">
                    <h3>S'han trobat els seguents errors</h3>
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nom del taller</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom del taller"
                    value="{{ $taller->name ?? old('name') }}">
            </div>
            <div class="mb-3">
                <label for="max_students" class="form-label">Numero de participants</label>
                <input class="form-control" id="max_students" name="max_students" type="number" min="1"
                    max="60" value="{{ $taller->max_students ?? old('max_students') }}">

            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripcio del taller</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $taller->description ?? old('description') }}</textarea>

            </div>
            <div class="mb-3">
                <label for="material" class="form-label">Material necessari</label>
                <textarea class="form-control" id="material" name="material" rows="3">{{ $taller->material ?? old('material') }}</textarea>

            </div>
            <div class="mb-3">
                <label for="observation" class="form-label">Observacions</label>
                <textarea class="form-control" id="observation" name="observation" rows="3">{{ $taller->observations ?? old('observation') }}</textarea>

            </div>
            <div>
                <label for="addressed-to" class="form-label">Adreçat a</label>

                <div class=" d-flex flex-wrap">

                    <div class="form-check col p-0 text-nowrap">
                        <select class="form-select" id="multiple-select-field" data-placeholder="Choose anything"
                            name="multiselect[]" multiple>
                            @foreach (Auth::User()->getCourseList() as $key => $value)
                                <option value="{{ $key }}"
                                    @if (old('multiselect') || isset($taller)) {{ in_array($key, old('multiselect') ? old('multiselect') : $taller->addressed_to) ? 'selected' : '' }} @endif>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" value="{{ isset($taller->id) ? 'update' : 'new' }}"
                name="submit">{!! isset($taller->id) ? '<i class="bi bi-pencil"></i> Actualitzar' : '<i class="bi bi-save"></i> Guardar' !!}</button>

            @if (isset($taller->id))
                <button type="submit" class="btn btn-danger mt-3" value="delete" name="submit"><i
                        class="bi bi-trash"></i>
                    Esborrar</button>
            @endif
        </form>
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
