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

Get Kubernetes URL:

```console
minikube service nginx-service -n mixerapi-docker
```

## Using local image

You may find it helpful to work with a local image instead of continually deploying to a container registry.

```console
eval (minikube docker-env)
docker run -d -p 5005:5005 --restart=always --name registry registry:2
docker build . -f .docker/Dockerfile -t localhost:5005/mixerapidev-demo:latest
docker push localhost:5005/mixerapidev-demo:latest
```

In [php.yaml](php.yaml.bak) change the image to `localhost:5005/mixerapidev-demo:latest`.

> Source: https://shashanksrivastava.medium.com/how-to-set-up-minikube-to-use-your-local-docker-registry-10a5b564883

Docker build / push commands:

```console
docker build . -t mixerapidev/demo:latest
docker push mixerapidev/demo:latest
```

