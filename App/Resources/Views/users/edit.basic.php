<h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Edit a user</h1>
<form action="/users/{{$user->id}}" method="post">
    @method('patch')
    <input type="text" name="name" placeholder="Human name..." value="{{$user->name}}" required
        class="w-full p-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
    <input type="password" name="password" placeholder="Password" required
        class="w-full p-2 mb-4 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
    <button type="submit"
        class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700 transition duration-200">
        Submit
    </button>
</form>