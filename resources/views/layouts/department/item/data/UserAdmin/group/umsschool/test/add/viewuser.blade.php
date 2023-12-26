
@php($i =  1)
@foreach ($usersnotnull->sortBy('user_id') as $unotnull)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $unotnull->username }}</td>
        <td>{{ $unotnull->firstname }} {{ $unotnull->lastname }}</td>
        <td>{{ $unotnull->user_affiliation }}</td>
        <td>{{ $extender->name }}</td>
    </tr>
@endforeach
