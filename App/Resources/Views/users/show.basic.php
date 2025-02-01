<h1 class="text-lg font-bold">Hello {{$user_name}} ({{$user_id}})</h1>

<h3 class="text-lg">Delete user</h3>
<form action="/users/{{ $user_id }}" method="post">
    @method('delete')
    <button class="btn border py-2 px-4 rounded-md text-white bg-red-500 hover:bg-red-600">Submit</button>
</form>