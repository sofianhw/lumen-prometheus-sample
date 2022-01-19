#!/bin/bash

echo -e "\n"
echo "Lumen Example App:            http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_NGINX_PORT}/"
echo "Lumen Example App test route: http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_NGINX_PORT}/test"
echo "MySQL:                        http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_MYSQL_PORT}/"
echo "Redis:                        http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_REDIS_PORT}/"
echo "Prometheus:                   http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_PROMETHEUS_PORT}/"
echo "Grafana:                      http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_GRAFANA_PORT}/"
echo "Push Gateway:                 http://${EXAMPLE_APP_IP}:${EXAMPLE_APP_PUSH_GATEWAY_PORT}/"
