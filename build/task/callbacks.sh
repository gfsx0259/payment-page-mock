#!/bin/bash
while $(sleep 3);
do
    curl -X POST http://nginx/task/scheduleCallbacks
done
