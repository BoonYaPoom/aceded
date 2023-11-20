
@php($u = 1)
@foreach ($users as $index => $utype)

<tr>
    <td>{{ $u++ }}</td>
    <td>{{ $utype->username }}</td>
    <td>{{ $utype->firstname }} {{ $utype->lastname }} </td>
    <td>
        @if ($utype->user_type  == $pertype->person_type)
            {{ $pertype->person }}
        @endif
    </td>
</tr>

@endforeach
