# Running the Project with `Docker`

To run the project, you need to have an up-to-date version of `Docker` that supports `Docker Compose`.

## Commands for Working

1. **Starting the Project**:
   ```bash
   docker compose up -d
   ```
   
2. **Stopping the Project**:
   ```bash
   docker compose down
   ```
   
These commands should be executed in the same folder where the `docker-compose.yml` file is located.


After successfully starting the project, it will be accessible at: 
`http://localhost:8080`

## Deployment on Hosting (e.g., VPS Server)
For deploying the project on a remote server, additional configuration is required.

### Recommended Method: Redirecting from `Port 80` to `Port 8080` via Web Server
To redirect requests from `port 80` to `port 8080`, use a web server such as `Apache` or `Nginx`. In this case, there is no need to modify the `docker-compose.yml` file.

### Alternative Method: Changing Port Configuration in `docker-compose.yml`
Если вы хотите, чтобы проект работал напрямую через порт `80`, можно изменить параметр `ports` в файле `docker-compose.yml` с `"8080:80"` на `"80:80"`.

If you want the project to run directly on port `80`, you can change the ports parameter in the `docker-compose.yml` file from `"8080:80"` to `"80:80"`.

In this case, port `80` must be opened in the server's network settings, and a web server (`Apache` / `Nginx`) will not be required.

You will likely need to run the project with `sudo`.

Example change in `docker-compose.yml`:

```yaml
ports:
  - "80:80"
```
