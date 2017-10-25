<div class="well well-sm">
    <div class="form-group">
        <div class="input-group input-group-md">
            <div class="icon-addon addon-md">
                <input type="text" placeholder="Search NambaNamba For Coolness..." 
                    class="form-control">
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" >Search!</button>
            </span>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4><i class="fa fa-external-link"></i>&nbsp;
        <strong>Links</strong></h4>
    </div><!--panel-heading-->

    <ul class="list-group">
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.music.albums.index') !!}"
                style='{!! Active::checkUriPattern(["albums", "albums/*"]) ? "color: orange;" : ""!!}'>
                <strong>Albums</strong>
            </a>
        </li>
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.music.singles.index') !!}"
                style='{!! Active::checkUriPattern(["singles", "singles/*"]) ? "color: orange;" : ""!!}'>
                <strong>Singles</strong>
            </a>
        </li>
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.music.tracks.index') !!}"
                style='{!! Active::checkUriPattern(["tracks", "tracks/*"]) ? "color: orange;" : ""!!}'>
                <strong>Tracks</strong>
            </a>
        </li>
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.music.artists.index') !!}"
                style='{!! Active::checkUriPattern(["artists", "artists/*"]) ? "color: orange;" : ""!!}'>
                <strong>Artists</strong>
            </a>
        </li>
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.music.genres.index') !!}"
                style='{!! Active::checkUriPattern(["genres", "genres/*"]) ? "color: orange;" : ""!!}'>
                <strong>Genres</strong>
            </a>
        </li>
        <li class="list-group-item">
            <i class="fa fa-chevron-right"></i>&nbsp;
            <a href="{!! route('frontend.contact') !!}"
                style='{!! Active::checkUriPattern("contact") ? "color: orange;" : ""!!}'>
                <strong>DMCA</strong>
            </a>
        </li>
    </ul><!--panel-body-->
</div><!--panel-->