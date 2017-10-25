<table id="users-table" class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>{{ trans('labels.backend.music.categories.table.id') }}</th>
            <th>{{ trans('labels.backend.music.categories.table.name') }}</th>
            <th>{{ trans('labels.backend.music.categories.table.slug') }}</th>
            <th>{{ trans('labels.general.actions') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{!! $category->action_buttons !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>