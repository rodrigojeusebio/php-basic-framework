# php-basic-framework

### Spin up

```bash
php -S localhost:8000
```

### Home page
![Home page](./images/HomePage.png)

### 404 - Not Found
![404 - Not Found](./images/404.png)

### Exception Handler during development
![Exception Handler](./images/ExceptionViewer.png)

### Logger
![Logger](./images/Logger.png)


### Implemented
- Router
- Database
- ORM (very weak)
- Session manager (File system)
- Authentication
- Authorization
- Render
- Request
- Form Validation
- Middleware
- Authorization to access resources (Gates or ACL, something like that) - Policies
- Form builder + Validation
- Views - built pre-processor - BasicTemplater

### To do's
- Table creation
- Validation, helpers to set the checkboxes
- Improve ORM, currently it is unusable
- Create a wrapper around the php array
    - Create methods like 
        - ->get($key, $default_value);
        - ->set($key, $value);
        - ->filter(fn);
        - ->map(fn);
- Improve the Request Helper (Go to move it from the Core to the Helpers)