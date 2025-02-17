@extends('front.layouts.app')

@section('content')
    <div class="flex flex-col items-center">
        <div class="flex flex-row gap-1">
            <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Default
            </button>
            <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Default
            </button>
        </div>
        <div class="border border-black rounded-xl w-full p-6">

            <form method="post" action="{{ route('front.generator', ['action' => 'generate']) }}"
                  class="max-w-sm mx-auto">
                @csrf
                <div>
                    <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Small
                        input</label>
                    <input type="text" id="small-input"
                           class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 ">
                </div>

                <h3>
                    Select Style
                </h3>
                <ul class="grid w-full gap-6 md:grid-cols-2">
                    @foreach($style = [1,2,3] as $key => $style)
                        <li>
                            <input type="radio" id="hosting-{{$key}}" name="hosting" value="{{$key}}"
                                   class="hidden peer"
                                   required/>
                            <label for="hosting-{{$key}}"
                                   class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <img src="https://picsum.photos/200" alt="" width="50">
                                    <span>Ink drawing</span>
                                </div>
                            </label>
                        </li>
                    @endforeach

                </ul>
                <div class="mb-6">
                    <label for="large-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Large
                        Describe what you want</label>
                    <input type="text" id="large-input"
                           class="block w-full p-4 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <button
                    id="generateImages"
                    type="button"
                    class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Generate
                </button>
            </form>

        </div>
    </div>
@endsection



