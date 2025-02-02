# Basic Templater

- Basic templater is the templating language used in the PHP Basic Framework. It is based on Blade functionality.

## Supported syntax
- `@component`
- `@method`
- `@old`
- `@errors`
- `@enderrors`
- `@error`
- `@if`
- `@endif`
- `@foreach`
- `@endforeach`
- `@auth`
- `@endauth`
- `@guest`
- `@endguest`
- `{{$variable}}`

## How it works

- The view files have the extension basic.php, this allows the LSP to use all the php functionality in your views.
- You define the page you want to display and the library will parse the base file and all files that are included with the @component directive. The base file and all dependent files are compiled from the basic syntax to php syntax. 
- Currently is not optimized, it will compile every dependent file every time a new request is made.