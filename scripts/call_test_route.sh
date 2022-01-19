#!/usr/bin/env bash
length=${TIMES_TO_CALL_EXAMPLE_ROUTE}
length=100
for ((i=1;i<=$length;i++));
do
   curl -v --header "Connection: keep-alive" "http://docker.aws:${EXAMPLE_APP_NGINX_PORT}/test";
done
