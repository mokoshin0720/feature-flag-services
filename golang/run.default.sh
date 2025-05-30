#!/usr/bin/env bash
set -eu

export LAUNCHDARKLY_SDK_KEY=''

exec "$@"
