#!/bin/bash

tmux new-session -A -d -s kraken_web
tmux new-window -t kraken_web -n "web_api"
tmux send-key -t kraken_web:web_api "cd ~/app/kraken_website_be" C-m
tmux send-key -t kraken_web:web_api "docker-compose up" C-m
