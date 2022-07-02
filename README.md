# MixerAPI Demo

[![Build](https://github.com/mixerapi/demo/actions/workflows/build.yml/badge.svg)](https://github.com/mixerapi/demo/actions/workflows/build.yml)
[![Image](https://github.com/mixerapi/demo/actions/workflows/image.yml/badge.svg)](https://github.com/mixerapi/demo/actions/workflows/image.yml)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Docker](https://img.shields.io/badge/docker-ffffff.svg?logo=docker)](https://hub.docker.com/r/mixerapidev/demo)
[![Kubernetes](https://img.shields.io/badge/kubernetes-D3D3D3.svg?logo=kubernetes)](.kube)
[![PHP](https://img.shields.io/badge/php-^8.0-8892BF.svg?logo=php)](https://hub.docker.com/_/php)
[![NGINX](https://img.shields.io/badge/nginx-1.19-009639.svg?logo=nginx)](https://hub.docker.com/_/nginx)
[![MySQL](https://img.shields.io/badge/mysql-8-00758F.svg?logo=mysql)](https://hub.docker.com/_/mysql)

A [mixerapi/mixerapi](https://github.com/mixerapi/mixerapi) demo application. This project was generated from the
[mixerapi/app](https://github.com/mixerapi/app) template. See that project for additional details.

Checkout the live demo: [https://demo.mixerapi.com](https://demo.mixerapi.com)

- [Installation](#Installation)
- [Examples](#Examples)

## Installation

You can run this demo via Docker and/or a local LAMP stack. Fork/clone this repository to get started.

### Docker

Bring up stack:

```console
make init
```

Next, generate schema and seed data:

```console
make php.sh
bin/cake migrations migrate
bin/cake migrations seed
```

That's it! Now browse to [http://localhost:8080](http://localhost:8080).

#### For Mac Users

1. Change your `SHELL` in the Makefile to `/bin/zsh`. This improves various output from the Makefile such as emoji's.

3. Mac ships with an older version of `sed` so install `gnu-sed` for some targets in the Makefile:

```console
brew install gnu-sed
```

Then update `sed` to `gsed` in the Makefile.

### Local

Copy default configs:

```console
cd app
cp config/.env.example config/.env
cp config/app_local.example.php config/app_local.php
cp ../.assets/bootstrap.php config/bootstrap.php
```

Configure your database settings in `app/config/.env` and run:

```console
composer install
bin/cake migrations migrate
bin/cake migrations seed
```

Generate keys for authentication examples:

```console
mkdir -p plugins/AuthenticationApi/config/keys/1
openssl genrsa -out plugins/AuthenticationApi/config/keys/1/private.pem 2048
openssl rsa -in plugins/AuthenticationApi/config/keys/1/private.pem -outform PEM -pubout -out plugins/AuthenticationApi/config/keys/1/public.pem
openssl rand -base64 32 > plugins/AuthenticationApi/config/keys/hmac_secret.txt
```

Bring on local server:

```console
bin/cake server
```

Browse to the URL given by the `server` console command.

## Examples

- For Docker see this [README](https://github.com/mixerapi/app).
- For information on the demo application code see [app/README.md](./app/README.md)
- For JWT Authentication see [AuthenticationApi](app/plugins/AuthenticationApi/README.md). The
AuthenticationApi uses [MixerApi/JwtAuth](https://github.com/mixerapi/jwt-auth). See `plugin/AdminApi/src/Application.php`
for loading [CakePHP authenticators and identifiers](https://book.cakephp.org/authentication/2/en/index.html).
- The demo uses [Muffin/Throttle])(https://github.com/UseMuffin/Throttle). See `src/Application.php` and
- `src/Event/ThrottleListener.php`.
