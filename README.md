# Mimosa

A minimalist php + reactJS combo

It is designed to seamlessly integrate PHP and ReactJS without the need for complete separation between frontend and backend layers.

## Example

```js
{{-- Screen/Components.blade.jsx --}}

var owner = 'Hedy Lamarr';
var initialTodos = JSON.parse('{!! json_encode($todos) !!}');

const TodoApp = () => {
    const [todos, setTodos] = React.useState(initialTodos);

    const TodoFormSubmit = (e) => {
        e.preventDefault();
        const newTodo = e.target.elements.todo.value;
        setTodos([...todos, newTodo]);
        e.target.reset(); // Reset the form after submission
    };

    return (
        <div>
            <ul id="toDoList">
                {todos.map((todo, index) => (
                    <li key={index}>{todo}</li>
                ))}
            </ul>
            <form onSubmit={TodoFormSubmit}>
                <input type="text" name="todo" placeholder="Add a todo" />
                <button type="submit">Add</button>
            </form>
        </div>
    );
}
```

```php-template
{{-- Screen/Main.blade.php --}}

@section('jsx')
    <div>
        <h1> {owner} </h1>
  
        <TodoApp />
    </div>
@endsection
```

## Features

- Routing
- Autoloading
- Error Handling
- ReactJS support

## Disclaimer

The toolset is literally a couple days old, so I would not advice anyone to use this framework in production environment or with major projects

## Credits

- Framework X
- React PHP - low-level library for event-driven programming in PHP
- Blade Template
- React JS
- Me 🤫

## Contributions

Opinions, suggestion, pull requests, and anything of value
