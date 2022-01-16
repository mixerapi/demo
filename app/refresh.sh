#!/bin/bash

printf "\n###################################"
printf "\n# Running database refresh"
printf "\n################################### \n"

printf "\n# Maintenance Mode \n"

bin/cake Setup.MaintenanceMode activate

printf "\n# Drop Tables \n"

bin/cake drop_tables

printf "\n# Run migrations \n"

bin/cake migrations migrate

printf "\n# Seeding Database \n"

bin/cake migrations seed

printf "\n# Live Mode \n"

bin/cake Setup.MaintenanceMode deactivate

printf "\n# Running Swagger Bake \n"

bin/cake swagger bake
bin/cake swagger bake --config AdminApi.swagger_bake
bin/cake cache clear_all
