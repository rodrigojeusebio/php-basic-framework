<?php

use Core\Request;

?>
<h3 class="text-2xl font-semibold leading-none tracking-tight">User Activity</h3>
<p class="text-sm text-muted-foreground">View user activity and engagement.</p>
<div class="p-6 pt-0">
    <div class="relative w-full overflow-auto">
        <div class="max-w-md mx-auto p-6 bg-white shadow-lg rounded-lg">
            <h1 class="text-3xl font-semibold mb-6 text-center text-slate-800">Filters</h1>
            <form method="GET" action="/users">
                <div class="flex flex-col">
                    <input type="text" name="name" placeholder="Search for a user" value="<?= Request::get('name') ?>"
                        class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 transition duration-200">

                    <button type="submit"
                        class="w-full bg-slate-800 text-white py-3 rounded-lg hover:bg-slate-700 transition duration-200">
                        Search
                    </button>
                </div>
            </form>
        </div>
        <table class="w-full caption-bottom text-sm">
            <thead class="tr:border-b font-bold">
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <th
                        class="font-bold h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                        Name
                    </th>
                    <th
                        class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                        Email
                    </th>
                    <th
                        class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                @foreach ($users as $user)
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                        <div class="flex items-center gap-3">
                            <div class="grid gap-0.5 text-sm">
                                <div class="font-medium">{{$user->name}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">{{$user->email}}</td>
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                        <a href="/users/{{$user->id}}" class="text-blue-600 hover:underline">Show</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>