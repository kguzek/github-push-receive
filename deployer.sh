#!/bin/sh -

REPO_NAME=$1
REPO_ROOT="/data/apps/"

log() {
  echo "$1"
  echo "$(date +'%F @ %T'): $1" >>deploy.log
}

fail() {
  local code=${2:-1}
  log "$1"
  log "Exiting with code $code"
  exit $code
}

if [ -z "$REPO_NAME" ]; then
  fail "No repo name provided"
fi

log "Start deploy of '$REPO_NAME'"

if ! cd "$REPO_ROOT$REPO_NAME" 2>/dev/null; then
  fail "Failed to cd into $REPO_ROOT$REPO_NAME"
fi

git pull

if [ ! -f "deploy.sh" ]; then
  fail "No deploy script found for this repository"
fi

log "Running deploy script"
./deploy.sh
exit $?
