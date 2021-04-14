# MixerAPI Demo

[![Build](https://github.com/mixerapi/app/workflows/Build/badge.svg?branch=main)](https://github.com/mixerapi/app/actions)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-4.2-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Docker](https://img.shields.io/badge/docker-ffffff.svg?logo=docker)](https://www.docker.com)
[![Kubernetes](https://img.shields.io/badge/kubernetes-D3D3D3.svg?logo=kubernetes)](https://kubernetes.io/)
[![PHP](https://img.shields.io/badge/php-7.4-8892BF.svg?logo=php)](https://php.net/)
[![NGINX](https://img.shields.io/badge/nginx-1.19-009639.svg?logo=nginx)](https://www.nginx.com/)
[![MySQL](https://img.shields.io/badge/mysql-8-00758F.svg?logo=mysql)](https://www.mysql.com/)

A [mixerapi/mixerapi](https://github.com/mixerapi/mixerapi) demo application. This project was built using the
[mixerapi/app](https://github.com/mixerapi/app) template.


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

### Local

Configure your database settings in `app/config/.env` and run:

```console
cd app
composer install
bin/cake migrations migrate
bin/cake migrations seed
bin/cake server
```

Browse to the URL given by the `server` console command.

## Usage

For Docker see this [README](https://github.com/mixerapi/app).
