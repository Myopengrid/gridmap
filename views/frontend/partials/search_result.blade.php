
@if(!isset($regions) or empty($regions))
    <div style="height: 50px">
        No regions matching your search term were found.
    </div>
@else
    <div>
        <p>Search results</p>

        @foreach ($regions as $region)
        <a id="{{$region->uuid}}" data-xcoord="{{($region->locx/256)}}" data-ycoord="{{($region->locy/256)}}" class="list-selectable"><div>{{ $region->regionname }}</div></a>
        @endforeach
    </div>
@endif