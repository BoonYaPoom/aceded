@foreach ($users as $index => $utype)
<!-- tr -->

@php
    $usernum = ($users->currentPage() - 1) * $users->perPage() + $index + 1;
@endphp
<tr>
    <td>{{ $usernum }}</td>
    <td>{{ $utype->username }}</td>
    <td>{{ $utype->firstname }} {{ $utype->lastname }} </td>
    <td>
        @if ($utype->user_type  == $pertype->person_type)
            {{ $pertype->person }}
        @endif
    </td>
</tr><!-- /tr -->
<!-- tr -->
@endforeach