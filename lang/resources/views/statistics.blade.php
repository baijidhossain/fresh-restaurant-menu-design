<x-frontend-layout>

    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden py-6 sm:py-12">


        <div class="pt-12">

            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

                <div class="mx-auto p-2">

                    <h1 class="text-xl md:text-2xl text-gray-800 mb-4 md:mb-6"><i
                            class="fa-sharp fa-light fa-chart-line-up"></i> Statistics</h1>

                    <!-- stats cards -->
                    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 text-white">

                        <!-- stat card -->
                        <div class="relative overflow-hidden bg-meta-3 p-4 text-center rounded-lg p-4 md:p-6 shadow">
                            <div class="mb-3 flex items-center space-x-1">

                                <i class="fa-light fa-bullseye-pointer"></i>

                                <span class="whitespace-nowrap font-bold uppercase "> Total Visits</span>
                            </div>
                            <div
                                class="relative z-10 mx-auto mb-7 flex h-24 w-24 items-center justify-center rounded-full bg-white text-4xl text-gray-700">
                                {{ $totalVisits }}
                                </div>

                            <svg class="absolute right-0 bottom-0 z-0 h-36 w-36" fill="none" viewBox="0 0 72 63">
                                <path class="fill-white/50" d="M68.5 137a68.5 68.5 0 1 0 0-137 68.5 68.5 0 0 0 0 137Z">
                                </path>
                                <path class="fill-white/50"
                                    d="M68.5 119.88a51.38 51.38 0 1 0 0-102.76 51.38 51.38 0 0 0 0 102.75Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 102.75a34.25 34.25 0 1 0 0-68.5 34.25 34.25 0 0 0 0 68.5Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 85.63a17.12 17.12 0 1 0 0-34.25 17.12 17.12 0 0 0 0 34.24Z"></path>
                            </svg>

                        </div>

                        <!-- stat card -->
                        <div class="relative overflow-hidden bg-blue-400 p-4 text-center rounded-lg p-4 md:p-6 shadow">
                            <div class="mb-3 flex items-center space-x-1">

                                <i class="fa-light fa-bullseye-pointer"></i>

                                <span class="whitespace-nowrap font-bold uppercase ">Today's Visits</span>
                            </div>
                            <div
                                class="relative z-10 mx-auto mb-7 flex h-24 w-24 items-center justify-center rounded-full bg-white text-4xl text-gray-700">
                                {{ $todaysVisitors }}
                                </div>

                            <svg class="absolute right-0 bottom-0 z-0 h-36 w-36" fill="none" viewBox="0 0 72 63">
                                <path class="fill-white/50" d="M68.5 137a68.5 68.5 0 1 0 0-137 68.5 68.5 0 0 0 0 137Z">
                                </path>
                                <path class="fill-white/50"
                                    d="M68.5 119.88a51.38 51.38 0 1 0 0-102.76 51.38 51.38 0 0 0 0 102.75Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 102.75a34.25 34.25 0 1 0 0-68.5 34.25 34.25 0 0 0 0 68.5Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 85.63a17.12 17.12 0 1 0 0-34.25 17.12 17.12 0 0 0 0 34.24Z"></path>
                            </svg>
                        </div>

                        <!-- stat card -->
                        <div
                            class="relative overflow-hidden bg-purple-400 p-4 text-center rounded-lg p-4 md:p-6 shadow">
                            <div class="mb-3 flex items-center space-x-1">

                                <i class="fa-light fa-bullseye-pointer"></i>

                                <span class="whitespace-nowrap font-bold uppercase ">Unique Visitors</span>
                            </div>
                            <div
                                class="relative z-10 mx-auto mb-7 flex h-24 w-24 items-center justify-center rounded-full bg-white text-4xl text-gray-700">
                            {{ $uniqueVisits }}
                            </div>

                            <svg class="absolute right-0 bottom-0 z-0 h-36 w-36" fill="none" viewBox="0 0 72 63">
                                <path class="fill-white/50" d="M68.5 137a68.5 68.5 0 1 0 0-137 68.5 68.5 0 0 0 0 137Z">
                                </path>
                                <path class="fill-white/50"
                                    d="M68.5 119.88a51.38 51.38 0 1 0 0-102.76 51.38 51.38 0 0 0 0 102.75Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 102.75a34.25 34.25 0 1 0 0-68.5 34.25 34.25 0 0 0 0 68.5Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 85.63a17.12 17.12 0 1 0 0-34.25 17.12 17.12 0 0 0 0 34.24Z"></path>
                            </svg>
                        </div>

                        <!-- stat card -->
                        <div
                            class="relative overflow-hidden bg-violet-400 p-4 text-center rounded-lg p-4 md:p-6 shadow">
                            <div class="mb-3 flex items-center space-x-1">

                                <i class="fa-light fa-bullseye-pointer"></i>

                                <span class="whitespace-nowrap font-bold uppercase ">Total Referrers</span>
                            </div>
                            <div
                                class="relative z-10 mx-auto mb-7 flex h-24 w-24 items-center justify-center rounded-full bg-white text-4xl text-gray-700">
                                0 </div>

                            <svg class="absolute right-0 bottom-0 z-0 h-36 w-36" fill="none" viewBox="0 0 72 63">
                                <path class="fill-white/50" d="M68.5 137a68.5 68.5 0 1 0 0-137 68.5 68.5 0 0 0 0 137Z">
                                </path>
                                <path class="fill-white/50"
                                    d="M68.5 119.88a51.38 51.38 0 1 0 0-102.76 51.38 51.38 0 0 0 0 102.75Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 102.75a34.25 34.25 0 1 0 0-68.5 34.25 34.25 0 0 0 0 68.5Z"></path>
                                <path class="fill-white/50"
                                    d="M68.5 85.63a17.12 17.12 0 1 0 0-34.25 17.12 17.12 0 0 0 0 34.24Z"></path>
                            </svg>
                        </div>
                    </div>





                    <div class="mx-auto mt-4">
                        <div class="flex flex-col space-y-5 text-black">

                            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4 text-gray-800">

                                <div class="w-full md:w-1/2 bg-white  rounded-lg p-4 md:p-6 shadow h-[300px]">
                                    <canvas id="myChart"></canvas>
                                </div>

                                <div class="w-full md:w-1/2 bg-white  rounded-lg p-4 md:p-6 shadow h-[300px]">
                                    <canvas id="osUsageChart"></canvas>
                                </div>

                            </div>

                        </div>
                    </div>





                    <div class="mx-auto mt-4">
                        <div class="flex flex-col space-y-5 text-black">

                            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4 text-gray-800">


                                <div
                                    class="w-full md:w-1/2 text-white bg-meta-3 px-4 py-3 text-left  rounded-lg p-4 md:p-6 shadow">
                                    <label class="font-semibold">Last Visit</label>
                                    <div
                                        class="relative flex items-center overflow-hidden text-ellipsis rounded-md my-1">
                                        <i class="mr-1 fa-light fa-clock text-gray-100"></i>
                                        <span class="text-sm">{{ $lastVisit->format('d M, Y h:i A') }}</span>
                                    </div>
                                </div>



                                <div
                                    class="w-full md:w-1/2 text-white bg-blue-400 px-4 py-3 text-left  rounded-lg p-4 md:p-6 shadow">
                                    <label class="font-semibold">Account Created</label>
                                    <div
                                        class="relative flex items-center overflow-hidden text-ellipsis rounded-md my-1">
                                        <i class="mr-1 fa-light fa-clock text-gray-100"></i>
                                        <span class="text-sm">{{ $created->format('d M, Y') }}</span>
                                    </div>
                                </div>


                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')

        <script>
            function visitChart(data) {

                // Process the data
                const labels = data.map(item => item.date);
                const visitCounts = data.map(item => item.total_visits);

                // Create the chart
                const ctx = document.getElementById('myChart').getContext('2d');
                const visitsChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Visits',
                            data: visitCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Visits'
                                }
                            }
                        }
                    }
                });

            }


            function UsageChart(data) {

                // Process data
                const labels = data.map(item => item.os);
                const visitCounts = data.map(item => item.visit_count);

                // Create pie chart
                const ctx = document.getElementById('osUsageChart').getContext('2d');
                const osUsageChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'OS Usage',
                            data: visitCounts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });

            }

            visitChart(@json($visit));

            UsageChart(@json($usage));

        </script>
    @endpush




</x-frontend-layout>
