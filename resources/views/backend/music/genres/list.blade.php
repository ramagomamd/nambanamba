<table id="users-table" class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>{{ trans('labels.backend.music.genres.table.id') }}</th>
            <th>{{ trans('labels.backend.music.genres.table.name') }}</th>
            <th>{{ trans('labels.backend.music.genres.table.slug') }}</th>
            <th>{{ trans('labels.general.actions') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($genres as $genre)
        <tr>
            <td>{{ $genre->id }}</td>
            <td>{{ $genre->name }}</td>
            <td>{{ $genre->slug }}</td>
            <td>{!! $genre->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>