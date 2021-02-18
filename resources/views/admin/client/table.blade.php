@foreach ($clients as $client)
    <tr>
        <td>{{ $client->id }}</td>
        <td>{{ $client->name }}</td>
        <td>{{ $client->email }}</td>
        <td>
            <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-info">Show</a>
            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-primary">Edit</a>
            <button type="button" class="btn btn-danger delete" data-url={{ route('admin.clients.destroy', $client) }}>
                Delete</button>



        </td>
    </tr>
@endforeach
