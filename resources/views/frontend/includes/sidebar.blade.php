@foreach ($categories as $category)
    <div class='panel 
        {!! Active::checkUriPattern(["$category->slug", "$category->slug/*"]) ? "panel-info" : "panel-default" !!}'>
        <div class="panel-heading">
            <span class="fa fa-th-large"></span>&nbsp;
            <a href="{{ route('frontend.music.categories.show', $category) }}">
                <strong>{!! strtoupper($category->name) !!}</strong>
            </a>
            <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                            <a href="{{ route('frontend.music.categories.albums', $category) }}">
                                <strong>{!! "{$category->name} Albums" !!}</strong>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('frontend.music.categories.singles', $category) }}">
                                <strong>{!! "{$category->name} Singles" !!}</strong>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('frontend.music.categories.show', $category) }}">
                                <strong>{!! "View {$category->name}" !!}</strong>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /. tools -->
        </div><!--panel-heading-->
        <ul class="list-group">           
            @foreach ($category->genres as $genre)
                <li class="list-group-item">
                    &nbsp;&nbsp;<span class="fa fa-chevron-circle-right"></span>&nbsp;
                    <a href="{{ route('frontend.music.categories.genres', [$category, $genre]) }}"
                        class="list-group-item-heading" 
                        style='{!! Active::checkUriPattern(
                            ["$category->slug/$genre->slug", "$category->slug/$genre->slug/*"]
                            ) ? "color: orange; font-weight: bold;" : ""!!}'> 
                            {!! $genre->name  !!}
                    </a>
                    <div class="box-tools pull-right">
                        <a class="btn bg-teal btn-sm btn-info" data-toggle="collapse" data-parent="#accordion"
                            href="#{!! $category->slug !!}-{!! $genre->slug !!}">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                    </div>
                    <p id="{!! $category->slug !!}-{!! $genre->slug !!}" 
                        class="list-group-item-text collapse">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="fa fa-forward"></i> 
                        <a href="{{ route('frontend.music.categories.genres.albums', [$category, $genre]) }}"
                            class="list-group-item-heading" 
                            style='{!! Active::checkUriPattern(
                                ["$category->slug/$genre->slug/albums", "$category->slug/$genre->slug/albums/*"]
                                ) ? "color: orange; font-weight: bold;" : ""!!}'> 
                                Albums
                        </a> <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <i class="fa fa-forward"></i>
                        <a href="{{ route('frontend.music.categories.genres.singles', [$category, $genre]) }}"
                            class="list-group-item-heading" 
                            style='{!! Active::checkUriPattern(
                                ["$category->slug/$genre->slug/singles", "$category->slug/$genre->slug/singles/*"]
                                ) ? "color: orange; font-weight: bold;" : ""!!}'> 
                                Singles
                        </a>
                    </p>
                </li>

            @endforeach        
        </ul>
    </div><!--panel-->
@endforeach