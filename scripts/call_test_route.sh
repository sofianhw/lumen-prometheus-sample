#!/usr/bin/env bash
length=${TIMES_TO_CALL_EXAMPLE_ROUTE}

for ((i=1;i<=$length;i++));
do
   curl -v -XGET --header "Connection: keep-alive" "http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_NGINX_PORT}/collector";
done
