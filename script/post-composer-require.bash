#!/usr/bin/env bash
#
# Install Weather service into an Anax installation using a default setup.
#
rsync -av vendor/pamo18/ramverk1-weather/config/ config/
rsync -av vendor/pamo18/ramverk1-weather/content/ content/
rsync -av vendor/pamo18/ramverk1-weather/htdocs/ htdocs/
rsync -av vendor/pamo18/ramverk1-weather/src/ src/
rsync -av vendor/pamo18/ramverk1-weather/test/ test/
rsync -av vendor/pamo18/ramverk1-weather/view/ view/
