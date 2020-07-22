
<div class="links">
    {{ $forecast->city }} - {{ $forecast->state }} - {{ $forecast->country }}
    <br>
    {{ $forecast->latitude }},{{ $forecast->longitude }}
    <br>
    @if (count($forecast->forecast))
        <table class="table">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Weather</th>
                <th scope="col">Hour</th>
                <th scope="col">Temperature</th>
            </tr>
            </thead>
            <tbody>
            @foreach (array_slice($forecast->forecast,0,24) as $f)
                <tr>
                    <th scope="row">
                        <img width=24 src="{{ $f->iconLink }}">
                    </th>
                    <td>{{ $f->description }}</td>
                    <td>{{ Carbon\Carbon::createFromFormat("HmdY", $f->localTime) }}</td>
                    <td> {{ $f->temperature }}&deg;</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @else
        <li>Sorry my dear friend, no forecast here.</li>
    @endif

</div>
