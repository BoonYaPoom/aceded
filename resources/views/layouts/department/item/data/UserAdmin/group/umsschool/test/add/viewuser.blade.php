
@php($i =  1)
@foreach ($usersnotnull as $unotnull)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $unotnull->username }}</td>
        <td>{{ $unotnull->firstname }} {{ $unotnull->lastname }}</td>
        <td>{{ $extender->name }}</td>
    </tr>
@endforeach
