<tr>
    <td rowspan="2">{{ $alumno->id }}</td>
    <th scope="row">{{ $alumno->nombre }}</th>
    <td>{{ $alumno->apellidos }}</td>
    <td>{{ $alumno->nif }}</td>
    <td>{{ (optional($alumno->matricula)->validado) ? 'Si' : 'No' }}</td>
    <td>{{ (optional($alumno->matricula)->repetidor) ?  'Si' : 'No' }}</td>
    <td>{{ $alumno->created_at }}</td>

    <td class="text-right">

        <a href="{{route('alumnos.edit', $alumno)}}" class="btn btn-outline-secondary btn-sm"><span class="oi oi-pencil"></span></a>

    </td>
</tr>
<tr class="skills">
    <td colspan="1"><span class="note">Alumno: </span></td>
</tr>

