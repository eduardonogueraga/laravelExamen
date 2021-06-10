{{ csrf_field() }}
<div class="form-group">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre', $alumno->nombre) }}" class="form-control">
</div>

<div class="form-group">
    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" placeholder="Apellidos" value="{{ old('apellidos', $alumno->apellidos) }}" class="form-control">
</div>

<div class="form-group">
    <label for="domicilio">Domicilio:</label>
    <input type="text" name="domicilio" placeholder="Domicilio" value="{{ old('domicilio', $alumno->domicilio) }}" class="form-control">
</div>

<div class="form-group">
    <label for="nif">Nif:</label>
    <input type="text" name="nif" placeholder="Nif" value="{{ old('nif', $alumno->nif) }}" class="form-control">
</div>

<div class="form-group">
    <label for="cp">Codigo Postal:</label>
    <input type="text" name="cp" placeholder="Codigo Postal" value="{{ old('cp', $alumno->cp) }}" class="form-control">
</div>

<div class="col-md-3">
    <div class="btn-group">
        <select name="curso" id="field" class="select-field">
            <option value="" selected disabled hidden>Seleccione un curso</option>
            @foreach($cursos as $value)

                <option value="{{ $value->id }}" >{{$value->curso .' '. $value->nivel }}</option>

            @endforeach
        </select>
    </div>
</div>
