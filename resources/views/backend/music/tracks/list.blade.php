<table id="tracks-table" class="table table-striped table-condensed table-hover">
<thead>
    <tr>
        <th>{{ trans('labels.backend.music.tracks.table.id') }}</th>
        <th>{{ trans('labels.backend.music.tracks.table.title') }}</th>
        <th>{{ trans('labels.backend.music.artists.owner') }}</th>
        <th>{{ trans('labels.backend.music.tracks.table.slug') }}</th>
        <th>{{ trans('labels.backend.music.tracks.table.duration') }}</th>
        <th>{{ trans('labels.general.actions') }}</th>
    </tr>
</thead>

<tbody>
    @foreach ($tracks as $track)
    <tr>
        <td>{!! $track->id !!}</td>
        <td>{!! str_limit($track->title . $track->features_title_comma, 45) !!}</td>
        <td>{!! str_limit($track->artists_title_comma, 55) !!}</td>
        <td>{!! str_limit($track->slug, 35) !!}</td>
        <td>{!! $track->duration !!}</td>
        <td>{!! $track->show_button !!}</td>
    </tr>
    @endforeach
</tbody></table>