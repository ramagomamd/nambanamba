@extends('frontend.layouts.app')

@section('title', "{$title} - " . app_name())

@section('before-content')
    <div class="jumbotron">
        <p>Welcome To LulaMusic Downloads!!</p>
        <p>Like and Share Us on 
            <a href="//fb.me/lulamusic" class="btn btn-primary"><i class="fa fa-facebook"></i>acebook</a>
        </p>
    </div>
@endsection

@section('content')
    <div class="col-xs-12 col-md-6 vcenter">
        @if ($albums->isNotEmpty())
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <h3 class="flex">Latest Albums</h3>

                    <a href="{{ route('frontend.music.albums.index') }}" 
                        class="btn btn-success btn-md">
                        <strong>View All...</strong>
                    </a> 
                </div>
            </div><!--panel-heading-->

            <div class="panel-body">
                @include('frontend.music.albums.list')
            </div><!--panel-body-->
        </div><!--panel-->
        @else
            <p class="lead">No Albums Updates Yet</p>
        @endif
    </div><!--col-md-6-->

    <div class="col-xs-12 col-md-6 vcenter">
        @if ($singles->isNotEmpty())
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <h3 class="flex">Latest Singles</h3>

                   <a href="{{ route('frontend.music.singles.index') }}" 
                        class="btn btn-success btn-md">
                        <strong>View All...</strong>
                    </a> 
                </div>
            </div><!--panel-heading-->

            <div class="panel-body">
                @include('frontend.music.singles.list')
            </div><!--panel-body-->
        </div><!--panel-->
        @else
            <p class="lead">No Singles Updates Yet</p>
        @endif
    </div><!--col-md-6-->
@endsection