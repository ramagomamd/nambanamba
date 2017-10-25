<table id="users-table" class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>{{ trans('labels.backend.music.artists.table.id') }}</th>
            <th>{{ trans('labels.backend.music.artists.table.name') }}</th>
            <th>{{ trans('labels.backend.music.artists.table.slug') }}</th>
            <th>{{ trans('labels.general.actions') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($artists as $artist)
        <tr>
            <td>{{ $artist->id }}</td>
            <td>{{ $artist->name }}</td>
            <td>{{ $artist->slug }}</td>
            <td>{!! $artist->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>