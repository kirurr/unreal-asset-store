
        $this->router->post('/api/signin', function (ServiceContainer $container) {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $container->get('AuthController')->signIn($email, $password);
        });

        $this->router->post('/api/signup', function (ServiceContainer $container) {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $container->get('AuthController')->signUp($name, $email, $password);
        });

        $this->router->get('/api/signout', function (ServiceContainer $container) {
            $container->get('AuthController')->signOut();
        });
