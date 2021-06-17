# &#x2638; Kubernetes

This is provided as a starter/example setup. You can run kubernetes locally with an orchestration tool such as
[minikube](https://minikube.sigs.k8s.io/docs/) and [kubectl](https://kubernetes.io/docs/tasks/tools/).

Starting minikube:

```console
minikube start
```

Apply configs:

```console
kubectl apply -f .kube/namespace.yaml
kubectl apply -f .kube/mysql-secret.yaml
kubectl apply -f .kube/php-secret.yaml
kubectl apply -f .kube/.
```

Minikube dashboard:

```console
minikube dashboard --url
```

Create services:

```console
minikube service nginx -n mixerapi-docker
minikube service mysql -n mixerapi-docker
```

Browse to the given nginx url:

```console
minikube service list
```

MySQL:

```console
mysql -u cakephp -h 192.168.49.2 -p --port 32089
```

Docker build / push commands:

```console
docker build . -t mixerapidev/demo:latest
docker push mixerapidev/demo:latest
```

