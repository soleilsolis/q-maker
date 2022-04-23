
@section('title', 'Stats')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Stats') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            <form class="ui secondary menu">
                <div class="right menu">
                    <div class="item">
                        <div class="ui input">
                            <input type="date" placeholder="From" name="from" value="{{ $from }}">
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui input">
                            <input type="date" placeholder="To" name="to" value="{{ $to }}">
                        </div>
                    </div>
                    <div class="item">
                        <button type="submit" class="ui purple button ">Go</button>
                    </div>
                </div>
            </form>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 cursor-pointer">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js" integrity="sha256-ErZ09KkZnzjpqcane4SCyyHsKAXMvID9/xwbl/Aq1pc=" crossorigin="anonymous"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($dates as $date)
                        '{{ $date }}',
                    @endforeach
                ],
                datasets: [
                    @foreach ($stats as $name => $values)

                        {
                            label: '{{ $name }}',
                            data: [
                                @foreach($values as $value)
                                    {{ $value }},
                                @endforeach
                            ],
                            borderColor: "#000000".replace(/0/g,function(){return (~~(Math.random()*16)).toString(16);}),
                            borderWidth: 3
                        },
                    @endforeach

                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection

</x-app-layout>

