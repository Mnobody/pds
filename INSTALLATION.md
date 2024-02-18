# INSTALLATION

Install Git Large File Storage (lfs) if not installed: https://github.com/git-lfs/git-lfs/wiki/Installation

If something went wrong and your folder 'data' is empty:
```sh
    git lfs pull
```

Run docker containers:
```sh
    docker compose up -d
```

site: [http://localhost:8080/](http://localhost:8080/)

jaeger: [http://localhost:16686/](http://localhost:16686/)

minio console: [http://localhost:9090/](http://localhost:9090/) \
login: `minioadmin` \
password: `minioadmin`

rabbitmq: [http://localhost:15672/](http://localhost:15672/) \
login: `guest` \
password: `guest`
