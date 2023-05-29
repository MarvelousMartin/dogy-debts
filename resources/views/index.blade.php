<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:400,700,900">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <title>Hospoda U Dog</title>

    <style>
        * {
            font-family: 'Mukta', sans-serif;
        }
    </style>
</head>
<body>
<div class="container mx-auto">
    @if (Session::has('success'))
        <div class="absolute w-full mt-4">
            <div id="toast-success" class="flex w-2/3 mx-auto items-center p-4 text-gray-500 bg-white rounded-lg shadow-lg" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-300 rounded-lg">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">{{Session::get('success')}}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 rounded-lg p-1.5 inline-flex h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <div class="flex flex-col">
        <h1 class="flex font-bold text-2xl justify-center">Hospoda U Dog</h1>
        <div class="flex justify-around my-2">
            <div class="flex align-center items-center">
                <p>Celkem dluh: </p>
                <span class="inline-flex items-center justify-center py-0.5 px-2 ml-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                    {{ $total }} Kč
                </span>
            </div>
            <div class="flex align-center items-center">
                <p>Celkem dlužníků: </p>
                <span class="inline-flex items-center justify-center py-0.5 px-2 ml-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                    {{ count($customers) }}
                </span>
            </div>
        </div>
    </div>

    <hr class="w-48 h-1 mx-auto my-4 bg-gray-300 border-0 rounded">

    <div class="flex gap-4">
        <button data-modal-target="createAccountModal" data-modal-toggle="createAccountModal" type="button" class="w-1/2 text-white bg-green-700 font-medium rounded-lg px-5 py-2.5 ml-2">Založit účet <i class="ml-2 fa-solid fa-user-plus"></i></button>
        <button type="button" class="w-1/2 text-white bg-red-700 font-medium rounded-lg px-5 py-2.5 mr-2">Smazat účet <i class=" ml-2 fa-solid fa-receipt"></i></button>
    </div>

    <div id="createAccountModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex flex-col p-6 space-y-6">
                    <form method="post" action="{{route('newDebtor')}}">
                        {{csrf_field()}}
                        <div class="mb-2">
                            <label for="debtor" class="block mb-2 text-sm font-medium text-gray-900">Dlužník</label>
                            <input type="text" id="debtor" name="debtor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 " placeholder="Jméno" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 font-medium rounded-lg px-2 py-2.5">Vystavit účet <i class=" ml-2 fa-solid fa-receipt"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex align-center items-center justify-between mx-2 mt-2">
        <h2 class="text-2xl text-black font-bold">Dlužníci</h2>
        <p data-dropdown-toggle="dropdown" style="cursor: pointer">@if ($request === 'debtd') Dlužná částka <i class="fa-solid fa-arrow-down-9-1"></i> @elseif($request === 'debta') Dlužná částka <i class="fa-solid fa-arrow-up-9-1"></i> @else Jméno <i class="fa-solid fa-arrow-down-a-z"></i> @endif <i class="ml-3 fa-solid fa-sort"></i></p>
        <div id="dropdown" class="z-10 hidden bg-gray-500 divide-y divide-gray-500 rounded-lg shadow w-34 mr-2">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{\Illuminate\Support\Facades\URL::to('/')}}?sort=name" class="block px-4 py-2 @if ($request === 'name') bg-green-600 @endif">Jméno <i class="fa-solid fa-arrow-down-a-z"></i></a>
                </li>
                <li class="flex align-center items-center justifz-start">
                    <a href="{{\Illuminate\Support\Facades\URL::to('/')}}?sort=debtd" class="block px-4 py-2 @if ($request === 'debtd') bg-green-600 @endif">Dlužná částka <i class="fa-solid fa-arrow-down-9-1"></i></a>
                </li>
                <li>
                    <a href="{{\Illuminate\Support\Facades\URL::to('/')}}?sort=debta" class="block px-4 py-2 @if ($request === 'debta') bg-green-600 @endif">Dlužná částka <i class="fa-solid fa-arrow-up-9-1"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="divide-y divide-gray-500 bg-black bg-opacity-30 rounded-lg p-2" style="margin: 20px 10px">
        @foreach ($customers as $customer)
            <li class="py-3 flex justify-between">
                <div class="flex items-center w-2/3">
                    <div class="flex-1 min-w-0 ml-4">
                        <p class="text-lg text-black font-bold">
                            {{$customer->name}}
                        </p>
                    </div>
                    <span id="debtValue-{{$customer->id}}" class="inline-flex items-center text-sm font-medium px-2.5 py-0.5 rounded-full text-white">
                        {{$customer->debt}} Kč
                    </span>
                </div>
                <div>
                    <a data-modal-target="addItem-{{$customer->id}}" data-modal-toggle="addItem-{{$customer->id}}" href="#" class="text-white bg-green-700 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 ">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <a  data-modal-target="history-{{$customer->id}}" data-modal-toggle="history-{{$customer->id}}" href="#" class="text-white bg-blue-700 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 ">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </a>
                </div>
            </li>
            <div id="addItem-{{$customer->id}}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-start justify-between px-4 py-2 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Přidat položku
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="addItem-{{$customer->id}}">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-2 space-y-2">
                            <div class="flex gap-2">
                                <button type="submit" class="w-full text-white bg-[#7a4a1c] font-medium rounded-lg h-16 px-2 py-2.5">Malá desítka <i class="fa-solid fa-beer-mug-empty"></i></button>
                                <button type="submit" class="w-full text-white bg-[#7a4a1c] font-medium rounded-lg h-16 px-2 py-2.5">Velká desítka <i class="fa-solid fa-beer-mug-empty fa-xl"></i></button>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="w-full text-white bg-[#005832] font-medium rounded-lg h-16 px-2 py-2.5">Malá dvanáctka <i class="fa-solid fa-beer-mug-empty"></i></button>
                                <button type="submit" class="w-full text-white bg-[#005832] font-medium rounded-lg h-16 px-2 py-2.5">Velká dvanáctka <i class="fa-solid fa-beer-mug-empty fa-xl"></i></button>
                            </div>
                        </div>

                        <hr class="w-48 h-1 mx-auto my-2 bg-gray-300 border-0 rounded">

                        <div class="p-2 space-y-2">
                            <div class="flex gap-2">
                                <button type="submit" class="w-full text-white bg-amber-500 font-medium rounded-lg h-12 py-2.5">Malá limonáda <i class="fa-solid fa-glass-water"></i></button>
                                <button type="submit" class="w-full text-white bg-amber-500 font-medium rounded-lg h-12 py-2.5">Velká limonáda <i class="fa-solid fa-glass-water fa-xl"></i></button>
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="w-full text-white bg-amber-800 font-medium rounded-lg h-8">Čaj <i class="fa-solid fa-mug-hot"></i></button>
                                <button type="submit" class="w-full text-white bg-black font-medium rounded-lg h-8">Kafe <i class="fa-solid fa-mug-saucer"></i></button>
                                <button type="submit" class="w-full text-white bg-slate-600 font-medium rounded-lg h-8">Vinný střík <i class="fa-solid fa-wine-glass"></i></button>
                            </div>
                        </div>

                        <hr class="w-48 h-1 mx-auto my-2 bg-gray-300 border-0 rounded">

                        <div class="p-2 space-y-2">
                            <div class="flex gap-2">
                                <button type="submit" class="w-1/4 text-white bg-amber-800 font-medium rounded-lg h-16 px-2 py-2.5">Chipsy <i class="fa-solid fa-bowl-food"></i></button>
                                <button type="submit" class="w-1/4 text-white bg-amber-800 font-medium rounded-lg h-16 px-2 py-2.5">Chipsy <i class="fa-solid fa-bowl-food"></i></button>
                                <div class="w-1/2 flex gap-2">
                                    <button type="submit" class="text-white bg-green-700 font-medium rounded-lg h-16 px-2 py-2.5">Panák <i class="fa-solid fa-whiskey-glass"></i></button>
                                    <div class="inline-grid grid-cols-2 gap-1">
                                        <button type="submit" class="text-white bg-green-700 font-medium rounded-lg py-0.5 px-4">2</button>
                                        <button type="submit" class="text-white bg-green-700 font-medium rounded-lg py-0.5 px-4">3</button>
                                        <button type="submit" class="text-white bg-green-700 font-medium rounded-lg py-0.5 px-4">4</button>
                                        <button type="submit" class="text-white bg-green-700 font-medium rounded-lg py-0.5 px-4">5</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="w-48 h-1 mx-auto my-2 bg-gray-300 border-0 rounded">

                        <div class="flex flex-col px-6 py-2">
                            <form method="post" action="{{route('newDebtor')}}">
                                {{csrf_field()}}
                                <label for="item" class="block mb-2 text-sm font-medium text-gray-900">Jiná položka</label>
                                <div class="flex mb-2 gap-x-4">
                                    <input type="number" pattern="[0-9]*" id="item" name="item" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Kč" required>
                                    <button type="submit" class="w-1/3 text-white bg-blue-700 font-medium rounded-lg"><i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
<script>
    @foreach ($customers as $customer)
        var debtValueElement{{$customer->id}} = document.getElementById('debtValue-{{$customer->id}}');
        var debtValue{{$customer->id}} = parseInt(debtValueElement{{$customer->id}}.innerText);
    @endforeach

    var greenColor = [0, 128, 0];        // RGB value for green
    var orangeColor = [255, 165, 0];     // RGB value for orange
    var darkRedColor = [139, 0, 0];      // RGB value for dark red
    var violetColor = [148, 0, 211];     // RGB value for violet

    var colorRangeStart = 0;             // Start value of the color range
    var colorRangeEnd = 5000;            // End value of the color range

    @foreach ($customers as $customer)
        var normalizedValue{{$customer->id}} = Math.max(0, Math.min((debtValue{{$customer->id}} - colorRangeStart) / (colorRangeEnd - colorRangeStart), 1));
        var interpolatedColor{{$customer->id}} = interpolateColor(greenColor, orangeColor, darkRedColor, violetColor, normalizedValue{{$customer->id}});

        debtValueElement{{$customer->id}}.style.backgroundColor = 'rgb(' + interpolatedColor{{$customer->id}}.join(',') + ')';
    @endforeach

    function interpolateColor(color1, color2, color3, color4, value) {
        if (value < 0.25) {
            value *= 2;
            var r = Math.round(color1[0] + (color2[0] - color1[0]) * value);
            var g = Math.round(color1[1] + (color2[1] - color1[1]) * value);
            var b = Math.round(color1[2] + (color2[2] - color1[2]) * value);
        } else if (value < 0.5) {
            value = (value - 0.25) * 2;
            var r = Math.round(color2[0] + (color3[0] - color2[0]) * value);
            var g = Math.round(color2[1] + (color3[1] - color2[1]) * value);
            var b = Math.round(color2[2] + (color3[2] - color2[2]) * value);
        } else if (value < 0.75) {
            value = (value - 0.5) * 2;
            var r = Math.round(color3[0] + (color4[0] - color3[0]) * value);
            var g = Math.round(color3[1] + (color4[1] - color3[1]) * value);
            var b = Math.round(color3[2] + (color4[2] - color3[2]) * value);
        } else {
            value = (value - 0.75) * 2;
            var r = Math.round(color4[0] + (255 - color4[0]) * value);
            var g = Math.round(color4[1] + (255 - color4[1]) * value);
            var b = Math.round(color4[2] + (255 - color4[2]) * value);
        }

        return [r, g, b];
    }
</script>
</body>
