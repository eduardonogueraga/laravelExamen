<?php


namespace App\Filters;


use Illuminate\Support\Carbon;

class AlumnoFilter extends QueryFilter
{
    public function rules(): array
    {
        return [
            'search' => 'filled',
            'valido' => 'in:with,without',
            'to' => 'date_format:d/m/Y',
            'from' => 'date_format:d/m/Y',
        ];
    }

    public function to($query, $date, $operator = '<=')
    {
        $this->dateRange($date, $query, $operator);
    }

    public function from($query, $date, $operator = '>=')
    {
        $this->dateRange($date, $query, $operator);
    }

    public function dateRange($date, $query, $operator): void
    {
        $date = Carbon::createFromFormat('d/m/Y', $date);
        $query->whereDate('created_at', $operator, $date);
    }

    public function valido($query, $valido)
    {
        if($valido=='with')
        {
            $query->whereHas('matricula', function ($query){
                return  $query->where('validado', 1);
            });
        }else {
            return  $query->whereHas('matricula', function ($query){
                return  $query->where('validado', 0);
            });
        }

    }

    public function search($query, $search)
    {
        return $query->where(function ($query) use ($search){
            return $query->where('nombre', 'like', "%$search%")
                ->orWhere('apellidos', 'like',  "%$search%");
        });
    }

}