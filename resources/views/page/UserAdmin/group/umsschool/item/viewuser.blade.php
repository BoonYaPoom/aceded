
@php
       $i = 1 ;
@endphp
@foreach ($userschool as $us)
@php
         $usersscho = \App\Models\Users::find($us->user_id);
         $departcho = \App\Models\Department::find($us->department_id);
@endphp
    <tr>
        <td>{{$i++}}</td>
        <td>{{ $usersscho->username }} </td>
        <td> {{ $usersscho->firstname }} {{ $usersscho->lastname }}</td>
        <td>
            @if ($departcho)
            {{ $departcho->name_th }}
        @else

        @endif
        </td>
        <td>
            {{ $school->school_name }}
        </td>
    </tr>
@endforeach
