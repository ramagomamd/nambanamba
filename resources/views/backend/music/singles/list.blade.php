<table id="users-table" class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>{{ trans('labels.backend.music.singles.table.id') }}</th>
            <th>{{ trans('labels.backend.music.singles.table.title') }}</th>
            <th>{{ str_singular(trans('labels.backend.music.singles.table.categories')) }}</th>
            <th>{{ trans('labels.backend.music.singles.table.genres') }}</th>
            <th>{{ trans('labels.general.actions') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($singles as $single)
        <tr>
            <td>{{ $single->id }}</td>
            <td>{!! $single->track->full_title !!}</td> 
            <td>{{ $single->track->trackable->category->name }}</td>
            <td>{{ $single->track->trackable->genre->name }}</td>
            <td>{!! $single->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>