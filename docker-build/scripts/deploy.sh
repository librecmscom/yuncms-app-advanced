#!/usr/bin/env bash

set -e

# Create tagged image from git tag
LATEST_TAG=$(git describe --abbrev=0 --always)
CURRENT_VERSION=$(git describe --always)

# Login to registry
docker login --username="${DOCKER_REGISTRY_USER}" --password="${DOCKER_REGISTRY_PASSWORD}" "${DOCKER_REGISTRY_HOST}"

# Create and push :latest
docker tag "tintsoft/yuncms:${BUILD_PREFIX}" "${IMAGE_NAME}":latest
docker push "${IMAGE_NAME}":latest

# Create and push :<CURRENT_VERSION>
if [ "$LATEST_TAG" = "$CURRENT_VERSION" ]; then
    echo "Stable tag $CURRENT_VERSION detected, tagging image..."
    docker tag "local/yuncms/app:${BUILD_PREFIX}" "${IMAGE_NAME}":"${CURRENT_VERSION}"
    docker push "${IMAGE_NAME}:${CURRENT_VERSION}"
    echo "Image pushed to registry."
else
    echo "No stable tag found."
fi;

exit 0