<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Git Profile') }}
        </h2>
    </x-slot>


    <div class="max-w-sm p-6  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center space-x-4">
            <img class="w-20 h-20" src="{{$user['avatar_url']}}" alt="">
            <div class="font-medium dark:text-white">
                <div>{{$user['login']}} (github id: {{$user['id']}})</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Created
                    at {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y')}}</div>
            </div>
        </div>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">User repositories:</p>
        <div class="relative overflow-x-auto">
            <table class="w-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        repository url
                    </th>
                    <th scope="col" class="px-6 py-3">
                        description
                    </th>

                    <th scope="col" class="px-6 py-3">
                        created at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        language
                    </th>
                    <th scope="col" class="px-6 py-3">
                        visibility
                    </th>
                    <th scope="col" class="px-6 py-3">
                        default branch
                    </th>

                </tr>
                </thead>
                <tbody>

                @foreach($repos as $repo)
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-6 py-4">
                            {{$repo['id']}}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{$repo['html_url']}}">{{$repo['full_name']}}</a>
                        </td>
                        <td class="px-6 py-4">
                            {{$repo['description']}}
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($user['created_at'])->format('d/m/Y')}}
                        </td>
                        <td class="px-6 py-4">
                            {{$repo['language']}}
                        </td>
                        <td class="px-6 py-4">
                            {{$repo['visibility']}}
                        </td>
                        <td class="px-6 py-4">
                            {{$repo['default_branch']}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


</x-app-layout>

