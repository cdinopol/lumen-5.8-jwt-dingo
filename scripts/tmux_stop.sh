#!/bin/bash

tmux send-key -t kraken_web:web_api C-c
sleep 20
tmux send-key -t kraken_web:web_api C-d
