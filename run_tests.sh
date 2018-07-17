#!/usr/bin/env bash

declare -A runTestsCommand

runTestsCommand='php vendor/phpunit/phpunit/phpunit'

if [[ -n $1 ]] ; then
	runTestsCommand+=' '$1
fi

eval ${runTestsCommand}