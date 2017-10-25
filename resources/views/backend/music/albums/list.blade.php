<table id="users-table" class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>{{ trans('labels.backend.music.albums.table.id') }}</th>
            <th>{{ trans('labels.backend.music.albums.table.title') }}</th>
            <th>{{ trans('labels.backend.music.albums.table.slug') }}</th>
            <th>{{ str_singular(trans('labels.backend.music.genres.owner')) }}</th>
            <th>{{ str_singular(trans('labels.backend.music.singles.table.categories')) }}</th>
            <th>{{ trans('labels.backend.music.albums.table.tracks_number') }}</th>
            <th>{{ trans('labels.general.actions') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($albums as $album)
        <tr>
            <td>{{ $album->id }}</td>
            <td>{{ $album->full_title }}</td>
            <td>{{ $album->slug }}</td>
            <td>{{ $album->genre->name }}</td>
            <td>{{ $album->category->name }}</td>
             <td>{{ $album->tracks_count }}</td>
            <td>{!! $album->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>