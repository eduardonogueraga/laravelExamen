<form method="get" action="{{ route('alumnos.index') }}">

    <div class="row row-filters">
        <div class="col-12">
            @foreach(trans('alumnos.filters.valid') as $value => $text)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="valido" id="valido_{{ $value }}"
                           value="{{ $value }}" {{ $value === request('valido') ? 'checked' : '' }}>
                    <label class="form-check-label" for="valido_{{ $value }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row row-filters">
        <div class="col-md-3">
            <div class="form-inline form-search">
                <div class="input-group">
                    <input type="search" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm" placeholder="Buscar...">
                </div>
            </div>
        </div>

        <div class="col-md-6 text-right">
            <div class="form-inline form-dates">
                <label for="date_start" class="form-label-sm">Fecha</label>&nbsp;
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="from" id="from" placeholder="Desde" value="{{ request('from') }}">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="to" id="to" placeholder="Hasta" value="{{ request('to') }}">
                </div>
            </div>
        </div>

        <div class="col text-right">
            <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
        </div>
    </div>
</form>