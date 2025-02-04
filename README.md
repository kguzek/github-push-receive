# GitHub Push Receive

This is a basic script which can be placed in a web server to allow receiving GitHub webhook events on push events.
It will automatically call the appropriate script for the appropriate repository, given that they are cloned locally to /data/apps and contain a `deploy.sh` file.

This script reads the payload of the webhook request, ensures the push is for the `main` branch, and calls the deployer script.

The deployer script simply attempts to call a file called `/data/apps/{REPO_NAME}/deploy.sh`.
